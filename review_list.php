<?
// include "config.php";    //데이터베이스 연결 설정파일
// include "util.php";      //유틸 함수

// $book_id = $_GET['book_id'];

// $conn = dbconnect($host, $dbid, $dbpass, $dbname);
$query = "SELECT User.name as user_name, rating, content, date(created_at) as create_date
		  FROM Review join User using(user_id)
		  WHERE book_id = $book_id
		  ORDER BY created_at DESC";
$review_list = mysqli_query($conn, $query);

$query = "SELECT avg(rating) FROM Review WHERE book_id = $book_id";
$avg_rating = mysqli_fetch_array(mysqli_query($conn, $query))['avg(rating)'];
?>

<p>평균평점:&ensp;<?=round($avg_rating, 2)?></p>

<h3>리뷰 목록</h3>

<form name="review_list" action="review_form.php" method="post">
	<input type="hidden" id="book_id" name="book_id" value="<?=$book_id?>">
	<p>
		<label for="user_id">사용자ID</label>
		<input type="text" id="user_id" name="user_id">
		<button type="submit">등록/수정</button>
	</p>
</form>

<table border="1">
    <thead>
		<tr>
		    <th>작성자</th>
		    <th>평점</th>
		    <th>내용</th>
		    <th>작성일시</th>
		</tr>
    </thead>
    <tbody align ="center">
    <?
    while ($review = mysqli_fetch_array($review_list)) {
        echo "<tr>";
	        echo "<td>{$review['user_name']}</td>";
	        echo "<td>";
	        for($i = 0; $i < $review['rating']; $i++)
	        	echo "★";
	        echo "</td>";
	        echo "<td>{$review['content']}</td>";
	        echo "<td>{$review['create_date']}</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>