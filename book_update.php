<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$book_id = $_GET['book_id'];

$title = $_POST['title'];
$category_id = $_POST['category_id'];
$author = $_POST['author'];
$publisher = $_POST['publisher'];
$price = $_POST['price'];
$publication_date = $_POST['publication_date'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
$query = "UPDATE Book SET title='$title', author='$author', publisher='$publisher',
	      price='$price', publication_date='$publication_date', category_id='$category_id'
	      WHERE book_id = '$book_id'";
db_rollback($conn, mysqli_query($conn, $query));

mysqli_query($conn, "commit");
s_msg ('도서 수정이 완료되었습니다.');
$url = "book_detail.php?book_id=" . $book_id;
redirect($url);
?>