<?php
/*
Multi-DB plugin's database encoding fix tool
Plugin URI http://premium.wpmudev.org/project/Multiple-Databases
Description:
Author: S H Mohanjith (Incsub)
Version: 1.0.1
Author URI: http://mohanjith.com/
Description: This script tries to change the DB encoding to utf8. Use this script at your own risk.  My test setup uses php 5, mysql 5, and wordpress mu 1.2.5a
*/

define('WP_REPAIRING', true);

require_once('../../wp-load.php');

header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php _e('Multi DB &rsaquo; Database Repair'); ?></title>
        <?php wp_admin_css( 'install', true ); ?>
</head>
<body>
<h1 id="logo"><img alt="WordPress" src="../images/wordpress-logo.png" /></h1>

<?php

if ( !defined('WP_ALLOW_REPAIR') ) {
        echo '<p>'.__('To allow use of this page to automatically repair database encoding problems and other commeon DB problems, please add the following line to your wp-config.php file. Once this line is added to your config, reload this page.')."</p><code>define('WP_ALLOW_REPAIR', true);</code>";
} elseif ( isset($_GET['repair']) ) {
        $problems = array();

	if ( 2 == $_GET['repair'] )
		$optimize = true;
	else
		$optimize = false;

	$okay = true;

	$tables = $wpdb->tables();
	// Sitecategories may not exist if global terms are disabled.
	if ( is_multisite() && ! $wpdb->get_var( "SHOW TABLES LIKE '$wpdb->sitecategories'" ) )
		unset( $tables['sitecategories'] );
	$tables = array_merge( $tables, (array) apply_filters( 'tables_to_repair', array() ) ); // Return tables with table prefixes.
	// Loop over the tables, checking and repairing as needed.
	foreach ( $tables as $table ) {
		if ($_GET['fix_100']) {
			$cols = $wpdb->get_results("SHOW FULL COLUMNS FROM `{$table}` WHERE (Type IN ('CHAR', 'TEXT', 'TINYTEXT', 'MEDIUMTEXT', 'LONGTEXT') OR Type LIKE  'VARCHAR%');");
		} else {
			$cols = $wpdb->get_results("SHOW FULL COLUMNS FROM `{$table}` WHERE (Type IN ('CHAR', 'TEXT', 'TINYTEXT', 'MEDIUMTEXT', 'LONGTEXT') OR Type LIKE  'VARCHAR%') AND Collation NOT LIKE 'utf8%';");
		}

		if (is_array($cols) && count($cols) > 0) {
			foreach ($cols as $col) {
				if ($_GET['fix_100']) {
					$wpdb->query("ALTER TABLE `{$table}` CHANGE {$col->Field} {$col->Field} {$col->Type} CHARACTER SET latin1 COLLATE latin1_general_ci;");
				}
				switch (strtolower($col->Type)) {
					case 'longtext':
						$wpdb->query("ALTER TABLE `{$table}` CHANGE {$col->Field} {$col->Field} longblob;");
						break;
					case 'mediumtext':
						$wpdb->query("ALTER TABLE `{$table}` CHANGE {$col->Field} {$col->Field} mediumblob;");
						break;
					case 'tinytext':
						$wpdb->query("ALTER TABLE `{$table}` CHANGE {$col->Field} {$col->Field} tinyblob;");
						break;
					case 'text':
						$wpdb->query("ALTER TABLE `{$table}` CHANGE {$col->Field} {$col->Field} blob;");
						break;
					case 'char':
						$wpdb->query("ALTER TABLE `{$table}` CHANGE {$col->Field} {$col->Field} binary;");
						break;
					case 'varchar':
						$wpdb->query("ALTER TABLE `{$table}` CHANGE {$col->Field} {$col->Field} varbinary;");
						break;
				}
				$wpdb->query("ALTER TABLE `{$table}` CHANGE {$col->Field} {$col->Field} {$col->Type};");
			}
		}

		$wpdb->query("ALTER TABLE `{$table}` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");

		$check = $wpdb->get_row("CHECK TABLE {$table}");
		if ( 'OK' == $check->Msg_text ) {
			echo "<p>The $table table is okay.";
		} else {
			echo "<p>The $table table is not okay. It is reporting the following error: <code>$check->Msg_text</code>.  WordPress will attempt to repair this table&hellip;";
			$repair = $wpdb->get_row("REPAIR TABLE $table");
			if ( 'OK' == $check->Msg_text ) {
				echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;Successfully repaired the $table table.";
			} else {
				echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;Failed to repair the $table table. Error: $check->Msg_text<br />";
				$problems["$table"] = $check->Msg_text;
				$okay = false;
			}
		}
		if ( $okay && $optimize ) {
			$check = $wpdb->get_row("ANALYZE TABLE $table");
			if ( 'Table is already up to date' == $check->Msg_text )  {
				echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;The $table table is already optimized.";
			} else {
				$check = $wpdb->get_row("OPTIMIZE TABLE $table");
				if ( 'OK' == $check->Msg_text || 'Table is already up to date' == $check->Msg_text )
					echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;Successfully optimized the $table table.";
				else
					echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;Failed to optimize the $table table. Error: $check->Msg_text";
			}
		}
		echo '</p>';
	}

	if ( !empty($problems) ) {
		printf('<p>'.__('Some database problems could not be repaired. Please copy-and-paste the following list of errors to the <a href="%s">WordPress support forums</a> to get additional assistance.').'</p>', 'http://wordpress.org/support/forum/3');
		$problem_output = array();
		foreach ( $problems as $table => $problem )
			$problem_output[] = "$table: $problem";
		echo '<textarea name="errors" id="errors" rows="20" cols="60">' . esc_textarea( implode("\n", $problem_output) ) . '</textarea>';
	} else {
		echo '<p>'.__('Repairs complete.  Please remove the following line from wp-config.php to prevent this page from being used by unauthorized users.')."</p><code>define('WP_ALLOW_REPAIR', true);</code>";
	}
} else {
	if ( isset($_GET['referrer']) && 'is_blog_installed' == $_GET['referrer'] )
		_e('One or more database tables are unavailable. To allow WordPress to attempt to repair these tables, press the &#8220;Repair Database&#8221; button. Repairing can take a while, so please be patient.');
	else
		_e('WordPress can automatically look for some common database problems and repair them.  Repairing can take a while, so please be patient.')
?>
	<p class="step"><a class="button" href="<?php echo wp_nonce_url('fix-db-encoding.php?repair=1', 'repair_db') ?>"><?php _e( 'Repair Database' ); ?></a></p>
	<p class="step"><a class="button" href="<?php echo wp_nonce_url('fix-db-encoding.php?repair=1&fix_100=1', 'repair_db') ?>"><?php _e( 'Repair Database fixed by 1.0.0' ); ?></a></p>
	<?php _e('WordPress can also attempt to optimize the database.  This improves performance in some situations.  Repairing and optimizing the database can take a long time and the database will be locked while optimizing.'); ?>
	<p class="step"><a class="button" href="<?php echo wp_nonce_url('fix-db-encoding.php?repair=2', 'repair_db') ?>"><?php _e( 'Repair and Optimize Database' ); ?></a></p>
<?php
}
?>
</body>
</html>
