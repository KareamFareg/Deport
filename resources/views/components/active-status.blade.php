<select class="form-control kt-select2 {{ $errors->has('active_status') ? ' is-invalid' : '' }}" id="kt_select2_1" name="active_status">
  <option selected value="-1"> {{ __('words.all')}}</option>
  <option {{ old('active_status') === "1" ? 'selected' : '' }} value="1"> {{ __('words.active') }}</option>
  <option {{ old('active_status') === "0" ? 'selected' : '' }} value="0"> {{ __('words.inactive') }}</option>
</select>
