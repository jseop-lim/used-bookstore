<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname, true);

if (array_key_exists("product_id", $_GET)) {
	$product_id = $_GET['product_id'];
	
    $query = "select * from Product where product_id = $product_id";
    $product = mysqli_fetch_array(mysqli_query($conn, $query));
    if(!$product)
	    // mysqli_query($conn, "rollback");
        msg("상품이 존재하지 않습니다.");
        
    $book_id = $product['book_id'];
	$query = "SELECT * FROM Book WHERE book_id=$book_id";
	$book = mysqli_fetch_array(mysqli_query($conn, $query));
    
    $mode = "수정/삭제";
    $button = "수정";
    $action = "product_update.php?product_id=$product_id";
}
elseif (array_key_exists("book_id", $_GET)) {
	$book_id = $_GET['book_id'];
	
    $query = "select * from Book where book_id = $book_id";
    $book = mysqli_fetch_array(mysqli_query($conn, $query));
    if(!$book)
	    // mysqli_query($conn, "rollback");
        msg("도서가 존재하지 않습니다.");
	
	$mode = "등록";
	$button = "등록";
	$action = "product_create.php";
}
else {
	mysqli_query($conn, "rollback");
	msg("잘못된 경로입니다.");
}
?>

<h2>상품 <?=$mode?></h2>

<h3>도서 정보</h3>

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

<form id="product_form" name="product_form" action=<?=$action?> method="post">
	<input type="hidden" id="book_id" name="book_id" value="<?=$book_id?>">
	<p>
		<label for="user_id">사용자ID</label>
		<input type="text" id="user_id" name="user_id">
	</p>
	<p>
		<label for="quality">품 질</label>
		<?
		foreach (array("최상","상","중","하") as $q) {
			echo "<input type='radio' id='quality' name='quality' value={$q}";
			if($product['quality'] == $q)
				echo " checked";
			echo ">{$q} ";
		}
		?>
	</p>
	<p>
		<label for="price">판매가</label>
		<input type="text" id="price" name="price" value="<?=$product['price']?>"> 원
	</p>
	<p>
		<label for="delivery_charge">배송비</label>
		<input type="text" id="delivery_charge" name="delivery_charge" value="<?=$product['delivery_charge']?>"> 원
	</p>
    <button type="submit" onclick="javascript:return validate();"><?=$button?></button>
    <?
    if($mode == "수정/삭제") {
    	echo "<button type='button' onclick='javascript:deleteProductConfirm($product_id)'>삭제</button>";
    }
    ?>
</form>

<script>
    function validate() {
        if(document.getElementById("user_id").value == "") {
            alert ("사용자ID를 입력하십시오."); return false;
        }
        if(document.querySelector('input[name="quality"]:checked') == null) {
            alert ("품질을 선택하십시오."); return false;
        }
        else if(document.getElementById("price").value == "") {
            alert ("판매가를 입력하십시오."); return false;
        }
        else if(document.getElementById("delivery_charge").value == "") {
            alert ("배송비를 입력하십시오."); return false;
        }
        return true;
    }
    
    function deleteProductConfirm(product_id) {
        if(document.getElementById("user_id").value == "") {
            alert ("사용자ID를 입력하십시오."); return false;
        }
        else if (confirm("정말 삭제하시겠습니까?") == true) {    //확인
            // window.location = "product_delete.php?product_id=" + product_id;
            var form = document.getElementById("product_form");
            form.action = "product_delete.php?product_id=" + product_id;
            form.submit();
            form.action = "product_update.php?product_id=" + product_id;
        }
        else {   //취소
            return;
        }
    }
</script>

<? mysqli_query($conn, "commit"); ?>
<? include("footer.php") ?>