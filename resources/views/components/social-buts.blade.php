{{--
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5f05a1367df6de00133233f4&product=inline-share-buttons" async="async"></script>
<div class="sharethis-inline-share-buttons"></div>
--}}

<div class="social-buttons">
    مشاركة
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode( $shareUrl ) }}"
       target="_blank" class="facebook-share">
       <i class="fab fa-facebook-f jssocials-share-logo"></i>
    </a>
    <a href="https://twitter.com/intent/tweet?url={{ urlencode( $shareUrl ) }}"
       target="_blank" class="twitter-share">
       <i class="fab fa-twitter jssocials-share-logo"></i>
    </a>
    <a href="https://wa.me/?text={{ urlencode( $shareUrl ) }}" data-action="share/whatsapp/share" class="whatsapp-share">
      <i class="fab fa-whatsapp jssocials-share-logo"></i>
    </a>
  </div>
