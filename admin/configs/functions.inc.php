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



function get_date() 
{
	$now=date("d.m.Y, H:i:s",time());
	return $now;
}


function getCutStrip($cs,$ml,$end)
{
	$cutstrip = $cs;
	$maxlaenge = $ml;
	$cutstrip = (strlen($cutstrip) > $maxlaenge) ? substr($cutstrip,0,$maxlaenge).$end : $cutstrip;
	return $cutstrip;
}


function dbconnect()
{
    global $config;
	if (!($link = mysqli_connect($config['DB_HOST'], $config['DB_USER'], $config['DB_PWD'], $config['DB_NAME'])))
	{
        print "<h3>could not connect to database</h3>\n";
		exit;
	}
    return $link;
}


function pihome_acp_login($pih_username,$pih_passwort) {
	dbconnect();
    $query = "SELECT `id`, `user`, `pass`  FROM pi_admin WHERE user = '".$pih_username."'";
    $result =  mysqli_query(dbconnect(), $query);
    #dbconnect();
    #$result =  mysqli_query(dbconnect(), "SELECT `id`, `user`, `pass`  FROM pi_admin WHERE user = '$pih_username'");
    $zeileholen =  mysqli_fetch_array($result,MYSQLI_ASSOC);
    if (!$zeileholen) { die ("<meta http-equiv='refresh' content='0; URL=index.php'></SCRIPT><script language='JavaScript'>(window-alert('Benutzername nicht gefunden'))</script>"); }
    if ($zeileholen["pass"] <> $pih_passwort)
    { die ("<meta http-equiv='refresh' content='0; URL=index.php'></SCRIPT><script language='JavaScript'>(window-alert('Sorry, aber dieses Passwort passt nicht zum Benutzernamen!!'))</script>");
    } else {
    $_SESSION["pihome_username"]=$pih_username;
    $_SESSION["pihome_usid"]=$zeileholen["id"];
    }
}


function getcopy(){
	return '<a href="http://" target="_blank" title="PiHome">PiHome</a> &#169; '.date('Y');
}



function getLights(){
	dbconnect();
	$sql_getLights = "SELECT * FROM  pi_devices ORDER BY aktiv DESC ";
	$query_getLights = mysqli_query(dbconnect(), $sql_getLights);	
	$x=0;
	while($light = mysqli_fetch_assoc($query_getLights)){
		$devices[$x]["id"] = $light['id'];
		$devices[$x]["room_id"] = $light['room_id'];
		$devices[$x]["device"] = $light['device'];
		$devices[$x]["letter"] = $light['letter'];
		$devices[$x]["code"] = $light['code'];
		$devices[$x]["status"] = $light['status'];
		$devices[$x]["sort"] = $light['sort'];
		$devices[$x]["aktiv"] = $light['aktiv'];
		$x=$x+1;
	}
	return $devices;
}


function getRooms(){
	dbconnect();
	$sql_getRooms = "SELECT * FROM  pi_rooms";
	$query_getRooms = mysqli_query(dbconnect(), $sql_getRooms);	
	$x=0;
	while($room = mysqli_fetch_assoc($query_getRooms)){
		$rooms[$x]["id"] = $room['id'];
		$rooms[$x]["room"] = $room['room'];
		$x=$x+1;
	}
	return $rooms;
}


function getRoomById($id){
dbconnect();
$sql_getroom = "SELECT * FROM  pi_rooms  WHERE id = '".$id."' ";
$query_getroom = mysqli_query(dbconnect(), $sql_getroom);
while($getroom  = mysqli_fetch_assoc($query_getroom)){
return $getroom['room'];
}
}



function setLightStatus($id,$status){
	dbconnect();
	$sql_light = "SELECT * FROM  pi_devices  WHERE id = '".$id."' ";
	$query_light = mysqli_query(dbconnect(), $sql_light);
	while($light = mysqli_fetch_assoc($query_light)){
	$ls = $light['status'];
	}
	if($status=="on"){ $s="1"; }elseif($status=="off"){ $s="0"; }	
	if($s!=$ls){	
		dbconnect();
		$sql_status_update = "UPDATE `pi_devices` SET `status`='".$s."' WHERE `id`='".$id."'";
		mysqli_query(dbconnect(), $sql_status_update);
	}
}



function getCodeById($id){
	dbconnect();
	$sql_getcode = "SELECT * FROM  pi_devices  WHERE id = '".$id."' ";
	$query_getcode = mysqli_query(dbconnect(), $sql_getcode);
	while($code = mysqli_fetch_assoc($query_getcode)){
		$c["letter"] = $code['letter'];
		$c["code"] = $code['code'];
	}
	return $c;
}



function getDevcieAktivById($id) {
dbconnect();
$sql_dabi = "SELECT * FROM pi_devices WHERE id = '".$id."'";
$result_dabi = mysqli_query(dbconnect(), $sql_dabi) OR die(mysqli_error());
while($get_dabi = mysqli_fetch_assoc($result_dabi)){
$da = $get_dabi['aktiv']; 
}
return $da;
}


?>
