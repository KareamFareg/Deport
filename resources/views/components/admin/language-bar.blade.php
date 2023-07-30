@if ($currentView == 'notInBar')
<div class="dropdown" style="text-align: center;">
  <a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
    {{ __('language.select_language') }}
  </a>
  <div class="dropdown-menu dropdown-menu-sm" aria-labelledby="dropdownMenuButton">

    <ul class="kt-nav">
      @foreach ($getLanguages as $language)
        <li class="kt-nav__item">
          <a href="{{ route('admin.login', ['locale' => $language->locale] ) }}" class="kt-nav__link">
            <i class="kt-nav__link-icon"><img class="" src="{{ asset($language->image) }}" alt="" /></i>
            <span class="kt-nav__link-text" style="{{ (app()->getLocale() == $language->locale) ? 'font-weight: 600;color: black;' : '' }} ">{{ $language->title }}</span>
          </a>
        </li>
      @endforeach
    </ul>

  </div>
</div>

@else

<div class="kt-header__topbar-item kt-header__topbar-item--langs">
  @php $currentLocal = app()->getLocale(); @endphp
  @foreach ($getLanguages as $language)
    @if ( $currentLocal == $language->locale )
      <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
        <span class="kt-header__topbar-icon">
          <img class="" src="{{ asset( $language->image ) }}" alt="" />
        </span>
      </div>
    @endif
  @endforeach
<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround">
  <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
    @foreach ($getLanguages as $language)
      @if ( $currentLocal != $language->locale )
      <li class="kt-nav__item kt-nav__item--active">
        {{--<a href="{{ route( request()->route()->getName(), ['locale' => $language->locale] ) }}" class="kt-nav__link">--}}
        <a href="{{ route( 'admin.home' , ['locale' => $language->locale] ) }}" class="kt-nav__link">
          <span class="kt-nav__link-icon"><img src="{{ asset( $language->image ) }}" alt="" /></span>
          <span class="kt-nav__link-text">{{ $language->title }}</span>
        </a>
      </li>
      @endif
    @endforeach
  </ul>
</div>
</div>

@endif
