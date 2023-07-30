@extends('admin.layouts.master')

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{ __('contact_us.contact_us') }} : &nbsp;&nbsp;
                                {{ $settings['phone_1'] }} &nbsp;&nbsp;-&nbsp;&nbsp;
                                {{ $settings['mail'] }}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">


                            <!-- form -->
                            <form class="kt_form_1" enctype="multipart/form-data"
                                action="{{ route('admin.trader.move',['id' => $shop->id]) }}" method="post">
                                {{ csrf_field() }}


                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">اسم المالك الجديد *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <select name='user_id'  class="form-control">
                                            @foreach($users as $user)   
                                            <option value="<?=$user->id?>">{{$user->name}} </option>
                                            @endforeach
                                       </select>
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('user_id'))
                                            <span class="invalid-feedback">{{ $errors->first('user_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                               
                                
                                <x-buttons.but_submit />

                            </form>





                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@section('js_pagelevel')
    <x-admin.dropify-js />
@endsection

@endsection
