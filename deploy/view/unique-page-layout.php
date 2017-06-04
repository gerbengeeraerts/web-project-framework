<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo MY_APP_FOLDER ?>"><!--[if lte IE 6]></base><![endif]-->
        <title><?php echo $_SESSION['APP_PAGE_TITLE']; ?> | Petrolfest</title>
        <meta charset="utf-8">
        <meta name="description" content="<?php echo $_SESSION['APP_PAGE_DESCRIPTION']; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Favicon Madness -->

        <!-- Meta for Google -->
        <meta name="author" content="Nerdben Entertainment" />
        <meta name="copyright" content="<?php echo date('Y'); ?> Nerdben Entertainment" />

        <!-- Meta for Facebook -->
        <meta property="og:title" content="<?php echo $_SESSION['APP_SHARE_TITLE']; ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="<?php echo $_SESSION['APP_SHARE_IMAGE']; ?>" />
        <meta property="og:url" content="<?php echo $_SESSION['APP_SHARE_URL'] ?>" />
        <meta property="og:description" content="<?php echo $_SESSION['APP_SHARE_DESCRIPTION']; ?>" />

        <!-- Meta for Twitter -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="<?php echo $_SESSION['APP_SHARE_TITLE']; ?>" />
        <meta name="twitter:description" content="<?php echo $_SESSION['APP_SHARE_DESCRIPTION']; ?>" />
        <meta name="twitter:image" content="<?php echo $_SESSION['APP_SHARE_IMAGE']; ?>" />

        <link href="https://fonts.googleapis.com/css?family=Orbitron|Montserrat|Open+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />

        <!-- ALL EXTRA INCLUDES -->

        <link rel="stylesheet" href="css/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />

    </head>
    <body>

        <?php if(!empty($_SESSION['info'])): ?><div class="container"><div class="alert alert-success"><?php echo $_SESSION['info'];?></div></div><?php endif; ?>
        <?php if(!empty($_SESSION['error'])): ?><div class="container"><div class="alert alert-danger"><?php echo $_SESSION['error'];?></div></div><?php endif; ?>
        <?php echo $content; ?>

      <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.min.js"></script>
      <script type="text/javascript" src="js/jquery.fancybox.pack.js?v=2.1.5"></script>
      <script type="text/javascript">
          $(document).ready(function() {
              $(".fancybox").fancybox();
          });
      </script>
      <script type="text/javascript" src="js/app.min.js"></script>

    </body>
</html>
