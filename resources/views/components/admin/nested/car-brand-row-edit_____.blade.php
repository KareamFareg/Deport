
<div class="kt-widget11">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <td style="width:40%"></td>
          <td style="width:20%"></td>
          <td style="width:40%"></td>
        </tr>
      </thead>
      <tbody>


        <form action="{{ route('admin.carbrands.update', ['id' => $data->id] ) }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input name="_method" type="hidden" value="PUT">

          <input type="hidden" value="{{ $trans }}" name="language">

        <tr>
          <td>
            @if ($defaultLanguage->locale != $trans)
            {{  $data->title[$defaultLanguage->locale] ?? ''  }}
            @endif
              <input type="text" class="form-control {{ $errors->has('title'.$data->id) ? ' is-invalid' : '' }}" required
              value="{{ old('title'.$data->id , $data->title[$trans] ?? '' ) }}" maxlength="40" name="title{{$data->id}}" placeholder="">
              @if ($errors->has('title'.$data->id ))
                    <span class="invalid-feedback">{{ $errors->first('title'.$data->id) }}</span>
              @endif
          </td>
          <td><x-buttons.but_update /></td>
          </form>

          <td>
            <form action="{{ route('admin.carbrands.status',['id' => $data->id ]) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" id="_method" name="_method" value="PUT">
                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                  <label>
                    <input type="checkbox"  {{ $data->is_active ? 'checked' : '' }}  onclick="submitForm(this);">
                    <span></span>
                  </label>
                </span>
            </form>
          </td>

        </tr>



      </tbody>
    </table>
  </div>
</div>
