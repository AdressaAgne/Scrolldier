<?php 
	include('../../admin/mysql/connect.php');
	include('../../admin/mysql/function.php');
	$x = new xClass();
	
	$pageSize = 12;
	$page = $_POST['p'] * $pageSize;
	
	$fan_query = $db->prepare("SELECT * FROM fanScrolls ORDER BY id DESC LIMIT :page, :pageSize");
	$fan_arr = array(
				'page' => $page,
				'pageSize' => $pageSize
			);		
	$x->arrayBinderInt($fan_query, $fan_arr);
	$fan_query->execute();

 ?>
 
 <?php while ($fanScroll = $fan_query->fetch(PDO::FETCH_ASSOC)) { ?>
 <div class="span-2">
 	<div class="div-4">	
 	<p class=" align-center">Made by <a href="<?php echo($main."user/".$fanScroll['user']) ?>"><?php echo($fanScroll['user']) ?></a></p>
 	
 	<a href="<?php echo($main."fanart/".$fanScroll['link']) ?>">
 		<img src="<?php echo($fanScroll['parma_link']) ?>" class="div-4" alt="" />
 	</a>
 	</div>
 </div>
 
 <?php } ?>	