@if ($auth == true)

  <div class="most-commented">
    <div class="card shadow-sm">

      <form method="POST" action="{{ route('user.update' , [ 'id' => auth()->id() ]) }}" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        @csrf

        <div class="card-header">
          <h4> <i class="fas fa-file-alt text-danger"></i> نبذة مختصرة</h4>
        </div>

        <div class="card-body">
          <div class="simple-text bg-light p-3">
            <div class="form-group">
                <textarea name="description" id="" class="form-control limited" data-mintext="0" maxlength="200" data-maxtext="200">{{ optional(optional(optional($user->client)->client_info)->first())->description}}</textarea>
            </div>
          </div>
          <div class="letters">
                <p>الحد الاقصي للحروف <span>200</span></p>
              </div>
        </div>

        <div class="card-header">
          <h4> <i class="fas fa-user text-danger"></i> المعلومات الشخصية</h4>
        </div>
        <div class="card-body">
          <div class="contact-us">
            <div class="contact-form">
              <x-FlashAlert/>

                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">اسم المستخدم</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name' , $user->name) }}" maxlength="150" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">الجوال</label>
                  <div class="col-sm-7">
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" required maxlength="9" name="phone" value="{{ old('phone',$user->phone) }}">
                    @error('phone')
                        <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">البريد الالكتروني</label>
                  <div class="col-sm-7">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$user->email) }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label"> كلمة المرور</label>
                  <div class="col-sm-7">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    minlength="8" maxlength="12" autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label"> تاكيد كلمة المرور</label>
                  <div class="col-sm-7">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" minlength="8" maxlength="12" autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="edit-buttons">
                  <div class="row">
                    <div class="col-6">
                      <button class="btn btn-block btn-rounded btn-success">حفظ</button>
                    </div>
                    <div class="col-6">
                      <!-- <button class="btn btn-block btn-rounded btn-secondary">تراجع</button> -->
                    </div>
                  </div>
                </div>

            </div>
          </div>
        </div>
      </form>

    </div>
  </div>

@else

<div class="most-commented">
  <div class="card shadow-sm">


      <div class="card-header">
        <h4> <i class="fas fa-file-alt text-danger"></i> نبذة مختصرة</h4>
      </div>

      <div class="card-body">
        <div class="simple-text bg-light p-3">
          <div class="form-group">
            <label class="form-control limited">{{ optional(optional(optional($user->client)->client_info)->first())->description}}</textarea>
          </div>
        </div>
      </div>

      <div class="card-header">
        <h4> <i class="fas fa-user text-danger"></i> المعلومات الشخصية</h4>
      </div>
      <div class="card-body">
        <div class="contact-us">
          <div class="contact-form">

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">اسم المستخدم</label>
                <div class="col-sm-7">
                  <label>{{ $user->name }}</label>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">الجوال</label>
                <div class="col-sm-7">
                  <label>{{ $user->phone }}</label>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">البريد الالكتروني</label>
                <div class="col-sm-7">
                  <label>{{ $user->email }} </label>
                </div>
              </div>

          </div>
        </div>
      </div>
    </form>

  </div>
</div>

@endif
