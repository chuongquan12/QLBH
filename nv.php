<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['MSNV'])) {
  header("refresh:0; url= index.php");
  exit();
} else {
  $MSNV = $_SESSION['MSNV'];
  $sql = "SELECT * FROM `nhanvien` WHERE MSNV = '$MSNV'";
  $temp_nv = mysqli_query($conn, $sql);
  $nv = mysqli_fetch_assoc($temp_nv);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý đặt hàng | Nhân viên</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <script src="https://kit.fontawesome.com/194e38739f.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-2 menu">
        <h4 class="menu-title">NHÂN VIÊN</h4>
        <hr />
        <li class="menu-item active" id="create-order">Thêm đơn hàng</li>
        <li class="menu-item" id="order">Đơn hàng</li>
        <li class="menu-item" id="customer">Khách hàng</li>
        <li class="menu-item" id="product">Hàng hóa</li>
      </div>
      <div class="col-10 content">
        <div class="row user justify-content-between align-items-center">
          <div class="col-5">
            <span class="user-hello">Xin chào, <?php echo $nv['HoTenNV'] ?></span>
          </div>
          <div class="col-2">
            <span class="user-icon" id="logout">
              Logout <i class="fas fa-sign-out-alt"></i>
            </span>
          </div>
        </div>
        <div id="content"></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="bootstrap/jquery-3.5.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function() {
      $("#content").load("create-order.php");
      // Menu Click

      $("#create-order").click(function(e) {
        $("#content").load("create-order.php");
      });

      $("#order").click(function(e) {
        $("#content").load("order.php");
      });

      $("#customer").click(function(e) {
        $("#content").load("customer.php");
      });

      $("#product").click(function(e) {
        $("#content").load("product.php");
      });

      $(".menu-item").click(function() {
        $(".menu-item").removeClass("active");
        $(this).toggleClass("active");
      });

      $("#logout").click(function(e) {

        $.post("action.php", {
          logout: true
        }, function() {
          window.location.href = 'index.php';
        });
      });
    });
  </script>
</body>

</html>