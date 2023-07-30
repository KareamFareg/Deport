<div class="row">

  <div class="col-md-6 offset-md-3">
    <h3>{{ __('auth.reset_password') }}</h3>
    <div class="kt-portlet">
      <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-grid">
          <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">
              <!-- <div class="card-header">{{ __('auth.password_reset_link') }}</div> -->
              <div class="card-body">
                    <div class="form-group row">
                        <!-- <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('verification.enter_code') }}</label> -->
                        <div class="col-md-7">
                            <a href="{{ $data->link }}">{{ __('auth.password_reset_link') }}</a>
                        </div>
                    </div>
                    {{ $data->receiver }}
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
