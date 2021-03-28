<?php
include "connect.php";
session_start();

$sql = "SELECT * FROM `nhanvien`";

if (isset($_GET['search']) && isset($_GET['key'])) {
  $key = $_GET['key'];

  $sql = "SELECT * FROM `nhanvien` WHERE HoTenNV LIKE '%$key%'";
}
$result = mysqli_query($conn, $sql);

?>

<script src="bootstrap/jquery-3.5.1.min.js"></script>
<script>
  $(document).ready(function() {
    // Validate
    var check_name = true; //form edit
    var check_n_phone = true; //form edit
    var check_address = true; //form edit
    var check_username = true; //form edit 
    var check_password = true; //form edit
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

    // Username
    $(".username").keyup(function(e) {
      var value = $(this).val();
      var check_NV = value.indexOf('NV');

      $.get("action.php", {

        Username: value,
        check_username_personnel: true

      }, function(data) {
        if (data == 1 || value.length == 0 || value.length > 10 || check_NV != 0) {
          if (value.length > 10) $(".error_username").text("*Họ tên không được quá 10 ký tự");
          if (check_NV != 0) $(".error_username").text("*Tên đăng nhập phải có dạng NV...");
          if (value.length == 0) $(".error_username").text("*Vui lòng nhập tên đăng nhập!");
          if (data == 1) $(".error_username").text("*Tên đăng nhập đã tồn tại!");

          check_username = false;
        } else {
          $(".error_username").text("");
          check_username = true;
        }
      });
    });

    // Password 
    $(".password").keyup(function(e) {
      var value = $(this).val();
      if (value.length < 6 || value.length > 15 || value.length == 0) {
        if (value.length < 6) $(".error_password").text("*Mật khẩu tối thiểu 6 kí tự!");
        if (value.length > 15) $(".error_password").text("*Mật khẩu không quá 15 ký tự!");
        if (value.length == 0) $(".error_password").text("*Vui lòng nhập mật khẩu!");
        check_password = false;

      } else {
        $(".error_password").text("");
        check_password = true;

      }
    });

    // Add Personnel
    $("#add-personnel").click(function(e) {
      check_name = false;
      check_n_phone = false;
      check_address = false;
      check_username = false;
      check_password = false;

      $(".form-add").show(500);
      $(".form-layout").show();
    });

    $("#add-save").click(function(e) {
      e.preventDefault();

      if (check_name && check_n_phone && check_address && check_username && check_password) {

        const name = $("#name-add").val(); //Tên nhân viên
        const address = $("#address-add").val(); //Địa chỉ nhân viên
        const n_phone = $("#n_phone-add").val(); //Số điện thoại nhân viên
        const position = $("#position-add").val(); //Chức vụ nhân viên
        const username = $("#username-add").val(); //Tên đăng nhập 
        const password = $("#password-add").val(); //Mật khẩu

        $.get("action.php", {

          name: name,
          address: address,
          n_phone: n_phone,
          position: position,
          username: username,
          password: password,
          sub_add_personnel: true

        }, function() {
          $("#content").load("personnel.php");
        });
      } else return false;

    });

    // Edit Personnel

    $(".edit-personnel").click(function() {
      var MSNV = $(this).attr("MSNV");

      $.post("personnel.php", {
          id: MSNV,
          edit_personnel: true
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

      if (check_name && check_n_phone && check_address) {

        const MSNV = $("#MSNV").val(); //Mã số nhân viên 
        const name = $("#name").val(); //Tên nhân viên
        const address = $("#address").val(); //Địa chỉ nhân viên
        const n_phone = $("#n_phone").val(); //Số điện thoại nhân viên
        const position = $("#position").val(); //Chức vụ nhân viên

        $.get("action.php", {

          MSNV: MSNV,
          name: name,
          address: address,
          n_phone: n_phone,
          position: position,
          sub_edit_personnel: true

        }, function() {
          $("#content").load("personnel.php");
        });
      } else return false;

    });

    // Delete Personnel
    $(".delete-personnel").click(function() {
      var MSNV = $(this).attr("MSNV");

      $.get("action.php", {
          MSNV: MSNV,
          sub_del_personnel: true
        },
        function() {
          $("#content").load("personnel.php");
        }
      );
    });

    // Search
    $("#form-search").click(function(e) {
      e.preventDefault();
      var key = $("#search").val();

      $.get("personnel.php", {
        key: key,
        search: true
      }, function(data) {
        $("#content").html(data);
      });

    });

    // Close
    $(".icon-close").click(function() {

      $(".form").hide(500);
      $(".form-layout").hide();
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
        <span class="list-personnel__title"> Danh sách nhân viên </span>
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
            <th scope="col">Mã NV</th>
            <th scope="col">Tên NV</th>
            <th scope="col">Chức vụ</th>
            <th scope="col">SĐT</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key) : ?>
            <tr>
              <th scope="row"><?php echo $key['MSNV'] ?></th>
              <td><?php echo $key['HoTenNV'] ?></td>
              <td><?php echo $key['ChucVu'] ?></td>
              <td><?php echo $key['SoDienThoai'] ?></td>
              <td><?php echo $key['DiaChi'] ?></td>
              <td>
                <span class="edit-personnel" MSNV="<?php echo $key['MSNV'] ?>">
                  <i class="far fa-edit form-icon"></i>
                </span>
                <span class="delete-personnel" MSNV="<?php echo $key['MSNV'] ?>">
                  <i class="far fa-trash-alt form-icon"></i>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="row justify-content-end">
        <span class="icon-add" id="add-personnel">
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
      <span class="form-title">THÊM THÔNG TIN NHÂN VIÊN</span>
    </div>
    <form action="">
      <div class="row form-item align-items-center">
        <input class="form-input name" type="text" id="name-add" placeholder="Họ và tên" value="" />
      </div>
      <div class="row error error_name"></div>
      <div class="row form-item align-items-center">
        <input class="form-input n_phone" type="text" id="n_phone-add" placeholder="Số điện thoại" value="" />
      </div>
      <div class="row error error_n_phone"></div>
      <div class="row form-item justify-content-between">
        <div class="col-3">
          <label for="position" class="form-lable">Chức vụ</label>
        </div>
        <div class="col-6">
          <select class="form-input" id="position-add" name="position">
            <option value="Nhân viên">Nhân viên</option>
            <option value="Quản lý">Quản lý</option>
          </select>
        </div>
      </div>
      <div class="row form-item align-items-center">
        <textarea class="address" id="address-add" placeholder="Địa chỉ" rows="3"></textarea>
      </div>
      <div class="row error error_address"></div>
      <div class="row form-item align-items-center">
        <input class="form-input username" type="text" id="username-add" placeholder="Tên đăng nhập" value="" />
      </div>
      <div class="row error error_username"></div>
      <div class="row form-item align-items-center">
        <input class="form-input password" type="password" id="password-add" placeholder="Mật khẩu" value="" />
      </div>
      <div class="row error error_password"></div>
      <div class="row justify-content-center">
        <div class="col-md-7">
          <button type="submit" class="form-submit" id="add-save">Thêm mới</button>
        </div>
      </div>
    </form>

  </div>
</div>

<?php
if (isset($_POST['edit_personnel']) && isset($_POST['id'])) {
  $id = $_POST['id'];

  $sql = "SELECT * FROM `nhanvien` WHERE MSNV = '$id'";
  $temp = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($temp);

?>


  <div class="form form-edit">
    <div class=" col">
      <div class="row justify-content-end">
        <i class="fas fa-times icon-close" id="icon-close"></i>
      </div>
      <div class="row">
        <span class="form-title">CHỈNH SỬA THÔNG TIN NHÂN VIÊN</span>
      </div>
      <form action="">
        <div class="row form-item align-items-center">
          <input class="form-input name" type="text" id="name" placeholder="Họ và tên" value="<?php echo $data['HoTenNV'] ?>" />
          <input type="hidden" name="MSNV" id="MSNV" value="<?php echo $data['MSNV'] ?>" />
        </div>
        <div class="row error error_name"></div>
        <div class="row form-item align-items-center">
          <input class="form-input n_phone" type="text" id="n_phone" placeholder="Số điện thoại" value="<?php echo $data['SoDienThoai'] ?>" />
        </div>
        <div class="row error error_n_phone"></div>
        <div class="row form-item justify-content-between">
          <div class="col-3">
            <label for="position" class="form-lable">Chức vụ</label>
          </div>
          <div class="col-6">
            <select class="form-input" id="position" name="position">
              <option <?php if ($data['ChucVu'] == 'Nhân viên') echo "selected=\"selected\""; ?> value="Nhân viên">Nhân viên</option>
              <option <?php if ($data['ChucVu'] == 'Quản lý') echo "selected=\"selected\""; ?> value="Quản lý">Quản lý</option>
            </select>
          </div>
        </div>
        <div class="row form-item align-items-center">
          <textarea class="address" id="address" placeholder="Địa chỉ" rows="3"><?php echo $data['DiaChi'] ?></textarea>
        </div>
        <div class="row error error_address"></div>
        <div class="row justify-content-center">
          <div class="col-md-7">
            <button type="submit" class="form-submit" id="edit-save">Chỉnh sửa</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>