<?php
// put db-tools in root-directory of your server (temporary)
include_once( '../wp-load.php' );
if ( ! is_user_logged_in() ) {
	?>
	<p>You must be logged in to access this tool.</p>
	<?php
} else {
	?>
	<p>
		Incsub DB Tools<br/>
		====================================================================<br/>
		<a href="db.php">DB List</a> | <a href="db_sql.php">DB SQL</a> | <a href="db_servers.php">DB Servers</a> | <a href="db_array.php">DB Array</a> | <a href="md5.php">MD5</a><br/>
		====================================================================
	</p>
	<form name="profile" id="your-profile" action="md5.php" method="post">
		<input type="hidden" name="process" value="true">
		<input type="text" name="data" value=""/>
		<input type="submit" value="Submit" name="submit"/>
	</form>

	<?php
	if ( $_POST['process'] == true ) {
		echo md5( $_POST['data'] );
	}
	?>
	<?php
}
?>
