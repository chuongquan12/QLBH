<?php
include "connect.php";

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
    $("#add-personnel").click(function(e) {
      $(".form-add").show(500);
      $(".form-layout").show(500);
    });

    $("#add-save").click(function(e) {
      e.preventDefault();

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
    });

    $(".edit-personnel").click(function() {
      var MSNV = $(this).attr("MSNV");

      $.post("personnel.php", {
          id: MSNV,
          edit_personnel: true
        },
        function(data) {
          $("#content").html(data);
          $(".form-edit").show(500);
          $(".form-layout").show(500);
        }
      );
    });

    $("#edit-save").click(function(e) {
      e.preventDefault();


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
    });


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

    $(".icon-close").click(function() {

      $(".form").hide(500);
      $(".form-layout").hide(500);
    });

    $("#form-search").click(function(e) {
      e.preventDefault();
      var key = $("#search").val();

      // console.log(key);

      $.get("personnel.php", {
        key: key,
        search: true
      }, function(data) {
        $("#content").html(data);
      });

    });

  });
</script>
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
        <input class="form-input" type="text" name="name" id="name-add" placeholder="Họ và tên" value="" />
      </div>
      <div class="row form-item align-items-center">
        <input class="form-input" type="text" name="n_phone" id="n_phone-add" placeholder="Số điện thoại" value="" />
      </div>
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
        <textarea name="address" id="address-add" placeholder="Địa chỉ" rows="3"></textarea>
      </div>
      <div class="row form-item align-items-center">
        <input class="form-input" type="text" name="username" id="username-add" placeholder="Tên đăng nhập" value="" />
      </div>
      <div class="row form-item align-items-center">
        <input class="form-input" type="password" name="password" id="password-add" placeholder="Mật khẩu" value="" />
      </div>
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
          <input class="form-input" type="text" name="name" id="name" placeholder="Họ và tên" value="<?php echo $data['HoTenNV'] ?>" />
          <input type="hidden" name="MSNV" id="MSNV" value="<?php echo $data['MSNV'] ?>" />
        </div>
        <div class="row form-item align-items-center">
          <input class="form-input" type="text" name="n_phone" id="n_phone" placeholder="Số điện thoại" value="<?php echo $data['SoDienThoai'] ?>" />
        </div>
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
          <textarea name="address" id="address" placeholder="Địa chỉ" rows="3"><?php echo $data['DiaChi'] ?></textarea>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-7">
            <button type="submit" class="form-submit" id="edit-save">Chỉnh sửa</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>