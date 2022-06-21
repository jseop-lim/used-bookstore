<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$product_id = $_GET['product_id'];
$user_id = $_POST['user_id'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
$query =  "select * from Product where product_id=$product_id and user_id='$user_id'";
$product = mysqli_fetch_array(mysqli_query($conn, $query));

if(!$product) {
	mysqli_query($conn, "rollback");
	msg('사용자ID가 일치하지 않습니다.');
}
else {
	$query = "DELETE FROM Product WHERE product_id=$product_id";
	db_rollback($conn, mysqli_query($conn, $query));
	
	mysqli_query($conn, "commit");
    s_msg ('상품 삭제가 완료되었습니다.');
    redirect('index.php');
}
?>