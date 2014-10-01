<?php 
	include('../admin/mysql/connect.php');
	include('../admin/mysql/function.php');
	$x = new xClass();
	session_start();
	
	
	if (empty($_POST['scroll'])) {
		echo("<h3 class='color-white'>Textfield is empty</h3>");
		die();
	}
	
	$json = $_POST['scroll'];	
	$data = json_decode($json, TRUE);
	

	$query = $db->prepare("SELECT * FROM scrollsCard");
	
	if ($query->execute()) {
		$dbScroll = array();
		
		while ($scroll = $query->fetch(PDO::FETCH_ASSOC)) {
			array_push($dbScroll, $scroll['id']);
		}
	}
	
	$result = array_diff($dbScroll, $data['types']);
	$result = array_values($result);

	$total = count($result);


?>




<?php if ($total == 0) { ?>
	<h3 class="color-white">Your Collection is Completed!</h3>
<?php } else { ?>
	<h3 class="color-white">Here are a list of scrolls you don't have in your collection, a total of <?php echo($total) ?></h3>
	<p>Does also include Test Server scrolls.</p>
<?php } ?>

<?php for ($i = 0; $i < count($result); $i++) { 
	$query = $db->prepare("SELECT * FROM scrollsCard WHERE id = :id ORDER BY id");
	$arr = array(
		'id' => $result[$i],
	);
	$x->arrayBinder($query, $arr);
	if ($query->execute()) {
	$missingScroll = $query->fetch(PDO::FETCH_ASSOC);
	
?>
	
	<div class="image-holder" data-id="<?php echo($missingScroll['id']) ?>">
		<p class=""><?php echo($missingScroll['name']) ?></p>
		<img src="../resources/cardImages/<?php echo($missingScroll['image']) ?>.png" alt="" />
	</div>
	
	
<?php } } 	
 ?>
