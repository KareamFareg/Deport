<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>سنارة</title>
  <!-- styles CSS -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
  <title></title>
	<!-- CSRF Token from laravel layout-->
	<meta name="csrf-token" content="{{ csrf_token() }}">

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
    <header class="main-header">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="main-logo text-center">
              <img src="assets/images/logo.svg" class="img-fluid mx-auto" alt="logo">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="search">
              <div class="search-box">
                <form action="">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="عن ماذا تبحث">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="user-links">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user-circle"></i>
                </button>
                <div class="dropdown-menu animate slideIn" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#"><i class="fas fa-user"></i> بياناتي الشخصية</a>
                  <a class="dropdown-item" href="#"><i class="fas fa-tags"></i> عروضي</a>
                  <a class="dropdown-item" href="#"><i class="fas fa-ticket-alt"></i> كوبوناتي</a>
                  <a class="dropdown-item" href="#"><i class="far fa-heart"></i> اعجاباتي</a>
                  <a class="dropdown-item" href="#"><i class="far fa-comment"></i> تعليقاتي </a>
                  <a class="dropdown-item" href="#"><i class="fas fa-images"></i> البوم الصور</a>
                  <a class="dropdown-item" href="#"><i class="fas fa-power-off"></i> خروج</a>
                </div>
              </div>
              <div class="notifications">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="badge">0</span> <i class="far fa-bell"></i>
                  </button>
                  <div class="dropdown-menu notifications-menu animate slideIn" aria-labelledby="dropdownMenuButton2">
                    <a class="dropdown-item" href="#">
                      <div class="media">
                        <img src="assets/images/user_photo.png" alt="" class="ml-2">
                        <div class="media-body">
                          <p class="text-dark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus aperiam ducimus excepturi. Vitae nam, dolore, doloremque</p>
                        </div>
                      </div>
                    </a>
                    <a class="dropdown-item" href="#">
                      <div class="media">
                        <img src="assets/images/user_photo.png" alt="" class="ml-2">
                        <div class="media-body">
                          <p class="text-dark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus aperiam ducimus excepturi. Vitae nam, dolore, doloremque</p>
                        </div>
                      </div>
                    </a>
                    <a class="dropdown-item" href="#">
                      <div class="media">
                        <img src="assets/images/user_photo.png" alt="" class="ml-2">
                        <div class="media-body">
                          <p class="text-dark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus aperiam ducimus excepturi. Vitae nam, dolore, doloremque</p>
                        </div>
                      </div>
                    </a>
                    <a class="dropdown-item" href="#">
                      <div class="media">
                        <img src="assets/images/user_photo.png" alt="" class="ml-2">
                        <div class="media-body">
                          <p class="text-dark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus aperiam ducimus excepturi. Vitae nam, dolore, doloremque</p>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>

              </div>
              <div class="likes">
                <a href="" class="btn btn-secondary">
                   <span class="badge">0</span> <i class="far fa-heart"></i>
                </a>
              </div>

              <div class="share-now">
                <a href="" class="btn btn-warning"><img src="assets/images/btn-img.svg" alt=""> شارك</a>
              </div>
            </div>

          </div>
        </div>

      </div>
    </header>
    <nav class="navbar navbar-expand-lg main-nav shadow-sm">
      <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
      </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="#"><img src="assets/images/select-all.svg" class="img-fluid" alt="icon"> عرض الكل</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><img src="assets/images/discount.svg" class="img-fluid" alt="icon"> عروض</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><img src="assets/images/coupon.svg" class="img-fluid" alt="icon">كوبونات</a>
            </li>

          </ul>
        </div>
      </div>
    </nav>

    <div class="mobile-header shadow-sm">
      <div class="container">
        <div class="menu-toggle">
          <a data-toggle="modal" data-target="#sideModal" class="btn"><i class="fas fa-bars"></i> </a>
        </div>
        <div class="space"></div>
        <div class="main-logo text-center">
          <img src="assets/images/logo.svg" class="img-fluid mx-auto" alt="logo">
        </div>
        <div class="space"></div>
        <div class="mobile-search">
          <a data-toggle="modal" data-target="#search-modal" class="btn"><i class="fas fa-search"></i> </a>
        </div>
      </div>
    </div>
    <div class="bottom-bar">
      <div class="container">
        <div class="back-home">
          <a href="#top" class="btn"><i class="fas fa-home"></i></a>
        </div>
        <div class="likes">
          <a href="" class="btn">
                       <span class="badge">0</span> <i class="far fa-heart"></i>
                    </a>
        </div>
        <div class="add__post">
          <a href="#top" class="btn"><img src="assets/images/btn-img-2.svg" class="img-fluid" alt=""></a>
        </div>
        <div class="notifications">
          <a href="" class="btn">
                   <span class="badge">0</span> <i class="far fa-bell"></i>
                </a>
        </div>
        <div class="go-profile">
          <div class="btn-group dropup">
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i>
              </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#"><i class="fas fa-user"></i> بياناتي الشخصية</a>
              <a class="dropdown-item" href="#"><i class="fas fa-tags"></i> عروضي</a>
              <a class="dropdown-item" href="#"><i class="fas fa-ticket-alt"></i> كوبوناتي</a>
              <a class="dropdown-item" href="#"><i class="far fa-heart"></i> اعجاباتي</a>
              <a class="dropdown-item" href="#"><i class="far fa-comment"></i> تعليقاتي </a>
              <a class="dropdown-item" href="#"><i class="fas fa-images"></i> البوم الصور</a>
              <a class="dropdown-item" href="#"><i class="fas fa-power-off"></i> خروج</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="main-slider">
      <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="7000">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100" src="assets/images/slider-img.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="assets/images/slider-img.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="assets/images/slider-img.jpg" alt="Third slide">
            </div>
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

    <div class="mob-main-sections">
      <div class="container">
        <div class="card shadow-sm bg-white">
          <ul class="list-unstyled no-margin">
            <li class="active"><a href="#"><img src="assets/images/select-all.svg" class="img-fluid" alt="icon"> عرض الكل</a></li>
            <li><a href="#"><img src="assets/images/discount.svg" class="img-fluid" alt="icon"> عروض</a></li>
            <li><a href="#"><img src="assets/images/coupon.svg" class="img-fluid" alt="icon">كوبونات</a></li>
          </ul>
        </div>
      </div>
    </div>





    <main class="main-content" id="top">
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-3 col-md-3 col-sm-12 order-1 order-lg-1 order-md-1 order-sm-2 order-xs-2">
            <div class="side-ads d-none d-sm-block">
              <img src="assets/images/banner01.jpg" class="img-fluid mx-auto" alt="">
            </div>
            <div class="most-commented">
              <div class="card shadow-sm">
                <div class="card-header">
                  <h4><i class="fas fa-comment text-warning"></i> الاكثر تعليقا</h4>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled no-margin">
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
            <div class="most-commented">
              <div class="card shadow-sm">
                <div class="card-header">
                  <h4><i class="fas fa-heart text-danger"></i> الاكثر اعجابا</h4>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled no-margin">
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 order-2 order-lg-2 order-md-2 order-sm-1 order-xs-1">
            <div class="add-post">
              <div class="card shadow-sm">
                <div class="card-header">
                  <div class="media">
                    <img src="assets/images/user_photo.png" class="ml-1" alt="use photo">
                    <div class="media-body">
                      <form action="">
                        <div class="form-group">

                          <textarea name="" id="" class="form-control" placeholder="شارك باضافة عرض او كوبون خصم ..."></textarea>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
                <div class="card-body">
                  <div class="post-type">
                    <a href="" data-toggle="modal" data-target="#selectType" class="btn btn-default">
                          <img src="assets/images/page-1.svg" class="img-fluid" alt=""> نوع المشاركة

                        </a>

                    <a href="#" class="btn btn-default ch-img" data-toggle="modal" data-target="#addImages">
                      <div class="upload-imgs">
                        <img src="assets/images/upload.svg" class="img-fluid" alt="icon"> اضافة صورة
                      </div>
                    </a>
                    <a href="#" class="btn btn-default" data-toggle="modal" data-target="#addLink">
                      <div class="add-link">
                        <img src="assets/images/link2.svg" class="img-fluid" alt="icon"> اضف رابط
                      </div>
                    </a>
                    <a href="#" class="btn btn-default" data-toggle="modal" data-target="#adsTime">
                          <i class="fas fa-clock"></i> مدة الاعلان
                        </a>


                  </div>

                  <div class="share-btn">
                    <button class="btn btn-danger"><img src="assets/images/share-icon.svg" class="img-fluid" alt="icon"> شارك</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="single-post">
              <div class="card shadow-sm">
                <div class="card-header">
                  <div class="media">
                    <div class="media-left ml-1">
                      <a href=""><img src="assets/images/user_photo.png" class="img-fluid" alt=""></a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading"><a href="">محمد احمد محمود</a></h4>
                      <span><i class="far fa-calendar-alt"></i> الاربعاء 10 يناير 2020 - 10 pm</span>
                    </div>
                  </div>
                  <div class="s-post-type bg-danger">
                    <img src="assets/images/discount-2.svg" class="img-fluid" alt="">
                    <span>عرض</span>
                  </div>
                </div>
                <div class="card-body">
                  <p class="card-text">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.</p>
                  <div class="post-imgs">
                    <div class="row">
                      <div class="col-6 col-padding-5">
                        <div class="sm-thum">
                          <img src="assets/images/img1.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="sm-thum">
                          <img src="assets/images/img2.jpg" class="img-fluid" alt="">
                        </div>
                      </div>
                      <div class="col-6 col-padding-5">
                        <div class="lg-img">
                          <img src="assets/images/img5.jpg" class="img-fluid" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="post-counts">
                    <span class="text-warning">2<i class="fas fa-comment"></i></span>
                    <span class="text-danger">0 <i class="fas fa-heart"></i></span>
                    <span class="text-muted">4<i class="fas fa-eye"></i></span>
                  </div>
                  <div class="post-actions">
                    <div class="like">
                      <button class="btn">
                         <div>
                          <input type="checkbox" id="checkbox" />
                          <label for="checkbox">
                            <svg id="heart-svg" viewBox="467 392 58 57" xmlns="http://www.w3.org/2000/svg">
                              <g id="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                                <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" id="heart" fill="#cb0621"/>
                                <circle id="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5"/>

                                <g id="grp7" opacity="0" transform="translate(7 6)">
                                  <circle id="oval1" fill="#9CD8C3" cx="2" cy="6" r="2"/>
                                  <circle id="oval2" fill="#8CE8C3" cx="5" cy="2" r="2"/>
                                </g>

                                <g id="grp6" opacity="0" transform="translate(0 28)">
                                  <circle id="oval1" fill="#CC8EF5" cx="2" cy="7" r="2"/>
                                  <circle id="oval2" fill="#91D2FA" cx="3" cy="2" r="2"/>
                                </g>

                                <g id="grp3" opacity="0" transform="translate(52 28)">
                                  <circle id="oval2" fill="#9CD8C3" cx="2" cy="7" r="2"/>
                                  <circle id="oval1" fill="#8CE8C3" cx="4" cy="2" r="2"/>
                                </g>

                                <g id="grp2" opacity="0" transform="translate(44 6)">
                                  <circle id="oval2" fill="#CC8EF5" cx="5" cy="6" r="2"/>
                                  <circle id="oval1" fill="#CC8EF5" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp5" opacity="0" transform="translate(14 50)">
                                  <circle id="oval1" fill="#91D2FA" cx="6" cy="5" r="2"/>
                                  <circle id="oval2" fill="#91D2FA" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp4" opacity="0" transform="translate(35 50)">
                                  <circle id="oval1" fill="#F48EA7" cx="6" cy="5" r="2"/>
                                  <circle id="oval2" fill="#F48EA7" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp1" opacity="0" transform="translate(24)">
                                  <circle id="oval1" fill="#9FC7FA" cx="2.5" cy="3" r="2"/>
                                  <circle id="oval2" fill="#9FC7FA" cx="7.5" cy="2" r="2"/>
                                </g>
                              </g>
                            </svg>
                          </label>
                        </div> اعجبني</button>
                    </div>
                    <div class="comments">
                      <button class="btn"><i class="fas fa-comment"></i> تعليق</button>
                    </div>
                    <div class="share">
                      <button class="btn" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-share-alt"></i> مشاركة</button>
                    </div>

                  </div>
                </div>
                <div class="card-footer">
                  <img src="assets/images/user_photo.png" class="img-fluid" alt="">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="اكتب تعليقا">
                  </div>
                  <button class="btn"><img src="assets/images/send.svg" class="img-fluid" alt="icon"></button>
                </div>
              </div>
            </div>
            <div class="single-post">
              <div class="card shadow-sm">
                <div class="card-header">
                  <div class="media">
                    <div class="media-left ml-1">
                      <a href=""><img src="assets/images/user_photo.png" class="img-fluid" alt=""></a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading"><a href="">محمد احمد محمود</a></h4>
                      <span><i class="far fa-calendar-alt"></i> الاربعاء 10 يناير 2020 - 10 pm</span>
                    </div>
                  </div>
                  <div class="s-post-type bg-danger">
                    <img src="assets/images/discount-2.svg" class="img-fluid" alt="">
                    <span>عرض</span>
                  </div>
                </div>
                <div class="card-body">
                  <p class="card-text">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.</p>
                  <div class="post-imgs">
                    <div class="row">
                      <div class="col-6 col-padding-5">
                        <div class="sm-thum">
                          <img src="assets/images/img1.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="sm-thum">
                          <img src="assets/images/img2.jpg" class="img-fluid" alt="">
                        </div>
                      </div>
                      <div class="col-6 col-padding-5">
                        <div class="lg-img">
                          <img src="assets/images/img5.jpg" class="img-fluid" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="post-link">
                    <a href="" target="_blank" class="alert alert-success" role="alert">
                      <i class="fas fa-link"></i> www.islamway.com
                    </a>
                  </div>
                  <div class="post-counts">
                    <span class="text-warning">2<i class="fas fa-comment"></i></span>
                    <span class="text-danger">0 <i class="fas fa-heart"></i></span>
                    <span class="text-muted">4<i class="fas fa-eye"></i></span>
                  </div>
                  <div class="post-actions">
                    <div class="like">
                      <button class="btn">
                         <div>
                          <input type="checkbox" id="checkbox" />
                          <label for="checkbox">
                            <svg id="heart-svg" viewBox="467 392 58 57" xmlns="http://www.w3.org/2000/svg">
                              <g id="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                                <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" id="heart" fill="#cb0621"/>
                                <circle id="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5"/>

                                <g id="grp7" opacity="0" transform="translate(7 6)">
                                  <circle id="oval1" fill="#9CD8C3" cx="2" cy="6" r="2"/>
                                  <circle id="oval2" fill="#8CE8C3" cx="5" cy="2" r="2"/>
                                </g>

                                <g id="grp6" opacity="0" transform="translate(0 28)">
                                  <circle id="oval1" fill="#CC8EF5" cx="2" cy="7" r="2"/>
                                  <circle id="oval2" fill="#91D2FA" cx="3" cy="2" r="2"/>
                                </g>

                                <g id="grp3" opacity="0" transform="translate(52 28)">
                                  <circle id="oval2" fill="#9CD8C3" cx="2" cy="7" r="2"/>
                                  <circle id="oval1" fill="#8CE8C3" cx="4" cy="2" r="2"/>
                                </g>

                                <g id="grp2" opacity="0" transform="translate(44 6)">
                                  <circle id="oval2" fill="#CC8EF5" cx="5" cy="6" r="2"/>
                                  <circle id="oval1" fill="#CC8EF5" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp5" opacity="0" transform="translate(14 50)">
                                  <circle id="oval1" fill="#91D2FA" cx="6" cy="5" r="2"/>
                                  <circle id="oval2" fill="#91D2FA" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp4" opacity="0" transform="translate(35 50)">
                                  <circle id="oval1" fill="#F48EA7" cx="6" cy="5" r="2"/>
                                  <circle id="oval2" fill="#F48EA7" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp1" opacity="0" transform="translate(24)">
                                  <circle id="oval1" fill="#9FC7FA" cx="2.5" cy="3" r="2"/>
                                  <circle id="oval2" fill="#9FC7FA" cx="7.5" cy="2" r="2"/>
                                </g>
                              </g>
                            </svg>
                          </label>
                        </div> اعجبني</button>
                    </div>
                    <div class="comments">
                      <button class="btn"><i class="fas fa-comment"></i> تعليق</button>
                    </div>
                    <div class="share">
                      <button class="btn" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-share-alt"></i> مشاركة</button>
                    </div>

                  </div>
                </div>
                <div class="card-footer">
                  <img src="assets/images/user_photo.png" class="img-fluid" alt="">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="اكتب تعليقا">
                  </div>
                  <button class="btn"><img src="assets/images/send.svg" class="img-fluid" alt="icon"></button>
                </div>

                <div class="post-comments">
                  <ul class="list-unstyled no-margin">
                    <li>
                      <div class="main-single-comment">
                        <div class="media">
                          <div class="media-left">
                            <img src="assets/images/user_photo.png" alt="">
                          </div>
                          <div class="media-body">
                            <p><b>mohammed ahmed ali</b> عرض مميز جدا يعطيك العافية</p>
                            <div class="comment-info">
                              <div class="comment-date">
                                10 يناير 2020 - 10 pm
                              </div>
                              <button type="button" class="btn reply-btn">رد <i class="fas fa-reply-all"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <ul class="list-unstyled no-margin">
                        <li>
                          <div class="inner-comment">
                            <div class="media">
                              <div class="media-left">
                                <img src="assets/images/user_photo.png" alt="">
                              </div>
                              <div class="media-body">
                                <p><b>mohammed ahmed ali</b> عرض مميز جدا يعطيك العافية</p>
                                <div class="comment-info">
                                  <div class="comment-date">
                                    10 يناير 2020 - 10 pm
                                  </div>
                                  <button type="button" class="btn reply-btn">رد <i class="fas fa-reply-all"></i></button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li>
                          <div class="inner-comment">
                            <div class="media">
                              <div class="media-left">
                                <img src="assets/images/user_photo.png" alt="">
                              </div>
                              <div class="media-body">
                                <p><b>mohammed ahmed ali</b> عرض مميز جدا يعطيك العافية</p>
                                <div class="comment-info">
                                  <div class="comment-date">
                                    10 يناير 2020 - 10 pm
                                  </div>
                                  <button type="button" class="btn reply-btn">رد <i class="fas fa-reply-all"></i></button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li>
                          <div class="write-comment">
                            <img src="assets/images/user_photo.png" class="img-fluid" alt="">
                            <div class="form-group">
                              <input type="text" class="form-control" value="ahmed ali" placeholder="اكتب تعليقا">
                            </div>
                          </div>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <div class="main-single-comment">
                        <div class="media">
                          <div class="media-left">
                            <img src="assets/images/user_photo.png" alt="">
                          </div>
                          <div class="media-body">
                            <p><b>mohammed ahmed ali</b> عرض مميز جدا يعطيك العافية</p>
                            <div class="comment-info">
                              <div class="comment-date">
                                10 يناير 2020 - 10 pm
                              </div>
                              <button type="button" class="btn reply-btn">رد <i class="fas fa-reply-all"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <div class="more-comments">
                    <a href=""><i class="fas fa-angle-down"></i> مزيد من التعليقات</a>
                    <span>13 من 100</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="single-post">
              <div class="card shadow-sm">
                <div class="card-header">
                  <div class="media">
                    <div class="media-left ml-1">
                      <a href=""><img src="assets/images/user_photo.png" class="img-fluid" alt=""></a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading"><a href="">محمد احمد محمود</a></h4>
                      <span><i class="far fa-calendar-alt"></i> الاربعاء 10 يناير 2020 - 10 pm</span>
                    </div>
                  </div>
                  <div class="s-post-type bg-warning">
                    <img src="assets/images/coupon-2.svg" class="img-fluid" alt="">
                    <span>كوبون</span>
                  </div>
                </div>
                <div class="card-body">
                  <p class="card-text">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.</p>
                  <div class="post-imgs">
                    <div class="row">
                      <div class="col-6 col-padding-5">
                        <div class="lg-img">
                          <img src="assets/images/img5.jpg" class="img-fluid" alt="">
                        </div>
                      </div>
                      <div class="col-6 col-padding-5">
                        <div class="lg-img">
                          <img src="assets/images/img5.jpg" class="img-fluid" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="post-counts">
                    <span class="text-warning">2<i class="fas fa-comment"></i></span>
                    <span class="text-danger">0 <i class="fas fa-heart"></i></span>
                    <span class="text-muted">4<i class="fas fa-eye"></i></span>
                  </div>
                  <div class="post-actions">
                    <div class="like">
                      <button class="btn">
                         <div>
                          <input type="checkbox" id="checkbox" />
                          <label for="checkbox">
                            <svg id="heart-svg" viewBox="467 392 58 57" xmlns="http://www.w3.org/2000/svg">
                              <g id="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                                <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" id="heart" fill="#cb0621"/>
                                <circle id="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5"/>

                                <g id="grp7" opacity="0" transform="translate(7 6)">
                                  <circle id="oval1" fill="#9CD8C3" cx="2" cy="6" r="2"/>
                                  <circle id="oval2" fill="#8CE8C3" cx="5" cy="2" r="2"/>
                                </g>

                                <g id="grp6" opacity="0" transform="translate(0 28)">
                                  <circle id="oval1" fill="#CC8EF5" cx="2" cy="7" r="2"/>
                                  <circle id="oval2" fill="#91D2FA" cx="3" cy="2" r="2"/>
                                </g>

                                <g id="grp3" opacity="0" transform="translate(52 28)">
                                  <circle id="oval2" fill="#9CD8C3" cx="2" cy="7" r="2"/>
                                  <circle id="oval1" fill="#8CE8C3" cx="4" cy="2" r="2"/>
                                </g>

                                <g id="grp2" opacity="0" transform="translate(44 6)">
                                  <circle id="oval2" fill="#CC8EF5" cx="5" cy="6" r="2"/>
                                  <circle id="oval1" fill="#CC8EF5" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp5" opacity="0" transform="translate(14 50)">
                                  <circle id="oval1" fill="#91D2FA" cx="6" cy="5" r="2"/>
                                  <circle id="oval2" fill="#91D2FA" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp4" opacity="0" transform="translate(35 50)">
                                  <circle id="oval1" fill="#F48EA7" cx="6" cy="5" r="2"/>
                                  <circle id="oval2" fill="#F48EA7" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp1" opacity="0" transform="translate(24)">
                                  <circle id="oval1" fill="#9FC7FA" cx="2.5" cy="3" r="2"/>
                                  <circle id="oval2" fill="#9FC7FA" cx="7.5" cy="2" r="2"/>
                                </g>
                              </g>
                            </svg>
                          </label>
                        </div> اعجبني</button>
                    </div>
                    <div class="comments">
                      <button class="btn"><i class="fas fa-comment"></i> تعليق</button>
                    </div>
                    <div class="share">
                      <button class="btn" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-share-alt"></i> مشاركة</button>
                    </div>

                  </div>
                </div>

              </div>
            </div>

            <div class="single-post">
              <div class="card shadow-sm">
                <div class="card-header">
                  <div class="media">
                    <div class="media-left ml-1">
                      <a href=""><img src="assets/images/user_photo.png" class="img-fluid" alt=""></a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading"><a href="">محمد احمد محمود</a></h4>
                      <span><i class="far fa-calendar-alt"></i> الاربعاء 10 يناير 2020 - 10 pm</span>
                    </div>
                  </div>
                  <div class="s-post-type bg-danger">
                    <img src="assets/images/discount-2.svg" class="img-fluid" alt="">
                    <span>عرض</span>
                  </div>
                </div>
                <div class="card-body">
                  <p class="card-text">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.</p>
                  <div class="post-imgs">
                    <div class="row">
                      <div class="col-12 col-padding-5">
                        <div class="lg-img">
                          <img src="assets/images/img5.jpg" class="img-fluid" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="post-counts">
                    <span class="text-warning">2<i class="fas fa-comment"></i></span>
                    <span class="text-danger">0 <i class="fas fa-heart"></i></span>
                    <span class="text-muted">4<i class="fas fa-eye"></i></span>
                  </div>
                  <div class="post-actions">
                    <div class="like">
                      <button class="btn">
                         <div>
                          <input type="checkbox" id="checkbox" />
                          <label for="checkbox">
                            <svg id="heart-svg" viewBox="467 392 58 57" xmlns="http://www.w3.org/2000/svg">
                              <g id="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                                <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" id="heart" fill="#cb0621"/>
                                <circle id="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5"/>

                                <g id="grp7" opacity="0" transform="translate(7 6)">
                                  <circle id="oval1" fill="#9CD8C3" cx="2" cy="6" r="2"/>
                                  <circle id="oval2" fill="#8CE8C3" cx="5" cy="2" r="2"/>
                                </g>

                                <g id="grp6" opacity="0" transform="translate(0 28)">
                                  <circle id="oval1" fill="#CC8EF5" cx="2" cy="7" r="2"/>
                                  <circle id="oval2" fill="#91D2FA" cx="3" cy="2" r="2"/>
                                </g>

                                <g id="grp3" opacity="0" transform="translate(52 28)">
                                  <circle id="oval2" fill="#9CD8C3" cx="2" cy="7" r="2"/>
                                  <circle id="oval1" fill="#8CE8C3" cx="4" cy="2" r="2"/>
                                </g>

                                <g id="grp2" opacity="0" transform="translate(44 6)">
                                  <circle id="oval2" fill="#CC8EF5" cx="5" cy="6" r="2"/>
                                  <circle id="oval1" fill="#CC8EF5" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp5" opacity="0" transform="translate(14 50)">
                                  <circle id="oval1" fill="#91D2FA" cx="6" cy="5" r="2"/>
                                  <circle id="oval2" fill="#91D2FA" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp4" opacity="0" transform="translate(35 50)">
                                  <circle id="oval1" fill="#F48EA7" cx="6" cy="5" r="2"/>
                                  <circle id="oval2" fill="#F48EA7" cx="2" cy="2" r="2"/>
                                </g>

                                <g id="grp1" opacity="0" transform="translate(24)">
                                  <circle id="oval1" fill="#9FC7FA" cx="2.5" cy="3" r="2"/>
                                  <circle id="oval2" fill="#9FC7FA" cx="7.5" cy="2" r="2"/>
                                </g>
                              </g>
                            </svg>
                          </label>
                        </div> اعجبني</button>
                    </div>
                    <div class="comments">
                      <button class="btn"><i class="fas fa-comment"></i> تعليق</button>
                    </div>
                    <div class="share">
                      <button class="btn" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-share-alt"></i> مشاركة</button>
                    </div>

                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 order-3 order-lg-3 order-md-3 order-sm-3 order-xs-3">
            <div class="side-ads d-none d-sm-block">
              <img src="assets/images/banner01.jpg" class="img-fluid mx-auto" alt="">
            </div>
            <div class="most-commented">
              <div class="card shadow-sm">
                <div class="card-header">
                  <h4><i class="fas fa-eye text-muted"></i> الاكثر مشاهدة</h4>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled no-margin">
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="side-widget">
                        <div class="media">
                          <div class="media-left">
                            <a href=""><img src="assets/images/user_photo.png" alt=""></a>
                          </div>
                          <div class="media-body">
                            <div class="media-heading">
                              <div class="widget-title">
                                <h5>محمد احمد محمود</h5>
                                <span>الاربعاء 10 يناير - 10:30 pm</span>
                              </div>
                              <div class="space"></div>
                              <div class="widget-comments">
                                <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i> 100</span>
                              </div>
                            </div>
                            <div class="media-text">
                              <p>اجمل سيارة متوفرة في امريكا والمملكة العربية السعودية </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
            <div class="most-commented">
              <div class="card shadow-sm">
                <div class="card-header">
                  <h4><i class="fas fa-mobile text-danger"></i> تحميل التطبيقات</h4>
                </div>
                <div class="card-body">
                  <p class="text-muted">حمل التطبيقات الآن</p>
                  <div class="download-app">
                    <a href=""><img src="assets/images/app-store.svg" class="img-fluid" alt=""></a>
                    <a href=""><img src="assets/images/google-play.svg" class="img-fluid" alt=""></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="follow-us">
              <div class="card shadow-sm">
                <div class="card-body">
                  <p class="text-muted">تابعنا علي </p>
                  <div class="social">
                    <a href="" class="fab fa-facebook-f"></a>
                    <a href="" class="fab fa-twitter"></a>
                    <a href="" class="fab fa-youtube"></a>
                    <a href="" class="fab fa-google"></a>
                  </div>
                </div>
              </div>
            </div>

            <div class="most-commented">
              <div class="card shadow-sm">
                <div class="card-header">
                  <h4><i class="fas fa-link text-danger"></i> روابط سريعة</h4>
                </div>
                <div class="card-body">
                  <div class="fast-links">
                    <ul class="list-unstyled no-margin">
                      <li><a href="">من نحن</a></li>
                      <li><a href="">الشروط والاحكام</a></li>
                      <li><a href="">سياسة الخصوصية</a></li>
                      <li><a href="">اتصل بنا</a></li>

                    </ul>
                  </div>
                </div>
                <div class="card-footer">
                  <span>جميع الحقوق محفوظة ©️ 2020</span>
                  <p>تصميم وبرمجة <a href=""><img src="assets/images/qrc.svg" class="img-fluid" alt=""> رمز الاستجابة</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <footer class="main-footer">

    </footer>

    <!-- Modal -->
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
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
              <label class="form-check-label" for="inlineRadio1">عرض</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
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
                <input type="text" class="form-control">
                <button class="btn btn-block btn-danger no-border">حفظ</button>
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
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
              <label class="form-check-label" for="inlineRadio1">اسبوع</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
              <label class="form-check-label" for="inlineRadio2">شهر</label>
            </div>
          </div>
        </div>
      </div>
    </div>

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
                <img src="assets/images/user_photo.png" class="ml-2" alt="user img">
                <div class="media-body">
                  <h5 class="media-heading">محمد عبد المنعم</h5>
                </div>
              </div>
            </div>
            <div class="dashboard-links">
              <ul class="list-unstyled no-margin">
                <li><a href="#"><i class="fas fa-user"></i> بياناتي الشخصية</a></li>
                <li><a href="#"><i class="fas fa-tags"></i> عروضي</a></li>
                <li><a href="#"><i class="fas fa-ticket-alt"></i> كوبوناتي</a></li>
                <li><a href="#"><i class="far fa-heart"></i> اعجاباتي</a></li>
                <li><a href="#"><i class="far fa-comment"></i> تعليقاتي </a></li>
                <li><a href="#"><i class="fas fa-images"></i> البوم الصور</a></li>
                <li><a href="#"><i class="fas fa-images"></i> الاكثر تعليقا</a></li>
                <li><a href="#"><i class="fas fa-images"></i> الاكثر اعجابا</a></li>
                <li><a href="#"><i class="fas fa-power-off"></i> خروج</a></li>
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
                <input type="text" class="form-control">
                <button class="btn btn-block btn-danger no-border">بحث</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <script src="assets/js/jquery-3.3.1.min.js"></script>
  <script src="assets/js/popper.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/plugins/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/plugins/select2.full.min.js"></script>
  <script src="assets/plugins/jssocials.min.js"></script>
  <script src="assets/js/scripts.0.0.1.js"></script>
</body>

</html>
