<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Alpha</title>
    <link rel="stylesheet" href="assets/install.min.css">
    <script src="assets/install.min.js" charset="utf-8"></script>
  </head>
  <body>
    <center>
      <h1 style="margin-top:0;padding-top:15px">Alpha</h1>
      <?php if(isset($_GET['error'])&&$_GET['error']=="1"){ ?>
        <h3>Oops! You aren't authorized as an administrator on Alpha.</h3>
        <p>Ask the owner of this website to grant you access.</p>
      <?php } ?>
      <div class="centered button">
        <a href="?login" class="bordered succ"><span>Login</span></a>
      </div>
    </center>
  </body>
</html>
