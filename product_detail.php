<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
include "book_category_print.php";

$product_id = $_GET['product_id'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
$query = "SELECT * FROM Product JOIN User using(user_id) WHERE product_id=$product_id";
$product = mysqli_fetch_array(mysqli_query($conn, $query));

$book_id = $product['book_id'];
$query = "SELECT * FROM Book WHERE book_id=$book_id";
$book = mysqli_fetch_array(mysqli_query($conn, $query));

$discount_rate = round($product['price']/$book['price'] * 100, 0) . '%';
?>

<h2>상품 상세</h2>

<table border="1">
    <thead>
		<tr>
		    <th>제목</th>
		    <th>저자</th>
		    <th>출판사</th>
		    <th>출간일</th>
		    <th>정가</th>
		</tr>
    </thead>
    <tbody align ="center">
	    <tr>
	    	<td><a href='book_detail.php?book_id=<?=$book['book_id']?>'><?=$book['title']?></a></td>
	    	<td><?=$book['author']?></td>
	        <td><?=$book['publisher']?></td>
	    	<td><?=$book['publication_date']?></td>
	    	<td><?=$book['price']?>원</td>
	    </tr>
    </tbody>
</table>

<p>판매자:&ensp;<?=$product['name']?></p>
<p>할인률:&ensp;<?=$discount_rate?></p>
<p>품 질:&ensp;<?=$product['quality']?></p>
<p>판매가:&ensp;<?=$product['price']?>원</p>
<p>배송비:&ensp;<?=$product['delivery_charge']?>원</p>

<hr>
<p>분 야:&ensp;<?=full_category($conn, $book['category_id'])?></p>

<? require "review_list.php"; ?>

<p>
	<button type="button" onclick="location.href='product_form.php?product_id=<?=$product_id?>'">수정/삭제</button>
</p>

<? mysqli_query($conn, "commit"); ?>
<? include "footer.php"; ?>