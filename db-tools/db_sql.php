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
	<form name="" id="" action="db_sql.php" method="post">
		<input type="hidden" name="process" value="true">
		DB Name: <input type="text" name="db_name" value=""/> ex: yoursite_<br/>
		<select name="option">
			<option value="16">16</option>
			<option value="256">256</option>
			<option value="4096">4096</option>
		</select>
		<input type="submit" value="Submit" name="submit"/>
	</form>

	<?php
	if ( $_POST['process'] == true ) {
		echo '====================================================================<br />';
		$hash_list[0]  = '0';
		$hash_list[1]  = '1';
		$hash_list[2]  = '2';
		$hash_list[3]  = '3';
		$hash_list[4]  = '4';
		$hash_list[5]  = '5';
		$hash_list[6]  = '6';
		$hash_list[7]  = '7';
		$hash_list[8]  = '8';
		$hash_list[9]  = '9';
		$hash_list[10] = 'a';
		$hash_list[11] = 'b';
		$hash_list[12] = 'c';
		$hash_list[13] = 'd';
		$hash_list[14] = 'e';
		$hash_list[15] = 'f';
		?>
		<form>
<textarea cols="73" rows="50">
<?php
//==============================================//
foreach ( $hash_list as $hash_1 ) {
	$tmp_hash_value = '';
	$tmp_hash_value = $tmp_hash_value . $hash_1;
	//========================//
	if ( $_POST['option'] == '16' ) {
		?>
		CREATE DATABASE `<?php echo esc_html( $_POST['db_name'] ) . $tmp_hash_value; ?>` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		<?php
	} else {
		//========================//
		foreach ( $hash_list as $hash_2 ) {
			if ( $_POST['option'] == '256' ) {
				//========================//
				$tmp_hash_value_2 = $tmp_hash_value . $hash_2;
				?>
				CREATE DATABASE `<?php echo esc_html( $_POST['db_name'] ) . $tmp_hash_value_2; ?>` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
				<?php
				//========================//
			} else {
				//========================//
				$tmp_hash_value_2 = $tmp_hash_value . $hash_2;
				foreach ( $hash_list as $hash_3 ) {
					//========================//
					$tmp_hash_value_3 = $tmp_hash_value_2 . $hash_3;
					?>
					CREATE DATABASE `<?php echo esc_html( $_POST['db_name'] ) . $tmp_hash_value_3; ?>` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
					<?php
					//========================//
				}
				//========================//
			}
		}
		//========================//
	}
	//========================//
}
//==============================================//
?>
</textarea>
		</form>
		<?php
	}
	?>
	<?php
}
?>
