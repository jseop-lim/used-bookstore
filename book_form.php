<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
$query = "select category_id, name from Category
		  where category_id not in (select parent_id from Category where parent_id is not null)
		  order by name";
$category_list = db_rollback($conn, mysqli_query($conn, $query));

$mode = "등록";
$action = "book_create.php";

if (array_key_exists("book_id", $_GET)) {
	$book_id = $_GET['book_id'];
	
    $query = "select * from Book where book_id = $book_id";
    $book = mysqli_fetch_array(mysqli_query($conn, $query));
	if(!$book) {
		mysqli_query($conn, "rollback");
		msg("도서가 존재하지 않습니다.");
	}
	
    $mode = "수정";
    $action = "book_update.php?book_id=$book_id";
}
?>

<h2>도서 <?=$mode?></h2>

<form name="book_form" action=<?=$action?> method="post">
	<p>
		<label for="title">제 목</label>
		<input type="text" id="title" name="title" value="<?=$book['title']?>">
	</p>
	<p>
		<label for="category_id">분 야</label>
		<select name="category_id" id="category_id">
			<option value="-1">선택</option>
			<?
			while($row = mysqli_fetch_array($category_list)) {
				if($row['category_id'] == $book['category_id']) {
					echo "<option value='{$row['category_id']}' selected>{$row['name']}</option>";
				}
				else {
					echo "<option value='{$row['category_id']}'>{$row['name']}</option>";
				}
			}
			?>
		</select>
	</p>
	<p>
		<label for="author">저 자</label>
		<input type="text" id="author" name="author" value="<?=$book['author']?>">
	</p>
	<p>
		<label for="publisher">출판사</label>
		<input type="text" id="publisher" name="publisher" value="<?=$book['publisher']?>">
	</p>
	<p>
		<label for="publication_date">출간일</label>
		<input type="date" id="publication_date" name="publication_date" value="<?=$book['publication_date']?>">
	</p>
	<p>
		<label for="price">정 가</label>
		<input type="text" id="price" name="price" value="<?=$book['price']?>"> 원
	</p>
    <button type="submit" onclick="javascript:return validate();">완료</button>
</form>

<script>
    function validate() {
        if(document.getElementById("title").value == "") {
            alert ("제목을 입력하십시오."); return false;
        }
        else if(document.getElementById("category_id").value == "-1") {
            alert ("분류를 선택하십시오."); return false;
        }
        else if(document.getElementById("author").value == "") {
            alert ("저자를 입력하십시오."); return false;
        }
        else if(document.getElementById("publisher").value == "") {
            alert ("출판사를 입력하십시오."); return false;
        }
        else if(document.getElementById("publication_date").value == "") {
            alert ("출간일을 입력하십시오."); return false;
        }
        else if(document.getElementById("price").value == "") {
            alert ("정가를 입력하십시오."); return false;
        }
        return true;
    }
</script>

<? mysqli_query($conn, "commit"); ?>
<? include("footer.php") ?>