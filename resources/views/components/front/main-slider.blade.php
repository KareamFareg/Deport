<div class="main-slider">
  <div class="container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="7000">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        @foreach($getSliders as $slider)
            <div class="carousel-item @if ($loop->first) active @endif">
              <a href="{{ $slider->link }}">
                <img class="d-block w-100" src="{{ $slider->imagePath() }}" alt="First slide">
              </a>
            </div>
        @endforeach
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>

    </div>
  </div>
</div>
