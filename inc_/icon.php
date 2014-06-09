<ul class="badge-icon left"><?php

 if ($thisRank == 5) {
	echo("<li><i class='icon-ig-mojang'></i><ul><li class='modern'>Mojangster</li></ul></li>");
 }
 
 if ($thisRank == 2) {
 	echo("<li><i class='icon-mod'></i><ul><li class='modern'>Moderator of scrolldier</li></ul></li>");
 } 
 
 if ($thisRank == 1) {
 	echo("<li><i class='icon-admin'></i><ul><li class='modern'>Admin of scrolldier</li></ul></li>");
 } 
 
 if ($x->hasDonated($thisUser)) {
 	echo("<li><i class='icon-donor'></i><ul><li class='modern'>Have donated to Scrolldier.com</li></ul></li>");
 } 
  
 if ($x->isGuildLeader($thisUser)) {
 	echo("<li><i class='icon-guild'></i><ul><li class='modern'>".$thisUser." is a guild leader</li></ul></li>");
 }
 
 if ($thisID != 0) {
 	if ($thisID <= 70) {
 		echo("<li><i class='icon-alpha'></i><ul><li class='modern'>Scrolldier Alpha user</li></ul></li>");
 	}
 	
 	if ($thisID > 70) {
 		echo("<li><i class='icon-beta'></i><ul><li class='modern'>Scrolldier Beta user</li></ul></li>");
 	}
 }
 
 
 
 $query = $db->prepare("SELECT * FROM badges WHERE user=:ign");
 $arr = array(
 		'ign' => strtolower($thisUser)
 	);
 $x->arrayBinder($query, $arr);
 $query->execute();
 
 while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
 	echo("<li><i class='".$row['type']."'></i><ul><li class='modern'>".$row['text']."</li></ul></li>");
 }
 
 

?></ul>