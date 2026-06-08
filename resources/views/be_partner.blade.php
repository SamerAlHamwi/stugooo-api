<!DOCTYPE html>
<html dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stugooo</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">

<!--===============CARDS ===============-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
<!--===============CARDS SWIPER CSS ===============-->
<link rel="stylesheet" href="{{asset('assets/card-assets/css/swiper-bundle.min.css')}}">
<!--=============== CARDS CSS ===============-->
<link rel="stylesheet" href="{{asset('assets/card-assets/css/styles.css')}}">

</head>

<body class="purple-theme" >

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
                        <a href="{{route('home')}}" id="index-nav" class="nav-link" data-scroll="index-section" > {{ __('Home') }}</a>
                        
                      </li>
                      <li class="nav-item">
                        <a href="{{route('posts')}}" id="ourproduct-nav" class="nav-link ourproduct" data-scroll="ourproduct-section" >{{ __('Blog') }}</a>
                      </li>
                      
                </ul>
              </div>
            </nav>
        </div>
        <div class="col col-md-3 pt-4 mt-2">
          <div class="full-logo me-auto">
            <div class="d-inline-block align-middle">
              <a class="logo-text" href="#">STUGOOO</a>
          </div>
          <div class="logo rounded-circle d-inline-block align-middle" >
          </div>  
          </div>        
        </div>
      </div>
    </div>
    <img src="{{asset('assets/css/totop.png')}}"  id="totop" class="scrollToTop" ></img>
    
{{-- <div id="be_partner0">
    {{$be_partner }}
</div> --}}
<div class="container mt-5 mb-5">
<div class="card shadow p-4" style="background: transparent;">
 <div id="be_partner" style="padding:20px;"></div>
</div></div>
<script type="application/json" id="md-content">
    {!! json_encode((string) $be_partner) !!}
</script>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    let markdownText = JSON.parse(document.getElementById('md-content').textContent);

    // تأكد أنه نص
    if (typeof markdownText !== 'string') {
        markdownText = String(markdownText);
    }

    let htmlContent = marked.parse(markdownText);
    document.getElementById('be_partner').innerHTML = htmlContent;
</script>


<!-- ====== Contact Form Section ====== -->
{{-- <div class="container mt-5 mb-5">
<div class="card shadow p-4" style="background: transparent;">
        <h3 class="mb-4 text-center">{{ __('Contact Us') }}</h3>
        
        <form action="{{ route('contact.send') }}" method="POST">
            @csrf
            <div class="mb-3" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                <label for="message" class="form-label" >{{ __('Message') }}</label>
                <textarea name="message" id="message" rows="4" class="form-control" required></textarea>
            </div>
            <button type="submit" class="div-link  rounded-pill w-100 px-auto mx-auto">{{ __('Send') }}</button>
        </form>

        <hr class="my-4">

        <div class="text-center">
            <p><strong>Email:</strong> 
                <a href="mailto:info@stugooo.com">info@stugooo.com</a> | 
                <a href="mailto:sales@stugooo.com">sales@stugooo.com</a>
            </p>
            <p><strong>Tel:</strong> <a href="tel:+905370408425">0090 537 040 84 25</a></p>
        </div>
    </div>
</div> --}}
<!-- ====== End Contact Form Section ====== -->




   
    <div class="layer">  
    </div>

  </div>
          
</div>


  

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  
     <!--=============== CARDS SWIPER JS ===============-->
     <script src="{{asset('assets/card-assets/js/swiper-bundle.min.js')}}"></script>
     <!--=============== MAIN JS ===============-->
     <script src="{{asset('assets/card-assets/js/main.js')}}"></script>



    
    
    

</body>
</html>