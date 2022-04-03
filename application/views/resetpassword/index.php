 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Reset Password</title>

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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>

  <body>

    <div class="container">
      

      <form class="form-signin" action="<?=current_url() . "?token=" . $this->input->get('token');?>" method="POST" role="form">
        <center><img src="<?=base_url();?>assets/images/logo-telerepair2.png" width="60%" /></center>
        <!-- <center><img src="<?=base_url();?>assets/images/logo-green.png" width="60%" /></center> -->
        <div style="margin-top: 30px"></div>
        <h1>Angiv adgangskode</h1>
        <p><?echo $this->session->flashdata('message');?></p>
        <?echo "Dit navn: " . $name;?>
        <br /><br />
        <? $info = "Minimum 8 tegn, 1 stort bogstav, et lille, 1 tal og et tegn, for eksempel ?!.,";?>
        <p><?echo $info;?></p>
        <label for="inputPassword" class="sr-only">Adgangskode</label>
        
        <? $pattern = "(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\.,\\(){}#@$!%*?&_-]).{8,}";?>
        
        <input type="password" name="password" id="password" class="form-control" placeholder="Angiv ny adgangskode" required autofocus pattern="<?echo $pattern;?>" title="<?echo $info;?>">
        <label for="inputPasswordConfirm" class="sr-only">Adgangskode verifikation</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Bekræft ny adgangskode" required autofocus pattern="<?echo $pattern;?>" title="<?echo $info;?>">
        <span id='message'></span>
        <br />
        <input type="submit" name="change_password" value="Skift adgangskode" class="btn btn-lg btn-primary btn-block" />
        <p><?echo $this->session->flashdata('message');?></p>
        
      </form>      
      
    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      $('#password, #confirm_password').on('keyup', function () {
        if ($('#password').val() == $('#confirm_password').val()) {
          $('#message').html('Indtastede adgangskoder er ens.').css('color', 'green');
        } else 
          $('#message').html('Indtastede adgangskoder er ikke ens.').css('color', 'red');
      });
    });
</script>

  </body>
  
</html>



