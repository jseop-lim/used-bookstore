<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$book_id = $_POST['book_id'];
$user_id = $_POST['user_id'];
$price = $_POST['price'];
$quality = $_POST['quality'];
$delivery_charge = $_POST['delivery_charge'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);

if(!check_id($conn, $user_id)) {
	mysqli_query($conn, "rollback");
	msg('등록되지 않은 사용자입니다.');
}
else {
	$query = "INSERT INTO Product(book_id, user_id, price, quality, delivery_charge)
		  VALUES ($book_id,'$user_id','$price','$quality','$delivery_charge')";
	db_rollback($conn, mysqli_query($conn, $query));
	
	$product_id = mysqli_insert_id($conn);
	mysqli_query($conn, "commit");
	s_msg ('상품 등록이 완료되었습니다.');
	$url = "product_detail.php?product_id=" . $product_id;
	redirect($url);
}
?>