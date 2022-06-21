<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$review_id = $_GET['review_id'];
$book_id = $_POST['book_id'];

$rating = $_POST['rating'];
$content = $_POST['content'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
$query = "UPDATE Review SET rating='$rating', content='$content'
		  WHERE review_id=$review_id";
db_rollback($conn, mysqli_query($conn, $query));

mysqli_query($conn, "commit");
s_msg ('리뷰 수정이 완료되었습니다.');
$url = "book_detail.php?book_id=" . $book_id;
redirect($url);
?>