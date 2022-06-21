<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$book_id = $_POST['book_id'];
$user_id = $_POST['user_id'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);
if(check_id($conn, $user_id)) {
	$mode = "등록";
	$button = "등록";
	$action = "review_create.php";
	
	$query = "select * from Review where book_id=$book_id and user_id='$user_id'";
	$review = mysqli_fetch_array(mysqli_query($conn, $query));
	if($review) {
		$review_id = $review['review_id'];
		
		$mode = "수정/삭제";
		$button = "수정";
		$action = "review_update.php?review_id=$review_id";
	}
} else {
	mysqli_query($conn, "rollback");
	msg('등록되지 않은 사용자입니다.');
}
?>

<h2>리뷰 <?=$mode?></h2>

<form name="review_form" action=<?=$action?> method="post">
	<input type="hidden" id="book_id" name="book_id" value="<?=$book_id?>">
	<input type="hidden" id="user_id" name="user_id" value="<?=$user_id?>">
	<p>
		<label for="rating">평 점</label>
		<?
		for($i=5; $i>0; $i--) {
			echo "<input type='radio' id='rating' name='rating' value={$i}";
			if($review['rating'] == strval($i))
				echo " checked";
			echo ">" . str_repeat('★', $i) . " ";
		}
		?>
	</p>
	<p>
		<label for="conent">내 용</label>
		<textarea name="content" id="content" row="2"><?=$review['content']?></textarea>
	</p>
    <button type="submit" onclick="javascript:return validate();"><?=$button?></button>
    <?
    if($mode == "수정/삭제") {
    	echo "<button type='button' onclick='javascript:deleteReviewConfirm($review_id)'>삭제</button>";
    }
    ?>
</form>

<script>
    function validate() {
        if(document.querySelector('input[name="rating"]:checked') == null) {
            alert ("평점을 선택하십시오."); return false;
        }
        else if(document.getElementById("content").value == "") {
            alert ("내용을 입력하십시오."); return false;
        }
        return true;
    }
    
    function deleteReviewConfirm(review_id) {
        if (confirm("정말 삭제하시겠습니까?") == true){    //확인
            window.location = "review_delete.php?review_id=" + review_id;
        }
        else {   //취소
            return;
        }
    }
</script>

<? mysqli_query($conn, "commit"); ?>
<? include("footer.php") ?>