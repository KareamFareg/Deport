
<div class="kt-widget11">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <td style="width:40%">{{ __('country.name') }}</td>
          <td style="width:20%"></td>
          <td style="width:40%"></td>
        </tr>
      </thead>
      <tbody>


        <form action="{{ route('admin.countries.store') }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}

        <tr>
          <td>
              <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required
              value="{{ old('title') }}" maxlength="40" name="title" placeholder="">
              @if ($errors->has('title'))
                    <span class="invalid-feedback">{{ $errors->first('title') }}</span>
              @endif
          </td>
          <td><x-buttons.but_submit /></td>
        </tr>

        </form>

      </tbody>
    </table>
  </div>
</div>
