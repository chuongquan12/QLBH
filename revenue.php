<div class="row">
  <div class="col-6">
    <div class="revenue-description">
      <div class="row">
        <span class="revenue-description__title"> Doanh thu</span>
      </div>
      <div class="row">
        <div class="col-6">
          <li>Số sản phẩm bán được:</li>
          <li>Số đơn hàng hoàn thành:</li>
          <li>Doanh thu hôm nay:</li>
        </div>
        <div class="col-3 revenue-description__table">
          <li>25.000.000</li>
          <li>15</li>
          <li>25</li>
        </div>
        <div class="col-3 revenue-description__table">
          <li>VNĐ</li>
          <li>đơn</li>
          <li>SP</li>
        </div>
      </div>
      <div class="row justify-content-end">
        <span class="revenue-description__submit">Xác nhận</span>
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="chart-product">
      <div class="row">
        <span class="revenue-description__title"> Số sản phẩm bán </span>
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
            <span class="product chart-icon active"> Ngày </span>
            <span class="product chart-icon"> Tháng </span>
          </div>
        </div>
      </div>
      <canvas id="ProductOrderChart"></canvas>
    </div>
  </div>
</div>
<script src="bootstrap/jquery-3.5.1.min.js"></script>
<script src="js/script.js"></script>
