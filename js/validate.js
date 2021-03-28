$(document).ready(function () {

    // 
    var check_name = false;
    var check_company = false;
    var check_n_phone = false;
    var check_email = false;
    var check_address = false;

    // Name
    $(".name").keyup(function (e) { 
        var value = $(this).val();
        console.log(value)
        if(value.length == 0 || value.length > 25) {
            if(value.length == 0 ) $(".error_name").text("*Vui lòng nhập họ tên!");
            if(value.length > 25 ) $(".error_name").text("*Họ tên không được quá 25 ký tự");
            check_name = false;
        } else {
            $(".error_name").text("");
            check_name = true;
        }
    });

    // Company 
    $(".company").keyup(function (e) { 
        var value = $(this).val();
        if(value.length == 0 || value.length > 25) {
            if(value.length == 0 ) $(".error_company").text("*Vui lòng nhập tên công ty!");
            if(value.length > 0 ) $(".error_company").text("*Tên công ty không quá 25 ký tự!");
            check_company = false;

        } else {
            $(".error_company").text("");
            check_company = true;

        }
    });

    // Phone
    $(".n_phone").keyup(function (e) { 
        var value = $(this).val();
        
        if(value.length != 10 ) {
            if(value.length != 10 ) $(".error_n_phone").text("*Số điện thoại phải có 10 ký tự!");
            check_n_phone = false;

        } else {
            $(".error_n_phone").text("");
            check_n_phone = true;

        }
    });

    // Email
    $(".email").keyup(function (e) { 
        var value = $(this).val();
        var check_mail = value.indexOf('@gmail.com');
        if(value.length == 0 || check_mail == -1) {
            if(value.length == 0 ) $(".error_email").text("*Vui lòng nhập email!");
            if(check_mail == -1 ) $(".error_email").text("*Email phải có dạng ...@gmail.com!");
            check_email = false;

        } else {
            $(".error_email").text("");
            check_email = true;

        }
    });

    // Address
    $(".address").keyup(function (e) { 
        var value = $(this).val();
        
        if(value.length == 0 || value.length > 100) {
            if(value.length == 0 ) $(".error_address").text("*Vui lòng nhập địa chỉ!");
            if(value.length > 100 ) $(".error_address").text("*Địa chỉ quá dài  !");
            check_address = false;

        } else {
            $(".error_address").text("");
            check_address = true;

        }
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

    $("#edit-save").click(function(e) {
        e.preventDefault();
        if (check_name && check_company && check_n_phone && check_email && check_address) {

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


});
