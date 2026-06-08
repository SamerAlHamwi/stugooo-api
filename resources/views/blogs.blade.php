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

<body class="purple-theme">
  <!--
  
  <div class="d-flex align-items-center w-100 position-absulute">
    <div class="loader mx-auto">
    </div>
  </div>
-->

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
                        <a href="{{route('home')}}" id="index-nav" class="nav-link" data-scroll="index-section" >{{ __('Home') }}</a>
                        
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
    

    <div class="">
        <!-- Start BLOGS-->
 
      
  
        <div class="post-container mx-5 p-5">
            <div class="posts-grid">
                @foreach ($posts as $post)
                <article class="card__article m-3">
                    <div class="card__image">
                        <img src="{{ asset('storage/' . $post->card_image) }}" alt="image" class="card__img">
                        <div class="card__shadow"></div>
                    </div>
        
                    <div class="card__data">
                        <h3 class="card__name">{{ $post->title }}</h3>
                        <p class="card__description">
                            {{ $post->summary }}
                        </p>
                        <a href="{{ route('post', $post->id) }}" class="div-link rounded-pill m-auto px-3">{{ __('Read more') }}</a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
        
          <!-- عرض روابط التنقل بين الصفحات -->
        <div class="pagination-container m-auto">
            {{ $posts->links() }}
        </div>
        
        
         <!-- END BLOGS--> 

 
    </div>  
   
    <div class="layer">
      
 
  
    </div>

  </div>
          
</div>


  

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  
     <!--=============== CARDS SWIPER JS ===============-->


    
    
    
    
    
    

</body>
</html>