<script src="{{asset('assets/admin/vendors/dropify/dist/js/dropify.min.js')}}"></script>
<script>
    $('.dropify').dropify({
      messages: {
          'default': 'اسحب الملفات هنا او اضغط للتحميل',
          'replace': 'اسحب الملفات هنا او اضغط للتحميل',
          'remove':  'حذف',
          'error':   'عفوا حدث خطأ'
      }
    });
    ! function(window, document, $) {
            "use strict";
            //$("input,select").not("[type=submit]").jqBootstrapValidation();
        }(window, document, jQuery);

        jQuery('#date-range').datepicker({
                toggleActive: true,
        });

        $(document).ready(function() {
        // Basic

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("هل تريد حذف \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('تم الحذف');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
</script>
