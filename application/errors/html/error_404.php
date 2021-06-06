

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>404 - Not found!</title>

<?//=css_link('bootstrap.css','template');?>

<style type="text/css">
  .center {text-align: center; margin-left: auto; margin-right: auto; margin-bottom: auto; margin-top: auto;}
</style>

</head>

<body>
<div class="container">
  <div class="row">
    <div class="span12">
      <div class="hero-unit center">
          
		<h1><?php echo $heading; ?></h1>
		  <p>The page you requested could not be found, either contact your webmaster or try again. Use your browsers <b>Back</b> button to navigate to the page you have prevously come from</p>
          <p><b>Or you could just press this neat little button:</b></p>
          <a onclick="history.back()" class="btn btn-large btn-info">Take Me Back</a>
        </div>
    </div>
  </div>
</div>
</body>
</html>