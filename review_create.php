<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$book_id = $_POST['book_id'];
$user_id = $_POST['user_id'];
$rating = $_POST['rating'];
$content = $_POST['content'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
$query = "insert into Review(user_id, book_id, rating, content)
		  values('$user_id', $book_id, '$rating', '$content')";
db_rollback($conn, mysqli_query($conn, $query));

mysqli_query($conn, "commit");
s_msg ('리뷰 등록이 완료되었습니다.');
$url = "book_detail.php?book_id=" . $book_id;
redirect($url);
?>