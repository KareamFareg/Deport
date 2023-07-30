<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

	<head>
		<meta charset="utf-8" />
		{{-- <title>@yield('pageTitle') - {{ config('app.name', 'ResCode Admin') }}</title> --}}
		@if (isset($seo_info))
			{!! $seo_info !!}
		@else
			<title>@yield('pageTitle') - {{ config('app.name', 'ResCode Admin') }}</title>
		@endif

		<meta name="description" content="Base form control examples">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token from laravel layout-->
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts from laravel layout-->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Almarai&display=swap" rel="stylesheet">
		<!--begin::Fonts from Metronic-->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>
		<!--end::Fonts -->

		@if (session()->has('locale'))
			@php $dir = (session('locale')['dir'] == 'rtl') ? 'rtl' : '' ; @endphp
			<link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
			<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/jquery-ui.min.css')}}" media="all" /> <!--for autocomplete-->
		@endif

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="{{ asset('assets/all/media/logos/favicon.ico') }}" />

    @yield('css_pagelevel')

	</head>

	<body class="rtl-mode">
	  <section id="wrapper">
	    <!--<div class="timeline-wrapper">
	      <div class="timeline-item">
	          <div class="animated-background">
	              <div class="background-masker header-top"></div>
	              <div class="background-masker header-left"></div>
	              <div class="background-masker header-right"></div>
	              <div class="background-masker header-bottom"></div>
	              <div class="background-masker subheader-left"></div>
	              <div class="background-masker subheader-right"></div>
	              <div class="background-masker subheader-bottom"></div>
	              <div class="background-masker content-top"></div>
	              <div class="background-masker content-first-end"></div>
	              <div class="background-masker content-second-line"></div>
	              <div class="background-masker content-second-end"></div>
	              <div class="background-masker content-third-line"></div>
	              <div class="background-masker content-third-end"></div>
	          </div>
	      </div>
	    </div>-->

			<x-front.header/>

			<x-front.nav/>

	    <div class="mobile-header shadow-sm">
	      <div class="container">
	        <div class="menu-toggle">
	          <a data-toggle="modal" data-target="#sideModal" class="btn"><i class="fas fa-bars"></i> </a>
	        </div>
	        <div class="space"></div>

					<x-logos.logo/>

	        <div class="space"></div>
	        <div class="mobile-search">
	          <a data-toggle="modal" data-target="#search-modal" class="btn"><i class="fas fa-search"></i> </a>
	        </div>
	      </div>
	    </div>
	    <div class="bottom-bar">
	      <div class="container">
	        <div class="back-home">
	          <a href="{{ route('front.home') }}" class="btn"><i class="fas fa-home"></i></a>
	        </div>
	        <div class="likes">
	          <a href="{{ route('user.likes' , [ 'id' => request()->user()->id ] ) }}" class="btn">
               <span id="notify_likes_m" class="badge">{{ $userLikesCount }}</span> <i class="far fa-heart"></i>
            </a>
	        </div>
	        <div class="add__post">
	          <a href="#top" class="btn"><img src="{{ asset('assets/front/images/btn-img-2.svg') }}" class="img-fluid" alt=""></a>
	        </div>
	        <div class="notifications">
	          <a href="" class="btn">
                 <span id="notify_m" class="badge">{{ count($userNotifications) }}</span> <i class="far fa-bell"></i>
	           </a>
	        </div>
	        <div class="go-profile">
	          <div class="btn-group dropup">
	            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                <!-- <i class="fas fa-user"></i> -->
									<img src="{{ auth()->user()->imagePath() }}" style="width: 40px;height: 40px;overflow: hidden;border-radius: 50%;">
									{{--<i class="fas fa-user" style="width: 50px;overflow: hidden;">{{ auth()->user()->name }}</i>--}}
	              </button>
	            <!-- <div class="dropdown-menu">
	              <a class="dropdown-item" href="#"><i class="fas fa-user"></i> بياناتي الشخصية</a>
	              <a class="dropdown-item" href="#"><i class="fas fa-tags"></i> عروضي</a>
	              <a class="dropdown-item" href="#"><i class="fas fa-ticket-alt"></i> كوبوناتي</a>
	              <a class="dropdown-item" href="#"><i class="far fa-heart"></i> اعجاباتي</a>
	              <a class="dropdown-item" href="#"><i class="far fa-comment"></i> تعليقاتي </a>
	              <a class="dropdown-item" href="#"><i class="fas fa-images"></i> البوم الصور</a>
	              <a class="dropdown-item" href="#"><i class="fas fa-power-off"></i> خروج</a>
	            </div> -->
							<div class="dropdown-menu">
								<a class="dropdown-item" href="{{ route('user.profile' , [ 'id' => auth()->id() ] ) }}"><i class="fas fa-user"></i> بياناتي الشخصية</a>
								<a class="dropdown-item" href="{{ route('user.offers', [ 'id' => auth()->id() ]) }}"><i class="fas fa-tags"></i> عروضي</a>
								<a class="dropdown-item" href="{{ route('user.coupons', [ 'id' => auth()->id() ]) }}"><i class="fas fa-ticket-alt"></i> كوبوناتي</a>
								<a class="dropdown-item" href="{{ route('user.likes', [ 'id' => auth()->id() ]) }}"><i class="far fa-heart"></i> اعجاباتي</a>
								<a class="dropdown-item" href="{{ route('user.comments', [ 'id' => auth()->id() ]) }}"><i class="far fa-comment"></i> تعليقاتي </a>
								<a class="dropdown-item" href="{{ route('user.images', [ 'id' => auth()->id() ]) }}"><i class="fas fa-images"></i> البوم الصور</a>
								<a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">
												<i class="fas fa-power-off"></i>{{ __('auth.logout') }}</a>
								<form id="logout-form" action="{{ route('front.logout') }}" method="POST" style="display: none;">
												@csrf
								</form>
							</div>

	          </div>
	        </div>

	      </div>
	    </div>



			@yield('content')

	    <footer class="main-footer">

	    </footer>

	    <!-- Modal -->
			<!-- onsubmit="share(event,this)" -->
			<form method="POST" id="frm_share" name="frm_share"
					action="{{ route('items.store') }}" enctype="multipart/form-data">
					@csrf

					<input type="hidden" value="" id="img_0" name="img_0">
					<input type="hidden" value="" id="img_1" name="img_1">
					<input type="hidden" value="" id="img_2" name="img_2">
			    <!-- Post Select Type -->
			    <div class="modal fade share-modal" id="selectType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			      <div class="modal-dialog" role="document">
			        <div class="modal-content">
			          <div class="modal-header">
			            <h5 class="modal-title" id="exampleModalLabel">نوع المشاركة</h5>
			            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			              <span aria-hidden="true">&times;</span>
			            </button>
			          </div>
			          <div class="modal-body">
			            <div class="form-check form-check-inline">
			              <input class="form-check-input" type="radio" name="type_id" id="type_id" value="1">
			              <label class="form-check-label" for="inlineRadio1">عرض</label>
			            </div>
			            <div class="form-check form-check-inline">
			              <input class="form-check-input" type="radio" name="type_id" id="type_id" value="2">
			              <label class="form-check-label" for="inlineRadio2">كوبون</label>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>

			    <!--Post Add Images-->
			    <div class="modal fade add-post-modal" id="addImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			      <div class="modal-dialog" role="document">
			        <div class="modal-content">
			          <div class="modal-header">
			            <h5 class="modal-title" id="exampleModalLabel">اضف صور</h5>
			            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			              <span aria-hidden="true">&times;</span>
			            </button>
			          </div>
			          <div class="modal-body">
									<h6><p style="font-size: 12px;color: gray;">الحد الاقصى لعدد الصور : 3 صور</p></h6>
			            <div class="img-uploader">
			              <div class="row">
			                <div class="col-4 imgUp">
			                  <div class="imagePreview"></div>
			                  <label class="btn btn-primary"> اختر صورة <input type="file" class="uploadFile img" value="اختر صورة" style="width: 0px;height: 0px;overflow: hidden;">
			                                </label>
			                </div>
			                <span class="imgAdd"><i class="fa fa-plus"></i> اضف صورة جديدة</span>
			              </div>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>

			    <!--Post Add link-->
			    <div class="modal fade add-post-modal" id="addLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			      <div class="modal-dialog" role="document">
			        <div class="modal-content">
			          <div class="modal-header">
			            <h5 class="modal-title" id="exampleModalLabel">اضف رابط</h5>
			            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			              <span aria-hidden="true">&times;</span>
			            </button>
			          </div>
			          <div class="modal-body">
			            <div class="add-link">
			              <div class="form-group">
			                <label for="">ادخل الرابط</label>
			                <input type="text" id="links" name="links" class="form-control">
			                <!-- <button class="btn btn-block btn-danger no-border">حفظ</button> -->
			              </div>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>

			    <!--Post Time-->
			    <div class="modal fade share-modal" id="adsTime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			      <div class="modal-dialog" role="document">
			        <div class="modal-content">
			          <div class="modal-header">
			            <h5 class="modal-title" id="exampleModalLabel">مدة الاعلان</h5>
			            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			              <span aria-hidden="true">&times;</span>
			            </button>
			          </div>
			          <div class="modal-body text-center">
									<x-Front.AdvPeriods />
			            <!-- <div class="form-check form-check-inline">
			              <input class="form-check-input" type="radio" name="adv_period_id" id="adv_period_id" value="1">
			              <label class="form-check-label" for="inlineRadio1">اسبوع</label>
			            </div>
			            <div class="form-check form-check-inline">
			              <input class="form-check-input" type="radio" name="adv_period_id" id="adv_period_id" value="2">
			              <label class="form-check-label" for="inlineRadio2">شهر</label> -->
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>
			</form>



	    <!--Share Modal-->
	    <div class="modal fade share-modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	      <div class="modal-dialog" role="document">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	          <div class="modal-body">
	            <div id="share"></div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <!--Mobile Side Menu-->
	    <div class="modal right fade side-menu" id="sideModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	      <div class="modal-dialog" role="document">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h4 class="modal-title">قائمتي</h4>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	          <div class="modal-body">
	            <div class="user-img">
	              <div class="media">
	                <!-- <img src="assets/images/user_photo.png" class="ml-2" alt="user img"> -->
									<img src="{{ auth()->user()->imagePath() }}" style="width: 40px;overflow: hidden;border-radius: 50%;margin-left: -20px;">
	                <div class="media-body">
	                  <h5 class="media-heading">{{ auth()->user()->name }}</h5>
	                </div>
	              </div>
	            </div>
	            <div class="dashboard-links">
	              <ul class="list-unstyled no-margin">
	                <li><a href="{{ route('user.profile', [ 'id' => auth()->id() ]) }}"><i class="fas fa-user"></i> بياناتي الشخصية</a></li>
	                <li><a href="{{ route('user.offers', [ 'id' => auth()->id() ]) }}"><i class="fas fa-tags"></i> عروضي</a></li>
	                <li><a href="{{ route('user.coupons', [ 'id' => auth()->id() ]) }}"><i class="fas fa-ticket-alt"></i> كوبوناتي</a></li>
	                <li><a href="{{ route('user.likes', [ 'id' => auth()->id() ]) }}"><i class="far fa-heart"></i> اعجاباتي</a></li>
	                <li><a href="{{ route('user.comments', [ 'id' => auth()->id() ]) }}"><i class="far fa-comment"></i> تعليقاتي </a></li>
	                <li><a href="{{ route('user.images', [ 'id' => auth()->id() ]) }}"><i class="fas fa-images"></i> البوم الصور</a></li>

	                <li><a href="#"><i class="fas fa-images"></i> الاكثر تعليقا</a></li>
	                <li><a href="#"><i class="fas fa-images"></i> الاكثر اعجابا</a></li>
	                <!-- <li><a href="#"><i class="fas fa-power-off"></i> خروج</a></li> -->
									<a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">
													<i class="fas fa-power-off"></i>{{ __('auth.logout') }}</a>
									<form id="logout-form" action="{{ route('front.logout') }}" method="POST" style="display: none;">
													@csrf
									</form>

	              </ul>
	            </div>
	          </div>
	        </div>
	        <!-- modal-content -->
	      </div>
	      <!-- modal-dialog -->
	    </div>

	    <!--Search Modal -->
	    <div class="modal fade add-post-modal" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	      <div class="modal-dialog" role="document">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h5 class="modal-title" id="exampleModalLabel">البحث</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	          <div class="modal-body">
	            <div class="add-link">
	              <div class="form-group">
									<form action="{{ route('front.search') }}" method="get">
										<input type="text" id="live_search_m" name="live_search_m" class="form-control" placeholder="عن ماذا تبحث">
		                <button type="submit" class="btn btn-block btn-danger no-border">بحث</button>
									</form>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

			<x-front.modal-image/>

	  </section>



	  <script src="{{ asset('assets/front/js/jquery-3.3.1.min.js') }}"></script>

		<script src="{{ asset('assets/front/js/jquery-ui.min.js') }}"></script>  <!--from autocomplete-->

	  <script src="{{ asset('assets/front/js/popper.js') }}"></script>
	  <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
	  <script src="{{ asset('assets/front/plugins/owl.carousel/owl.carousel.min.js') }}"></script>
	  <script src="{{ asset('assets/front/plugins/select2.full.min.js') }}"></script>
	  <script src="{{ asset('assets/front/plugins/jssocials.min.js') }}"></script>
	  <script src="{{ asset('assets/front/js/scripts.0.0.1.js') }}"></script>

		<x-social-js/>
		<x-pusher.pusher-js/>

		<script>


		function loader()
		{ return "<div style='text-align:center;padding-top:15px;'><div id='div-loader' class='loader-wheel'></div></div>"; }


		function enlarge(me)
		{
			$('#imagepreview').attr('src', $(me).attr('src'));
			$('#imageModal').modal('show');
		}

		// $(".enlarge").on("click", function() {
		//    $('#imagepreview').attr('src', $(this).attr('src'));
		//    $('#imageModal').modal('show');
		// });


$('#live_search_m').autocomplete({
		source : function(request, response) {
			$.ajax({
				url: "/live_search/" + request.term,
				type: 'get',
				dataType: "json",
				data: {},
				success: function(data) {
					// console.log(data);
					response(data);
				},
					 error: function (xhr, status, error)
					 { console.log(xhr.responseText); },
			});
		},
		minLength: 3,
		select:function(event,ui) {
			var url = '{{ route("items.show", ":id") }}';
			url = url.replace(':id', ui.item.item_id);
			location.href = url;
		}
});

		$('#live_search').autocomplete({
				source : function(request, response) {
					$.ajax({
						url: "/live_search/" + request.term,
						type: 'get',
						dataType: "json",
						data: {},
						success: function(data) {
							// console.log(data);
							response(data);
						},
							 error: function (xhr, status, error)
							 { console.log(xhr.responseText); },
					});
				},
				minLength: 3,
				select:function(event,ui) {
					var url = '{{ route("items.show", ":id") }}';
					url = url.replace(':id', ui.item.item_id);
					location.href = url;
				}
		});


		function gat_data(data_div,err_div,type,url,data,special=null)
		{
			$('#'+err_div).html(loader());

			$.ajax({
				 type: type,
				 url: url,
				 data: data,
				 success: function (data) {
						 console.log(data);

						$('#'+err_div).html(data['msg']);

						if (data['status']=='ma')
						{
							jQuery('#popup_div').modal();
							// $('#popup_div').modal();// because my be this happend in button click not in link so the button doesnt join to a modal
							$('#details').html(data['ma_html']);
							return;
						}


						$('#'+data_div).html(data['html']); // Normal Behaviour


					// if (special=='fav_get' && data['status']=='1')
					// {$('#frm_favget').submit();}


					if (data['link'])
					{window.location.href = '/' + data['link'];} // {{ Request()->lang }}

					if (data['linkOut'])
					{window.location.href = data['linkOut'];}

					if (data['redir'])
					{location.reload();}

				 },
				 error: function (xhr, status, error)
				 {
					 if (xhr.status == 419) // httpexeption login expired or user loged out from another tab
					 {window.location.replace( '{{ Request()->lang }}/login' );}
					 console.log(xhr.responseText);

				 },
			 });
		}

		function addComment(e,theform,data_div,err_div,comments_div)
		{

			e.preventDefault();
			// $('#'+err_div).html(loader());
			$.ajax({
				type: $(theform).attr('method'),
				url: $(theform).attr('action'),
				data: $(theform).serialize(),
				success: function (data) {
						// console.log(data);

						$('#'+err_div).html('');

						if (data['status'] == 'validation'){
								$('#'+err_div).html(data['msg']);
								return;
						}

						$('#'+data_div).prepend(data['html']);

						var commentInputs = document.getElementsByClassName("comment");
						for (var i = 0; i < commentInputs.length; i++) {
						   commentInputs.item(i).value = '';
						}

				},
				error: function (xhr, status, error)
				{
					// if (xhr.status = 419) // httpexeption login expired or user loged out from another tab
					// {window.location.replace( '{{ Request()->lang }}' );}
					console.log(xhr.responseText);
				},
			});

		};

		function addLike(e,theform,data_div,err_div)
		{

			e.preventDefault();
			// $('#'+err_div).html(loader());
			$.ajax({
				type: $(theform).attr('method'),
				url: $(theform).attr('action'),
				data: $(theform).serialize(),
				success: function (data) {
					// console.log(data);
						$('#'+err_div).html('');

						$('#'+data_div).html(data['itemLikes']);
						document.getElementById('notify_likes').innerHTML = data['userLikes'] ;
						document.getElementById('notify_likes_m').innerHTML = data['userLikes'] ;

				},
				error: function (xhr, status, error)
				{
					// if (xhr.status = 419) // httpexeption login expired or user loged out from another tab
					// {window.location.replace( '{{ Request()->lang }}' );}
					console.log(xhr.responseText);
				},
			});

		};


		function notificationReaded(e ,id)
		{

			// e.preventDefault();

			var url = '{{ route("front.notifications.readed", ":id") }}';
			url = url.replace(':id', id);

			$.ajax({
				type: 'post',
				url: url,
				data: { "_token": "{{ csrf_token() }}" , '_method' : 'PUT' },
				success: function (data) {
						// console.log(data);
						// $('#'+err_div).html('');
						// $('#'+data_div).html(data['html']);
				},
				error: function (xhr, status, error)
				{
					console.log(xhr.responseText);
				},
			});

		}

		function formAjax(e,me,data_div,err_div,data)
	  {
	    e.preventDefault();
	    var type=$(me).attr('method');
	    var url=$(me).attr('action');
	    var data=$(me).serialize();
	    gat_data(data_div,err_div,type,url,data);
	  }

		function linkAjax(e,me,data_div,err_div,data)
		{
				e.preventDefault();
				var type='get';
				var url=$(me).attr("href");
				var data=data;
				gat_data(data_div,err_div,type,url,data);
		}

		function linkAjaxMore(e,me,data_div,pagination_div,err_div,data)
		{
			e.preventDefault();
			$('#'+err_div).html(loader());

			$.ajax({
				 type: 'get',
				 url: $(me).attr("href"),
				 data: data,
				 success: function (data) {
						 // console.log(data);
						 $('#'+data_div).append(data['html']);
						 $('#'+pagination_div).html(data['paginate']);
						 // history.pushState(null, null, $(me).attr('href'));
						 // $('#but_more').hide(); // hide But
				 },
				 error: function (xhr, status, error)
				 {
					 if (xhr.status == 419) // httpexeption login expired or user loged out from another tab
					 {window.location.replace( '{{ Request()->lang }}/login' );}
					 console.log(xhr.responseText);

				 },
			 });
		}

		function submitForm()
		{

			img = $(".imagePreview");
			img_0 = '';
			img_1 = '';
			img_2 = '';
			if(img[0]) { $("#img_0").val( img[0].style.backgroundImage );	}
			if(img[1]) { $("#img_1").val( img[1].style.backgroundImage );	}
			if(img[2]) { $("#img_2").val( img[2].style.backgroundImage );	}

			$('#frm_share').submit();

		}





		</script>

	</body>

</html>
