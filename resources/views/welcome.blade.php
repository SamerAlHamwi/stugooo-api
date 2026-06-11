<!DOCTYPE html>
<html dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stugooo</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main.css">


<!--===============CARDS ===============-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
<!--===============CARDS SWIPER CSS ===============-->
<link rel="stylesheet" href="assets/card-assets/css/swiper-bundle.min.css">
<!--=============== CARDS CSS ===============-->
<link rel="stylesheet" href="assets/card-assets/css/styles.css">

</head>

<body class="purple-theme">
  <!--

  <div class="d-flex align-items-center w-100 position-absulute">
    <div class="loader mx-auto">
    </div>
  </div>
-->



<div class="maincontainer">

    <div class="container-xxl sticky-top ">
      <div class="header row d-flex justify-content-center justify-content-sm-between">
        <div class="col col-md-9 ">
          <nav class="navbar navbar-expand-md">
              <button class="navbar-toggler"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#navbarSupportedContent"
                      aria-controls="navbarSupportedContent"
                      aria-expanded="false"
                      aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                    <li class="nav-item">
                        <a id="index-nav" class="nav-link" data-scroll="index-section" href="#">{{ __('Home') }}</a>

                      </li>
                      <li class="nav-item">
                        <a id="ourproduct-nav" class="nav-link ourproduct" data-scroll="ourproduct-section" href="#">{{ __('Our Products') }}</a>
                      </li>
                      <li class="nav-item">
                        <a id="vision-nav" class="nav-link" data-scroll="vision-section" href="#">{{ __('Vision') }}</a>
                      </li>
                      <li class="nav-item">
                        <a id="blog-nav" class="nav-link" data-scroll="blog-cards-section" href="#">{{ __('Blog') }}</a>
                      </li>
                      {{-- <li class="nav-item">
                        <a id="said-nav" class="nav-link" data-scroll="said-cards-section" href="#">{{ __('Customer Reviews') }}</a>
                      </li> --}}

                       <li class="nav-item">
                        <a id="our-team-nav" class="nav-link" data-scroll="our-team-cards-section" href="#">{{ __('Our team') }}</a>
                      </li>


                      <li class="nav-item">
                        <a id="video-nav" class="nav-link" data-scroll="video-section" href="#">{{ __('Videos') }}</a>
                      </li>
                      <li class="nav-item">
                        <a id="contactus-nav" class="nav-link" data-scroll="contactus-section" href="#">{{ __('Contact Us') }}</a>
                      </li>
                      <li class="nav-item">
                        <a id="be-partner-nav" class="nav-link" data-scroll="be-partner-section" href="{{ route('partner') }}">{{ __('Be a partner') }}</a>
                      </li>
                       <li class="nav-item">
                          <a id="sign-up-nav" class="nav-link" href="https://pro.stugooo.com/auth/sign-up" target="_blank" rel="noopener noreferrer">{{ __('Sign Up') }}</a>
                      </li>
                </ul>
              </div>
            </nav>
        </div>
        <div class="col col-md-3 pt-4 mt-2" >
          <div class="d-flex">
          <div class="full-logo {{app()->getLocale() == 'ar' ? 'me-auto' : 'ms-auto'}} ">
            <div class="d-inline-block align-middle">
              <a class="logo-text" href="#">STUGOOO</a>
          </div>
          <div class="logo rounded-circle d-inline-block align-middle" >
          </div>
          </div>
          </div>
        </div>
      </div>
    </div>
    <img src="assets/css/totop.png"  id="totop" class="scrollToTop" ></img>

    <div class="container">
        <!-- Start Index-->
         <div class="section"   id="index-section">

            <div class="row d-flex justify-content-center justify-content-sm-between my-1 pe-1 pe-md-5">
                <div class="col-10 col-md-9">
                    <p class="head fw-bolder mb-3 mb-lg-5 fs-1 ">{{$data->settings->main_title}}</p>
                    <p class="paragraph fs-4 ">
                        {{$data->settings->main_content}}
                    </p>
                </div>
                <div class="col-1 col-sm-1 col-lg-2 d-flex justify-content-end align-items-center" >
                </div>
                <!--
                <div id="changeTheme" class="site-color  rounded-pill col-2 align-self-center d-none d-lg-block" ></div>
              -->
            </div>
            {{--  <div class="row mb-3 d-flex justify-content-center justify-content-md-evenly">
                <div class="div-link  rounded-pill">{{ __('Become a Partner') }}</div>
                <div class="div-link  rounded-pill">{{ __('Contact Us') }}</div>
                <a href="{{route('posts')}}" class="div-link  rounded-pill">{{ __('Blog') }}</a>
                <div class="div-link  rounded-pill">{{ __('Videos') }}</div>
            </div>
			--}}
         </div>

        <!-- End Index -->

        <!-- Start Product Slider-->
        <div class="section" id="ourproduct-section">
                <section class="ccontainer">
                    <div class="card__container swiper">

                    <div class="blog__content">
                            <p class="head fw-bolder fs-1 fs-sm-3">{{ __('Our Products') }}</p>

                        <div class="swiper-wrapper">
 @foreach ($data->products as $key=>$product)
<article class="card__article swiper-slide">
  <div class="row d-flex justify-content-between mx-md-2 ">
    <div class="col-md-8">
      <div class="position-relative">
        <p class="head fw-bolder fs-1 fs-sm-3">{{ __('Our Products') }}</p>
        <p class="head fw-bolder fs-1 fs-sm-3">{{ $product->title }}</p>

        <span class="productContent paragraph fs-5 fs-md-2">
          {{ $product->content }}
        </span>
        <span class="toggleBtn rounded-pill">{{ __('More') }}</span>
      </div>
    </div>

    <div class="col-md-3 d-flex align-items-center">
      <img class="our-product" src="storage/{{$product->image}}" alt="">
    </div>
  </div>

  <div class="row d-flex justify-content-center d-sm-flex justify-content-md-end mt-4 px-1">
    @if ($product->android_url)
      <a class="div-link rounded-pill" target="_blank" rel="noopener noreferrer" href="{{$product->android_url}}">
        {{ __('Download Android') }}
      </a>
    @endif
    @if ($product->ios_url)
      <a class="div-link rounded-pill" target="_blank" rel="noopener noreferrer" href="{{$product->ios_url}}">
        {{ __('Download Ios') }}
      </a>
    @endif
  </div>
</article>
@endforeach


                        </div>
                    </div>

                    <!-- Navigation buttons -->
                    <div class="swiper-button-next">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>

                    <div class="swiper-button-prev">
                        <i class="ri-arrow-left-s-line"></i>
                    </div>

                    <!-- Pagination
                        <div class="swiper-pagination"></div>
                        -->

                    </div>
                </section>

                          </div>

        <!-- END Product Slider-->


        <!-- Start Our Product-->
         {{-- <div class="section" id="ourproduct-section">
            <div class="row d-flex justify-content-between mx-md-2 ">
                <div class="col-md-8" >
                  <div id="product-description" class="position-relative" >
                    <p class="head fw-bolder fs-1 fs-sm-3">{{ __('Our Products') }} </p>
                    <p class="head fw-bolder fs-1 fs-sm-3">{{$product->title}}</p>
                    <p class="paragraph      fs-5 fs-md-2  ">
                        {{$product->content}}
                    </p>
                  </div>

                </div>
                <div class="col-md-3 d-flex align-items-center">
                  <img id="product-image"  class="our-product" src="storage/{{$product->image}}" alt="">
                </div>
                </div>
                <div id="product-buttons" class="row d-flex justify-content-center d-sm-flex justify-content-md-end mt-4 px-1">
                  @if ($product->android_url)
                      <a class="div-link  rounded-pill" target="_blank" rel="noopener noreferrer" href="{{$product->android_url}}">{{ __('Download Android') }}</a>
                  @endif
                  @if ($product->ios_url)
                      <a class="div-link  rounded-pill" target="_blank" rel="noopener noreferrer" href="{{$product->ios_url}}">{{ __('Download Ios') }}</a>
                  @endif
              </div>
            </div> --}}




        <!-- End Our Product-->
        <!-- <hr> -->
        <!-- Start Vision-->
         <div class="section" id="vision-section">
            <div class="row d-flex justify-content-between my-3 mx-2">
                <div class="col-9 col-sm-8">
                    <p class="head fw-bolder fs-1 fs-sm-3">{{ __('Vision') }}</p>
                </div>
                <div class="col-2 col-sm-3">
                    <img class="d-none d-md-block vision-image float-start" src="assets/css/vision-svgrepo-com.png" alt="">

                </div>
            </div>
            <div class="row  mx-auto">
              <div class="col">
                <div id="vision-1" class="vision">
                  <p>
                    {{$data->settings->vision_1}}
                </p>
                    <img class="dice" src="assets/css/dice/dice-one.png" alt="">
                </div>
              </div>

              <div  class="col">
                <div id="vision-2" class="vision">
                  <p>
                    {{$data->settings->vision_2}}
                  </p>
                  <img class="dice" src="assets/css/dice/dice-two.png" alt="">
                </div>
              </div>
              <div class="col">
                <div id="vision-3" class="vision">
                  <p>
                    {{$data->settings->vision_3}}
                  </p>
                  <img class="dice" src="assets/css/dice/dice-three.png" alt="">
                </div>
              </div>

              <div class="col">
                <div id="vision-4" class="vision">
                  <p>
                    {{$data->settings->vision_4}}
                  </p>
                  <img class="dice" src="assets/css/dice/dice-four.png" alt="">
                </div>
              </div>

              <div class="col">
                <div id="vision-5" class="vision">
                  <p>
                    {{$data->settings->vision_5}}
                  </p>
                  <img class="dice" src="assets/css/dice/dice-five.png" alt="">
                </div>
              </div>
              <div class="col">
                <div id="vision-6" class="vision">
                  <p>
                    {{$data->settings->vision_6}}
                  </p>
                  <img class="dice" src="assets/css/dice/dice-six.png" alt="">
                </div>
              </div>

            </div>
         </div>

        <!-- End Vision-->

        <!-- Start BLOG-->

        <div class="section" id="blog-cards-section">
          <section class="ccontainer">
            <div class="card__container swiper">

              <div class="card__content">
                    <a href="{{route('posts')}}" class="head fw-bolder fs-1 fs-sm-3">{{ __('Blog') }}</a>

                  <div class="swiper-wrapper">

                    @foreach ($data->posts as $post)
                    <article class="card__article swiper-slide">
                        <div class="card__image">
                          <img src="storage/{{$post->card_image}}" alt="image" class="card__img">
                          <div class="card__shadow"></div>
                        </div>

                        <div class="card__data">
                          <h3 class="card__name">{{$post->title}}</h3>
                          <p class="card__description">
                            {{$post->summary}}
                        </p>
                          <a href="{{ route('post', $post->id) }}" class="div-link rounded-pill m-auto px-5">{{ __('Read more') }}</a>

                        </div>
                    </article>
                    @endforeach
                  </div>
              </div>

              <!-- Navigation buttons -->
              <div class="swiper-button-next">
                  <i class="ri-arrow-right-s-line"></i>
              </div>

              <div class="swiper-button-prev">
                  <i class="ri-arrow-left-s-line"></i>
              </div>

              <!-- Pagination
               <div class="swiper-pagination"></div>
               -->

            </div>
            </section>
        </div>
        <!-- END BLOG-->


       <!-- Start Said-->
         {{-- <div class="section" id="said-cards-section">
          <div class="row my-1 mx-4">
            <div class="col">
                <p class="head fw-bolder fs-1 fs-sm-3">{{ __('Customer Reviews') }}</p>
            </div>
        </div>
        <div class=" row d-flex justify-content-between said-container m-auto">
        @foreach ($data->said as $key=>$said)

          <div id="said-card-{{$key+1}}" class="said-card col-10 col-lg-3">
              <div class="face face1">
                  <div class="content">
                      <img src="storage/{{$said->card_image}}">
                      <h3>{{$said->customer}}</h3>
                  </div>
              </div>
              <div class="face face2">
                  <div class="content">
                    <p>
                        {{$said->content}}
                    </p>
                  </div>
              </div>
          </div>

          @endforeach
      </div>
    </div> --}}
        <!-- End Said-->

        <!-- Start our team-->
         <div class="section" id="our-team-cards-section">
          <div class="row my-1 mx-4">
            <div class="col">
                <p class="head fw-bolder fs-1 fs-sm-3">{{ __('Our team') }}</p>
            </div>
        </div>
        <div class=" row d-flex justify-content-between said-container m-auto">
        @foreach ($data->said as $key=>$said)

          <div id="our-team-card-{{$key+1}}" class="said-card col-10 col-lg-3">
              <div class="face face1">
                  <div class="content">
                      <img  style=" object-fit:fill;" src="storage/{{$said->card_image}}">
                      <h3>{{$said->customer}}</h3>
                  </div>
              </div>
              <div class="face face2">
                  <div class="content">
                    <p>
                        {{$said->content}}
                    </p>
                  </div>
              </div>
          </div>

          @endforeach
      </div>
    </div>
        <!-- End our team-->
        <!-- <hr> -->

        <!-- Start video-->
        <div class="section" id="video-section">

            @foreach ($data->videos as $video)
            <div class="row my-1 mx-4">
            <div class="col-8  col-md-10">
                <p class="head fw-bolder fs-3 fs-sm-4">
                    {{$video->title}}
                </p>
            </div>
            <div class="col-8 col-md-2">
                <img src="assets/css/social.png" >
          </div>
        </div>

        <div class="row  my-2 mx-4">
          <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%;">
         <iframe
        id="youtube-player"
        height="640"
        title="YouTube video player"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="origin-when-cross-origin"
        src = "{{$video->video_url}}?rel=0&playsinline=1"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
        allowfullscreen>
      </iframe>

        </div>
          </div>

        @endforeach

      </div>


        <!-- End video-->
        <!-- <hr> -->

        <!-- Start Contact Us-->
         <div class="section" id="contactus-section">
            <div class="row d-flex justify-content-between my-3 mx-2">
                <div class="col">
                    <p class="head fw-bolder fs-1 fs-sm-3">{{ __('Contact Us') }}</p>
                </div>
            </div>
            <div class="row d-flex justify-content-between">
              <div class="col-10 col-lg-4 mx-3">
    <div class="d-flex justify-content-start align-items-center my-2" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <i class="fa-2x fas fa-map-marker-alt text-white"></i>
        <span class="ms-2 me-2">{{$data->settings->company_address}}</span>
    </div>
    <div class="d-flex justify-content-start align-items-center my-4" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <i class="fa-2x fas fa-phone-square text-white"></i>
        <span class="ms-2 me-2">{{$data->settings->company_phone}}</span>
    </div>
    <div class="d-flex justify-content-start align-items-center my-2" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <i class="fa-2x fas fa-mail-bulk text-white"></i>
        <span class="ms-2 me-2">{{$data->settings->company_email}}</span>
    </div>
</div>

              <div class="col-10 col-lg-3 mx-3 ">
                <div class="d-flex justify-content-start align-items-center" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                    <i class="fa-2x far fa-clock text-white "></i>

                  <span class="ms-2">  Office Hours </span>

                </div>
                 <p class="mt-4">
                    {{$data->settings->office_hours}}
                </p>
              </div>
              <div class="col-10 col-lg-2 text-start my-2 mx-3">
                <div class="mb-3">
                  Follow Us
                </div>
              <div class="d-flex justify-content-between">

                <a class="icon-link" href="{{$data->settings->instagram_url}}">
                    <i class="fa-2x fab fa-instagram text-white "></i>
                </a>

                <a class="icon-link" href="{{$data->settings->facebook_url}}">
                    <i class="fa-2x fab fa-facebook-square text-white "></i>
                </a>
                <a class="icon-link" href="{{$data->settings->youtube_url}}">
                    <i class="fa-2x fab fa-youtube text-white" href="ada"></i>
                </a>


              </div>
              <br>
               <div class="d-flex justify-content-between">


                <a class="icon-link" href="{{$data->settings->tiktok_url}}">
                    <i class="fa-2x fab fa-tiktok text-white "></i>
                </a>
                <a class="icon-link" href="{{$data->settings->telegram_url}}">
                    <i class="fa-2x fab fa-telegram text-white "></i>
                </a>
                <a class="icon-link" href="{{$data->settings->whatsapp_url}}">
                    <i class="fa-2x fab fa-whatsapp text-white" href="ada"></i>
                </a>


              </div>
              </div>
            </div>
            <div class="row m-2 mb-5 py-5">
                <p class="text-light text-center p-3">
                    {{$data->settings->footer}}
                </p>


            </div>

         </div>

        <!-- End Contact Us-->
    </div>
</div>
    <div class="layer">

    </div>
    <div class="loading-spinner"></div>

     <ul class="circles">
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>

    </ul>




     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
     <!--=============== CARDS SWIPER JS ===============-->
     <script src="assets/card-assets/js/swiper-bundle.min.js"></script>

     <!--=============== MAIN JS ===============-->
     <script src="assets/card-assets/js/main.js"></script>
     <script src="assets/js/main.js"></script>


       <!--=============== vedio ===============

    <script>
    const player = document.getElementById("youtube-player");
    const params = new URLSearchParams({
      rel: "0",
      playsinline: "1"
    });

    if (window.location.origin && window.location.origin !== "null") {
      params.set("origin", window.location.origin);
    }

    player.src = `https://www.youtube.com/embed/nT7YCf9uSoY?${params}`;
  </script>
         -=============== vedio ===============-->


<script>
  document.querySelectorAll(".card__article").forEach(article => {
    const contentElement = article.querySelector(".productContent");
    const toggleBtn = article.querySelector(".toggleBtn");

    if (!contentElement || !toggleBtn) return;

    const fullText = contentElement.textContent.trim();
    const maxLength = 1000;

    if (fullText.length > maxLength) {
      const shortText = fullText.substring(0, maxLength) + " .....";
      let isShort = true;
      contentElement.textContent = shortText;

      toggleBtn.addEventListener("click", function () {
        if (isShort) {
          contentElement.textContent = fullText;
          toggleBtn.textContent = "Hide";
        } else {
          contentElement.textContent = shortText;
          toggleBtn.textContent = "More";
        }
        isShort = !isShort;
      });
    } else {
      toggleBtn.style.display = "none"; // النص قصير → إخفاء الزر
    }
  });
</script>



<div class="d-flex align-items-center justify-content-start px-5">
    <div class="dropdown me-2"> {{-- Added me-2 for margin-right --}}
        <button class="btn btn-link" dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            {{-- Display current language --}}
            @if(app()->getLocale() == 'en')
                English
            @elseif(app()->getLocale() == 'ar')
                العربية
            @elseif(app()->getLocale() == 'tr')
                Türkçe
            @else
                {{ __('Select Language') }}
            @endif
        </button>
        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
            <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('set.locale', ['locale' => 'en']) }}">English</a></li>
            <li><a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ route('set.locale', ['locale' => 'ar']) }}">العربية</a></li>
            <li><a class="dropdown-item {{ app()->getLocale() == 'tr' ? 'active' : '' }}" href="{{ route('set.locale', ['locale' => 'tr']) }}">Türkçe</a></li>
        </ul>
    </div>
    <a href="{{ url('/admin') }}" class="btn btn-link" mx-2">{{ __('Login') }}</a> {{-- Applied btn btn-primary for consistent styling --}}
</div>


</body>
</html>
