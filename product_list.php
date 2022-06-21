<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$kw = $_GET['kw'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$query = "SELECT product_id, title, author, publisher, quality, Product.price as product_price,
			  delivery_charge, name as user_name
		  FROM Product JOIN
		  (SELECT book_id, title, author, publisher FROM Book
		  WHERE title like '%$kw%' or author like '%$kw%' or publisher like '%$kw%') B
		  USING(book_id) JOIN
		  (SELECT user_id, name FROM User) U
		  USING(user_id)
		  ORDER BY title, quality, product_price+delivery_charge";
$product_list = mysqli_query($conn, $query);
?>

<h2>상품 목록</h2>

<form name="product_search" action="product_list.php" method="get">
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
		    <th>품질</th>
		    <th>판매가</th>
		    <th>배송비</th>
		    <th>판매자</th>
		</tr>
    </thead>
    <tbody align ="center">
    <?
    while ($product = mysqli_fetch_array($product_list)) {
        echo "<tr>";
	        echo "<td><a href='product_detail.php?product_id={$product['product_id']}'>{$product['title']}</a></td>";
	        echo "<td>{$product['author']}</td>";
	        echo "<td>{$product['publisher']}</td>";
	        echo "<td>{$product['quality']}</td>";
	        echo "<td>{$product['product_price']}원</td>";
	        echo "<td>{$product['delivery_charge']}원</td>";
	        echo "<td>{$product['user_name']}</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<? include("footer.php") ?>