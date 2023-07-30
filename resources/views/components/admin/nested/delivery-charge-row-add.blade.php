
<div class="kt-widget11">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <td style="width:40%">{{ __('delivery_charge.category') }}</td>
          <td style="width:15%">{{ __('delivery_charge.from') }}</td>
          <td style="width:15%">{{ __('delivery_charge.to') }}</td>
          <td style="width:20%">{{ __('delivery_charge.charge') }}</td>
          <td style="width:10%"></td>
        </tr>
      </thead>
      <tbody>


        <form id="frm_category_status" name="frm_category_status" action="{{ route('admin.deliverycharges.store') }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}

        <tr>
          <td>
            <select class="form-control kt-select2 {{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="kt_select2_5" required name="category_id">
              @foreach ( $categories as $category )
                <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}"> {{ $category->title }} {{str_repeat('__', $category->depth)}}</option>
              @endforeach
            </select>
            @if ($errors->has('category_id'))
                <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
            @endif
          </td>
          <td>
              <input type="number" step=".01" class="form-control {{ $errors->has('d_from') ? ' is-invalid' : '' }}" required
              value="{{ old('d_from') }}" maxlength="3" name="d_from" placeholder="">
              @if ($errors->has('d_from'))
                    <span class="invalid-feedback">{{ $errors->first('d_from') }}</span>
              @endif
          </td>
          <td>
              <input type="number" step=".01" class="form-control {{ $errors->has('d_to') ? ' is-invalid' : '' }}" required
              value="{{ old('d_to') }}" maxlength="3" name="d_to" placeholder="">
              @if ($errors->has('d_to'))
                    <span class="invalid-feedback">{{ $errors->first('d_to') }}</span>
              @endif
          </td>
          <td>
              <input type="number" step=".01" class="form-control {{ $errors->has('charge') ? ' is-invalid' : '' }}" required
              value="{{ old('charge') }}" maxlength="5" name="charge" placeholder="">
              @if ($errors->has('charge'))
                  <span class="invalid-feedback">{{ $errors->first('charge') }}</span>
              @endif
          </td>
          <td><x-buttons.but_submit /></td>
        </tr>

        </form>

      </tbody>
    </table>
  </div>
</div>
