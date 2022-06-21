<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$kw = $_GET['kw'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$query = "SELECT book_id, title, author, publisher, publication_date, price
		  FROM Book
		  WHERE title like '%$kw%' or author like '%$kw%' or publisher like '%$kw%'
		  ORDER BY title";
$book_list = mysqli_query($conn, $query);
?>

<h2>도서 목록</h2>

<form name="book_search" action="book_list.php" method="get">
	<p>
		<input type="text" id="kw" name="kw" placeholder="제목/저자/출판사">
		<button type="submit">검색</button>
	</p>
</form>

<table border="1">
    <thead>
		<tr>
		    <th>제목</th>
		    <th>저자</th>
		    <th>출판사</th>
		    <th>출간일</th>
		    <th>정가</th>
		    <th></th>
		</tr>
    </thead>
    <tbody align ="center">
    <?
    while ($book = mysqli_fetch_array($book_list)) {
        echo "<tr>";
	        echo "<td><a href='book_detail.php?book_id={$book['book_id']}'>{$book['title']}</a></td>";
	        echo "<td>{$book['author']}</td>";
	        echo "<td>{$book['publisher']}</td>";
	        echo "<td>{$book['publication_date']}</td>";
	        echo "<td>{$book['price']}원</td>";
	        echo "<td><button type='button' onclick=location.href='product_form.php?book_id={$book['book_id']}'>상품등록</button></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<? include("footer.php") ?>