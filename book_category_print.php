<?
function full_category($conn, $category_id)
{
	$query = "SELECT * FROM Category WHERE category_id = $category_id";
	$cur_category = mysqli_fetch_array(mysqli_query($conn, $query));
	$full_category_str = $cur_category['name'];
	
	$parent_id = $cur_category['parent_id'];
	$query = "SELECT * FROM Category WHERE category_id = $parent_id";
	$cur_category = mysqli_fetch_array(mysqli_query($conn, $query));
	
	 while ($cur_category) {
	 	$full_category_str = $cur_category['name'] . " > " . $full_category_str;
	 	
		$parent_id = $cur_category['parent_id'];
		$query = "SELECT * FROM Category WHERE category_id = $parent_id";
		$cur_category = mysqli_fetch_array(mysqli_query($conn, $query));
	}
	
	return $full_category_str;
}
?>