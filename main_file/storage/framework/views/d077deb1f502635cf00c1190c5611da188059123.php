<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Event')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>


    <script>
        var Fullcalendar = (function () {
            var $calendar = $('[data-toggle="calendar"]');

            function init($this) {
                var events =<?php echo $arrEvents; ?>,
                    locale = '<?php echo e(basename(App::getLocale())); ?>',

                    options = {
                        header: {
                            right: '',
                            center: '',
                            left: ''
                        },
                        buttonIcons: {
                            prev: 'calendar--prev',
                            next: 'calendar--next'
                        },
                        theme: false,
                        selectable: true,
                        selectHelper: true,
                        editable: true,
                        events: events,

                        dayClick: function (date) {
                            var isoDate = moment(date).toISOString();
                            $('#new-event').modal('show');
                            $('.new-event--title').val('');
                            $('.new-event--start').val(isoDate);
                            $('.new-event--end').val(isoDate);
                        },

                        viewRender: function (view) {
                            var calendarDate = $this.fullCalendar('getDate');
                            var calendarMonth = calendarDate.month();

                            $('.fullcalendar-title').html(view.title);
                        },

                        eventClick: function (event, element) {
                            $('#edit-event input[value=' + event.className + ']').prop('checked', true);
                            $('#edit-event').modal('show');
                            $('.edit-event--id').val(event.id);
                            $('.edit-event--title').val(event.title);
                            $('.edit-event--description').val(event.description);
                        }
                    };

                // Initalize the calendar plugin
                $this.fullCalendar(options);

                //Calendar views switch
                $('body').on('click', '[data-calendar-view]', function (e) {
                    e.preventDefault();

                    $('[data-calendar-view]').removeClass('active');
                    $(this).addClass('active');

                    var calendarView = $(this).attr('data-calendar-view');
                    $this.fullCalendar('changeView', calendarView);
                });


                //Calendar Next
                $('body').on('click', '.fullcalendar-btn-next', function (e) {
                    e.preventDefault();
                    $this.fullCalendar('next');
                });


                //Calendar Prev
                $('body').on('click', '.fullcalendar-btn-prev', function (e) {
                    e.preventDefault();
                    $this.fullCalendar('prev');
                });
            }

            // Init
            if ($calendar.length) {
                init($calendar);
            }

        })();


        $(document).on('change', '#department', function () {
            var department_id = $(this).val();
            getEmployee(department_id);
        });

        function getEmployee(department_id) {

            $.ajax({
                url: '<?php echo e(route('event.employee')); ?>',
                type: 'POST',
                data: {
                    "department": department_id, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#employee').empty();
                    $('#employee').append('<option value="0"> <?php echo e(__('All')); ?> </option>');
                    $.each(data, function (key, value) {
                        $('#employee').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <h6 class="h2 d-inline-block mb-0"><?php echo e(__('Event')); ?></h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Event')); ?></li>
        </ol>
    </nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0"><?php echo e(__('Manage Event')); ?></h2>
                        </div>
                        <?php if(\Auth::user()->type=='company'): ?>
                            <div class="col-auto">
                                <span class="create-btn">
                                    <a href="#" data-url="<?php echo e(route('event.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Event')); ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-plus"></i>  <?php echo e(__('Create')); ?>

                                    </a>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="header header-dark content__title content__title--calendar">
                    <div class="header header-dark bg-primary  content__title content__title--calendar">
                        <div class="container-fluid">
                            <div class="header-body">
                                <div class="row align-items-center py-4">
                                    <div class="col-lg-6">
                                        <h6 class="fullcalendar-title h2 text-white d-inline-block mb-0"></h6>

                                    </div>
                                    <div class="col-lg-6 mt-3 mt-lg-0 text-lg-right">
                                        <a href="#" class="fullcalendar-btn-prev btn btn-sm btn-neutral">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                        <a href="#" class="fullcalendar-btn-next btn btn-sm btn-neutral">
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="month"><?php echo e(__('Month')); ?></a>
                                        <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicWeek"><?php echo e(__('Week')); ?></a>
                                        <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicDay"><?php echo e(__('Day')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-calendar">
                        <div class="card-">
                            <div class="calendar" data-toggle="calendar" id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/event/index.blade.php ENDPATH**/ ?>