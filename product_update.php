<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$product_id = $_GET['product_id'];

$user_id = $_POST['user_id'];
$price = $_POST['price'];
$quality = $_POST['quality'];
$delivery_charge = $_POST['delivery_charge'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
$query =  "select * from Product where product_id=$product_id and user_id='$user_id'";
$product = mysqli_fetch_array(mysqli_query($conn, $query));

if(!$product) {
	mysqli_query($conn, "rollback");
	msg('사용자ID가 일치하지 않습니다.');
}
else {
	$query = "UPDATE Product SET price='$price', quality='$quality', delivery_charge='$delivery_charge'
			  WHERE product_id=$product_id";
	db_rollback($conn, mysqli_query($conn, $query));

	mysqli_query($conn, "commit");
    s_msg ('상품 수정이 완료되었습니다.');
    $url = "product_detail.php?product_id=" . $product_id;
    redirect($url);
}
?>