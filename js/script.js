$(document).ready(function(){

    $(".revenue").click(function () {
        $('.revenue').removeClass('active');
        $(this).toggleClass('active')
    });

    $(".product").click(function () {
        $('.product').removeClass('active');
        $(this).toggleClass('active')
    });

    var ctx = document.getElementById("ProductChart").getContext("2d");
    var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: "doughnut",

      // The data for our dataset
      data: {
        labels: ["January", "February", "March", "April"],
        datasets: [
          {
            backgroundColor: ["red", "blue", "green", "while"],
            data: [0, 10, 5, 2],
          },
        ],
      },

      // Configuration options go here
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

    var ctx = document.getElementById("RevenueDayChart").getContext("2d");
    var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: "line",

      // The data for our dataset
      data: {
        labels: ["January", "February", "March", "April"],
        datasets: [
          {
            label: "Doanh thu",
            borderColor: "#00c8ff",
            backgroundColor: "rgba(0, 200, 255, .5)",
            data: [185810, 244180, 215555, 211052],
          },
        ],
      },
    });

    // Chart

    var ctx = document.getElementById("ProductOrderChart").getContext("2d");
    var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: "line",

      // The data for our dataset
      data: {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
        ],
        datasets: [
          {
            label: "Đơn hàng",
            borderColor: "rgb(255, 99, 132)",
            backgroundColor: "rgba(255, 99, 132, .5)",
            data: [0, 10, 5, 2, 20, 30, 45],
          },
          {
            label: "Sản phẩm",
            borderColor: "#00c8ff",
            backgroundColor: "rgba(0, 200, 255, .5)",
            data: [10, 40, 20, 50, 30, 15, 5],

            type: "line",
          },
        ],
      },

      // Configuration options go here
      options: {},
    });

});