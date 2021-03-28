<?php
include "connect.php";
session_start();

$sql_category = "SELECT * FROM `loaihanghoa`";
$sql = "SELECT * FROM `hanghoa`, `loaihanghoa` WHERE hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang";

if (isset($_GET['search']) && isset($_GET['key'])) {
  $key = $_GET['key'];
  $sql = "SELECT * FROM `hanghoa`, `loaihanghoa` WHERE hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang && TenHH LIKE '%$key%'";
}


$result_category = mysqli_query($conn, $sql_category);
$result = mysqli_query($conn, $sql);

?>

<script src="bootstrap/jquery-3.5.1.min.js"></script>
<script>
  $(document).ready(function() {
    // Validate
    var check_name = true; //form edit
    var check_rule = true; //form edit
    var check_description = true; //form add address
    // Name
    $(".name").keyup(function(e) {
      var value = $(this).val();
      if (value.length == 0 || value.length > 25) {
        if (value.length == 0) $(".error_name").text("*Vui lòng nhập tên sản phẩm!");
        if (value.length > 25) $(".error_name").text("*Tên sản phẩm không được quá 25 ký tự");
        check_name = false;
      } else {
        $(".error_name").text("");
        check_name = true;
      }
    });

    // Rule
    $(".rule").keyup(function(e) {
      var value = $(this).val();
      if (value.length == 0 || value.length > 25) {
        if (value.length == 0) $(".error_rule").text("*Vui lòng nhập quy cách sản phẩm!");
        if (value.length > 0) $(".error_rule").text("*Quy cách không quá 25 ký tự!");
        check_rule = false;

      } else {
        $(".error_rule").text("");
        check_rule = true;

      }
    });

    // Description
    $(".description").keyup(function(e) {
      var value = $(this).val();

      if (value.length > 100) {
        if (value.length > 100) $(".error_description").text("*Mô tả quá dài  !");
        check_description = false;

      } else {
        $(".error_description").text("");
        check_description = true;

      }
    });

    // Thêm sản phẩm mới
    $("#add-product").click(function(e) {
      check_name = false;
      check_rule = false;

      $(".form-add").show(500);
      $(".form-layout").show();
    });

    $("#add-save").click(function(e) {
      e.preventDefault();
      if (check_name && check_rule && check_description) {

        const name = $("#name-add").val(); //Tên hàng hóa
        const rule = $("#rule-add").val(); //Quy cách
        const quantity = $("#quantity-add").val(); //Số lượng
        const price = $("#price-add").val(); //Giá
        const category = $("#category-add").val(); //Loại hàng 
        const description = $("#description-add").val(); //Ghi chú

        $.get("action.php", {

          name: name,
          rule: rule,
          quantity: quantity,
          price: price,
          category: category,
          description: description,
          sub_add_product: true

        }, function() {
          $("#content").load("product.php");
        });
      } else return false;
    });

    // Chỉnh sửa sản phẩm
    $(".edit-product").click(function() {
      var MSHH = $(this).attr("MSHH");

      $.post("product.php", {
          id: MSHH,
          edit_product: true
        },
        function(data) {
          $("#content").html(data);
          $(".form-edit").show(500);
          $(".form-layout").show();
        }
      );
    });

    $("#edit-save").click(function(e) {
      e.preventDefault();

      if (check_name && check_rule && check_description) {

        const MSHH = $("#MSHH").val(); //Mã hàng hóa
        const name = $("#name").val(); //Tên hàng hóa
        const rule = $("#rule").val(); //Quy cách
        const quantity = $("#quantity").val(); //Số lượng
        const price = $("#price").val(); //Giá
        const category = $("#category-id").val(); //Loại hàng 
        const description = $("#description").val(); //Ghi chú

        $.get("action.php", {

          MSHH: MSHH,
          name: name,
          rule: rule,
          quantity: quantity,
          price: price,
          category: category,
          description: description,
          sub_edit_product: true

        }, function() {
          $("#content").load("product.php");
        });
      } else return false;
    });

    // Xóa sản phẩm
    $(".delete-product").click(function() {
      var MSHH = $(this).attr("MSHH");

      $.get("action.php", {
          MSHH: MSHH,
          sub_del_product: true
        },
        function() {
          $("#content").load("product.php");
        }
      );

    });

    // Close
    $(".icon-close").click(function() {

      $(".form").hide(500);
      $(".form-layout").hide();
    });

    // Search
    $("#form-search").click(function(e) {
      e.preventDefault();

      var key = $("#search").val();


      $.get("product.php", {
        key: key,
        search: true
      }, function(data) {
        $("#content").html(data);
      });

    });

    // Mess
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
        <span class="list-personnel__title"> Danh sách hàng hóa </span>
      </div>
      <div class="row align-items-center justify-content-end">
        <div class="col-3">
          <form action="">
            <input type="text" name="" id="search" class="form-input" placeholder="Search" />
            <button type="submit" class="form-search" id="form-search">
              <i class="fas fa-search"></i>
            </button>
          </form>
        </div>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Mã HH</th>
            <th scope="col">Tên hàng hóa</th>
            <th scope="col">Quy cách</th>
            <th scope="col">Giá</th>
            <th scope="col">SL</th>
            <th scope="col">Loại hàng</th>
            <th scope="col">Ghi chú</th>
            <th scope="col">Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key) : ?>
            <tr>
              <th scope="row"><?php echo $key['MSHH'] ?></th>
              <td><?php echo $key['TenHH'] ?></td>
              <td><?php echo $key['QuyCach'] ?></td>
              <td><?php echo $key['Gia'] ?></td>
              <td><?php echo $key['SoLuongHang'] ?></td>
              <td><?php echo $key['TenLoaiHang'] ?></td>
              <td><?php echo $key['GhiChu'] ?></td>
              <td>
                <span class="edit-product" MSHH="<?php echo $key['MSHH'] ?>">
                  <i class="far fa-edit form-icon"></i>
                </span>
                <span class="delete-product" MSHH="<?php echo $key['MSHH'] ?>">
                  <i class="far fa-trash-alt form-icon"></i>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="row justify-content-end">
        <span class="icon-add" id="add-product">
          Thêm <i class="fas fa-plus"></i>
        </span>
      </div>
    </div>
  </div>
</div>
<div class="form-layout"></div>
<div class="form form-add">
  <div class="col">
    <div class="row justify-content-end">
      <i class="fas fa-times icon-close" id="icon-close"></i>
    </div>
    <div class="row">
      <span class="form-title">THÊM THÔNG TIN HÀNG HÓA</span>
    </div>
    <form action="">
      <div class="row form-item align-items-center">
        <input class="form-input name" type="text" name="name" id="name-add" placeholder="Tên hàng hóa" value="" />
      </div>
      <div class="row error error_name"></div>

      <div class="row form-item align-items-center">
        <input class="form-input rule" type="text" name="rule" id="rule-add" placeholder="Quy cách" value="" />
      </div>
      <div class="row error error_rule"></div>

      <div class="row form-item">
        <div class="col-3">
          <label for="quantity" class="form-lable">Số lượng: </label>
        </div>
        <div class="col-3">
          <input type="number" name="quantity" id="quantity-add" min="0" value="1" />
        </div>
        <div class="col-2">
          <label for="price" class="form-lable">Giá: </label>
        </div>
        <div class="col-4">
          <input type="number" name="price" id="price-add" min="0" value="0" />
        </div>
      </div>
      <div class="row form-item justify-content-between">
        <div class="col-3">
          <label for="category" class="form-lable">Loại:</label>
        </div>
        <div class="col-6">
          <select class="form-input" id="category-add" name="category">
            <?php foreach ($result_category as $key) : ?>
              <option value="<?php echo $key['MaLoaiHang'] ?>"><?php echo $key['TenLoaiHang'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="row form-item align-items-center">
        <textarea class="description" id="description-add" placeholder="Ghi chú" rows="3"></textarea>
      </div>
      <div class="row error error_description"></div>

      <div class="row justify-content-center">
        <div class="col-md-7">
          <button type="submit" class="form-submit" id="add-save">Thêm mới</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
if (isset($_POST['edit_product']) && isset($_POST['id'])) {
  $id = $_POST['id'];

  $sql = "SELECT * FROM `hanghoa` WHERE MSHH = '$id'";
  $temp = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($temp);

?>


  <div class="form form-edit">
    <div class=" col">
      <div class="row justify-content-end">
        <i class="fas fa-times icon-close" id="icon-close"></i>
      </div>
      <div class="row">
        <span class="form-title">CHỈNH SỬA THÔNG TIN HÀNG HÓA</span>
      </div>
      <form action="">
        <div class="row form-item align-items-center">
          <input class="form-input name" type="text" id="name" placeholder="Tên hàng hóa" value="<?php echo $data['TenHH'] ?>" />
          <input type="hidden" name="MSHH" id="MSHH" value="<?php echo $data['MSHH'] ?>" />
        </div>
        <div class="row error error_name"></div>
        <div class="row form-item align-items-center">
          <input class="form-input rule" type="text" id="rule" placeholder="Quy cách" value="<?php echo $data['QuyCach'] ?>" />
        </div>
        <div class="row error error_rule"></div>
        <div class="row form-item">
          <div class="col-3">
            <label for="quantity" class="form-lable">Số lượng: </label>
          </div>
          <div class="col-3">
            <input type="number" name="quantity" id="quantity" min="0" value="<?php echo $data['SoLuongHang'] ?>" />
          </div>
          <div class="col-2">
            <label for="price" class="form-lable">Giá: </label>
          </div>
          <div class="col-4">
            <input type="number" name="price" id="price" min="0" value="<?php echo $data['Gia'] ?>" />
          </div>
        </div>
        <div class="row form-item justify-content-between">
          <div class="col-3">
            <label for="category" class="form-lable">Loại:</label>
          </div>
          <div class="col-6">
            <select class="form-input" id="category-id" name="category">
              <?php foreach ($result_category as $key) : ?>
                <option <?php if ($data['MaLoaiHang'] == $key['MaLoaiHang']) echo "selected=\"selected\""; ?> value="<?php echo $key['MaLoaiHang'] ?>"><?php echo $key['TenLoaiHang'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="row form-item align-items-center">
          <textarea class="description" id="description" placeholder="Ghi chú" rows="3"><?php echo $data['GhiChu'] ?></textarea>
        </div>
        <div class="row error error_description"></div>
        <div class="row justify-content-center">
          <div class="col-md-7">
            <button type="submit" class="form-submit" id="edit-save">Chỉnh sửa</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>