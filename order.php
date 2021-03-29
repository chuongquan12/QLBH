<?php
include "connect.php";

$sql = "SELECT SoDonDH, NgayDH, NgayGH, HoTenKH, HoTenNV 
          FROM `dathang`, `khachhang`, `nhanvien` 
        WHERE dathang.MSKH = khachhang.MSKH && dathang.MSNV = nhanvien.MSNV";

$today = date("Y-m-d");

if (isset($_GET['search']) && isset($_GET['key'])) {
  $key = $_GET['key'];
  $sql = "SELECT SoDonDH, NgayDH, NgayGH, HoTenKH, HoTenNV 
  FROM `dathang`, `khachhang`, `nhanvien` 
WHERE dathang.MSKH = khachhang.MSKH && dathang.MSNV = nhanvien.MSNV && NgayDH = '$key'";
}


$result = mysqli_query($conn, $sql);

?>

<script src="bootstrap/jquery-3.5.1.min.js"></script>
<script>
  $(document).ready(function() {
    $(".order-detail").click(function() {
      var SoDonDH = $(this).attr("SoDonDH");

      $.post("order.php", {
          id: SoDonDH,
          order_detail: true
        },
        function(data) {

          $("#content").html(data);
          $(".form-edit").show(500);
          $(".form-layout").show();
        }
      );
    });


    $(".icon-close").click(function() {

      $(".form").hide(500);
      $(".form-layout").hide();
    });

    $(".form-layout").click(function() {

      $(".form").hide(500);
      $(".form-layout").hide();
    });

    $("#form-search").click(function(e) {
      e.preventDefault();

      var key = $("#search").val();

      $.get("order.php", {
        key: key,
        search: true
      }, function(data) {
        $("#content").html(data);
      });

    });

    $("#create-order").click(function(e) {
      $("#content").load("create-order.php");
    });

  });
</script>
<div class="row">
  <div class="col">
    <div class="list-personnel">
      <div class="row">
        <span class="list-personnel__title"> Danh sách đơn hàng </span>
      </div>
      <div class="row align-items-center justify-content-end">
        <div class="col-3">
          <form action="">
            <input type="date" name="" id="search" class="form-date" min="1970-01-01" max="<?php echo $today ?>" />
            <button type="submit" class="form-filer" id="form-search">
              <i class="fas fa-filter"></i>
            </button>
          </form>
        </div>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Mã đơn</th>
            <th scope="col">Tên khách hàng</th>
            <th scope="col">Tên nhân viên</th>
            <th scope="col">Ngày đặt hàng</th>
            <th scope="col">Ngày giao</th>
            <th scope="col">Chi tiết</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key) : ?>
            <tr>
              <th scope="row"><?php echo $key['SoDonDH'] ?></th>
              <td><?php echo $key['HoTenKH'] ?></td>
              <td><?php echo $key['HoTenNV'] ?></td>
              <td><?php echo $key['NgayDH'] ?></td>
              <td><?php echo $key['NgayGH'] ?></td>
              <td>
                <span class="order-detail" SoDonDH="<?php echo $key['SoDonDH'] ?>">
                  <i class="fas fa-ellipsis-h form-icon"></i>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="form-layout"></div>

<?php
if (isset($_POST['order_detail']) && isset($_POST['id'])) {
  $sum = 0;
  $SoDonDH = $_POST['id'];

  $sql_product = "SELECT TenHH, SoLuong, GiaDatHang, GiamGia 
            FROM `chitietdathang`, `hanghoa` 
          WHERE SoDonDH = '$SoDonDH' && chitietdathang.MSHH = hanghoa.MSHH";
  $sql_detail = "SELECT SoDonDH, NgayDH, NgayGH, HoTenKH, HoTenNV, khachhang.TenCongTy, khachhang.DiaChi, khachhang.SoDienThoai, khachhang.Email 
                  FROM `dathang`,`khachhang`,`nhanvien` 
                WHERE dathang.MSKH = khachhang.MSKH && dathang.MSNV = dathang.MSNV && SoDonDH = '$SoDonDH'";

  $data_product = mysqli_query($conn, $sql_product);
  $temp = mysqli_query($conn, $sql_detail);
  $data_detail = mysqli_fetch_assoc($temp);

?>


  <div class="form form-edit">
    <div class=" col">
      <div class="row justify-content-end">
        <i class="fas fa-times icon-close" id="icon-close"></i>
      </div>
      <div class="row">
        <span class="form-title">Chi tiết đơn hàng: #<?php echo $data_detail['SoDonDH'] ?></span>
      </div>
      <div class="row">
        <div class="col list-personnel">
          <div class="row customer-detail">
            <li><b>- Họ tên khách hàng: </b><?php echo $data_detail['HoTenKH'] ?></li>
            <li><b>- Tên công ty: </b><?php echo $data_detail['TenCongTy'] ?></li>
            <li><b>- Địa chỉ: </b><?php echo $data_detail['DiaChi'] ?></li>
            <li><b>- Số điện thoai: </b><?php echo $data_detail['SoDienThoai'] ?></li>
            <li><b>- Email: </b><?php echo $data_detail['Email'] ?></li>
          </div>
        </div>
      </div>
      <div class="row ">
        <div class="col list-personnel">
          <div class="row list-product">
            <div class="col">
              <?php foreach ($data_product as $key) : ?>
                <div class="row align-items-center">
                  <div class="col-6">
                    <span class="row order-detail__list-product--title"><?php echo $key['TenHH'] ?></span>
                  </div>
                  <div class="col-2">
                    <span class="order-detail__list-product--quantity">x<?php echo $key['SoLuong'] ?></span>
                  </div>
                  <div class="col-2">
                    <span class="order-detail__list-product--quantity">-<?php echo $key['GiamGia'] ?>%</span>
                  </div>
                  <div class="col-2">
                    <span class="order-detail__list-product--quantity"><?php $sum += ($key['GiaDatHang'] * $key['SoLuong']) * (100 - $key['GiamGia']) * 0.01;
                                                                        echo ($key['GiaDatHang'] * $key['SoLuong']) * (100 - $key['GiamGia']) * 0.01 ?>$</span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col order-detail__list-product--total">
          <span>Giá trị đơn hàng: </span>
          <span><?php echo $sum ?> $</span>
        </div>
      </div>
    </div>
  </div>
<?php } ?>