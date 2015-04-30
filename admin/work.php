<?php
/*
 * PiHome v1.0
 * http://pihome.harkemedia.de/
 *
 * PiHome Copyright (c) 2012, Sebastian Harke
 * Lizenz Informationen.
 * 
 * This work is licensed under the Creative Commons Namensnennung - Nicht-kommerziell - Weitergabe unter gleichen Bedingungen 3.0 Unported License. To view a copy of this license,
 * visit: http://creativecommons.org/licenses/by-nc-sa/3.0/.
 *
*/


require('../configs/dbconfig.inc.php');
require('configs/functions.inc.php');


$wid = $_GET["w"];
$opp =  $_GET['o'];


if($opp=="device"){
dbconnect();
$sql_work_data    = "SELECT * FROM pi_devices WHERE id = ".$wid;
$query_work_data  = mysqli_query(dbconnect(), $sql_work_data);
while($workdata   = mysqli_fetch_assoc($query_work_data)){
?>
<form id="formdevice" method="post">
	<select name="waktiv">
		<?php if($workdata['aktiv']=="0"){ ?>
		<option value="0">disable</option>
		<option value="1">enable</option>
		<?php }else{ ?>
		<option value="1">enable</option>
		<option value="0">disable</option>		
		<?php } ?>

	</select>
	<br><br>
	Device Name:<br>
	<input type="text" name="wdevice_name" value="<?=utf8_encode($workdata['device'])?>">
	<br><br>
	Room:<br>
	<select name="wroom_id">
		<?php 
		$ro=getRooms();
		for($x=0;$x<count($ro);$x++){	
			if($ro[$x]["id"]==$workdata['room_id']){	
				echo '<option value="'.$ro[$x]["id"].'" selected>'.utf8_encode($ro[$x]["room"]).'</option>';
			}else{
				echo '<option value="'.$ro[$x]["id"].'">'.utf8_encode($ro[$x]["room"]).'</option>';
			}
		} 
		?>
	</select>
	<br><br>
	Letter:<br>
	<?php $letters=array("A","B","C","D") ?>
	<select name="wletter">		
		<?php for($le=0;$le<count($letters);$le++){ 
			if($letters[$le]==$workdata['letter']){
		?>
			<option value="<?=$letters[$le]?>" selected><?=$letters[$le]?></option>
		<?php }else{ ?>
			<option value="<?=$letters[$le]?>"><?=$letters[$le]?></option>
		<?php } } ?>
	</select>
	<br><br>
	Code:<br>
	<select name="wc1">
		<?php if($workdata['code'][0]=="0"){ ?>
		<option value="0">0</option>
		<option value="1">1</option>
		<?php }else{ ?>
		<option value="1">1</option>
		<option value="0">0</option>		
		<?php } ?>
	</select>
	<select name="wc2">
		<?php if($workdata['code'][1]=="0"){ ?>
		<option value="0">0</option>
		<option value="1">1</option>
		<?php }else{ ?>
		<option value="1">1</option>
		<option value="0">0</option>		
		<?php } ?>
	</select>
	<select name="wc3">
		<?php if($workdata['code'][2]=="0"){ ?>
		<option value="0">0</option>
		<option value="1">1</option>
		<?php }else{ ?>
		<option value="1">1</option>
		<option value="0">0</option>		
		<?php } ?>
	</select>
	<select name="wc4">
		<?php if($workdata['code'][3]=="0"){ ?>
		<option value="0">0</option>
		<option value="1">1</option>
		<?php }else{ ?>
		<option value="1">1</option>
		<option value="0">0</option>		
		<?php } ?>
	</select>
	<select name="wc5">
		<?php if($workdata['code'][4]=="0"){ ?>
		<option value="0">0</option>
		<option value="1">1</option>
		<?php }else{ ?>
		<option value="1">1</option>
		<option value="0">0</option>		
		<?php } ?>
	</select>
	<br><br>				
	Sort:<br>
	<input type="text" name="wsort" size="10" value="<?=$workdata['sort'];?>">				
	<br><br>				
	<span class="submit"><input type="button" onclick="update_device_send(<?=$workdata['id'];?>)" value="Update device"></span>	
</form>
<?php
}
}elseif($opp=="room"){
dbconnect();
$sql_work_room    = "SELECT * FROM pi_rooms WHERE id = ".$wid;
$query_work_room  = mysqli_query(dbconnect(), $sql_work_room);
while($workroom   = mysqli_fetch_assoc($query_work_room)){
?>
<form method="post" id="formroom">
	Room Name:<br>
	<input type="text" name="wroom" value="<?=utf8_encode($workroom['room']);?>">
	<br><br>
	<span class="submit"><input type="button" onclick="update_room_send(<?=$workroom['id']?>);" value="Update room"></span>
</form>
<?php
}
}
?>
