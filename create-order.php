<?php
include "connect.php";
session_start();
$sql_product = "SELECT MSHH, TenHH, Gia , GhiChu
                  FROM `hanghoa` ";

$sql_customer = "SELECT MSKH, HoTenKH, TenCongTy, SoDienThoai, Email 
                  FROM `khachhang` ";

$data_product = mysqli_query($conn, $sql_product);
$data_customer = mysqli_query($conn, $sql_customer);


if (isset($_POST['add_cart_customer']) && isset($_POST['MSKH']) && isset($_POST['MaDC'])) {
  $_SESSION['mess'] = "Chọn khách hàng thành công!";
  $_SESSION['cart_MSKH'] = $_POST['MSKH'];
  $_SESSION['cart_MaDC'] = $_POST['MaDC'];
  $_SESSION['cart_product'] = array();
}

if (isset($_POST['add_cart_product']) && isset($_POST['MSHH'])) {
  $MSHH = $_POST['MSHH'];
  $price = $_POST['price'];
  $name = $_POST['name'];
  $quantity = $_POST['quantity'];
  $discount = $_POST['discount'];

  $_SESSION['cart_product'][] = array(
    [
      'MSHH' => "$MSHH",
      'name' => "$name",
      'price' => "$price",
      'quantity' => "$quantity",
      'discount' => "$discount",
    ],
  );

  $_SESSION['mess'] = "Thêm sản phẩm thành công!";
}
?>

<script src="bootstrap/jquery-3.5.1.min.js"></script>
<script>
  $(document).ready(function() {
    // Validate
    var check_name = false; //form edit
    var check_company = false; //form edit
    var check_n_phone = false; //form edit
    var check_email = false; //form edit
    var check_address = false; //form add address
    // Name
    $(".name").keyup(function(e) {
      var value = $(this).val();
      if (value.length == 0 || value.length > 25) {
        if (value.length == 0) $(".error_name").text("*Vui lòng nhập họ tên!");
        if (value.length > 25) $(".error_name").text("*Họ tên không được quá 25 ký tự");
        check_name = false;
      } else {
        $(".error_name").text("");
        check_name = true;
      }
    });

    // Company 
    $(".company").keyup(function(e) {
      var value = $(this).val();
      if (value.length == 0 || value.length > 25) {
        if (value.length == 0) $(".error_company").text("*Vui lòng nhập tên công ty!");
        if (value.length > 0) $(".error_company").text("*Tên công ty không quá 25 ký tự!");
        check_company = false;

      } else {
        $(".error_company").text("");
        check_company = true;

      }
    });

    // Phone
    $(".n_phone").keyup(function(e) {
      var value = $(this).val();

      if (value.length != 10) {
        if (value.length != 10) $(".error_n_phone").text("*Số điện thoại phải có 10 ký tự!");
        check_n_phone = false;

      } else {
        $(".error_n_phone").text("");
        check_n_phone = true;

      }
    });

    // Email
    $(".email").keyup(function(e) {
      var value = $(this).val();
      var check_mail = value.indexOf('@gmail.com');
      if (value.length == 0 || check_mail == -1) {
        if (value.length == 0) $(".error_email").text("*Vui lòng nhập email!");
        if (check_mail == -1) $(".error_email").text("*Email phải có dạng ...@gmail.com!");
        check_email = false;

      } else {
        $(".error_email").text("");
        check_email = true;

      }
    });

    // Address
    $(".address").keyup(function(e) {
      var value = $(this).val();

      if (value.length == 0 || value.length > 100) {
        if (value.length == 0) $(".error_address").text("*Vui lòng nhập địa chỉ!");
        if (value.length > 100) $(".error_address").text("*Địa chỉ quá dài  !");
        check_address = false;

      } else {
        $(".error_address").text("");
        check_address = true;

      }
    });

    // Mô tả sản phẩm
    $(".product-detail").click(function() {
      var MSHH = $(this).attr("MSHH");

      $.post("create-order.php", {
          id: MSHH,
          product_detail: true
        },
        function(data) {

          $("#content").html(data);
          $(".form-edit").show(500);
          $(".form-layout").show();
        }
      );
    });

    // Mô tả khách hàng
    $(".customer-detail").click(function() {
      var MSKH = $(this).attr("MSKH");

      $.post("create-order.php", {
          id: MSKH,
          customer_detail: true
        },
        function(data) {

          $("#content").html(data);
          $(".form-edit").show(500);
          $(".form-layout").show();
        }
      );
    });

    // Thêm địa chỉ cho khách hàng
    $("#icon-add-customer-address").click(function(e) {
      e.preventDefault();
      var MSKH = $(this).attr("MSKH");

      $.post("create-order.php", {
          id: MSKH,
          customer_add_address: true
        },
        function(data) {

          $("#content").html(data);
          $(".form-edit").show(500);
          $(".form-layout").show();
        }
      );
    });

    $("#add-customer-address").click(function(e) {
      e.preventDefault();
      if (check_address) {
        const MSKH = $("#MSKH").val(); //Mã khách hàng
        const address = $("#address").val(); //Mã khách hàng

        $.get("action.php", {

          MSKH: MSKH,
          address: address,
          sub_add_customer_address: true

        }, function(data) {
          $.post("create-order.php", {

            MSKH: MSKH,
            MaDC: data,
            add_cart_customer: true
          }, function() {
            $("#content").load("create-order.php");
          });
        });
      } else return false;
    });

    // Thêm khách hàng mới
    $("#icon-customer-add").click(function(e) {
      e.preventDefault();

      $.post("create-order.php", {
          customer_add: true
        },
        function(data) {

          $("#content").html(data);
          $(".form-edit").show(500);
          $(".form-layout").show();
        }
      );
    });

    $("#add-customer").click(function(e) {
      e.preventDefault();
      if (check_name && check_company && check_n_phone && check_email && check_address) {

        const name = $("#name-add").val(); //Mã khách hàng
        const company = $("#company-add").val(); //Mã khách hàng
        const n_phone = $("#n_phone-add").val(); //Mã khách hàng
        const email = $("#email-add").val(); //Mã khách hàng
        const address = $("#address-add").val(); //Mã khách hàng

        $.get("action.php", {

          name: name,
          company: company,
          n_phone: n_phone,
          email: email,
          address: address,
          sub_add_customer: true

        }, function() {
          $("#content").load("create-order.php");
        });
      } else return false;
    });

    // Thêm khách hàng vào đơn hàng
    $("#add-cart-customer").click(function(e) {
      e.preventDefault();

      const MSKH = $("#MSKH").val();
      const MaDC = $("input[name=address]:checked").val();

      $.post("create-order.php", {

          MSKH: MSKH,
          MaDC: MaDC,
          add_cart_customer: true
        },
        function(data) {
          $("#content").html(data);
        }
      );
    });

    // Thêm sản phẩm vào đơn hàng
    $("#add-cart-product").click(function(e) {
      e.preventDefault();

      const MSHH = $("#MSHH").val();
      const name = $("#name").text();
      const price = $("#price").text();
      const quantity = $("#quantity").val();
      const discount = $("#discount").val();

      $.post("create-order.php", {

          MSHH: MSHH,
          price: price,
          name: name,
          quantity: quantity,
          discount: discount,
          add_cart_product: true
        },
        function(data) {
          $("#content").html(data);
        }
      );

    });

    // Thêm đơn hàng
    $("#add-order").click(function() {

      $.get("action.php", {

        sub_add_order: true

      }, function(data) {
        $("#content").load("create-order.php");
      });
    });

    $(".icon-close").click(function() {

      $(".form").hide(500);
      $(".form-layout").hide();
    });

    $(".message-overlay").click(function(e) {
      $(".message").hide(500);
      $(".message-overlay").hide();
    });

  });
</script>
<?php if (isset($_SESSION['mess'])) {
  echo '<span class="message-overlay"></span>';
  echo '<span class="message">' . $_SESSION['mess'] . '</span>';
  unset($_SESSION['mess']);
} ?>
<div class="row">
  <div class="col">
    <div class="list-personnel">
      <div class="row">
        <span class="list-personnel__title"> Thêm đơn hàng </span>
      </div>
      <div class="row">
        <?php if (!isset($_SESSION['cart_MSKH'])) { ?>
          <div class="col">
            <div class="list-personnel">
              <div class="row">
                <div class="col">
                  <span class="list-personnel__title">Khách hàng</span>
                </div>
                <div class="col">
                  <div class="row justify-content-end">
                    <span class="icon-add-customer mt-1 mb-1" id="icon-customer-add">
                      <i class="fas fa-user-plus"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row list-product">
                <div class="col">
                  <?php foreach ($data_customer as $key) : ?>
                    <div class="row align-items-center product">
                      <div class="col-1">
                        <span class="order-detail__list-product--quantity">#<?php echo $key['MSKH'] ?></span>
                      </div>
                      <div class="col-3">
                        <span class="row order-detail__list-product--title"><?php echo $key['HoTenKH'] ?></span>
                      </div>
                      <div class="col-2">
                        <span class="row order-detail__list-product--title"><?php echo $key['TenCongTy'] ?></span>
                      </div>
                      <div class="col-2">
                        <span class="row order-detail__list-product--title"><?php echo $key['SoDienThoai'] ?></span>
                      </div>
                      <div class="col-2">
                        <span class="row order-detail__list-product--title"><?php echo $key['Email'] ?></span>
                      </div>
                      <div class="col-2">
                        <span class="customer-detail" MSKH="<?php echo $key['MSKH'] ?>">
                          <i class="fas fa-plus form-icon"></i>
                        </span>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>

              </div>

            </div>
          </div>
        <?php } ?>
        <?php if (isset($_SESSION['cart_MSKH']) && isset($_SESSION['cart_MaDC'])) { ?>
          <div class="col">
            <div class="list-personnel">
              <div class="row">
                <span class="list-personnel__title">Sản phẩm</span>
              </div>
              <div class="row list-product">
                <div class="col">
                  <?php foreach ($data_product as $key) : ?>
                    <div class="row align-items-center product">
                      <div class="col-1">
                        <span class="order-detail__list-product--quantity">#<?php echo $key['MSHH'] ?></span>
                      </div>
                      <div class="col-4">
                        <span class="row order-detail__list-product--title"><?php echo $key['TenHH'] ?></span>
                      </div>
                      <div class="col-2">
                        <span class="order-detail__list-product--quantity"><?php echo $key['Gia'] ?>$</span>
                      </div>
                      <div class="col-4">
                        <span class="order-detail__list-product--title"><?php echo $key['GhiChu'] ?></span>
                      </div>
                      <div class="col-1">
                        <span class="product-detail" MSHH="<?php echo $key['MSHH'] ?>">
                          <i class="fas fa-plus form-icon"></i>
                        </span>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <?php
      if (isset($_SESSION['cart_MSKH']) && isset($_SESSION['cart_MaDC'])) {
        $sum = 0;
        $MSKH = $_SESSION['cart_MSKH'];
        $MaDC = $_SESSION['cart_MaDC'];

        $sql_customer = "SELECT HoTenKH, TenCongTy, SoDienThoai, Email FROM `khachhang` WHERE MSKH='$MSKH'";
        $sql_address = "SELECT DiaChi FROM `diachikh` WHERE MSKH='$MSKH' && MaDC='$MaDC'";

        $temp_customer = mysqli_query($conn, $sql_customer);
        $temp_address = mysqli_query($conn, $sql_address);

        $result_customer = mysqli_fetch_assoc($temp_customer);
        $result_address = mysqli_fetch_assoc($temp_address);

        $data_product = $_SESSION['cart_product'];


      ?>
        <div class="row">
          <div class="col">
            <div class="list-personnel">
              <div class="row">
                <span class="list-personnel__title">Đơn hàng</span>
              </div>
              <div class="row">
                <div class="col">
                  <div class="list-personnel">
                    <div class="row">
                      <span class="ml-3">Thông tin khách hàng</span>
                    </div>
                    <hr>
                    <div class="row customer-detail">
                      <li><b>- Họ tên khách hàng: </b><?php echo $result_customer['HoTenKH'] ?></li>
                      <li><b>- Tên công ty: </b><?php echo $result_customer['TenCongTy'] ?></li>
                      <li><b>- Địa chỉ: </b><?php echo $result_address['DiaChi'] ?></li>
                      <li><b>- Số điện thoai: </b><?php echo $result_customer['SoDienThoai'] ?></li>
                      <li><b>- Email: </b><?php echo $result_customer['Email'] ?></li>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="list-personnel">
                    <div class="row">
                      <span class="ml-3">Giỏ sản phẩm</span>
                    </div>
                    <hr>
                    <div class="row list-product">
                      <div class="col">
                        <?php foreach ($data_product as $result) : ?>
                          <?php foreach ($result as $key) : ?>
                            <div class="row align-items-center">
                              <div class="col-6">
                                <span class="row order-detail__list-product--title"><?php echo $key['name'] ?></span>
                              </div>
                              <div class="col-2">
                                <span class="order-detail__list-product--quantity">x<?php echo $key['quantity'] ?></span>
                              </div>
                              <div class="col-2">
                                <span class="order-detail__list-product--quantity">-<?php echo $key['discount'] ?>%</span>
                              </div>
                              <div class="col-2">
                                <span class="order-detail__list-product--quantity"><?php $sum += ($key['price'] * $key['quantity']) * (100 - $key['discount']) * 0.01;
                                                                                    echo ($key['price'] * $key['quantity']) * (100 - $key['discount']) * 0.01 ?></span>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        <?php endforeach; ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row justify-content-center">
                      <div class="col-8 order-detail__list-product--total">
                        <span>Giá trị đơn hàng: </span>
                        <span><?php echo $sum ?>$</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-end">
                <span class="icon-add" id="add-order">
                  Xác nhận đơn
                </span>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="form-layout"></div>

  <?php
  // Mô tả sản phẩm
  if (isset($_POST['product_detail']) && isset($_POST['id'])) {
    $MSHH = $_POST['id'];

    $sql_detail = "SELECT * FROM `hanghoa`, `loaihanghoa` WHERE MSHH = '$MSHH' && hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang";

    $temp = mysqli_query($conn, $sql_detail);
    $data_detail = mysqli_fetch_assoc($temp);

  ?>
    <div class="form form-edit">
      <div class="col">
        <div class="row justify-content-end">
          <i class="fas fa-times icon-close" id="icon-close"></i>
        </div>
        <div class="row">
          <span class="form-title">Thêm sản phẩm:</span>
        </div>
        <form action="">
          <div class="row form-item align-items-center">
            <div class="col-4">
              <label for="name" class="form-lable">Tên sản phẩm: </label>
            </div>
            <div class="col-8">
              <div class="form-input" id="name"><?php echo $data_detail['TenHH'] ?></div>
              <input type="hidden" name="MSHH" id="MSHH" value="<?php echo $data_detail['MSHH'] ?>" />
            </div>
          </div>
          <div class="row form-item align-items-center">
            <div class="col-4">
              <label for="rule" class="form-lable">Quy cách: </label>
            </div>
            <div class="col-8">
              <div class="form-input" id="rule"><?php echo $data_detail['QuyCach'] ?></div>
            </div>
          </div>
          <div class="row form-item align-items-center">
            <div class="col-2">
              <label for="category" class="form-lable">Loại:</label>
            </div>
            <div class="col-5">
              <div class="form-input" id="category"><?php echo $data_detail['TenLoaiHang'] ?></div>
            </div>
            <div class="col-2">
              <label for="price" class="form-lable">Giá: </label>
            </div>
            <div class="col-3">
              <div class="form-input" id="price"><?php echo $data_detail['Gia'] ?></div>
            </div>
          </div>
          <div class="row form-item">
            <div class="col-3">
              <label for="quantity" class="form-lable">Số lượng: </label>
            </div>
            <div class="col-4">
              <input type="number" name="quantity" id="quantity" min="1" max="<?php echo $data_detail['SoLuongHang'] ?>" value="1" />
            </div>
            <div class="col-2">
              <label for="discount" class="form-lable">Giảm: </label>
            </div>
            <div class="col-3">
              <input type="number" name="discount" id="discount" min="0" max="100" value="0" />
            </div>
          </div>
          <br>
          <div class="row justify-content-center">
            <div class="col-md-7">
              <button class="form-submit" id="add-cart-product">Thêm</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

  <?php

  // Chọn khách hàng
  if (isset($_POST['customer_detail']) && isset($_POST['id'])) {
    $MSKH = $_POST['id'];

    $sql_detail = "SELECT * FROM `khachhang` WHERE MSKH = '$MSKH' ";
    $sql_address = "SELECT * FROM `diachikh` WHERE MSKH = '$MSKH' ";

    $data_address = mysqli_query($conn, $sql_address);

    $temp = mysqli_query($conn, $sql_detail);
    $data_detail = mysqli_fetch_assoc($temp);

  ?>
    <div class="form form-edit">
      <div class="col">
        <div class="row justify-content-end">
          <i class="fas fa-times icon-close" id="icon-close"></i>
        </div>
        <div class="row">
          <span class="form-title">Chọn khách hàng:</span>
        </div>
        <form action="">
          <div class="row form-item align-items-center">
            <div class="col-3">
              <label for="name" class="form-lable">Họ tên: </label>
            </div>
            <div class="col-9">
              <div class="form-input" id="name"><?php echo $data_detail['HoTenKH'] ?></div>
              <input type="hidden" name="MSKH" id="MSKH" value="<?php echo $data_detail['MSKH'] ?>" />
            </div>
          </div>
          <div class="row form-item align-items-center">
            <div class="col-3">
              <label for="rule" class="form-lable">Công ty: </label>
            </div>
            <div class="col-9">
              <div class="form-input" id="rule"><?php echo $data_detail['TenCongTy'] ?></div>
            </div>
          </div>
          <div class="row form-item align-items-center">
            <div class="col-3">
              <label for="rule" class="form-lable">Email: </label>
            </div>
            <div class="col-9">
              <div class="form-input" id="rule"><?php echo $data_detail['Email'] ?></div>
            </div>
          </div>
          <div class="row form-item align-items-center">
            <div class="col list-personnel">
              <div class="row">
                <div class="col-3">
                  <label for="address" class="form-lable">Địa chỉ: </label>
                </div>
                <div class="col">
                  <div class="row justify-content-end">
                    <span class="icon-add-customer" id="icon-add-customer-address" MSKH="<?php echo $data_detail['MSKH'] ?>">
                      <i class="far fa-map"></i> <i class="fas fa-plus"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row list-address">
                <div class="col">
                  <?php foreach ($data_address as $key) : ?>
                    <div class="row align-items-center">
                      <div class="col-10">
                        <span class="row order-detail__list-product--title"><?php echo $key['DiaChi'] ?></span>
                      </div>
                      <div class="col-2">
                        <span class="order-detail__list-product--quantity">
                          <input type="radio" name="address" id="address" value="<?php echo $key['MaDC'] ?>" <?php if ($data_detail['DiaChi'] == $key['DiaChi']) echo 'checked' ?>>
                        </span>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-md-7">
              <button type="submit" class="form-submit" id="add-cart-customer">Chọn</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

  <?php
  // Form thêm địa chỉ
  if (isset($_POST['customer_add_address']) && isset($_POST['id'])) {
    $MSKH = $_POST['id'];

    $sql_detail = "SELECT * FROM `khachhang` WHERE MSKH = '$MSKH' ";

    $temp = mysqli_query($conn, $sql_detail);
    $data_detail = mysqli_fetch_assoc($temp);

  ?>
    <div class="form form-edit">
      <div class="col">
        <div class="row justify-content-end">
          <i class="fas fa-times icon-close" id="icon-close"></i>
        </div>
        <div class="row">
          <span class="form-title">Thêm địa chỉ:</span>
        </div>
        <form action="">
          <div class="row form-item align-items-center">
            <div class="col-3">
              <label for="name" class="form-lable">Họ tên: </label>
            </div>
            <div class="col-9">
              <div class="form-input" id="name"><?php echo $data_detail['HoTenKH'] ?></div>
              <input type="hidden" name="MSKH" id="MSKH" value="<?php echo $data_detail['MSKH'] ?>" />
            </div>
          </div>
          <div class="row form-item">
            <div class="col-3">
              <label for="address" class="form-lable">Địa chỉ: </label>
            </div>
            <div class="col-9">
              <textarea class="address" id="address" rows="4"></textarea>
            </div>
          </div>
          <div class="row error error_address"></div>
          <div class="row justify-content-center">
            <div class="col-md-7">
              <button type="submit" class="form-submit" id="add-customer-address">Thêm</button>
            </div>
          </div>
        </form>
      </div>

    </div>
</div>
<?php } ?>
<?php

// Form thêm khách hàng
if (isset($_POST['customer_add'])) {
?>
  <div class="form form-edit">
    <div class="col">
      <div class="row justify-content-end">
        <i class="fas fa-times icon-close" id="icon-close"></i>
      </div>
      <div class="row">
        <span class="form-title">THÊM THÔNG TIN KHÁCH HÀNG</span>
      </div>
      <form id="form-add-customer">
        <div class="row form-item align-items-center">
          <input class="form-input name" type="text" id="name-add" placeholder="Tên khách hàng" />
        </div>
        <div class="row error error_name"></div>
        <div class="row form-item align-items-center">
          <input class="form-input company" type="text" id="company-add" placeholder="Tên công ty" value="" />
        </div>
        <div class="row error error_company"></div>

        <div class="row form-item align-items-center">
          <input class="form-input n_phone" type="text" id="n_phone-add" placeholder="Số điện thoại" value="" />
        </div>
        <div class="row error error_n_phone"></div>

        <div class="row form-item align-items-center">
          <input class="form-input email" type="text" id="email-add" placeholder="Email" value="" />
        </div>
        <div class="row error error_email"></div>
        <div class="row form-item align-items-center">
          <textarea class="address" id="address-add" placeholder="Địa chỉ" rows="3"></textarea>
        </div>
        <div class="row error error_address"></div>
        <div class="row justify-content-center">
          <div class="col-md-7">
            <button type="submit" class="form-submit" id="add-customer">Thêm</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>