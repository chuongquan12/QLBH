<?php
include "connect.php";
session_start();

$sql = "SELECT * FROM `loaihanghoa`";

if (isset($_GET['search']) && isset($_GET['key'])) {
  $key = $_GET['key'];

  $sql = "SELECT * FROM `loaihanghoa` WHERE TenLoaiHang LIKE '%$key%'";
}
$result = mysqli_query($conn, $sql);

?>

<script src="bootstrap/jquery-3.5.1.min.js"></script>
<script>
  $(document).ready(function() {
    // Validate
    var check_name = true; //form edit
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
    // Add Category
    $("#add-category").click(function(e) {
      check_name = false;

      $(".form-add").show(500);
      $(".form-layout").show();
    });

    $("#add-save").click(function(e) {
      e.preventDefault();
      if (check_name) {

        const name = $("#name-add").val(); //Tên loại hàng hóa

        $.get("action.php", {

          name: name,
          sub_add_category: true

        }, function() {
          $("#content").load("category.php");
        });
      } else return false;

    });

    // Edit Category
    $(".edit-category").click(function() {
      var MaLoaiHang = $(this).attr("MaLoaiHang");

      $.post("category.php", {
          id: MaLoaiHang,
          edit_category: true
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
      if (check_name) {

        const MaLoaiHang = $("#MaLoaiHang").val(); //Mã số nhân viên 
        const name = $("#name").val(); //Tên nhân viên

        $.get("action.php", {

          MaLoaiHang: MaLoaiHang,
          name: name,
          sub_edit_category: true

        }, function() {
          $("#content").load("category.php");
        });
      } else return false;

    });

    // Delete Category
    $(".delete-category").click(function() {
      var MaLoaiHang = $(this).attr("MaLoaiHang");

      $.get("action.php", {
          MaLoaiHang: MaLoaiHang,
          sub_del_category: true
        },
        function(data) {
          $("#content").load("category.php");
        }
      );

    });

    // Search
    $("#form-search").click(function(e) {
      e.preventDefault();
      var key = $("#search").val();

      // console.log(key);

      $.get("category.php", {
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
        <span class="list-personnel__title"> Danh sách loại hàng </span>
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
            <th scope="col">Mã loại</th>
            <th scope="col">Tên loại</th>
            <th scope="col">Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key) : ?>
            <tr>
              <th scope="row"><?php echo $key['MaLoaiHang'] ?></th>
              <td><?php echo $key['TenLoaiHang'] ?></td>
              <td>
                <span class="edit-category" MaLoaiHang="<?php echo $key['MaLoaiHang'] ?>">
                  <i class="far fa-edit form-icon"></i>
                </span>
                <span class="delete-category" MaLoaiHang="<?php echo $key['MaLoaiHang'] ?>">
                  <i class="far fa-trash-alt form-icon"></i>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="row justify-content-end">
        <span class="icon-add" id="add-category">
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
      <span class="form-title">THÊM THÔNG TIN LOẠI HÀNG</span>
    </div>
    <form action="">
      <div class="row form-item align-items-center">
        <input class="form-input name" type="text" id="name-add" placeholder="Tên loại hàng hóa" value="" />
      </div>
      <div class="row error error_name"></div>
      <br />
      <div class="row justify-content-center">
        <div class="col-md-7">
          <button type="submit" class="form-submit" id="add-save">Thêm mới</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
if (isset($_POST['edit_category']) && isset($_POST['id'])) {
  $id = $_POST['id'];

  $sql = "SELECT * FROM `loaihanghoa` WHERE MaLoaiHang = '$id'";
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
          <input class="form-input name" type="text" id="name" placeholder="Tên loại hàng hóa" value="<?php echo $data['TenLoaiHang'] ?>" />
          <input type="hidden" id="MaLoaiHang" value="<?php echo $data['MaLoaiHang'] ?>" />
        </div>
        <div class="row error error_name"></div>
        <br>
        <div class="row justify-content-center">
          <div class="col-md-7">
            <button type="submit" class="form-submit" id="edit-save">Chỉnh sửa</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>