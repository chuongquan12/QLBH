<?php
include "connect.php";
session_start();

$sql_address = "SELECT * FROM `diachikh`";
$sql = "SELECT * FROM `khachhang`";

if (isset($_GET['search']) && isset($_GET['key'])) {
    $key = $_GET['key'];
    $sql = "SELECT * FROM `khachhang` WHERE HoTenKH LIKE '%$key%'";
}


$result_address = mysqli_query($conn, $sql_address);
$result = mysqli_query($conn, $sql);

?>

<script src="bootstrap/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Validate
        var check_name = true; //form edit
        var check_company = true; //form edit
        var check_n_phone = true; //form edit
        var check_email = true; //form edit
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

        // Add Customer
        $("#add-customer").click(function(e) {
            check_name = false;
            check_company = false;
            check_n_phone = false;
            check_email = false;
            check_address = false;

            $(".form-add").show(500);
            $(".form-layout").show();
        });

        $("#form-add-customer").submit(function(e) {
            $("#content").load("customer.php");
        });

        $("#save-add").click(function(e) {
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
                    $("#content").load("customer.php");
                });
            } else return false;


        });

        // Edit Customer
        $(".edit-customer").click(function() {
            var MSKH = $(this).attr("MSKH");

            $.post("customer.php", {
                    id: MSKH,
                    edit_customer: true
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

            if (check_name && check_company && check_n_phone && check_email) {

                const MSKH = $("#MSKH").val(); //Mã khách hàng
                const name = $("#name").val(); //Mã khách hàng
                const company = $("#company").val(); //Mã khách hàng
                const n_phone = $("#n_phone").val(); //Mã khách hàng
                const email = $("#email").val(); //Mã khách hàng

                $.get("action.php", {

                    MSKH: MSKH,
                    name: name,
                    company: company,
                    n_phone: n_phone,
                    email: email,
                    sub_edit_customer: true

                }, function() {
                    $("#content").load("customer.php");
                });
            } else return false;


        });

        // Delete Customer
        $(".delete-customer").click(function() {
            var MSKH = $(this).attr("MSKH");

            $.get("action.php", {
                    MSKH: MSKH,
                    sub_del_customer: true
                },
                function() {
                    $("#content").load("customer.php");
                }
            );

        });

        // Thêm địa chỉ cho khách hàng
        $("#icon-add-customer-address").click(function(e) {
            e.preventDefault();
            var MSKH = $(this).attr("MSKH");

            $.post("customer.php", {
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

        // Save address
        $("#add-customer-address").click(function(e) {
            e.preventDefault();
            if (check_address) {

                const MSKH = $("#MSKH").val(); //Mã khách hàng
                const address = $("#address").val(); //Mã khách hàng

                $.get("action.php", {

                    MSKH: MSKH,
                    address: address,
                    sub_add_customer_address: true

                }, function() {
                    $("#content").load("customer.php");
                });
            } else return false;

        });

        // Xóa địa chỉ cho khách hàng
        $(".delete-customer-address").click(function() {
            var MaDC = $(this).attr("MaDC");

            $.get("action.php", {
                    MaDC: MaDC,
                    sub_del_customer_address: true
                },
                function() {
                    $("#content").load("customer.php");
                }
            );

        });

        // Search
        $("#form-search").click(function(e) {
            e.preventDefault();

            var key = $("#search").val();


            $.get("customer.php", {
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
                <span class="list-personnel__title"> Danh sách khách hàng </span>
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
                        <th scope="col">Mã KH</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Tên công ty</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">SĐT</th>
                        <th scope="col">Email</th>
                        <th scope="col">Tùy chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $key) : ?>
                        <tr>
                            <th scope="row"><?php echo $key['MSKH'] ?></th>
                            <td><?php echo $key['HoTenKH'] ?></td>
                            <td><?php echo $key['TenCongTy'] ?></td>
                            <td>
                                <?php
                                foreach ($result_address as $key_1) :
                                    if ($key_1['MSKH'] == $key['MSKH']) {
                                        echo '<li> - ' . $key_1['DiaChi'] . '</li>';
                                    }
                                endforeach;
                                ?>
                            </td>
                            <td><?php echo $key['SoDienThoai'] ?></td>
                            <td><?php echo $key['Email'] ?></td>
                            <td>
                                <span class="edit-customer" MSKH="<?php echo $key['MSKH'] ?>">
                                    <i class="far fa-edit form-icon"></i>
                                </span>
                                <span class="delete-customer" MSKH="<?php echo $key['MSKH'] ?>">
                                    <i class="far fa-trash-alt form-icon"></i>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="row justify-content-end">
                <span class="icon-add" id="add-customer">
                    Thêm <i class="fas fa-plus"></i>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="form-layout"></div>
<!-- Form thêm khách hàng -->
<div class="form form-add">
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
                    <button type="submit" class="form-submit" id="save-add">Thêm</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
// Form chỉnh sửa khách hàng
if (isset($_POST['edit_customer']) && isset($_POST['id'])) {
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
                <span class="form-title">Chỉnh sửa thông tin khách hàng:</span>
            </div>
            <form action="">
                <div class="row form-item align-items-center">
                    <input class="form-input name" type="text" id="name" placeholder="Tên khách hàng" value="<?php echo $data_detail['HoTenKH'] ?>" />
                    <input type="hidden" name="MSKH" id="MSKH" value="<?php echo $data_detail['MSKH'] ?>" />
                </div>
                <div class="row error error_name"></div>
                <div class="row form-item align-items-center">
                    <input class="form-input company" type="text" id="company" placeholder="Tên công ty" value="<?php echo $data_detail['TenCongTy'] ?>" />
                </div>
                <div class="row error error_company"></div>
                <div class="row form-item align-items-center">
                    <input class="form-input n_phone" type="text" id="n_phone" placeholder="Số điện thoại" value="<?php echo $data_detail['SoDienThoai'] ?>" />
                </div>
                <div class="row error error_n_phone"></div>
                <div class="row form-item align-items-center">
                    <input class="form-input email" type="text" id="email" placeholder="Email" value="<?php echo $data_detail['Email'] ?>" />
                </div>
                <div class="row error error_email"></div>
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
                                        <div class="col-9">
                                            <span class="row order-detail__list-product--title">- <?php echo $key['DiaChi'] ?></span>
                                        </div>
                                        <div class="col-2">
                                            <span class="order-detail__list-product--quantity delete-customer-address" MaDC="<?php echo $key['MaDC'] ?>">
                                                <i class=" far fa-trash-alt icon-add-customer"></i>
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
                        <button type="submit" class="form-submit" id="edit-save">Chỉnh sửa</button>
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
                        <input type="hidden" id="MSKH" value="<?php echo $data_detail['MSKH'] ?>" />
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