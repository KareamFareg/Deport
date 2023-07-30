
@foreach ( $languages as $language )
<form class="kt-form" enctype="multipart/form-data"  style="margin: 10px"  action="{{ $route }}" method="post">
{{ csrf_field() }}

    <input type="hidden" name="trans" value="{{ $language->locale }}">
    <button type="submit"

      @if ($language->locale == $trans)
        class="btn btn-outline-dark"
        @else
        class="btn btn-outline-secondary"
      @endif


    >{{ $language->title }}</button>

</form>
@endforeach
