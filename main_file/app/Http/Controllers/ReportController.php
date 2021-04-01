<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Department;
use App\Employee;
use App\Estimate;
use App\Expense;
use App\Invoice;
use App\Lead;
use App\Leave;
use App\LeaveType;
use App\Project;
use App\ProjectStage;
use App\ProjectTask;
use App\Timesheet;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function task(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $projects = Project::where('created_by', \Auth::user()->creatorId());
            if (!empty($request->project)) {
                $projects->where('id', $request->project);
            }

            $projects = $projects->get();

            $projectStages = ProjectStage::where('created_by', \Auth::user()->creatorId())->get();
            $stages        = $label = $color = $data = [];
            $total         = 0;

            $filter['endDateRange']   = $end_date = date('Y-m-d');
            $filter['startDateRange'] = $start_date = date('Y-m-d', strtotime('-30 days'));
            $filter['project']        = __('All');
            $filter['employee']       = __('All');

            foreach ($projectStages as $stage) {
                $tasks = ProjectTask::where('stage', $stage->id);

                if (isset($request->project) && !empty($request->project)) {
                    $tasks->where('project_id', $request->project);
                    $proj              = Project::find($request->project);
                    $filter['project'] = $proj->title;
                }

                if ((isset($request->start_date) && !empty($request->start_date)) && (isset($request->end_date) && !empty($request->end_date))) {
                    $tasks->whereBetween(
                        'start_date',
                        [
                                        $request->start_date,
                                        $request->end_date,
                                    ]
                    );
                    $filter['startDateRange'] = $request->start_date;
                    $filter['endDateRange']   = $request->end_date;
                } else {
                    $tasks->whereBetween(
                        'start_date',
                        [
                                        $start_date,
                                        $end_date,
                                    ]
                    );
                }


                if (!empty($request->employee)) {
                    $tasks->where('assign_to', $request->employee);
                    $emp                = User::find($request->employee);
                    $filter['employee'] = $emp->name;
                }

                $task['stage'] = $label[] = $stage->name;
                $task['color'] = $color[] = $stage->color;
                $task['total'] = $totalTask = $data[] = $tasks->count();

                $stages[] = $task;
                $total    += $totalTask;
            }

            $projectList = Project::where('created_by', \Auth::user()->creatorId())->get()->pluck('title', 'id');
            $projectList->prepend('All', '');

            $employees = User::where('created_by', \Auth::user()->creatorId())->where('type', 'employee')->get()->pluck('name', 'id');
            $employees->prepend('All', '');


            return view('report.task', compact('projects', 'stages', 'total', 'label', 'data', 'color', 'projectList', 'employees', 'filter'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function timelog(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $filter['endDateRange']   = $end_date = date('Y-m-d');
            $filter['startDateRange'] = $start_date = date('Y-m-d', strtotime('-15 days'));
            $filter['project']        = __('All');
            $filter['employee']       = __('All');
            $filter['task']           = __('All');

            $timesheets = Timesheet::where('created_by', \Auth::user()->creatorId());


            if ((isset($request->start_date) && !empty($request->start_date)) && (isset($request->end_date) && !empty($request->end_date))) {
                $timesheets->whereBetween(
                    'start_date',
                    [
                                    $request->start_date,
                                    $request->end_date,
                                ]
                );


                $filter['startDateRange'] = $request->start_date;
                $filter['endDateRange']   = $request->end_date;
            } else {
                $timesheets->whereBetween(
                    'start_date',
                    [
                                    $start_date,
                                    $end_date,
                                ]
                );
            }


            if (isset($request->project) && !empty($request->project)) {
                $timesheets->where('project_id', $request->project);


                $proj              = Project::find($request->project);
                $filter['project'] = $proj->title;
            }

            if (isset($request->task) && !empty($request->task)) {
                $timesheets->where('task_id', $request->task);

                $task           = ProjectTask::find($request->task);
                $filter['task'] = $task->title;
            }

            if (isset($request->employee) && !empty($request->employee)) {
                $timesheets->where('employee', $request->employee);

                $emp                = User::find($request->employee);
                $filter['employee'] = $emp->name;
            }

            $timesheets = $timesheets->get();


            $projectList = Project::where('created_by', \Auth::user()->creatorId())->get()->pluck('title', 'id');
            $projectList->prepend('All', '');

            $employees = User::where('created_by', \Auth::user()->creatorId())->where('type', 'employee')->get()->pluck('name', 'id');
            $employees->prepend('All', '');

            $tasks = ProjectTask::select('project_tasks.*')->leftjoin('projects', 'project_tasks.project_id', 'projects.id')->get()->pluck('title', 'id');
            $tasks->prepend('All', '');

            $labels = [];
            $data   = [];

            $start = strtotime($filter['startDateRange']);
            $end   = strtotime($filter['endDateRange']);

            $currentdate = $start;

            while ($currentdate <= $end) {
                $currentDateFormat = date('Y-m-d', $currentdate);

                $timesheetsFilter = Timesheet::where('created_by', \Auth::user()->creatorId())->where('start_date', $currentDateFormat);

                if (isset($request->project) && !empty($request->project)) {
                    $timesheetsFilter->where('project_id', $request->project);
                }

                if (isset($request->task) && !empty($request->task)) {
                    $timesheetsFilter->where('task_id', $request->task);
                }
                if (isset($request->employee) && !empty($request->employee)) {
                    $timesheetsFilter->where('employee', $request->employee);
                }
                $timesheetsFilter = $timesheetsFilter->get();

                $hours = 0;
                foreach ($timesheetsFilter as $timesheet) {
                    $t1    = strtotime($timesheet->end_date . ' ' . $timesheet->end_time);
                    $t2    = strtotime($timesheet->start_date . ' ' . $timesheet->start_time);
                    $diff  = $t1 - $t2;
                    $hours += number_format($diff / (60 * 60), 2);
                }

                $currentdate = strtotime('+1 days', $currentdate);
                $labels[]    = date('d-M', strtotime($currentDateFormat));
                $data[]      = $hours;
            }


            return view('report.timelog', compact('timesheets', 'projectList', 'employees', 'tasks', 'labels', 'data', 'filter'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function finance(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $filter['project'] = __('All');
            $filter['client']  = __('All');

            $projectList = Project::where('created_by', \Auth::user()->creatorId())->get()->pluck('title', 'id');
            $projectList->prepend('All', '');

            $clients = User::where('created_by', \Auth::user()->creatorId())->where('type', 'client')->get()->pluck('name', 'id');
            $clients->prepend('All', '');

            $invoices = Invoice::where('created_by', \Auth::user()->creatorId());

            if (!empty($request->start_month) && !empty($request->end_month)) {
                $start = strtotime($request->start_month);
                $end   = strtotime($request->end_month);
            } else {
                $start = strtotime(date('Y-01-01'));
                $end   = strtotime(date('Y-12-31'));
            }

            $invoices->where('issue_date', '>=', date('Y-m-d', $start))->where('issue_date', '<=', date('Y-m-d', $end));


            if (isset($request->project) && !empty($request->project)) {
                $invoices->where('project', $request->project);
                $proj              = Project::find($request->project);
                $filter['project'] = $proj->title;
            }

            if (isset($request->client) && !empty($request->client)) {
                $invoices->where('client', $request->client);
                $client           = User::find($request->client);
                $filter['client'] = $client->name;
            }

            $invoices = $invoices->get();
            //        dd($invoices);
            $labels = [];
            $data   = [];

            $currentdate = $start;

            while ($currentdate <= $end) {
                $monthYearList[] = date('Y-m', $currentdate);

                $currentdate = strtotime('+1 month', $currentdate);
            }

            $invoicesTotal = $invoicesDue = $invoicesTax = $invoicesDiscount = 0;
            foreach ($monthYearList as $monthYearDate) {
                $dateFormat = strtotime($monthYearDate);
                $month      = date('m', $dateFormat);
                $year       = date('Y', $dateFormat);

                $invoicesFilter = Invoice::where('created_by', \Auth::user()->creatorId())->whereMonth('issue_date', $month)->whereYear('issue_date', $year);

                if (isset($request->project) && !empty($request->project)) {
                    $invoicesFilter->where('project', $request->project);
                }
                if (isset($request->client) && !empty($request->client)) {
                    $invoicesFilter->where('client', $request->client);
                }
                $invoicesFilter = $invoicesFilter->get();


                $total = $due = $tax = $discount = 0;
                foreach ($invoicesFilter as $invoice) {
                    $total    += $invoice->getTotal();
                    $due      += $invoice->getDue();
                    $tax      += $invoice->getTotalTax();
                    $discount += $invoice->getTotalDiscount();
                }
                $invoicesTotal    += $total;
                $invoicesDue      += $due;
                $invoicesTax      += $tax;
                $invoicesDiscount += $discount;
                $data[]           = $total;
                $labels[]         = date('M Y', $dateFormat);
            }

            $filter['startDateRange'] = date('M-Y', $start);
            $filter['endDateRange']   = date('M-Y', $end);

            return view('report.finance', compact('invoices', 'projectList', 'clients', 'labels', 'data', 'filter', 'invoicesTotal', 'invoicesDue', 'invoicesTax', 'invoicesDiscount'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function incomeVsExpense(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $invoices     = Invoice::where('created_by', \Auth::user()->creatorId());
            $labels       = $data = [];
            $expenseCount = $incomeCount = 0;

            if (!empty($request->start_month) && !empty($request->end_month)) {
                $start = strtotime($request->start_month);
                $end   = strtotime($request->end_month);
            } else {
                $start = strtotime(date('Y-01-01'));
                $end   = strtotime(date('Y-12-31'));
            }
            
            // print($start . " " . $end);
            // exit();
            
            
            $invoicesFilter = Invoice::selectRaw('invoices.*,MONTH(send_date) as month,YEAR(send_date) as year')->where('created_by', \Auth::user()->creatorId());
            if (!empty($request->start_month) && !empty($request->end_month)) {
                $invoicesFilter->where('send_date', '>=', date('Y-m-d', $start))->where('send_date', '<=', date('Y-m-t', $end));
            }
            $invoicesFilter = $invoicesFilter->get();

            $invoicesTotal     = 0;
            $invoiceTotalArray = [];
            foreach ($invoicesFilter as $invoice) {
                $invoicesTotal += $invoice->getTotal();
                $invoiceTotalArray[$invoice->month][] = $invoice->getTotal();
            }
            $incomeCount += $invoicesTotal;

            for ($i = 1; $i <= 12; $i++) {
                $incomeData[] = array_key_exists($i, $invoiceTotalArray) ? array_sum($invoiceTotalArray[$i]) : 0;
            }

            $expenseFilter    = Expense::selectRaw('expenses.*,MONTH(date) as month,YEAR(date) as year')->where('created_by', \Auth::user()->creatorId())->where('date', '>=', date('Y-m-01', $start))->where('date', '<=', date('Y-m-t', $end))->get();
            $expenseTotal     = 0;
            $expeseTotalArray = [];
            foreach ($expenseFilter as $expense) {
                $expenseTotal                        += $expense->amount;
                $expeseTotalArray[$expense->month][] = $expense->amount;
            }
            $expenseCount += $expenseTotal;

            for ($i = 1; $i <= 12; $i++) {
                $expenseData[] = array_key_exists($i, $expeseTotalArray) ? array_sum($expeseTotalArray[$i]) : 0;
            }

            $currentdate = $start;
            while ($currentdate <= $end) {
                $labels[]    = date('d M Y', $currentdate);
                $currentdate = strtotime('+1 month', $currentdate);
            }


            $incomeArr['label']           = __('Income');
            $incomeArr['borderColor']     = '#6777ef';
            $incomeArr['fill']            = '!0';
            $incomeArr['backgroundColor'] = '#6777ef';
            $incomeArr['data']            = $incomeData;

            $expenseArr['label']           = __('Expense');
            $expenseArr['borderColor']     = '#fc544b';
            $expenseArr['fill']            = '!0';
            $expenseArr['backgroundColor'] = '#fc544b';
            $expenseArr['data']            = $expenseData;

            $data[] = $incomeArr;
            $data[] = $expenseArr;

            $filter['startDateRange'] = date('d-M-Y', $start);
            $filter['endDateRange']   = date('d-M-Y', $end);

            return view('report.income_expense', compact('invoices', 'labels', 'data', 'incomeCount', 'expenseCount', 'filter'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function leave(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $department = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $department->prepend('All', '');
            $filterYear['department']    = __('All');
            $filterYear['type']          = __('Monthly');
            $filterYear['dateYearRange'] = date('M-Y');
            $employees                   = Employee::where('created_by', \Auth::user()->creatorId());
            if (!empty($request->department)) {
                $employees->where('department', $request->department);
                $filterYear['department'] = !empty(Department::find($request->department)) ? Department::find($request->department)->name : '';
            }
            $employees = $employees->get();
            
            $leaves        = [];
            $totalApproved = $totalReject = $totalPending = 0;
            foreach ($employees as $employee) {
                $employeeLeave['id']          = $employee->user_id;
                $employeeLeave['employee_id'] = $employee->employee_id;
                $employeeLeave['employee']    = !empty($employee->users) ? $employee->users->name : '';
                
                $approved = Leave::where('employee_id', $employee->user_id)->where('status', 'Approve');
                $reject   = Leave::where('employee_id', $employee->user_id)->where('status', 'Reject');
                $pending  = Leave::where('employee_id', $employee->user_id)->where('status', 'Pending');
                
                if ($request->type == 'monthly' && !empty($request->month)) {
                    $month = date('m', strtotime($request->month));
                    $year  = date('Y', strtotime($request->month));
                    
                    $approved->whereMonth('applied_on', $month)->whereYear('applied_on', $year);
                    $reject->whereMonth('applied_on', $month)->whereYear('applied_on', $year);
                    $pending->whereMonth('applied_on', $month)->whereYear('applied_on', $year);

                    $filterYear['dateYearRange'] = date('M-Y', strtotime($request->month));
                    $filterYear['type']          = __('Monthly');
                } elseif (!isset($request->type)) {
                    $month     = date('m');
                    $year      = date('Y');
                    $monthYear = date('Y-m');
                    
                    $approved->whereMonth('applied_on', $month)->whereYear('applied_on', $year);
                    $reject->whereMonth('applied_on', $month)->whereYear('applied_on', $year);
                    $pending->whereMonth('applied_on', $month)->whereYear('applied_on', $year);
                    
                    $filterYear['dateYearRange'] = date('M-Y', strtotime($monthYear));
                    $filterYear['type']          = __('Monthly');
                }
                
                
                if ($request->type == 'yearly' && !empty($request->year)) {
                    $approved->whereYear('applied_on', $request->year);
                    $reject->whereYear('applied_on', $request->year);
                    $pending->whereYear('applied_on', $request->year);
                    
                    
                    $filterYear['dateYearRange'] = $request->year;
                    $filterYear['type']          = __('Yearly');
                }
                
                $approved = $approved->count();
                $reject   = $reject->count();
                $pending  = $pending->count();
                
                $totalApproved += $approved;
                $totalReject   += $reject;
                $totalPending  += $pending;
                
                $employeeLeave['approved'] = $approved;
                $employeeLeave['reject']   = $reject;
                $employeeLeave['pending']  = $pending;
                

                $leaves[] = $employeeLeave;
            }
            
            $starting_year = date('Y', strtotime('-5 year'));
            $ending_year   = date('Y', strtotime('+5 year'));
            
            $filterYear['starting_year'] = $starting_year;
            $filterYear['ending_year']   = $ending_year;
            
            $filter['totalApproved'] = $totalApproved;
            $filter['totalReject']   = $totalReject;
            $filter['totalPending']  = $totalPending;
            
            return view('report.leave', compact('department', 'leaves', 'filterYear', 'filter'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function employeeLeave(Request $request, $employee_id, $status)
    {
        if (\Auth::user()->type == 'company') {
            $leaveTypes = LeaveType::where('created_by', \Auth::user()->creatorId())->get();
            $leaves     = [];
            foreach ($leaveTypes as $leaveType) {
                $leave        = new Leave();
                $leave->title = $leaveType->title;
                $leave->total = Leave::where('employee_id', $employee_id)->where('status', $status)->where('leave_type', $leaveType->id)->count();
                $leaves[]     = $leave;
            }
            $leaveData = Leave::where('employee_id', $employee_id)->where('status', $status)->get();

            return view('report.leaveShow', compact('leaves', 'leaveData'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function estimate(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $filter['status'] = __('All');
            $filter['client'] = __('All');

            $status = Estimate::$statues;

            $clients = User::where('created_by', \Auth::user()->creatorId())->where('type', 'client')->get()->pluck('name', 'id');
            $clients->prepend('All', '');

            $estimates = Estimate::orderBy('id');

            if (!empty($request->client)) {
                $estimates->where('client', $request->client);
                $client           = User::find($request->client);
                $filter['client'] = $client->name;
            }

            if ($request->status != '') {
                $estimates->where('status', $request->status);
                $filter['status'] = Estimate::$statues[$request->status];
            }

            if (!empty($request->start_month) && !empty($request->end_month)) {
                $start = strtotime($request->start_month);
                $end   = strtotime($request->end_month);
            } else {
                $start = strtotime(date('Y-01-d'));
                $end   = strtotime(date('Y-12-31'));
            }

            $estimates->where('send_date', '>=', date('Y-m-d', $start))->where('send_date', '<=', date('Y-m-d', $end));

            $estimates->where('created_by', \Auth::user()->creatorId());
            $estimates = $estimates->get();

            $totalEstimation = $totalTax = $totalDiscount = 0;
            foreach ($estimates as $estimation) {
                $totalEstimation += $estimation->getTotal();
                $totalTax        += $estimation->getTotalTax();
                $totalDiscount   += $estimation->getTotalDiscount();
            }
            $filter['startDateRange'] = date('M-Y', $start);
            $filter['endDateRange']   = date('M-Y', $end);

            return view('report.estimate', compact('status', 'clients', 'estimates', 'filter', 'totalEstimation', 'totalTax', 'totalDiscount'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function invoice(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $filter['status'] = __('All');
            $filter['client'] = __('All');

            $status = Invoice::$statues;

            $clients = User::where('created_by', \Auth::user()->creatorId())->where('type', 'client')->get()->pluck('name', 'id');
            $clients->prepend('All', '');

            $invoices = Invoice::orderBy('id');

            if (!empty($request->client)) {
                $invoices->where('client', $request->client);
                $client = User::find($request->client);
                $filter['client'] = $client->name;
            }

            
            if ($request->status != '') {
                $invoices->where('status', $request->status);
                $filter['status'] = Invoice::$statues[$request->status];
            }
            
            if (!empty($request->start_month) && !empty($request->end_month)) {
                $start = date('Y-m-d', strtotime($request->start_month));
                $end   = date('Y-m-d', strtotime($request->end_month));
            // $start = date('Y-m-d', $request->start_month);
                // $end = date('Y-m-d', $request->end_month);
            } else {
                $start = date('Y-1-31');
                $end   = date('Y-12-31');
            }

            // print($request->start_month . " " . $request->end_month . "<br>");
            // print($start . " " . $end);
            // exit();
            $invoices->where('send_date', '>=', $start)->where('send_date', '<=', $end);
                    
            $invoices->where('created_by', \Auth::user()->creatorId());
            $invoices = $invoices->get();
            
            if (!empty($request->payment_method)) {
                $invoices = $invoices->filter(function ($val, $key) use ($request) {
                    $invoicePayments = \App\InvoicePayment::query()->where("invoice", $val->id)->where("payment_method", $request->payment_method)->get();
                    if ($invoicePayments->isEmpty()) {
                        return false;
                    } else {
                        return true;
                    }
                });
                $invoices = $invoices->all();
            }
            // dd($invoices);

            $totalInvoice = $totalDue = $totalTax = $totalDiscount = 0;
            foreach ($invoices as $invoice) {
                $totalInvoice  += $invoice->getTotal();
                $totalDue      += $invoice->getDue();
                $totalTax      += $invoice->getTotalTax();
                $totalDiscount += $invoice->getTotalDiscount();
            }
            $filter['startDateRange'] = $start;
            $filter['endDateRange']   = $end;

            $paymentMethods = \App\PaymentMethod::query()->where("created_by", \Auth::user()->creatorId())->get()->toArray();

            return view('report.invoice', compact('status', 'clients', 'invoices', 'filter', 'totalInvoice', 'totalDue', 'totalTax', 'totalDiscount', 'paymentMethods'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function client(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $start = strtotime(date('Y-01'));
            $end   = strtotime(date('Y-12'));
            
            $filter['client'] = __('All');

            $clients = User::where('created_by', \Auth::user()->creatorId())->where('type', 'client')->get()->pluck('name', 'id');
            $clients->prepend('All', '');

            $clientFilter = User::where('created_by', \Auth::user()->creatorId())->where('type', 'client');

            if (!empty($request->client)) {
                $clientFilter->where('id', $request->client);
                $client           = User::find($request->client);
                $filter['client'] = $client->name;
            }

            $clientFilter = $clientFilter->get();

            $clientReport       = [];
            $clientTotalInvoice = $clientTotalAmount = $clientTotalDue = $clientTotalTax = $clientTotalDiscount = $clientTotalPaid = 0;
            foreach ($clientFilter as $client) {
                $clientData['client'] = $client->name;
                $totalAmount          = $totalTax = $totalDiscount = $totalDue = $totalPaid = 0;
                $clientInvoice        = Invoice::orderBy('id');

                if (!empty($request->start_month) && !empty($request->end_month)) {
                    $start = strtotime($request->start_month);
                    $end   = strtotime($request->end_month);
                }


                $clientInvoice->where('client', $client->id);
                $clientInvoice->where('send_date', '>=', date('Y-m-01', $start))->where('send_date', '<=', date('Y-m-t', $end));

                $clientInvoice->where('created_by', \Auth::user()->creatorId());
                $clientInvoice = $clientInvoice->get();

                $clientData['totalInvoice'] = count($clientInvoice);
                $clientTotalInvoice         += count($clientInvoice);

                foreach ($clientInvoice as $invoice) {
                    $totalAmount   += $invoice->getTotal();
                    $totalTax      += $invoice->getTotalTax();
                    $totalDiscount += $invoice->getTotalDiscount();
                    $totalDue      += $invoice->getDue();
                    $totalPaid     += $invoice->getTotal() - $invoice->getDue();
                }

                $clientTotalAmount   += $totalAmount;
                $clientTotalTax      += $totalTax;
                $clientTotalDiscount += $totalDiscount;
                $clientTotalDue      += $totalDue;
                $clientTotalPaid     += $totalPaid;


                $clientData['totalAmount']   = $totalAmount;
                $clientData['totalTax']      = $totalTax;
                $clientData['totalDiscount'] = $totalDiscount;
                $clientData['totalDue']      = $totalDue;
                $clientData['totalPaid']     = $totalPaid;
                $clientReport[]              = $clientData;
            }

            $filter['startDateRange'] = date('M-Y', $start);
            $filter['endDateRange']   = date('M-Y', $end);

            return view('report.client', compact('clients', 'clientReport', 'filter', 'clientTotalInvoice', 'clientTotalAmount', 'clientTotalTax', 'clientTotalDiscount', 'clientTotalDue', 'clientTotalPaid'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function lead(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $labels = [];
            $data   = [];


            if (!empty($request->start_month) && !empty($request->end_month)) {
                $start = strtotime($request->start_month);
                $end   = strtotime($request->end_month);
            } else {
                $start = strtotime(date('Y-01'));
                $end   = strtotime(date('Y-12'));
            }

            $leads = Lead::orderBy('id');
            $leads->where('date', '>=', date('Y-m-01', $start))->where('date', '<=', date('Y-m-t', $end));
            $leads->where('created_by', \Auth::user()->creatorId());
            $leads = $leads->get();

            $currentdate = $start;
            while ($currentdate <= $end) {
                $month = date('m', $currentdate);
                $year  = date('Y', $currentdate);

                $leadFilter = Lead::where('created_by', \Auth::user()->creatorId())->whereMonth('date', $month)->whereYear('date', $year)->get();

                $data[]      = count($leadFilter);
                $labels[]    = date('M Y', $currentdate);
                $currentdate = strtotime('+1 month', $currentdate);
            }

            $filter['startDateRange'] = date('M-Y', $start);
            $filter['endDateRange']   = date('M-Y', $end);

            return view('report.lead', compact('labels', 'data', 'filter', 'leads'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function payment(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $paymentMethods = \App\PaymentMethod::query()->where("created_by", \Auth::user()->creatorId())->get()->toArray();
            $paymentReceipts = \App\InvoicePayment::query();
            if (!empty($request->start_month) && !empty($request->end_month)) {
                $start = $request->start_month;
                $end = $request->end_month;
            } else {
                $start = date('Y-1-31');
                $end = date('Y-12-31');
            }
            // print($start . " " . $end);
            // exit;
            $paymentReceipts->where("date", ">=", $start)->where("date", "<=", $end);
            $paymentReceipts = $paymentReceipts->get();
            return view('report.payment', compact("paymentMethods", "paymentReceipts"));
        }
    }

    public function attendance(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $department = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $department->prepend('All', '');

            $data['department'] = __('All');

            $employees = Employee::where('created_by', \Auth::user()->creatorId());

            if (!empty($request->department)) {
                $employees->where('department', $request->department);
                $data['department'] = !empty(Department::find($request->department)) ? Department::find($request->department)->name : '';
            }

            $employees = $employees->get();


            if (!empty($request->month)) {
                $currentdate = strtotime($request->month);
                $month       = date('m', $currentdate);
                $year        = date('Y', $currentdate);
                $curMonth    = date('M-Y', strtotime($request->month));
            } else {
                $month    = date('m');
                $year     = date('Y');
                $curMonth = date('M-Y', strtotime($year . '-' . $month));
            }


            $num_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($i = 1; $i <= $num_of_days; $i++) {
                $dates[] = str_pad($i, 2, '0', STR_PAD_LEFT);
            }

            $employeesAttendance = [];
            $totalPresent        = $totalLeave = $totalEarlyLeave = 0;
            $ovetimeHours        = $overtimeMins = $earlyleaveHours = $earlyleaveMins = $lateHours = $lateMins = 0;
            foreach ($employees as $employee) {
                $attendances['name'] = !empty($employee->users) ? $employee->users->name : '';

                foreach ($dates as $date) {
                    $dateFormat = $year . '-' . $month . '-' . $date;

                    if ($dateFormat <= date('Y-m-d')) {
                        $employeeAttendance = Attendance::where('employee_id', $employee->user_id)->where('date', $dateFormat)->first();

                        if (!empty($employeeAttendance) && $employeeAttendance->status == 'Present') {
                            $attendanceStatus[$date] = 'P';
                            $totalPresent            += 1;

                            if ($employeeAttendance->overtime > 0) {
                                $ovetimeHours += date('h', strtotime($employeeAttendance->overtime));
                                $overtimeMins += date('i', strtotime($employeeAttendance->overtime));
                            }

                            if ($employeeAttendance->early_leaving > 0) {
                                $earlyleaveHours += date('h', strtotime($employeeAttendance->early_leaving));
                                $earlyleaveMins  += date('i', strtotime($employeeAttendance->early_leaving));
                            }

                            if ($employeeAttendance->late > 0) {
                                $lateHours += date('h', strtotime($employeeAttendance->late));
                                $lateMins  += date('i', strtotime($employeeAttendance->late));
                            }
                        } elseif (!empty($employeeAttendance) && $employeeAttendance->status == 'Leave') {
                            $attendanceStatus[$date] = 'L';
                            $totalLeave              += 1;
                        } else {
                            $attendanceStatus[$date] = '';
                        }
                    } else {
                        $attendanceStatus[$date] = '';
                    }
                }
                $attendances['status'] = $attendanceStatus;
                $employeesAttendance[] = $attendances;
            }

            $totalOverTime   = $ovetimeHours + ($overtimeMins / 60);
            $totalEarlyleave = $earlyleaveHours + ($earlyleaveMins / 60);
            $totalLate       = $lateHours + ($lateMins / 60);

            $data['totalOvertime']   = $totalOverTime;
            $data['totalEarlyLeave'] = $totalEarlyleave;
            $data['totalLate']       = $totalLate;
            $data['totalPresent']    = $totalPresent;
            $data['totalLeave']      = $totalLeave;
            $data['curMonth']        = $curMonth;

            return view('report.attendance', compact('employeesAttendance', 'department', 'dates', 'data'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
