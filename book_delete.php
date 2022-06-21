<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$book_id = $_GET['book_id'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
$query = "DELETE FROM Book WHERE book_id = $book_id";
db_rollback($conn, mysqli_query($conn, $query));

mysqli_query($conn, "commit");
s_msg ('도서 삭제가 완료되었습니다.');
redirect('index.php');
?>