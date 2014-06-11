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
 
// $userStats['played'] matches palyed
// $userStats['ranked'] ranked matches won
// $userStats['lost'] matches lost

 if ($userStats['played'] >= 2000) {
 	echo("<li><i class='icon-matches-2k'></i><ul><li class='modern'>Played over 2000 matches</li></ul></li>");
 } elseif ($userStats['played'] >= 1000) {
 	echo("<li><i class='icon-matches-1k'></i><ul><li class='modern'>Played over 1000 matches</li></ul></li>");
 }
 
 if ($userStats['ranked'] >= 1000) {
 	echo("<li><i class='icon-ranked-1k'></i><ul><li class='modern'>Won over 1000 ranked matches</li></ul></li>");
 } elseif ($userStats['ranked'] >= 500) {
 	echo("<li><i class='icon-ranked-500'></i><ul><li class='modern'>Won over 500 ranked matches</li></ul></li>");
 }
 
 if ($userStats['lost'] >= 1000) {
 	echo("<li><i class='icon-lost-1k'></i><ul><li class='modern'>Lost over 1000 matches</li></ul></li>");
 }
 

?></ul>