<?php

// SVN file version:
// $Id: addons_lib.php 302 2007-05-21 18:00:34Z schonhose $

$query_ad_s = "SELECT * FROM {$pixelpost_db_prefix}addons WHERE status='on' AND (type = 'normal' OR type='admin')";
//basically frontpage addons have been sucked in already at the beginning.
$query_ad_s = mysql_query($query_ad_s);
$addon_dir = "addons/";
while (list($id,$filename,$status)= mysql_fetch_row($query_ad_s))
{
	if (file_exists($addon_dir.$filename.".php")){
		include_once($addon_dir.$filename.".php");
	}
}
?>