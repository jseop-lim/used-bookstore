<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
include "book_category_print.php";

$book_id = $_GET['book_id'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
$query = "SELECT * FROM Book WHERE book_id = '$book_id'";
$book = mysqli_fetch_array(mysqli_query($conn, $query));
?>

<h2>도서 상세</h2>

<button type="button" onclick="location.href='product_form.php?book_id=<?=$book_id?>'">상품등록</button>

<p>제 목:&ensp;<?=$book['title']?></p>
<p>저 자:&ensp;<?=$book['author']?></p>
<p>출판사:&ensp;<?=$book['publisher']?></p>
<p>출간일:&ensp;<?=$book['publication_date']?></p>
<p>정 가:&ensp;<?=$book['price']?>원</p>

<hr>
<p>분 야:&ensp;<?=full_category($conn, $book['category_id'])?></p>

<? require "review_list.php"; ?>

<p>
	<button type="button" onclick="location.href='book_form.php?book_id=<?=$book_id?>'">수정</button>
	<button type="button" onclick="javascript:deleteBookConfirm(<?=$book_id?>)">삭제</button>
</p>

<script>
    function deleteBookConfirm(book_id) {
        if (confirm("정말 삭제하시겠습니까?") == true){    //확인
            window.location = "book_delete.php?book_id=" + book_id;
        }
        else {   //취소
            return;
        }
    }
</script>

<? mysqli_query($conn, "commit"); ?>
<? include "footer.php"; ?>