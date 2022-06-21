<?
function dbconnect($host, $id, $pass, $db, $is_transaction=false)  //데이터베이스 연결
{
    $conn = mysqli_connect($host, $id, $pass, $db);
	
    if ($conn == false) {
        die('Not connected : ' . mysqli_error());
    }
    if ($is_transaction) {
    	mysqli_query($conn, "set autocommit=0");
		mysqli_query($conn, "set session transaction isolation level serializable");
		mysqli_query($conn, "start transaction");
    }
	
    return $conn;
}

function msg($msg) // 경고 메시지 출력 후 이전 페이지로 이동
{
    echo "
        <script>
             window.alert('$msg');
             history.go(-1);
        </script>";
    exit;
}

function s_msg($msg) //일반 메시지 출력
{
    echo "
        <script>
            window.alert('$msg');
        </script>";
}

function check_id($conn, $user_id)
{
	$query = "select user_id from User where user_id='$user_id'";
	$result = mysqli_fetch_array(mysqli_query($conn, $query));
	if ($result){
		return true;
	} else {
		return false;
	}
}

function redirect($url)
{
	echo "<script>
		      location.replace('$url');
		  </script>";
}

function db_rollback($conn, $result, $msg='')
{
	if(!$result) {
		if(empty($msg)) {
			$msg = "Query Error : " . mysqli_error($conn);	
		}
		mysqli_query($conn, "rollback");
	    die($msg);
	}
	
	return $result;
}

?>