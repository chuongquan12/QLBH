<?php
include "connect.php";

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
    $("#add-category").click(function(e) {
      $(".form-add").show(500);
      $(".form-layout").show(500);
    });

    $("#add-save").click(function(e) {
      e.preventDefault();

      const name = $("#name-add").val(); //Tên loại hàng hóa

      $.get("action.php", {

        name: name,
        sub_add_category: true

      }, function() {
        $("#content").load("category.php");
      });
    });

    $(".edit-category").click(function() {
      var MaLoaiHang = $(this).attr("MaLoaiHang");

      $.post("category.php", {
          id: MaLoaiHang,
          edit_category: true
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

      const MaLoaiHang = $("#MaLoaiHang").val(); //Mã số nhân viên 
      const name = $("#name").val(); //Tên nhân viên

      $.get("action.php", {

        MaLoaiHang: MaLoaiHang,
        name: name,
        sub_edit_category: true

      }, function() {
        $("#content").load("category.php");
      });
    });

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

    $(".icon-close").click(function() {

      $(".form").hide(500);
      $(".form-layout").hide(500);
    });

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

  });
</script>
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
        <input class="form-input" type="text" name="name" id="name-add" placeholder="Tên loại hàng hóa" value="" />
      </div>
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
          <input class="form-input" type="text" name="name" id="name" placeholder="Tên loại hàng hóa" value="<?php echo $data['TenLoaiHang'] ?>" />
          <input type="hidden" name="MaLoaiHang" id="MaLoaiHang" value="<?php echo $data['MaLoaiHang'] ?>" />
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