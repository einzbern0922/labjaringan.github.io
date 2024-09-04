<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
// if (!isset($_SESSION['system'])) {
  $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
  foreach ($system as $k => $v) {
    $_SESSION['system'][$k] = $v;
  }
// }
ob_end_flush();
?>
<?php 
if (isset($_SESSION['login_id'])) {
    header("location:index.php?page=home");
}
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome for icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <!-- Custom Styles -->
  <style>
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body, html {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .bg-video-wrap {
      position: fixed;
      overflow: hidden;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
    .bg-video-wrap video, img {
      position: absolute;
      min-width: 100%;
      min-height: 100%;
      width: auto;
      height: auto;
      z-index: -1;
      background-size: cover;
      object-fit: cover;
      mix-blend-mode: multiply;

    }
    .login-box {
      position: relative;
      z-index: 1;
      width: 360px;
      margin: 7% auto;
    }
    .login-logo a {
      font-size: 1.5rem;
      color: #fff;
      text-decoration: none;
    }
    .card {
      border-radius: .5rem;
    }
  </style>
</head>
<body class="hold-transition login-page bg-black">
<div class="bg-video-wrap">
  
  <video src="assets/mp4/bg.mp4" autoplay loop muted> </video>
  <img src="assets/img/mask.jpg">
</div>
<div class="login-box">
  <div class="login-logo text-center">
    <a href="#" class="text-white"><b><?php echo $_SESSION['system']['name']; ?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <form action="" id="login-form">
        <div class="form-group mb-3">
          <div class="input-group">
            <input type="Number" class="form-control" name="email" required placeholder="NIM">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-group">
            <input type="password" class="form-control" name="password" required placeholder="Password">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-8">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="remember">
              <label class="form-check-label" for="remember">Remember Me</label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery and Bootstrap JS CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $('#login-form').submit(function(e) {
      e.preventDefault();
      start_load();
      if ($(this).find('.alert-danger').length > 0) {
        $(this).find('.alert-danger').remove();
      }
      $.ajax({
        url: 'ajax.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        error: err => {
          console.log(err);
          end_load();
        },
        success: function(resp) {
          if (resp == 1) {
            location.href = 'index.php?page=home';
          } else {
            $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
            end_load();
          }
        }
      });
    });
  });
</script>

<?php include 'footer.php'; ?>
</body>
</html>