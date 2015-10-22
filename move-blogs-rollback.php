<?php

/*
Multi-DB plugin's database conversion rollback tool.
Plugin URI https://premium.wpmudev.org/project/multi-db/
Version: 3.2.6
Author: WPMU DEV
Author URI: http://premium.wpmudev.org/
Description: This script is to rollback from a WordPress Multisite multiple database setup, to a WordPress Multisite single database setup.
*/

///DB Settings
$target_dbname = "target_single_db";  //New single DB. It should be already created.
$multi_db_prefix = 'multidb_';  //This is the prefix of the DB's you're moving your tables from.

//We need info to connect to the databases
$dbhost = 'localhost';
$dbuname = 'root';
$dbpass = 'pass';

//How many db's are you moving into (16, 256, or 4096)?
$db_scaling = '16';


//------------------------------------------------------------------------//
//---Processing-----------------------------------------------------------//
//------------------------------------------------------------------------//

$newdbsize = '1';
if ( $db_scaling == '256' ) {
	$newdbsize = '2';
} else if ( $db_scaling == '4096' ) {
	$newdbsize = '3';
}

//Check if we are executing the rollback operation.
$doing_rollback = !empty($_REQUEST['action']) && $_REQUEST['action'] == 'rollback';


$dbh_multi = ($GLOBALS["___mysqli_ston"] = mysqli_connect( $dbhost,  $dbuname,  $dbpass ));
if ( !$dbh_multi ) {
	echo 'Could not connect to mysql';
	exit;
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Multiple Databases Roll-Back Tool</title>
	<style type="text/css">
		.centered { text-align: center; }
		table.stats { text-align: center; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif ; font-weight: normal;font-size: 12px;color: #fff;width: 750px;background-color: #666;border: 1px solid #555;border-collapse: collapse;border-spacing: 1px; }
		table.stats td { background-color: #CCC; color: #000; padding: 6px; text-align: left; border: 1px #fff solid; }
		table.stats td.head { background-color: #666; color: #fff; padding: 6px; text-align: center; border-bottom: 2px #fff solid; font-size: 12px; font-weight: bold; width: 25%; }
	</style>
</head>
<body>
<table align="center" class="stats">
	<tr>
		<td colspan="4" align="center">
			<ol>
				<li>Tested on PHP 5 & MySQL 5</li>
				<li>Note this will only work if all the new databases are on the same MySQL server, and ONE set of credentials has access to all of them.</li>
				<li>Make sure that your target DB "<?php echo $target_dbname; ?>" exist (green text next to table name in db column below)</li>
				<li>In the status section, each table should show <i>not in target db (unless you've already run this script)</i></li>
				<li>To start the rollback process <a href='move-blogs-rollback.php?action=rollback'>click here</a> </li>
				<li>Be patient, depending on how many blogs you have, this could take a while</li>
				<li>Once completed, refresh this page by <a href='move-blogs-rollback.php'>clicking here</a></li>
				<li>Check to make sure that in the status section all tables say <i>table in target db</i></li>
				<li>Rejoice, I probably just saved you hours of your life!</li>
				<li>If this didn't work, don't blame me.  Sometimes life is just like that..</li>
			</ol>
		</td>
	</tr>
	<tr>
		<td class="head">DB name</td>
		<td class="head">table name</td>
		<td class="head">target db</td>
		<td class="head">status</td>
	</tr><?php

	$db_ids = array('global');

	for( $i = 0; $i < $db_scaling; $i++ ){
		$hex = base_convert($i, 10, 16);
		$db_ids[] = $hex;
	}

	foreach($db_ids as $i => $hex){

		$current_db_name = $multi_db_prefix . str_pad( $hex, $newdbsize, "0", STR_PAD_LEFT );
		//Get our table list from each multi DB.
		$result = mysqli_query( $dbh_multi ,  'SHOW TABLES FROM ' . $current_db_name);
		if ( !$result ) {
			echo "DB Error, could not list tables<br><b>Make sure you configure your original table in the dbname variable at the top of the script!</b><br>";
			echo 'MySQL Error: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
			exit;
		}
		while ( $row = mysqli_fetch_row( $result ) ) {

			$dbh_target = ($GLOBALS["___mysqli_ston"] = mysqli_connect( $dbhost,  $dbuname,  $dbpass )) or die( "Houston, we have a problem!<br>Database Error: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
			((bool)mysqli_query( $dbh_target , "USE " . $target_dbname)) or die( "Houston, we have a problem!<br><b>Looks like you need to create your target DB '" . $target_dbname . "'. <br /> Database Error: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );

			$tableexists = mysqli_num_rows( mysqli_query( $dbh_target ,  "SHOW TABLES LIKE '{$row[0]}'") );
			$tabletest = $tableexists
				? '<span style="color:green">table in target db</span>'
				: "table not in target db";

			//CHeck if we are executing the rollback process.
			if ( $doing_rollback && !$tableexists ) {
				mysqli_query( $dbh_target ,  "CREATE TABLE {$row[0]} LIKE {$current_db_name}.{$row[0]}");
				mysqli_query( $dbh_target ,  "INSERT INTO {$row[0]} SELECT * FROM {$current_db_name}.{$row[0]}");
			}

			$testpass = '<span style="color:green">&nbsp;exists</span>';
			echo "<tr>";
			echo "<td>" . $current_db_name . "</td>";
			echo "<td>{$row[0]}</td>";
			echo "<td>{$target_dbname} <i>{$testpass}</i></td><td>{$tabletest}</td></tr>";

			((is_null($___mysqli_res = mysqli_close( $dbh_target ))) ? false : $___mysqli_res);
		} // end while
	}

	?></table>
</body>
</html>