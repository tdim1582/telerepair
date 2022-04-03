
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Status</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="<?=base_url();?>assets/css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="<?=site_url(current_url());?>" method="POST" role="form">
        <center><img src="<?=base_url();?>assets/images/logo-telerepair2.png" /></center>
        <!-- <center><img src="<?=base_url();?>assets/images/logo-green.png" /></center> -->
        <div style="margin-top: 30px"></div>
        <label for="inputEmail" class="sr-only">ID</label>
        <input type="text" id="inputEmail" name="personal_id" class="form-control" placeholder="ID" required autofocus>
        <label for="inputPassword" class="sr-only">Adgangskode</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Adgangskode" required>
        <input type="submit" name="login" value="Log ind" class="btn btn-lg btn-primary btn-block" />
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
