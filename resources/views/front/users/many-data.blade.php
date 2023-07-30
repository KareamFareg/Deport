<html lang="{{ app()->getLocale() }}">

	<head>
		<meta charset="utf-8" />
		<title>@yield('pageTitle') - {{ config('app.name', 'ResCode Admin') }}</title>
		<meta name="description" content="Base form control examples">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token from laravel layout-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

		<x-front.header/>



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
								<img src="{{ auth()->user()->imagePath() }}" style="width: 40px;height: 40px;overflow: hidden;border-radius: 50%;margin-left: -20px;">
              </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ route('user.profile' , [ 'id' => auth()->id() ] ) }}"><i class="fas fa-user"></i> بياناتي الشخصية</a>
              <a class="dropdown-item" href="{{ route('user.offers', [ 'id' => auth()->id() ]) }}"><i class="fas fa-tags"></i> عروضي</a>
              <a class="dropdown-item" href="{{ route('user.coupons', [ 'id' => auth()->id() ]) }}"><i class="fas fa-ticket-alt"></i> كوبوناتي</a>
              <a class="dropdown-item" href="{{ route('user.likes', [ 'id' => auth()->id() ]) }}"><i class="far fa-heart"></i> اعجاباتي</a>
              <a class="dropdown-item" href="{{ route('user.comments', [ 'id' => auth()->id() ]) }}"><i class="far fa-comment"></i> تعليقاتي </a>
              <a class="dropdown-item" href="{{ route('user.images', [ 'id' => auth()->id() ]) }}"><i class="fas fa-images"></i> البوم الصور</a>
              <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i>{{ __('auth.logout') }}</a>
							<form id="logout-form" action="{{ route('front.logout') }}" method="POST" style="display: none;">
											@csrf
							</form>
            </div>
          </div>
        </div>

      </div>
    </div>

    <main class="main-content" id="top">
      <div class="user-main-cover">
        <div class="cover-upload">
          <div class="cover-preview">
            <div id="imagePreview2" style="background-image: url({{ $user->bannerPath() }})">
            </div>
          </div>
					@if($auth == true)
					<form method="post" action="{{ route('user.background') }}" enctype="multipart/form-data" id="frm_background">
						@csrf
	          <div class="cover-edit">
	            <input type='file' id="imageUpload2" accept=".png, .jpg, .jpeg" /> <!-- onchange="getImage(this);" -->
	            <label id="lbl_imageUpload2" for="imageUpload2"><i class="fas fa-image"></i>  تحديث صورة الغلاف</label>
							<x-loading-gif id='imageUpload2_loading'/>
	          </div>
					</form>
					@endif
        </div>
        <!--visible on mobile only --->
        <div class="mob-usr-img">
              <div class="avatar-upload">
                <div class="avatar-preview">
                  <div id="imagePreview" style="background-image: url({{ $user->imagePath() }})">
                  </div>
                </div>
								@if($auth == true)
								<form method="post" action="{{ route('user.image') }}" enctype="multipart/form-data" id="frm_image_m">
									@csrf
	                <div class="avatar-edit">
	                  <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
	                  <label id="lbl_imageUpload" for="imageUpload"><i class="fas fa-image"></i> تعديل الصورة</label>
										<x-loading-gif id='imageUpload_loading'/>
	                </div>
								</form>
								@endif
              </div>
              <div class="user-info">
                <h4 style="font-family: inherit;">{{ $user->name }}</h4>
                <span><i class="fas fa-calendar-alt"></i>{{ $user->created_at }} تاريخ الانضمام</span>
              </div>
            </div>
      </div>
      <nav class="navbar navbar-expand dashboard-menu shadow-sm">
        <div class="container">
          <div class="navbar-brand">
            <div class="usr-img">
              <div class="avatar-upload">
                <div class="avatar-preview">
                  <div id="imagePreview3" style="background-image: url({{ $user->imagePath() }})">
                  </div>
                </div>
								@if($auth == true)
								<form method="post" action="{{ route('user.image') }}" enctype="multipart/form-data" id="frm_image">
									@csrf
	                <div class="avatar-edit">
	                  <input type='file' id="imageUpload3" accept=".png, .jpg, .jpeg" />
	                  <label id="lbl_imageUpload3" for="imageUpload3"><i class="fas fa-image"></i> تعديل الصورة</label>
										<x-loading-gif id='imageUpload3_loading'/>
	                </div>
								</form>
								@endif
              </div>
              <div class="user-info">
                <h4 style="width: 200px;overflow: hidden;">{{ $user->name }}</h4>
                <span><i class="fas fa-calendar-alt"></i>{{ $user->created_at }} تاريخ الانضمام</span>
              </div>
            </div>
          </div>

					@if ($page == 'item_edit') <!-- becuse in navbar we get user id from request and request in this case is itemid not userid-->
						<x-front.nav-user :page="$page" :user="$user"/>
					@else
						<x-front.nav-user :page="$page"/>
					@endif

					<x-confirmation/>

        </div>
      </nav>
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-3 col-md-3 col-sm-12 order-1 order-lg-1 order-md-1 order-sm-2 order-xs-2">

						<x-front.SidebarImage1/>

            <div class="most-commented">
              <div class="card shadow-sm">
                <div class="card-header">
                  <h4><i class="fas fa-file-alt text-danger"></i> نبذة مختصرة</h4>
                </div>
                <div class="card-body">
                  <div class="simple-text bg-light p-3">
                    <p class="text-dark mb-0">
											{{ optional(optional(optional($user->client)->client_info)->first())->description }}
										</p>
                  </div>
                </div>
              </div>
            </div>
						@isset($images)
            <div class="most-commented">
              <div class="card shadow-sm">
                <div class="card-header">
                  <h4><i class="fas fa-image text-danger"></i> البوم الصور</h4>
                </div>
                <div class="card-body">
                  <div class="images-ablum">
                    <ul class="list-unstyled no-margin row">
											@foreach($images as $image)
												@if( $loop->iteration < 7 )
		                      <li class="col-4 col-padding-5">
		                        <img src="{{ asset('storage/app/'.$image->file_name) }}" class="img-fluid mx-auto enlarge" alt=""  onclick="enlarge(this)">
		                      </li>
												@endif
											@endforeach
                    </ul>

										@if( !empty($images) )
											@if (count($images) > 6 )
	                    <div class="view-more-imgs">
	                      <a href="{{ route('user.images' , [ 'id' => auth()->id() ]) }}">عرض مزيد من الصور</a>
	                    </div>
											@endif
										@endif

                  </div>
                </div>
              </div>
            </div>
						@endisset
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 order-2 order-lg-2 order-md-2 order-sm-1 order-xs-1">

						<x-FlashAlert/>

						@if ( $page == 'images')
									<div class="most-commented">
										<div class="card shadow-sm">
											<div class="card-header"><h4> <i class="fas fa-image text-danger"></i> البوم الصور</h4></div>
											<div class="card-body">
												<div class="images-albums">

													<div id='items_all'>
														<x-front.album :userImages="$userImages"/>
													</div>

								      </div>
								    </div>
								  </div>
								</div>
								<div id="items_paginate">
											<x-front.paginate :nextUrl="$userImages->nextPageUrl()"/>
								</div>
						@elseif  ( $page == 'profile')
							<x-front.profile :user="$user"/>
						@elseif  ( $page == 'item_edit')
								<x-front.item-edit :item="$item" :advPeriods="$advPeriods" :types="$types"/>
						@else
								<div id='items_all'>
										<x-front.items :data="$data"/>
								</div>
								<div id="items_paginate">
											<x-front.paginate :nextUrl="$data->nextPageUrl()"/>
								</div>
						@endif

          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 order-3 order-lg-3 order-md-3 order-sm-3 order-xs-3">

						<x-front.SidebarImage2/>

						<x-front.DownloadApp/>
						<x-front.FollowUs/>

						<x-front.quick-links/>

          </div>
        </div>
      </div>
    </main>
    <footer class="main-footer">

    </footer>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade add-post-modal" id="addPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">اضف صور</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

          </div>
        </div>
      </div>
    </div>
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
                <input type="text" class="form-control">
                <button class="btn btn-block btn-danger no-border">حفظ</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
                <img src="assets/images/user_photo.png" class="ml-2" alt="user img">
                <div class="media-body">
                  <h5 class="media-heading">{{ $user->name }}</h5>
                </div>
              </div>
            </div>
            <div class="dashboard-links">
              <ul class="list-unstyled no-margin">
                <li><a href="{{ route('user.profile' , [ 'id' => auth()->id() ] ) }}"><i class="fas fa-user"></i> بياناتي الشخصية</a></li>
                <li><a href="{{ route('user.offers', [ 'id' => auth()->id() ]) }}"><i class="fas fa-tags"></i> عروضي</a></li>
                <li><a href="{{ route('user.coupons', [ 'id' => auth()->id() ]) }}"><i class="fas fa-ticket-alt"></i> كوبوناتي</a></li>
                <li><a href="{{ route('user.likes', [ 'id' => auth()->id() ]) }}"><i class="far fa-heart"></i> اعجاباتي</a></li>
                <li><a href="{{ route('user.comments', [ 'id' => auth()->id() ]) }}"><i class="far fa-comment"></i> تعليقاتي </a></li>
                <li><a href="{{ route('user.images', [ 'id' => auth()->id() ]) }}"><i class="fas fa-images"></i> البوم الصور</a></li>
                <li><a href="#"><i class="fas fa-images"></i> الاكثر تعليقا</a></li>
                <li><a href="#"><i class="fas fa-images"></i> الاكثر اعجابا</a></li>
                <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i> خروج</a></li>
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
                <input type="text" class="form-control">
                <button class="btn btn-block btn-danger no-border">بحث</button>
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


	<x-confirmation-js/>

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
	// 	 $('#imagepreview').attr('src', $(this).attr('src'));
	// 	 $('#imageModal').modal('show');
	// });

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
           // console.log(data);

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






			function showConfirmation(e,me)
			{
				e.preventDefault();
				$("#confirem-modal").modal('show');

				modalConfirm(function(confirm){
				  if(confirm){
						formAjax(e,me,'nodiv','nodiv');
				  }
				});
			}












			// banner
			$(document).ready(function(){

			    $("#imageUpload2").change(function(){

			        // var formData = new FormData();
			        // // var files = $('#imageUpload2')[0].files[0];
							// var files = document.getElementById("imageUpload2").files[0];
			        // formData.append('banner',files);

							lbl = document.getElementById("lbl_imageUpload2");
							lbl.innerHTML = 'جارى الرفع';
							loading = document.getElementById("imageUpload2_loading");
							loading.style.display = "block";


							myForm = document.getElementById('frm_background');
				      let formData = new FormData(myForm);
				      var file = document.getElementById("imageUpload2").files[0];
				      formData.append('banner', file);

			        $.ajax({
									headers: {
											 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									},
									type: $("#frm_background").attr('method'),
									url: $("#frm_background").attr('action'),
									data: formData , // serialize,
									enctype: 'multipart/form-data',
									processData: false,
									contentType: false,
									dataType:'JSON',
			            success: function(data){
										// console.log(data);
										if (data['status'] != 'success'){
												lbl.innerHTML = data['msg']; // 'خطأ اثناء تحديث الصورة'
												loading.style.display = "none";
												return;
										}
										lbl.innerHTML = 'تم تحديث صورة الغلاف';
										loading.style.display = "none";

			            },
									error: function (xhr, status, error)
			            {
			              console.log(xhr.responseText);
			            },
			        });
			    });
			});

			// image
			$(document).ready(function(){

			    $("#imageUpload3").change(function(){

			        // var formData = new FormData();
			        // // var files = $('#imageUpload2')[0].files[0];
							// var files = document.getElementById("imageUpload2").files[0];
			        // formData.append('banner',files);

							lbl = document.getElementById("lbl_imageUpload3");
							lbl.innerHTML = 'جارى الرفع';
							loading = document.getElementById("imageUpload3_loading");
							loading.style.display = "block";

							myForm = document.getElementById('frm_image');

				      let formData = new FormData(myForm);
				      var file = document.getElementById("imageUpload3").files[0];
				      formData.append('image', file);


			        $.ajax({
									headers: {
											 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									},
									type: $("#frm_image").attr('method'),
									url: $("#frm_image").attr('action'),
									data: formData , // serialize,
									enctype: 'multipart/form-data',
									processData: false,
									contentType: false,
									dataType:'JSON',
			            success: function(data){
										// console.log(data);
										if (data['status'] != 'success'){
												lbl.innerHTML = data['msg']; // 'خطأ اثناء تحديث الصورة'
												loading.style.display = "none";
												return;
										}
										lbl.innerHTML = 'تم تحديث صورة الغلاف';
										loading.style.display = "none";

			            },
									error: function (xhr, status, error)
			            {
			              console.log(xhr.responseText);
			            },
			        });
			    });
			});

			// image mobile
			$(document).ready(function(){

			    $("#imageUpload").change(function(){

			        // var formData = new FormData();
			        // // var files = $('#imageUpload2')[0].files[0];
							// var files = document.getElementById("imageUpload2").files[0];
			        // formData.append('banner',files);

							lbl = document.getElementById("lbl_imageUpload");
							lbl.innerHTML = 'جارى الرفع';
							loading = document.getElementById("imageUpload_loading");
							loading.style.display = "block";


							myForm = document.getElementById('frm_image_m');

				      let formData = new FormData(myForm);
				      var file = document.getElementById("imageUpload").files[0];
				      formData.append('image', file);


			        $.ajax({
									headers: {
											 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									},
									type: $("#frm_image").attr('method'),
									url: $("#frm_image").attr('action'),
									data: formData , // serialize,
									enctype: 'multipart/form-data',
									processData: false,
									contentType: false,
									dataType:'JSON',
			            success: function(data){
										// console.log(data);
										if (data['status'] != 'success'){
												lbl.innerHTML = data['msg']; // 'خطأ اثناء تحديث الصورة'
												loading.style.display = "none";
												return;
										}
										lbl.innerHTML = 'تم تحديث صورة الغلاف';
										loading.style.display = "none";

			            },
									error: function (xhr, status, error)
			            {
			              console.log(xhr.responseText);
			            },
			        });
			    });
			});

  </script>


</body>

</html>
