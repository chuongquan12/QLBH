<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "quanlydathang";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if ($conn) {
	mysqli_query($conn, "SET NAMES 'utf8' ");
} else {
	echo "Kết nối của bạn thất bại" . mysqli_connect_error();
}
