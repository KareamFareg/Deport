<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FlashAlert extends Component
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
                @if (! isset($flashAlert['type']))
                  <div class="alert alert-{{ ($key == 'faild') ? 'danger' : $key }}" role="alert">
                    <div class="alert-text">{{ $flashAlert['msg'] }}</div>
                  </div>
                @endif
              @endforeach
            </div>
          </div>
        @endif


        @if ($errors->any())
          <div class="kt-section">
            <div class="kt-section__content">
              <div class="alert alert-danger" role="alert">
                <div class="alert-text">
                  @foreach ($errors->all() as $error)
                    {{$error}}<br>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        @endif

        blade;
    }

}
