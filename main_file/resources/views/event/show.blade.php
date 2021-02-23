<div class="form-body">
    <div class="row">
        <div class="col-md-6 ">
            <div class="form-group">
                <label><b>{{__('Event Name')}}</b></label>
                <p> {{$event->name}} </p>
                <p class="font-normal"> — <i>{{__('at')}}</i> {{$event->where}}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="font-12" for="">{{__('Department')}}</label><br>
                <div class="bootstrap-tagsinput">
                    @foreach($dep as $department)
                        <span class="tag badge badge-primary">{{$department}}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="font-12" for="">{{__('Employee')}}</label><br>
                <div class="bootstrap-tagsinput">
                    @foreach($emp as $employee)
                        <span class="tag badge badge-primary">{{$employee}}</span>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 ">
            <div class="form-group">
                <label><b>{{__('Description')}}</b></label>
                <p>{{$event->description}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><b>{{__('Starts On')}}</b></label>
                <p>{{\Auth::user()->dateFormat($event->start_date).' '.\Auth::user()->timeFormat($event->start_time)}}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><b>{{__('Ends On')}}</b></label>
                <p>{{\Auth::user()->dateFormat($event->end_date).' '.\Auth::user()->timeFormat($event->end_time)}}</p>
            </div>
        </div>
    </div>
    @if(\Auth::user()->type == 'company')
        <div class="row">
            <div class="col-md-12 text-right">
            <span class="create-btn">
                <a href="#" data-url="{{ route('event.edit',$event->id) }}" data-ajax-popup="true" data-title="{{__('Edit Event')}}" class="btn btn-outline-primary btn-sm">
                    <i class="fa fa-pencil"></i>  {{__('Edit')}}
                </a>
            </span>
            </div>
        </div>
    @endif
</div>


