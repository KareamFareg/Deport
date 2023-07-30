
  @foreach ($getAdvPeriods as $advPeriod)
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="adv_period_id" id="adv_period_id" value="{{ $advPeriod->id }}">
    <label class="form-check-label" for="inlineRadio1">{{ $advPeriod->title }}</label>
  </div>
  @endforeach
