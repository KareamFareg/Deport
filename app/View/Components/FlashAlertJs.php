<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FlashAlertJs extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return <<<'blade'

        @if (session()->has('flashAlerts'))
          <div class="kt-section">
            <div class="kt-section__content">
              @foreach (session('flashAlerts') as $key => $flashAlert)
                @isset ( $flashAlert['type'])
                  <script type="text/javascript">

                     swal.fire("Oops!", "{{$flashAlert['msg']}}" , "error");

                    toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  };
                  toastr.success("{{$flashAlert['msg']}}");

                  </script>
                @endisset
              @endforeach
            </div>
          </div>
        @endif

        blade;
    }

}
