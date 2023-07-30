@extends('admin.layouts.master')

@section('content')



<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">

            <div class="kt-portlet__head">
              <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                  Add New
                </h3>
              </div>
            </div>
            <!--begin::Form-->
            <form class="kt_form_1">    <!-- kt_form_1   kt-form  -->
              <div class="kt-portlet__body">
                <div class="form-group row">
                  <div class="col-lg-4">
                    <label>Full Name:</label>
                    <input type="email" class="form-control" placeholder="Enter full name">
                    <span class="form-text text-muted">Please enter your full name</span>
                  </div>
                  <div class="col-lg-4">
                    <label class="">Email:</label>
                    <input type="email" class="form-control" placeholder="Enter email">
                    <span class="form-text text-muted">Please enter your email</span>
                  </div>
                  <div class="col-lg-4">
                    <label class="">User Group:</label>
                    <div class="kt-radio-inline">
                      <label class="kt-radio kt-radio--solid">
                        <input type="radio" name="example_2" checked value="2"> Sales Person
                        <span></span>
                      </label>
                      <label class="kt-radio kt-radio--solid">
                        <input type="radio" name="example_2" value="2"> Customer
                        <span></span>
                      </label>
                    </div>
                    <span class="form-text text-muted">Please select user group</span>
                  </div>
                </div>
              </div>
              <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                  <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-8">
                      <button type="reset" class="btn btn-primary">Submit</button>
                      <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
      </div>

      <!-- table -->
      <div class="kt-portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
          <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
              <i class="kt-font-brand flaticon2-line-chart"></i>
            </span>
            <h3 class="kt-portlet__head-title">
              Languages
            </h3>
          </div>
          <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
              <a href="#" class="btn btn-clean btn-icon-sm">
                <i class="la la-long-arrow-left"></i>
                Back
              </a>
              &nbsp;
              <div class="dropdown dropdown-inline">
                <button type="button" class="btn btn-brand btn-icon-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="flaticon2-plus"></i> Add New
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <ul class="kt-nav">
                    <li class="kt-nav__section kt-nav__section--first">
                      <span class="kt-nav__section-text">Choose an action:</span>
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-open-text-book"></i>
                        <span class="kt-nav__link-text">Reservations</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-calendar-4"></i>
                        <span class="kt-nav__link-text">Appointments</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-bell-alarm-symbol"></i>
                        <span class="kt-nav__link-text">Reminders</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-contract"></i>
                        <span class="kt-nav__link-text">Announcements</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-shopping-cart-1"></i>
                        <span class="kt-nav__link-text">Orders</span>
                      </a>
                    </li>
                    <li class="kt-nav__separator kt-nav__separator--fit">
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-rocket-1"></i>
                        <span class="kt-nav__link-text">Projects</span>
                      </a>
                    </li>
                    <li class="kt-nav__item">
                      <a href="#" class="kt-nav__link">
                        <i class="kt-nav__link-icon flaticon2-chat-1"></i>
                        <span class="kt-nav__link-text">User Feedbacks</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section">
            <h3 class="kt-section__title">Local KTDatatable Example</h3>
            <div class="kt-section__info">
              Display KTDatatable example in modal pop-up with local data.
            </div>
            <button type="button" class="btn btn-brand" data-toggle="modal" data-target="#kt_modal_KTDatatable_local">Launch Modal</button>
          </div>
          <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
        </div>
      </div>
      <!-- remote datatable modal -->
      <div id="kt_modal_KTDatatable_remote" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content" style="min-height: 590px;">
            <div class="modal-header">
              <h5 class="modal-title">
                Datatable
                <small>remote data source</small>
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <!--begin: Search Form -->
              <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                <div class="row align-items-center">
                  <div class="col-xl-8 order-2 order-xl-1">
                    <div class="row align-items-center">
                      <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                        <div class="kt-input-icon kt-input-icon--left">
                          <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                          <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                          </span>
                        </div>
                      </div>
                      <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                        <div class="kt-form__group kt-form__group--inline">
                          <div class="kt-form__label">
                            <label>Status:</label>
                          </div>
                          <div class="kt-form__control">
                            <select class="form-control bootstrap-select" id="kt_form_status">
                              <option value="">All</option>
                              <option value="1">Pending</option>
                              <option value="2">Delivered</option>
                              <option value="3">Canceled</option>
                              <option value="4">Success</option>
                              <option value="5">Info</option>
                              <option value="6">Danger</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                        <div class="kt-form__group kt-form__group--inline">
                          <div class="kt-form__label">
                            <label>Type:</label>
                          </div>
                          <div class="kt-form__control">
                            <select class="form-control bootstrap-select" id="kt_form_type">
                              <option value="">All</option>
                              <option value="1">Online</option>
                              <option value="2">Retail</option>
                              <option value="3">Direct</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 order-1 order-xl-2 kt-align-right">
                    <a href="#" class="btn btn-default kt-hidden">
                      <i class="la la-cart-plus"></i> New Order
                    </a>
                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
                  </div>
                </div>
              </div>

              <!--end: Search Form -->
            </div>
            <div class="modal-body modal-body-fit">

              <!--begin: Datatable -->
              <div id="modal_datatable_ajax_source"></div>

              <!--end: Datatable -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-clean btn-bold btn-upper btn-font-sm" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-default btn-bold btn-upper btn-font-sm">Submit</button>
            </div>
          </div>
        </div>
      </div>
      <!-- local datatable modal -->
      <div id="kt_modal_KTDatatable_local" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" style="min-height: 590px;">
        <div class="modal-header">
          <h5 class="modal-title">
            Datatable
            <small>local data source</small>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <!--begin: Search Form -->
          <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
            <div class="row align-items-center">
              <div class="col-xl-8 order-2 order-xl-1">
                <div class="row align-items-center">
                  <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                    <div class="kt-input-icon kt-input-icon--left">
                      <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                      <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                    <div class="kt-form__group kt-form__group--inline">
                      <div class="kt-form__label">
                        <label>Status:</label>
                      </div>
                      <div class="kt-form__control">
                        <select class="form-control bootstrap-select" id="kt_form_status">
                          <option value="">All</option>
                          <option value="1">Pending</option>
                          <option value="2">Delivered</option>
                          <option value="3">Canceled</option>
                          <option value="4">Success</option>
                          <option value="5">Info</option>
                          <option value="6">Danger</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                    <div class="kt-form__group kt-form__group--inline">
                      <div class="kt-form__label">
                        <label>Type:</label>
                      </div>
                      <div class="kt-form__control">
                        <select class="form-control bootstrap-select" id="kt_form_type">
                          <option value="">All</option>
                          <option value="1">Online</option>
                          <option value="2">Retail</option>
                          <option value="3">Direct</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 order-1 order-xl-2 kt-align-right">
                <a href="#" class="btn btn-default kt-hidden">
                  <i class="la la-cart-plus"></i> New Order
                </a>
                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
              </div>
            </div>
          </div>

          <!--end: Search Form -->
        </div>
        <div class="modal-body modal-body-fit">

          <!--begin: Datatable -->
          <div id="modal_datatable_local_source"></div>

          <!--end: Datatable -->
        </div>
        <div class="modal-footer kt-hidden">
          <button type="button" class="btn btn-clean btn-bold btn-upper btn-font-md" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-default btn-bold btn-upper btn-font-md">Submit</button>
        </div>
      </div>
    </div>
  </div>

    </div>
  </div>
</div>
<!-- End table -->








@endsection
