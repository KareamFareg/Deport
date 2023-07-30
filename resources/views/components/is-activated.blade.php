<select class="form-control kt-select2 {{ $errors->has('is_activated') ? ' is-invalid' : '' }}" id="kt_select2_7" name="is_activated">
  <option selected value="-1"> {{ __('words.all')}}</option>
  <option {{ old('is_activated') === "1" ? 'selected' : '' }} value="1"> {{ __('words.activated') }}</option>
  <option {{ old('is_activated') === "0" ? 'selected' : '' }} value="0"> {{ __('words.not_activated') }}</option>
</select>
