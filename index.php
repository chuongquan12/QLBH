<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý đặt hàng | Đăng nhập</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <script src="https://kit.fontawesome.com/194e38739f.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="background-image">
      <form action="action.php" method="POST">
        <div class="form-login">
          <h5 class="form-login__title">Đăng nhập</h5>
          <div class="row">
            <input type="text" name="username" id="username" class="form-input" placeholder="Tên đăng nhập" />
          </div>
          <div class="row">
            <input type="password" name="password" id="password" class="form-input" placeholder="Mật khẩu" />
          </div>
          <div class="row justify-content-end">
            <button type="submit" id="login" name="login" class="form-btn"> Đăng nhập </button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <!-- <script src="js/script.js"></script> -->
  <script src="bootstrap/jquery-3.5.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

  <!-- <script>
    $(document).ready(function() {
      $("#login").click(function(e) {
        const username = $("#username").val();
        const password = $("#password").val();

        $.post("action.php", {

          username: username,
          password: password,
          login: true
        }, function(data) {
          $('#login').html(data);
        });

      });
    });
  </script>
  <div id="login"></div> -->
</body>

</html>