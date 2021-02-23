<?php

namespace App\Http\Controllers;

use App\ActivityLog;
use App\ClientDeal;
use App\ClientPermission;
use App\CustomField;
use App\Deal;
use App\DealCall;
use App\DealDiscussion;
use App\DealEmail;
use App\DealFile;
use App\DealStage;
use App\DealTask;
use App\Item;
use App\Label;
use App\Mail\SendDealEmail;
use App\Pipeline;
use App\Product;
use App\Source;
use App\Stage;
use App\User;
use App\UserDeal;
use App\Utility;
use Illuminate\Http\Request;

class DealController extends Controller
{

    public function index()
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee' || \Auth::user()->type == 'client')
        {
            if(\Auth::user()->default_pipeline)
            {
                $pipeline = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->where('id', '=', \Auth::user()->default_pipeline)->first();
                if(!$pipeline)
                {
                    $pipeline = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->first();
                }
            }
            else
            {
                $pipeline = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->first();
            }

            $pipelines = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $cnt_deal = [];
            if(!empty($pipeline))
            {
                $deals       = Deal::where('created_by', '=', \Auth::user()->creatorId())->where('pipeline_id', '=', $pipeline->id)->get();
                $curr_month  = Deal::where('created_by', '=', \Auth::user()->creatorId())->where('pipeline_id', '=', $pipeline->id)->whereMonth('created_at', '=', date('m'))->get();
                $curr_week   = Deal::where('created_by', '=', \Auth::user()->creatorId())->where('pipeline_id', '=', $pipeline->id)->whereBetween(
                    'created_at', [
                                    \Carbon\Carbon::now()->startOfWeek(),
                                    \Carbon\Carbon::now()->endOfWeek(),
                                ]
                )->get();
                $last_30days = Deal::where('created_by', '=', \Auth::user()->creatorId())->where('pipeline_id', '=', $pipeline->id)->whereDate('created_at', '>', \Carbon\Carbon::now()->subDays(30))->get();

                // Deal Summary
                $cnt_deal                = [];
                $cnt_deal['total']       = \App\Deal::getDealSummary($deals);
                $cnt_deal['this_month']  = \App\Deal::getDealSummary($curr_month);
                $cnt_deal['this_week']   = \App\Deal::getDealSummary($curr_week);
                $cnt_deal['last_30days'] = \App\Deal::getDealSummary($last_30days);

                return view('deal.index', compact('pipelines', 'pipeline', 'cnt_deal'));
            }
            else
            {
                return view('deal.index', compact('pipeline', 'pipelines'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $clients = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'Client')->get()->pluck('name', 'id');


        return view('deal.create', compact('clients'));
    }


    public function store(Request $request)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
        {
            $usr       = \Auth::user();
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
            if(empty($pipeline))
            {
                return redirect()->back()->with('error', __('Please add constant pipeline.'));
            }

            // Default Field Value
            if($usr->default_pipeline)
            {
                $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->where('id', '=', $usr->default_pipeline)->first();
                if(!$pipeline)
                {
                    $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
                }
            }
            else
            {
                $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
            }

            $stage = DealStage::where('pipeline_id', '=', $pipeline->id)->first();
            // End Default Field Value

            if(empty($stage))
            {
                return redirect()->back()->with('error', __('Please add constant deal stage'));
            }
            else
            {
                $deal       = new Deal();
                $deal->name = $request->name;
                if(empty($request->price))
                {
                    $deal->price = 0;
                }
                else
                {
                    $deal->price = $request->price;
                }
                $deal->pipeline_id = $pipeline->id;
                $deal->stage_id    = $stage->id;
                $deal->status      = 'Active';
                $deal->created_by  = $usr->creatorId();
                $deal->save();

                $clients = User::whereIN('id', array_filter($request->clients))->get()->pluck('email', 'id')->toArray();

                foreach(array_keys($clients) as $client)
                {
                    ClientDeal::create(
                        [
                            'deal_id' => $deal->id,
                            'client_id' => $client,
                        ]
                    );
                }

                UserDeal::create(
                    [
                        'user_id' => $usr->id,
                        'deal_id' => $deal->id,
                    ]
                );


                $dArr = [
                    'deal_name' => $deal->name,
                    'deal_pipeline' => $pipeline->name,
                    'deal_stage' => $stage->name,
                    'deal_status' => $deal->status,
                    'deal_price' => $usr->priceFormat($deal->price),
                ];

                $resp = Utility::sendEmailTemplate('deal_assign', $clients, $dArr);

                return redirect()->back()->with('success', __('Deal successfully created.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }


    public function show($id)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee' || \Auth::user()->type == 'client')
        {
            $ids  = \Crypt::decrypt($id);
            $deal = Deal::find($ids);

            $calenderTasks = [];

            foreach($deal->tasks as $task)
            {
                $calenderTasks[] = [
                    'title' => $task->name,
                    'start' => $task->date,
                    'url' => route(
                        'deal.tasks.show', [
                                             $deal->id,
                                             $task->id,
                                         ]
                    ),
                    'className' => ($task->status) ? 'bg-success border-success' : 'bg-warning border-warning',
                ];
            }


            return view('deal.view', compact('deal', 'calenderTasks', 'permission'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit(Deal $deal)
    {
        $pipelines = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $pipelines->prepend(__('Select Pipeline'), '');
        $sources = Source::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

        $products = Item::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

        $deal->sources  = explode(',', $deal->sources);
        $deal->products = explode(',', $deal->products);

        return view('deal.edit', compact('deal', 'pipelines', 'sources', 'products'));
    }


    public function update(Request $request, Deal $deal)
    {
        if(\Auth::user()->type == 'company')
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                                   'pipeline_id' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $deal->name = $request->name;
            if(empty($request->price))
            {
                $request->price = 0;
            }
            else
            {
                $deal->price = $request->price;
            }
            $deal->pipeline_id = $request->pipeline_id;
            $deal->stage_id    = $request->stage_id;
            $deal->sources     = implode(",", array_filter($request->sources));
            $deal->products    = implode(",", array_filter($request->products));
            $deal->notes       = $request->notes;
            $deal->save();

            return redirect()->back()->with('success', __('Deal successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }


    public function destroy(Deal $deal)
    {
        if(\Auth::user()->type == 'company')
        {

            DealDiscussion::where('deal_id', '=', $deal->id)->delete();
            DealFile::where('deal_id', '=', $deal->id)->delete();
            ClientDeal::where('deal_id', '=', $deal->id)->delete();
            UserDeal::where('deal_id', '=', $deal->id)->delete();
            DealTask::where('deal_id', '=', $deal->id)->delete();
            ActivityLog::where('deal_id', '=', $deal->id)->delete();

            $deal->delete();

            return redirect()->back()->with('success', __('Deal successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function order(Request $request)
    {

        if(\Auth::user()->type == 'company')
        {
            $usr = \Auth::user();

            $post       = $request->all();
            $deal       = Deal::find($post['deal_id']);
            $clients    = ClientDeal::select('client_id')->where('deal_id', '=', $deal->id)->get()->pluck('client_id')->toArray();
            $deal_users = $deal->users->pluck('id')->toArray();
            $usrs       = User::whereIN('id', array_merge($deal_users, $clients))->get()->pluck('email', 'id')->toArray();

            if($deal->stage_id != $post['stage_id'])
            {
                $newStage = DealStage::find($post['stage_id']);
                ActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'deal_id' => $deal->id,
                        'log_type' => 'Move',
                        'remark' => json_encode(
                            [
                                'title' => $deal->name,
                                'old_status' => !empty($deal->stage) ? $deal->stage->name : '',
                                'new_status' => $newStage->name,
                            ]
                        ),
                    ]
                );

            }

            foreach($post['order'] as $key => $item)
            {
                $deal           = Deal::find($item);
                $deal->order    = $key;
                $deal->stage_id = $post['stage_id'];
                $deal->save();
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function userEdit($id)
    {
        $deal = Deal::find($id);

        $users = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'client')->whereNOTIn(
            'id', function ($q) use ($deal){
            $q->select('user_id')->from('user_deals')->where('deal_id', '=', $deal->id);
        }
        )->get();

        $users = $users->pluck('name', 'id');


        return view('deal.users', compact('deal', 'users'));
    }

    public function userUpdate($id, Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $usr  = \Auth::user();
            $deal = Deal::find($id);


            if(!empty($request->users))
            {
                $users   = User::whereIN('id', array_filter($request->users))->get()->pluck('email', 'id')->toArray();
                $dealArr = [
                    'deal_id' => $deal->id,
                    'name' => $deal->name,
                    'updated_by' => $usr->id,
                ];
                $dArr    = [
                    'deal_name' => $deal->name,
                    'deal_pipeline' => $deal->pipeline->name,
                    'deal_stage' => $deal->stage->name,
                    'deal_status' => $deal->status,
                    'deal_price' => $usr->priceFormat($deal->price),
                ];

                foreach(array_keys($users) as $user)
                {
                    UserDeal::create(
                        [
                            'deal_id' => $deal->id,
                            'user_id' => $user,
                        ]
                    );

                }

            }


            if(!empty($users) && !empty($request->users))
            {
                return redirect()->back()->with('success', __('Users successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Please select valid user.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function userDestroy($id, $user_id)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal = Deal::find($id);
            UserDeal::where('deal_id', '=', $deal->id)->where('user_id', '=', $user_id)->delete();

            return redirect()->back()->with('success', __('User successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function productEdit($id)
    {
        $deal     = Deal::find($id);
        $products = Item::where('created_by', '=', \Auth::user()->creatorId())->whereNOTIn('id', explode(',', $deal->products))->get()->pluck('name', 'id');

        return view('deal.items', compact('deal', 'products'));
    }

    public function productUpdate($id, Request $request)
    {

        if(\Auth::user()->type == 'company')
        {
            $usr        = \Auth::user();
            $deal       = Deal::find($id);
            $clients    = ClientDeal::select('client_id')->where('deal_id', '=', $id)->get()->pluck('client_id')->toArray();
            $deal_users = $deal->users->pluck('id')->toArray();

            if(!empty($request->items))
            {
                $products       = array_filter($request->items);
                $old_products   = explode(',', $deal->products);
                $deal->products = implode(',', array_merge($old_products, $products));
                $deal->save();

                $objProduct = Item::whereIN('id', $products)->get()->pluck('name', 'id')->toArray();

                ActivityLog::create(
                    [
                        'user_id' => \Auth::user()->id,
                        'deal_id' => $deal->id,
                        'log_type' => 'Add Product',
                        'remark' => json_encode(['title' => implode(",", $objProduct)]),
                    ]
                );


            }

            if(!empty($products) && !empty($request->items))
            {
                return redirect()->back()->with('success', __('Products successfully updated.'))->with('status', 'products');
            }
            else
            {
                return redirect()->back()->with('error', __('Please select valid product.'))->with('status', 'general');
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function productDestroy($id, $product_id)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal     = Deal::find($id);
            $products = explode(',', $deal->products);
            foreach($products as $key => $product)
            {
                if($product_id == $product)
                {
                    unset($products[$key]);
                }
            }
            $deal->products = implode(',', $products);
            $deal->save();

            return redirect()->back()->with('success', __('Products successfully deleted.'))->with('status', 'products');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function fileUpload($id, Request $request)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
        {
            $deal = Deal::find($id);
            $request->validate(['file' => 'required|mimes:png,jpeg,jpg,pdf,doc,txt|max:20480']);
            $file_name = $request->file->getClientOriginalName();
            $file_path = $request->deal_id . "_" . md5(time()) . "_" . $request->file->getClientOriginalName();
            $request->file->storeAs('uploads/deal_files', $file_path);

            $file                 = DealFile::create(
                [
                    'deal_id' => $request->deal_id,
                    'file_name' => $file_name,
                    'file_path' => $file_path,
                ]
            );
            $return               = [];
            $return['is_success'] = true;
            $return['download']   = route(
                'deal.file.download', [
                                        $deal->id,
                                        $file->id,
                                    ]
            );
            $return['delete']     = route(
                'deal.file.delete', [
                                      $deal->id,
                                      $file->id,
                                  ]
            );

            ActivityLog::create(
                [
                    'user_id' => \Auth::user()->id,
                    'deal_id' => $deal->id,
                    'log_type' => 'Upload File',
                    'remark' => json_encode(['file_name' => $file_name]),
                ]
            );

            return response()->json($return);
        }
        else
        {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission denied.'),
                ], 200
            );
        }
    }

    public function fileDownload($id, $file_id)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee' || \Auth::user()->type == 'client')
        {
            $deal = Deal::find($id);
            $file = DealFile::find($file_id);
            if($file)
            {
                $file_path = storage_path('uploads/deal_files/' . $file->file_path);
                $filename  = $file->file_name;

                return \Response::download(
                    $file_path, $filename, [
                                  'Content-Length: ' . filesize($file_path),
                              ]
                );
            }
            else
            {
                return redirect()->back()->with('error', __('File is not exist.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function fileDelete($id, $file_id)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
        {
            $deal = Deal::find($id);
            $file = DealFile::find($file_id);
            if($file)
            {
                $path = storage_path('uploads/deal_files/' . $file->file_path);
                if(file_exists($path))
                {
                    \File::delete($path);
                }
                $file->delete();

                return response()->json(['is_success' => true], 200);
            }
            else
            {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission denied.'),
                    ], 200
                );
            }
        }
        else
        {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission denied.'),
                ], 200
            );

        }
    }

    public function noteStore($id, Request $request)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
        {
            $deal        = Deal::find($id);
            $deal->notes = $request->notes;
            $deal->save();

            return response()->json(
                [
                    'is_success' => true,
                    'success' => __('Note successfully saved.'),
                ], 200
            );
        }
        else
        {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission denied.'),
                ], 200
            );
        }
    }


    public function taskCreate($id)
    {
        $deal       = Deal::find($id);
        $priorities = DealTask::$priorities;
        $status     = DealTask::$status;

        return view('deal.tasks', compact('deal', 'priorities', 'status'));
    }

    public function taskStore($id, Request $request)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
        {
            $usr        = \Auth::user();
            $deal       = Deal::find($id);
            $clients    = ClientDeal::select('client_id')->where('deal_id', '=', $id)->get()->pluck('client_id')->toArray();
            $deal_users = $deal->users->pluck('id')->toArray();
            $usrs       = User::whereIN('id', array_merge($deal_users, $clients))->get()->pluck('email', 'id')->toArray();

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'date' => 'required',
                                   'time' => 'required',
                                   'priority' => 'required',
                                   'status' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $dealTask = DealTask::create(
                [
                    'deal_id' => $deal->id,
                    'name' => $request->name,
                    'date' => $request->date,
                    'time' => date('H:i:s', strtotime($request->date . ' ' . $request->time)),
                    'priority' => $request->priority,
                    'status' => $request->status,
                ]
            );

            ActivityLog::create(
                [
                    'user_id' => $usr->id,
                    'deal_id' => $deal->id,
                    'log_type' => 'Create Task',
                    'remark' => json_encode(['title' => $dealTask->name]),
                ]
            );

            return redirect()->back()->with('success', __('Task successfully created.'))->with('status', 'tasks');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function taskShow($id, $task_id)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal = Deal::find($id);
            $task = DealTask::find($task_id);

            return view('deal.tasksShow', compact('task', 'deal'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function taskEdit($id, $task_id)
    {
        $deal       = Deal::find($id);
        $priorities = DealTask::$priorities;
        $status     = DealTask::$status;
        $task       = DealTask::find($task_id);

        return view('deal.tasks', compact('task', 'deal', 'priorities', 'status'));
    }

    public function taskUpdate($id, $task_id, Request $request)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
        {
            $deal      = Deal::find($id);
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'date' => 'required',
                                   'time' => 'required',
                                   'priority' => 'required',
                                   'status' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $task = DealTask::find($task_id);

            $task->update(
                [
                    'name' => $request->name,
                    'date' => $request->date,
                    'time' => date('H:i:s', strtotime($request->date . ' ' . $request->time)),
                    'priority' => $request->priority,
                    'status' => $request->status,
                ]
            );

            return redirect()->back()->with('success', __('Task successfully updated.'))->with('status', 'tasks');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function taskUpdateStatus($id, $task_id, Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal      = Deal::find($id);
            $validator = \Validator::make(
                $request->all(), [
                                   'status' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return response()->json(
                    [
                        'is_success' => false,
                        'error' => $messages->first(),
                    ], 401
                );
            }

            $task = DealTask::find($task_id);
            if($request->status)
            {
                $task->status = 0;
            }
            else
            {
                $task->status = 1;
            }
            $task->save();

            return response()->json(
                [
                    'is_success' => true,
                    'success' => __('Task successfully updated.'),
                    'status' => $task->status,
                    'status_label' => __(DealTask::$status[$task->status]),
                ], 200
            );
        }
        else
        {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission denied.'),
                ], 200
            );
        }
    }

    public function taskDestroy($id, $task_id)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal = Deal::find($id);
            $task = DealTask::find($task_id);
            $task->delete();

            return redirect()->back()->with('success', __('Task successfully deleted.'))->with('status', 'tasks');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function sourceEdit($id)
    {
        $deal    = Deal::find($id);
        $sources = Source::where('created_by', '=', \Auth::user()->creatorId())->get();

        $selected = $deal->sources();
        if($selected)
        {
            $selected = $selected->pluck('name', 'id')->toArray();
        }

        return view('deal.sources', compact('deal', 'sources', 'selected'));
    }

    public function sourceUpdate($id, Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $usr = \Auth::user();

            $deal       = Deal::find($id);
            $clients    = ClientDeal::select('client_id')->where('deal_id', '=', $id)->get()->pluck('client_id')->toArray();
            $deal_users = $deal->users->pluck('id')->toArray();

            if(!empty($request->sources) && count($request->sources) > 0)
            {
                $deal->sources = implode(',', $request->sources);
            }
            else
            {
                $deal->sources = "";
            }
            $deal->save();
            ActivityLog::create(
                [
                    'user_id' => $usr->id,
                    'deal_id' => $deal->id,
                    'log_type' => 'Update Sources',
                    'remark' => json_encode(['title' => 'Update Sources']),
                ]
            );


            return redirect()->back()->with('success', __('Sources successfully updated.'))->with('status', 'sources');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function sourceDestroy($id, $source_id)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal    = Deal::find($id);
            $sources = explode(',', $deal->sources);
            foreach($sources as $key => $source)
            {
                if($source_id == $source)
                {
                    unset($sources[$key]);
                }
            }
            $deal->sources = implode(',', $sources);
            $deal->save();

            return redirect()->back()->with('success', __('Sources successfully deleted.'))->with('status', 'sources');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function discussionCreate($id)
    {

        $deal = Deal::find($id);

        return view('deal.discussions', compact('deal'));
    }

    public function discussionStore($id, Request $request)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
        {
            $usr        = \Auth::user();
            $deal       = Deal::find($id);
            $clients    = ClientDeal::select('client_id')->where('deal_id', '=', $id)->get()->pluck('client_id')->toArray();
            $deal_users = $deal->users->pluck('id')->toArray();

            $discussion             = new DealDiscussion();
            $discussion->comment    = $request->comment;
            $discussion->deal_id    = $deal->id;
            $discussion->created_by = \Auth::user()->id;
            $discussion->save();

            return redirect()->back()->with('success', __('Message successfully created.'))->with('status', 'discussion');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function callCreate($id)
    {

        $deal  = Deal::find($id);
        $users = UserDeal::where('deal_id', '=', $deal->id)->get();

        return view('deal.calls', compact('deal', 'users'));
    }

    public function callStore($id, Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $usr = \Auth::user();

            $deal      = Deal::find($id);
            $validator = \Validator::make(
                $request->all(), [
                                   'subject' => 'required',
                                   'call_type' => 'required',
                                   'user_id' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            DealCall::create(
                [
                    'deal_id' => $deal->id,
                    'subject' => $request->subject,
                    'call_type' => $request->call_type,
                    'duration' => $request->duration,
                    'user_id' => $request->user_id,
                    'description' => $request->description,
                    'call_result' => $request->call_result,
                ]
            );

            ActivityLog::create(
                [
                    'user_id' => $usr->id,
                    'deal_id' => $deal->id,
                    'log_type' => 'Create Deal Call',
                    'remark' => json_encode(['title' => 'Create new Deal Call']),
                ]
            );


            return redirect()->back()->with('success', __('Call successfully created.'))->with('status', 'calls');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function callEdit($id, $call_id)
    {
        $deal  = Deal::find($id);
        $call  = DealCall::find($call_id);
        $users = UserDeal::where('deal_id', '=', $deal->id)->get();

        return view('deal.calls', compact('call', 'deal', 'users'));
    }

    public function callUpdate($id, $call_id, Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal      = Deal::find($id);
            $validator = \Validator::make(
                $request->all(), [
                                   'subject' => 'required',
                                   'call_type' => 'required',
                                   'user_id' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $call = DealCall::find($call_id);

            $call->update(
                [
                    'subject' => $request->subject,
                    'call_type' => $request->call_type,
                    'duration' => $request->duration,
                    'user_id' => $request->user_id,
                    'description' => $request->description,
                    'call_result' => $request->call_result,
                ]
            );

            return redirect()->back()->with('success', __('Call successfully updated.'))->with('status', 'calls');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function callDestroy($id, $call_id)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal = Deal::find($id);
            $task = DealCall::find($call_id);
            $task->delete();

            return redirect()->back()->with('success', __('Call successfully deleted.'))->with('status', 'calls');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function emailCreate($id)
    {
        $deal = Deal::find($id);

        return view('deal.emails', compact('deal'));
    }

    public function emailStore($id, Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal      = Deal::find($id);
            $settings  = Utility::settings();
            $validator = \Validator::make(
                $request->all(), [
                                   'to' => 'required|email',
                                   'subject' => 'required',
                                   'description' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $dealEmail = DealEmail::create(
                [
                    'deal_id' => $deal->id,
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'description' => $request->description,
                ]
            );

            ActivityLog::create(
                [
                    'user_id' => \Auth::user()->id,
                    'deal_id' => $deal->id,
                    'log_type' => 'Create Deal Email',
                    'remark' => json_encode(['title' => 'Create new Deal Email']),
                ]
            );

            return redirect()->back()->with('success', __('Email successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function clientEdit($id)
    {
        $deal    = Deal::find($id);
        $clients = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'Client')->whereNOTIn(
            'id', function ($q) use ($deal){
            $q->select('client_id')->from('client_deals')->where('deal_id', '=', $deal->id);
        }
        )->get()->pluck('name', 'id');


        return view('deal.clients', compact('deal', 'clients'));
    }

    public function clientUpdate($id, Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal = Deal::find($id);
            if(!empty($request->clients))
            {
                $clients = array_filter($request->clients);
                foreach($clients as $client)
                {
                    ClientDeal::create(
                        [
                            'deal_id' => $deal->id,
                            'client_id' => $client,
                        ]
                    );
                }
            }

            if(!empty($clients) && !empty($request->clients))
            {
                return redirect()->back()->with('success', __('Clients successfully updated.'))->with('status', 'clients');
            }
            else
            {
                return redirect()->back()->with('error', __('Please select valid clients.'))->with('status', 'clients');
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function clientDestroy($id, $client_id)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal = Deal::find($id);

            ClientDeal::where('deal_id', '=', $deal->id)->where('client_id', '=', $client_id)->delete();

            return redirect()->back()->with('success', __('Client successfully deleted.'))->with('status', 'clients');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function labels($id)
    {
        $deal     = Deal::find($id);
        $labels   = Label::where('pipeline_id', '=', $deal->pipeline_id)->get();
        $selected = $deal->labels();
        if($selected)
        {
            $selected = $selected->pluck('name', 'id')->toArray();
        }
        else
        {
            $selected = [];
        }

        return view('deal.labels', compact('deal', 'labels', 'selected'));
    }

    public function labelStore($id, Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            $deal = Deal::find($id);
            if($request->labels)
            {
                $deal->labels = implode(',', $request->labels);
            }
            else
            {
                $deal->labels = $request->labels;
            }
            $deal->save();

            return redirect()->back()->with('success', __('Labels successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function deal_list()
    {
        $usr = \Auth::user();

        if($usr->default_pipeline)
        {
            $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->where('id', '=', $usr->default_pipeline)->first();
            if(!$pipeline)
            {
                $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
            }
        }
        else
        {
            $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
        }

        $pipelines = Pipeline::where('created_by', '=', $usr->creatorId())->get()->pluck('name', 'id');

        $deals       = Deal::where('created_by', '=', $usr->creatorId())->where('pipeline_id', '=', $pipeline->id)->get();
        $curr_month  = Deal::where('created_by', '=', $usr->creatorId())->where('pipeline_id', '=', $pipeline->id)->whereMonth('created_at', '=', date('m'))->get();
        $curr_week   = Deal::where('created_by', '=', $usr->creatorId())->where('pipeline_id', '=', $pipeline->id)->whereBetween(
            'created_at', [
                            \Carbon\Carbon::now()->startOfWeek(),
                            \Carbon\Carbon::now()->endOfWeek(),
                        ]
        )->get();
        $last_30days = Deal::where('created_by', '=', $usr->creatorId())->where('pipeline_id', '=', $pipeline->id)->whereDate('created_at', '>', \Carbon\Carbon::now()->subDays(30))->get();

        // Deal Summary
        $cnt_deal                = [];
        $cnt_deal['total']       = \App\Deal::getDealSummary($deals);
        $cnt_deal['this_month']  = \App\Deal::getDealSummary($curr_month);
        $cnt_deal['this_week']   = \App\Deal::getDealSummary($curr_week);
        $cnt_deal['last_30days'] = \App\Deal::getDealSummary($last_30days);

        // Deals
        if($usr->type == 'client')
        {
            $deals = Deal::select('deals.*')->join('client_deals', 'client_deals.deal_id', '=', 'deals.id')->where('client_deals.client_id', '=', $usr->id)->orderBy('deals.order')->get();

        }
        else
        {
            $deals = Deal::select('deals.*')->join('user_deals', 'user_deals.deal_id', '=', 'deals.id')->where('user_deals.user_id', '=', $usr->id)->orderBy('deals.order')->get();
        }

        return view('deal.list', compact('pipelines', 'pipeline', 'deals', 'cnt_deal'));
    }

    public function changePipeline(Request $request)
    {

        if(\Auth::user()->type == 'company')
        {
            $user                   = \Auth::user();
            $user->default_pipeline = $request->pipeline_id;
            $user->save();

            return redirect()->back()->with('success', __('Pipeline succefully change.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $deal         = Deal::where('id', '=', $id)->first();
        $deal->status = $request->deal_status;
        $deal->save();

        return redirect()->back();
    }

}
