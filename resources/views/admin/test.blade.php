@foreach($data as $item)
{{ $item->question['ar']}}
{{ $item->question_data()}}
<br>
@endforeach

<br><br>

{{--
@foreach($data as $item)
{{ $item->question['en']}}<br>
@endforeach
--}}

<form class="kt_form_1"  action="{{ route('admin.test.post') }}" method="post">
    {{ csrf_field() }}


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('faq.question') }}</label>
      <div class=" col-lg-7 col-md-9 col-sm-12">
            <input type="text" class="form-control {{ $errors->has('question') ? ' is-invalid' : '' }}"
            maxlength="500" required name="question[{{ $trans }}]" value="{{ old('question') }}" placeholder="">
            @if ($errors->has('question'))
                    <span class="invalid-feedback">{{ $errors->first('question') }}</span>
            @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('faq.answer') }}</label>
      <div class=" col-lg-7 col-md-9 col-sm-12">
            <input type="text" class="form-control {{ $errors->has('answer') ? ' is-invalid' : '' }}"
            maxlength="500" required name="answer[{{ $trans }}]" value="{{ old('answer') }}" placeholder="">
            @if ($errors->has('answer'))
                    <span class="invalid-feedback">{{ $errors->first('answer') }}</span>
            @endif
      </div>
    </div>


    <x-buttons.but_submit/>

</form>
