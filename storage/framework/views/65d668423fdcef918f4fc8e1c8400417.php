<!DOCTYPE html>
<html dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stugooo</title>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css')); ?>">

<!--===============CARDS ===============-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
<!--===============CARDS SWIPER CSS ===============-->
<link rel="stylesheet" href="<?php echo e(asset('assets/card-assets/css/swiper-bundle.min.css')); ?>">
<!--=============== CARDS CSS ===============-->
<link rel="stylesheet" href="<?php echo e(asset('assets/card-assets/css/styles.css')); ?>">

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
                        <a href="<?php echo e(route('home')); ?>" id="index-nav" class="nav-link" data-scroll="index-section" > <?php echo e(__('Home')); ?></a>
                        
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo e(route('posts')); ?>" id="ourproduct-nav" class="nav-link ourproduct" data-scroll="ourproduct-section" ><?php echo e(__('Blog')); ?></a>
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
    <img src="<?php echo e(asset('assets/css/totop.png')); ?>"  id="totop" class="scrollToTop" ></img>
    

<div class="container mt-5 mb-5">
<div class="card shadow p-4" style="background: transparent;">
 <div id="be_partner" style="padding:20px;"></div>
</div></div>
<script type="application/json" id="md-content">
    <?php echo json_encode((string) $be_partner); ?>

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

<!-- ====== End Contact Form Section ====== -->




   
    <div class="layer">  
    </div>

  </div>
          
</div>


  

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  
     <!--=============== CARDS SWIPER JS ===============-->
     <script src="<?php echo e(asset('assets/card-assets/js/swiper-bundle.min.js')); ?>"></script>
     <!--=============== MAIN JS ===============-->
     <script src="<?php echo e(asset('assets/card-assets/js/main.js')); ?>"></script>



    
    
    

</body>
</html><?php /**PATH /home/stug_ooo/htdocs/stugooo.com/resources/views/be_partner.blade.php ENDPATH**/ ?>