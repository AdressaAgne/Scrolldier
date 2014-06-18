<?php
	
	include('../../admin/mysql/connect.php');
	include('../../admin/mysql/function.php');
	$xClass = new xClass();
	//header ('Content-Type: image/png');
	session_start();
	
	$zipname = strtolower($_SESSION['username'])."_scroll_library.zip";

			
	$fan_query = $db->prepare("SELECT * FROM fanScrolls WHERE user=:user");	
		
	$fan_arr = array(
			'user' => $_SESSION['username']
		);
	$xClass->arrayBinder($fan_query, $fan_arr);
		
	$fan_query->execute();
				
	
	 
   

    
    $zip = new ZipArchive;
   
   
   	if ($zip->open($main."u/user_files/".$zipname, ZipArchive::CREATE) === true) {
   		while ($fanScroll = $fan_query->fetch(PDO::FETCH_ASSOC)) {
   		
   			if (file_exists(strtolower($_SESSION['username'])."/".$fanScroll['link'].".png")) {
   				if ($zip->addFile(strtolower($_SESSION['username'])."/".$fanScroll['link'].".png", $fanScroll['link'].".png")) {
   					
   				}
   			} else {
   				print("file does not exist: ".$fanScroll['link']."png \n");
   			}
   			
   		}
   	}


    if ($zip->close()) {
    	header('Content-Type: application/zip');
    	header("Content-Disposition: attachment; filename='".$zipname."'");
    	header('Content-Length: ' . filesize($zipname));
    	header("Location: ".$main."u/user_files/".$zipname);
    } else {
    	print("Unable to close zip");
    }
   

    
