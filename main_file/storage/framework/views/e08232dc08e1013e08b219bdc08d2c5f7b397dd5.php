<script src="<?php echo e(asset('assets/vendor/jquery/dist/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/js-cookie/js.cookie.js')); ?> "></script>
<script src="<?php echo e(asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/vendor/chart.js/dist/Chart.min.js')); ?> "></script>
<script src="<?php echo e(asset('assets/vendor/chart.js/dist/Chart.extension.js')); ?> "></script>
<script src="<?php echo e(asset('assets/vendor/jvectormap-next/jquery-jvectormap.min.js')); ?> "></script>
<script src="<?php echo e(asset('assets/js/vendor/jvectormap/jquery-jvectormap-world-mill.js')); ?> "></script>


<script src="<?php echo e(asset('assets/module/js/select2.full.min.js')); ?> "></script>
<script src="<?php echo e(asset('assets/module/js/bootstrap-datepicker.min.js')); ?> "></script>


<script src="<?php echo e(asset('assets/module/js/moment.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/vendor/fullcalendar/dist/fullcalendar.min.js')); ?>"></script>


<script src="<?php echo e(asset('assets/module/js/datatable.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/module/datatables/datatables.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/dropzone/dist/min/dropzone.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/js/argon.js?v=1.1.0')); ?> "></script>


<script src="<?php echo e(asset('assets/module/bootstrap-toastr/toastr.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/module/bootstrap-toastr/ui-toastr.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/module/js/jquery.easy-autocomplete.min.js')); ?>"></script>


<script src="<?php echo e(asset('assets/js/demo.min.js')); ?> "></script>

<script>
    var dataTabelLang = {
        paginate: {
            previous: "<i class='fas fa-angle-left'>",
            next: "<i class='fas fa-angle-right'>"
        },
        lengthMenu: "<?php echo e(__('Show')); ?> _MENU_ <?php echo e(__('entries')); ?>",
        zeroRecords: "<?php echo e(__('No data available in table')); ?>",
        info: "<?php echo e(__('Showing')); ?> _START_ <?php echo e(__('to')); ?> _END_ <?php echo e(__('of')); ?> _TOTAL_ <?php echo e(__('entries')); ?>",
        infoEmpty: " ",
        search: "<?php echo e(__('Search:')); ?>"
    }
</script>

<script src="<?php echo e(asset('assets/module/js/custom.js')); ?> "></script>

<script src="<?php echo e(asset('assets/module/js/jquery-ui.min.js')); ?>"></script>


<script>
    var date_picker_locale = {
        format: 'YYYY-MM-DD',
        daysOfWeek: [
            "<?php echo e(__('Sun')); ?>",
            "<?php echo e(__('Mon')); ?>",
            "<?php echo e(__('Tue')); ?>",
            "<?php echo e(__('Wed')); ?>",
            "<?php echo e(__('Thu')); ?>",
            "<?php echo e(__('Fri')); ?>",
            "<?php echo e(__('Sat')); ?>"
        ],
        monthNames: [
            "<?php echo e(__('January')); ?>",
            "<?php echo e(__('February')); ?>",
            "<?php echo e(__('March')); ?>",
            "<?php echo e(__('April')); ?>",
            "<?php echo e(__('May')); ?>",
            "<?php echo e(__('June')); ?>",
            "<?php echo e(__('July')); ?>",
            "<?php echo e(__('August')); ?>",
            "<?php echo e(__('September')); ?>",
            "<?php echo e(__('October')); ?>",
            "<?php echo e(__('November')); ?>",
            "<?php echo e(__('December')); ?>"
        ],
    };

    var calender_header = {
        today: "<?php echo e(__('today')); ?>",
        month: "<?php echo e(__('month')); ?>",
        week: "<?php echo e(__('week')); ?>",
        day: "<?php echo e(__('day')); ?>",
        list: "<?php echo e(__('list')); ?>"
    };

    if ($("[data-uploaditems]")) {
        $("[data-uploaditems]").on('click', function() {
            var file = $("<input accept='pplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet' type='file' style='display:none' />");
            $('body').append(file);
            file.on('change', async function() {
                var fdt = new FormData;
                fdt.append("excelfile", this.files[0]);
                var response = await fetch("/item/import", {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr('content')
                    },
                    body: fdt
                });
                console.log(this.files[0]);
                console.log(await response.text());
                location.reload();
                file.off('change');
            });
            file.trigger('click');
        });
    }

    if ($("[data-importclients]")) {
        $("[data-importclients]").click(() => {
            let file = $("<input type='file' style='display:none;' />");
            $('body').append(file);
            file.change(async () => {
                let fdt = new FormData;
                fdt.append('excelfile', file.get(0).files[0]);
                let response = await fetch("/client/import", {
                    method: 'post',
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr('content')
                    },
                    body: fdt
                });
                // console.log(await response.text());
                location.reload();
                file.off('change');
            });
            file.trigger('click');
        });
    }
</script>

<?php if($message = Session::get('success')): ?>
<script>
    toastrs('Success', '<?php echo $message; ?>', 'success')
</script>
<?php endif; ?>

<?php if($message = Session::get('error')): ?>
<script>
    toastrs('Error', '<?php echo $message; ?>', 'error')
</script>
<?php endif; ?>

<?php if($message = Session::get('info')): ?>
<script>
    toastrs('Info', '<?php echo $message; ?>', 'info')
</script>
<?php endif; ?>

<?php echo $__env->yieldPushContent('script-page'); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/partials/admin/footer.blade.php ENDPATH**/ ?>