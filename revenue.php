<?php
include "connect.php";
session_start();

$today = date("Y-m-d");
$result_revenue_total = 0;

$sql_revenue_product = "SELECT SUM(SoLuong) as SoLuong FROM `dathang`, `chitietdathang` WHERE dathang.SoDonDH = chitietdathang.SoDonDH && NgayDH='$today'";
$sql_revenue_order = "SELECT COUNT(SoDonDH) as SoDon FROM `dathang` WHERE NgayDH='$today'";
$sql_revenue_total = "SELECT (SoLuong*GiaDatHang * (100 - GiamGia) * 0.01) as DoanhThu FROM `dathang`, `chitietdathang` WHERE dathang.SoDonDH = chitietdathang.SoDonDH && NgayDH='$today'";

$temp_revenue_product = mysqli_query($conn, $sql_revenue_product);
$temp_revenue_order = mysqli_query($conn, $sql_revenue_order);
$temp_revenue_total = mysqli_query($conn, $sql_revenue_total);

$result_revenue_product = mysqli_fetch_assoc($temp_revenue_product);
$result_revenue_order = mysqli_fetch_assoc($temp_revenue_order);
foreach ($temp_revenue_total as $key) :
  $result_revenue_total += $key['DoanhThu'];
endforeach;
// Kiểm tra đóng ca

$sql_revenue_check = "SELECT * FROM `doanhthu` WHERE Ngay='$today'";
$revenue_check = mysqli_query($conn, $sql_revenue_check);
?>
<script src="bootstrap/jquery-3.5.1.min.js"></script>
<script>
  $(document).ready(function() {
    showChartProduct();
    showChartRevenue();
    showChartProductOrder();

    $(".revenue").click(function() {
      $('.revenue').removeClass('active');
      $(this).toggleClass('active')

    });

    $(".product_order").click(function() {
      $('.product_order').removeClass('active');
      $(this).toggleClass('active')
    });

    $("#sub_revenue").click(function() {
      const product = $('#revenue_product').text();
      const order = $('#revenue_order').text();
      const revenue = $('#revenue_revenue').text();

      $.get("action.php", {
          product: product,
          order: order,
          revenue: revenue,
          add_revenue: true,
        },
        function(data) {
          $("#content").load('revenue.php');
        });
    });

    function showChartProduct() {
      $.get("action.php", {
          data_product_chart: true
        },
        function(data) {
          var labels = [];
          var result = [];
          var backlground_color = [
            "rgba(205, 55, 0, 0.7)",
            "rgba(132, 112, 255, 0.7)",
            "rgba(255, 255, 0, 0.7)",
            "rgba(169, 169, 169, 0.7)",
            "rgba(205, 155, 155, 0.7)",
            "rgba(208, 32, 144, 0.7)",
            "rgba(125, 38, 205, 0.7)",
          ];
          var boder = [
            "rgba(205, 55, 0, 1)",
            "rgba(132, 112, 255, 1)",
            "rgba(255, 255, 0, 1)",
            "rgba(169, 169, 169, 1)",
            "rgba(205, 155, 155, 1)",
            "rgba(208, 32, 144, 1)",
            "rgba(125, 38, 205, 1)",
          ];
          for (var key in data) {
            labels.push(data[key].TenLoaiHang)
            result.push(data[key].SoLuong)
          };

          var product = document.getElementById("ProductChart").getContext("2d");
          var chart = new Chart(product, {
            type: "doughnut",
            data: {
              labels: labels,
              datasets: [{
                backgroundColor: backlground_color,
                data: result,
              }, ],
            },
            options: {
              title: {
                display: true,
                text: "Tỉ lệ loại sản phẩm bán trong ngày",
                fonsSize: 25,
                fontStyle: "bold",
                position: "bottom",
                align: "center",
              },
              legend: {
                display: true,
                position: "left",
                labels: {
                  fontColor: "#00c8ff",
                },
              },
              layout: {
                padding: {
                  left: 0,
                  right: 0,
                  top: 0,
                  bottom: 10,
                },
              },
            },
          });
        },
      );
    }

    function showChartRevenue() {
      $.get("action.php", {
          data_revenue_chart: true
        },
        function(data) {
          var labels = [];
          var result = [];
          var backlground_color = [
            "rgba(205, 55, 0, 0.7)",
            "rgba(132, 112, 255, 0.7)",
            "rgba(255, 255, 0, 0.7)",
            "rgba(169, 169, 169, 0.7)",
            "rgba(205, 155, 155, 0.7)",
            "rgba(208, 32, 144, 0.7)",
            "rgba(125, 38, 205, 0.7)",
          ];
          var boder = [
            "rgba(205, 55, 0, 1)",
            "rgba(132, 112, 255, 1)",
            "rgba(255, 255, 0, 1)",
            "rgba(169, 169, 169, 1)",
            "rgba(205, 155, 155, 1)",
            "rgba(208, 32, 144, 1)",
            "rgba(125, 38, 205, 1)",
          ];
          for (var key in data) {
            labels.push(data[key].Ngay)
            result.push(data[key].DoanhThu)
          };

          var ctx = document.getElementById("RevenueDayChart").getContext("2d");
          var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: "line",

            // The data for our dataset
            data: {
              labels: labels,
              datasets: [{
                label: "Doanh thu",
                borderColor: "rgba(255, 255, 0, 1)",
                backgroundColor: "rgba(255, 255, 0, 0.54)",
                data: result,
              }, ],
            },
          });

        },
      );
    }

    function showChartProductOrder() {
      $.get("action.php", {
          data_product_order_chart: true
        },
        function(data) {
          var labels = [];
          var result_1 = [];
          var result_2 = [];
          var backlground_color = [
            "rgba(205, 55, 0, 0.7)",
            "rgba(132, 112, 255, 0.7)",
            "rgba(255, 255, 0, 0.7)",
            "rgba(169, 169, 169, 0.7)",
            "rgba(205, 155, 155, 0.7)",
            "rgba(208, 32, 144, 0.7)",
            "rgba(125, 38, 205, 0.7)",
          ];
          var boder = [
            "rgba(205, 55, 0, 1)",
            "rgba(132, 112, 255, 1)",
            "rgba(255, 255, 0, 1)",
            "rgba(169, 169, 169, 1)",
            "rgba(205, 155, 155, 1)",
            "rgba(208, 32, 144, 1)",
            "rgba(125, 38, 205, 1)",
          ];
          for (var key in data) {
            labels.push(data[key].Ngay)
            result_1.push(data[key].SoDonHang)
            result_2.push(data[key].SoSanPham)
          };

          var ctx = document.getElementById("ProductOrderChart").getContext("2d");
          var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: "line",

            // The data for our dataset
            data: {
              labels: labels,
              datasets: [{
                  label: "Đơn hàng",
                  borderColor: "rgb(255, 99, 132)",
                  backgroundColor: "rgba(255, 99, 132, .5)",
                  data: result_1,
                },
                {
                  label: "Sản phẩm",
                  borderColor: "#00c8ff",
                  backgroundColor: "rgba(0, 200, 255, .5)",
                  data: result_2,

                  type: "line",
                },
              ],
            },

            // Configuration options go here
            options: {},
          });

        },
      );
    }

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
  <div class="col-6">
    <div class="revenue-description">
      <div class="row">
        <span class="revenue-description__title"> Doanh thu: #<?php echo $today ?></span>
      </div>
      <div class="row mt-3">
        <div class="col-6">
          <li>Số sản phẩm bán được:</li>
          <li>Số đơn hàng hoàn thành:</li>
          <li>Doanh thu hôm nay:</li>
        </div>
        <div class="col-3 revenue-description__table">
          <li id="revenue_product">
            <?php
            if ($result_revenue_product['SoLuong'] != "")
              echo $result_revenue_product['SoLuong'];
            else
              echo 0;
            ?>
          </li>
          <li id="revenue_order">
            <?php
            if ($result_revenue_order['SoDon'] != "")
              echo $result_revenue_order['SoDon'];
            else
              echo 0;
            ?>
          </li>
          <li id="revenue_revenue">
            <?php
            if ($result_revenue_total != "")
              echo $result_revenue_total;
            else
              echo 0;
            ?>
          </li>
        </div>
        <div class="col-3 revenue-description__table">
          <li>SP</li>
          <li>đơn</li>
          <li>VNĐ</li>
        </div>
      </div>
      <?php if (!mysqli_num_rows($revenue_check)) { ?>
        <div class="row justify-content-end">
          <span class="revenue-description__submit" id="sub_revenue">Xác nhận</span>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="col-6">
    <div class="chart-product">
      <div class="row">
        <span class="revenue-description__title"> Tỉ lệ loại sản phẩm trong ngày </span>
      </div>
      <canvas id="ProductChart"></canvas>
    </div>
  </div>
</div>
<br />
<div class="row">
  <div class="col">
    <div class="revenue-chart-day">
      <div class="row">
        <div class="col">
          <span class="revenue-description__title"> Thống kê doanh thu </span>
        </div>
        <div class="col-3">
          <div class="chart-icon-group">
            <span class="revenue chart-icon active"> Ngày </span>
            <span class="revenue chart-icon"> Tháng </span>
          </div>
        </div>
      </div>
      <canvas id="RevenueDayChart"></canvas>
    </div>
  </div>
</div>
<br />
<div class="row">
  <div class="col">
    <div class="product-order-chart">
      <div class="row">
        <div class="col">
          <span class="revenue-description__title">
            Thống kê sản phẩm - đơn hàng
          </span>
        </div>
        <div class="col-3">
          <div class="chart-icon-group">
            <span class="product_order chart-icon active"> Ngày </span>
            <span class="product_order chart-icon"> Tháng </span>
          </div>
        </div>
      </div>
      <canvas id="ProductOrderChart"></canvas>
    </div>
  </div>
</div>