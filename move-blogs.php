<?php
/*
Plugin Name: Multi-DB (Conversion Tool)
Plugin URI: http://premium.wpmudev.org/project/Multiple-Databases
Description:
Author: Ron Dillehay - FanMail to rdillehay@hotmail.com (no tech support please) - Modified slightly by Andrew Billits (Incsub)
Version: 2.9.2
Author URI:
Descriptiom:
This script is to move blogs from a wordpress mu single database setup, to a wordpress mu multiple database setup using an MD5 hash to establish blog routing
Use this script at your own risk.  My test setup uses php 5, mysql 5, and wordpress mu 1.2.5a
*/ 

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

///DB Settings
$dbname = "old_db_name";  //This is your current database
$blog_table_prefix = 'wp_';  //Prefix of your wpmu blog tables, most likely this won't need to be changed
$newdb_prefix = 'newdbname';  //This is the prefix of the db's you're moving your tables into - we assume they are all the same, if not, you're in trouble

//We need info to connect to the databases
$dbhost = 'localhost';
$dbuname = 'user';
$dbpass = 'pass';

//How many db's are you moving into (16, 256, or 4096)? 
$db_scaling = '256';

//------------------------------------------------------------------------//
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Multiple Databases Conversion Tool</title>
<head>
<style type="text/css">
table.stats 
{text-align: center; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif ; font-weight: normal;font-size: 12px;color: #fff;width: 750px;background-color: #666;border: 1px solid #555;border-collapse: collapse;border-spacing: 1px;}
table.stats td 
{background-color: #CCC;color: #000;padding: 6px;text-align: left;border: 1px #fff solid;}
table.stats td.head
{background-color: #666;color: #fff;padding: 6px;text-align: center;border-bottom: 2px #fff solid;font-size: 12px;font-weight: bold;}
</style>
</head> 

<?php

if ($db_scaling == '16'){
$newdbsize = '1';
} else if ($db_scaling == '256'){
$newdbsize = '2';
} else if ($db_scaling == '4096'){
$newdbsize = '3';
}

//Check to see if we are moving tables yet
$tabletomove = $_REQUEST["table"];

//Connect to SQL
if (!mysql_connect($dbhost, $dbuname, $dbpass)) {
	echo 'Could not connect to mysql';
	exit;
}

//Get our table list from the original db
$sql = "SHOW TABLES FROM $dbname";
$result = mysql_query($sql);

if (!$result) {
	echo "DB Error, could not list tables <br /> <b>Make sure you configure your original table in the dbname variable at the top of the script!</b><br />\n";
	echo 'MySQL Error: ' . mysql_error();
	exit;
}

echo "<table align='center' class='stats'><tr><td colspan='4' align='center'><br /><ol>
	<li>Tested on PHP 5 & MySQL 5</li>
	<li>Make sure all of your new db's exist (green text next to table name in db column below)</li>
	<li>In the status section, each table should show <i>not in new db (unless you've already run this script)</i></li>
	<li>To start the copy process <a href='move-blogs.php?table=copy'>click here</a> </li>
	<li>Be patient, depending on how many blogs you have, this could take a while</li>
	<li>Once completed, refresh this page by <a href='move-blogs.php'>clicking here</a></li>
	<li>Check to make sure that in the status section all tables say <i>table in new db</i></li>
	<li>Rejoice, I probably just saved you hours of your life!</li>
	<li>If this didn't work, don't blame me.  Sometimes life is just like that..</li></ol>
	</td></tr><tr><td class='head' width='25%'>table name</td><td class='head' width='25%'>table info</td><td class='head' width='25%'>new db</td><td class='head' width='25%'>status</td></tr>";

while ($row = mysql_fetch_row($result)) {

	//Here we find our blog id, hash it, and establish our new db names
	$blogid_get = explode("_", $row[0]); 
	$blogid = $blogid_get[1];
	$md5_hash = md5($blogid);
	$md5_dbprefix = substr($md5_hash, 0, $newdbsize);
	$this_blog_new_db = $newdb_prefix.$md5_dbprefix;
	if ( !is_numeric($blogid) ) {
		// this is a global table
		$this_blog_new_db = $newdb_prefix."global";
	}
	/*
	if ( $blogid == 1 ) {
		$this_blog_new_db = $newdb_prefix."_home";
	} elseif ( !is_numeric($blogid) ) {
		// this is a global table
		$this_blog_new_db = $newdb_prefix."_global";
	}
	*/
	$db = mysql_connect($dbhost, $dbuname, $dbpass) or die("Houston, we have a problem! <br />Database Error: ".mysql_error()); 
	mysql_select_db($this_blog_new_db, $db) or die("Houston, we have a problem! <br /><b> Looks like you need to create your new db's!   If you're lucky, this link still works - <a href='http://calc.idtstudios.com/db.php'>click me</a> </b><br />Database Error: ".mysql_error());
	if( mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$row[0]."'"))) { $tabletest = "<font color='green'>table in new db</font>"; } else { $tabletest = "table not in new db"; }

	//Filter out the nonblog tables
	if ( is_numeric($blogid) ) { 
		//Next we check to see if we are actually moving anything yet
		if ($tabletomove != "") {
			//This is where the heavy lifting is done - amazing only four lines of code can save so much time! Tested on php 5 - mysql 5
			$sql_table = "CREATE TABLE $row[0] LIKE $dbname.$row[0]";
			$insert_info = "INSERT INTO $row[0] SELECT * FROM $dbname.$row[0]";
			mysql_query($sql_table);
			mysql_query($insert_info);
			mysql_free_result($sql_table);
			mysql_free_result($insert_info);
		}

		//Close the db and report db status
		mysql_close($db); $testpass = "<font color='green'>&nbsp;exists</font>";
		echo "<tr><td>{$row[0]}</td><td>blog {$blogid}</td><td>{$this_blog_new_db} <i>{$testpass}</i></td><td>{$tabletest}</td></tr>";
	} else {
		// this is a global db.
		//Next we check to see if we are actually moving anything yet
		if ($tabletomove != "") {
			//This is where the heavy lifting is done - amazing only four lines of code can save so much time! Tested on php 5 - mysql 5
			$sql_table = "CREATE TABLE $row[0] LIKE $dbname.$row[0]";
			$insert_info = "INSERT INTO $row[0] SELECT * FROM $dbname.$row[0]";
			mysql_query($sql_table);
			mysql_query($insert_info);
			mysql_free_result($sql_table);
			mysql_free_result($insert_info);
		}
		//Close the db and report db status
		mysql_close($db); $testpass = "<font color='green'>&nbsp;exists</font>";
		echo "<tr><td>{$row[0]}</td><td>blog {$blogid}</td><td>{$this_blog_new_db} <i>{$testpass}</i></td><td>{$tabletest}</td></tr>";
	}
} // end while

echo "</table>";

//Clean up after ourselves
echo "<center>Ignore any errors below this line</center>";
echo "<center>================================================================================</center>";

?>