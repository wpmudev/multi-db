<?php
/*
Plugin Name: Multi-DB
Plugin URI:
Description:
Author: Andrew Billits, S H Mohanjith (Incsub)
Version: 3.0.6
Author URI:
WDP ID: 1
*/
//  WordPress DB Class
//
//  ORIGINAL CODE FROM:
//  Justin Vincent (justin@visunet.ie)
//	http://php.justinvincent.com
//
//	Plugin Name: Multi-DB
//	Plugin URI: http://premium.wpmudev.org/project/multi-db
//	Author: Andrew Billits (Incsub)
//	Version: 2.9.2
//------------------------------------------------------------------------//
//---Multi-DB-------------------------------------------------------------//
//------------------------------------------------------------------------//

/*
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

global $db_servers, $dc_ips, $original_table_prefix, $table_prefix, $global_tables, $vip_blogs;
$original_table_prefix = $table_prefix;
//	add_db_server(DS, DC, READ, WRITE, HOST, LAN_HOST, NAME, USER, PASS)
function add_db_server($ds, $dc, $read, $write, $host, $lhost, $name, $user, $password) {
	global $db_servers;

	$server = compact('ds', 'dc', 'read', 'write', 'host', 'name', 'user', 'password');

	if ( !empty($lhost) )
		$server['lhost'] = $lhost;

	$db_servers[$ds][] = $server;
}
$global_tables = array ($table_prefix . 'blogs',$table_prefix . 'blog_versions',$table_prefix . 'registration_log',$table_prefix . 'signups',$table_prefix . 'site',$table_prefix . 'sitecategories',$table_prefix . 'sitemeta',$table_prefix . 'usermeta',$table_prefix . 'users',$table_prefix . 'bp_activity_sitewide',$table_prefix . 'bp_activity_user_activity',$table_prefix . 'bp_activity_user_activity_cached',$table_prefix . 'bp_friends',$table_prefix . 'bp_groups',$table_prefix . 'bp_groups_groupmeta',$table_prefix . 'bp_groups_members',$table_prefix . 'bp_groups_wire',$table_prefix . 'bp_messages_messages',$table_prefix . 'bp_messages_notices',$table_prefix . 'bp_messages_notices',$table_prefix . 'bp_messages_recipients',$table_prefix . 'bp_messages_threads',$table_prefix . 'bp_messages_threads',$table_prefix . 'bp_notifications',$table_prefix . 'bp_user_blogs',$table_prefix . 'bp_user_blogs_blogmeta',$table_prefix . 'bp_user_blogs_comments',$table_prefix . 'bp_user_blogs_posts',$table_prefix . 'bp_xprofile_data',$table_prefix . 'bp_xprofile_fields',$table_prefix . 'bp_xprofile_groups',$table_prefix . 'bp_xprofile_wire',$table_prefix . 'bp_activity',$table_prefix . 'bp_activity_meta');
//	add_global_table(TABLE_NAME)
function add_global_table($table_name) {
	global $global_tables;
	array_push ($global_tables,$table_name);
}
$vip_blogs = array ();
//	add_vip_blog(BLOG_ID, DS)
function add_vip_blog($blog_id, $dataset) {
	global $vip_blogs, $vip_blogs_datasets;
	array_push ($vip_blogs,$blog_id);
	$vip_blogs_datasets[$blog_id] = $dataset;
}
$dc_ips = array();
//	add_dc_ip(IP, DC)
function add_dc_ip($ip, $dc) {
	global $dc_ips;
	$dc_ips[$ip] = $dc;
}
require_once( ABSPATH . 'wp-content/db-config.php' );
foreach ( $dc_ips as $dc_ip => $dc ) {
	if ( substr($_SERVER['SERVER_ADDR'], 0, strlen($dc_ip)) == $dc_ip ) {
		define( 'DATACENTER', $dc );
		break;
	}
}
if ( file_exists( ABSPATH . 'wp-content/db-list.php' ) ) {
	require_once( ABSPATH . 'wp-content/db-list.php' );
}

// To allow extending of database class
$wpdb = 'we-need-to-pre-populate-this-variable';
require_once( ABSPATH . 'wp-includes/wp-db.php' );

if (!defined('MULTI_DB_VERSION')) define('MULTI_DB_VERSION', '2.9.2');
if (!defined('WP_USE_MULTIPLE_DB')) define('WP_USE_MULTIPLE_DB', false );
if (!defined('DB_SCALING')) define ('DB_SCALING', '16');
if (!defined('SAVEQUERIES')) define('SAVEQUERIES', false);
if (!defined('EZSQL_VERSION')) define('EZSQL_VERSION', 'WP1.25');
if (!defined('OBJECT')) define('OBJECT', 'OBJECT', true);
if (!defined('OBJECT_K')) define('OBJECT_K', 'OBJECT_K', false);
if (!defined('ARRAY_A')) define('ARRAY_A', 'ARRAY_A', false);
if (!defined('ARRAY_N')) define('ARRAY_N', 'ARRAY_N', false);


class m_wpdb extends wpdb {

	var $dbh_connections = array();
	var $open_connections = array();
	var $max_connections = 10;

	var $srtm = false;

	var $dbh;	// will now always hold the global database
	var $dbhglobal; //

	/**
	 * Connects to the database server and selects a database
	 * @param string $dbuser
	 * @param string $dbpassword
	 * @param string $dbname
	 * @param string $dbhost
	 */

	function m_wpdb( $dbuser, $dbpassword, $dbname, $dbhost ) {
		return $this->__construct( $dbuser, $dbpassword, $dbname, $dbhost );
	}

	function __construct( $dbuser, $dbpassword, $dbname, $dbhost ) {

		register_shutdown_function( array( &$this, '__destruct' ) );

		if ( WP_DEBUG )
			$this->show_errors();

		if ( is_multisite() ) {
			$this->charset = 'utf8';
			if ( defined( 'DB_COLLATE' ) && DB_COLLATE )
				$this->collate = DB_COLLATE;
			else
				$this->collate = 'utf8_general_ci';
		} elseif ( defined( 'DB_COLLATE' ) ) {
			$this->collate = DB_COLLATE;
		}

		if ( defined( 'DB_CHARSET' ) )
			$this->charset = DB_CHARSET;

		$this->dbuser = $dbuser;

		// Try to connect to the database
		$global = $this->get_global_read();

		$this->dbhglobal = @mysql_connect( $global['host'], $global['user'], $global['password'], true );
		$this->dbh = @mysql_connect( $global['host'], $global['user'], $global['password'], true );

		if ( !$this->dbhglobal ) {
			$this->bail( sprintf( /*WP_I18N_DB_CONN_ERROR*/"
	<h1>Error finding a global database</h1>
	<p>This either means that the username and password information in your <code>db-config.php</code> file is incorrect, you haven't declared a global database or we can't contact the global database server. This could mean your host's database server is down.</p>
	<ul>
		<li>Are you sure you have the correct username and password?</li>
		<li>Are you sure that you have typed the correct hostname?</li>
		<li>Are you sure that the database server is running?</li>
	</ul>
	<p>If you're unsure what these terms mean you should probably contact your host. If you still need help you can always visit the <a href='http://wordpress.org/support/'>WordPress Support Forums</a>.</p>
	"/*/WP_I18N_DB_CONN_ERROR*/ ), 'db_connect_fail' );
		}

		$this->ready = true;

		if ( $this->has_cap( 'collation' ) && !empty( $this->charset ) ) {
			if ( function_exists( 'mysql_set_charset' ) ) {
				mysql_set_charset( $this->charset, $this->dbhglobal );
				$this->real_escape = true;
			} else {
				$query = $this->prepare( 'SET NAMES %s', $this->charset );
				if ( ! empty( $this->collate ) )
					$query .= $this->prepare( ' COLLATE %s', $this->collate );
				$this->query( $query );
			}
		}

		$this->select( $global['name'], $this->dbhglobal );


	}

	function get_global_read() {
		global $db_servers;

		if(is_array($db_servers['global'])) {
			if(count($db_servers['global']) > 1) {
				foreach($db_servers['global'] as $global) {
					if($global['dc'] == DATACENTER && $global['read'] > 0) {
						return $global;
					}
				}
				// If still here we can't find a local readable global database so return first readable one
				foreach($db_servers['global'] as $global) {
					if($global['read'] > 0) {
						return $global;
					}
				}
				// Nope, none of those either so exit.
				return false;
			} else {
				return $db_servers['global'][0];
			}
		} else {
			return false;
		}
	}


	//------------------------------------------------------------------------//
	//---Multi-DB-------------------------------------------------------------//
	//------------------------------------------------------------------------//

	function db_connect( $query = 'SELECT' ) {
		global $db_servers, $current_connection;

		//dbh_connections

		if ( empty( $query ) )
			return false;

		$query_data = $this->analyze_query( $query );

		$this->last_table = $query_data['table_name'];
		$this->last_db_used = $query_data['query_type'];

		// Send reads to the master for a few seconds after a write to user db or global db.
		// This ought to help with accidental post regressions and other replication issues.
		if ( $query_data['query_type'] == 'write' ) {
			$this->srtm = true;
			$operation = 'write';
		} else {
			$operation = 'read';
		}

		// Return a global read database as if already have it connected
		if($operation == 'read' && $query_data['dataset'] == 'global' && is_resource($this->dbhglobal)) {
			return $this->dbhglobal;
		}

		if ( $query_data['query_type'] == 'write' && defined( 'MASTER_DB_DEAD' ) ) {
			die("We're updating the database, please try back in 5 minutes. If you are posting to your blog please hit the refresh button on your browser in a few minutes to post the data again. It will be posted as soon as the database is back online again.");
		}

		if(isset($this->dbh_connections[ $query_data['dataset'] ]) && is_resource($this->dbh_connections[ $query_data['dataset'] ]['connection']) && $this->dbh_connections[ $query_data['dataset'] ][ $operation ] > 0) {
			// we're already connected.

			// Found one we can use - hoorah
			$dbh =& $this->dbh_connections[ $query_data['dataset'] ]['connection'];
			$this->select( $this->dbh_connections[ $query_data['dataset'] ]['name'], $dbh);

			// reset the connections
			if ( $k = array_search($query_data['dataset'], $this->open_connections) ) {
				unset($this->open_connections[$k]);
				$this->open_connections[] = $query_data['dataset'];
			}
			//echo $operation . " - " . $query_data['dataset'] . " - " . $query . "\n";
			return $dbh; // all done for now - off we go
		}

		// Group eligible servers by R (plus 10,000 if remote)
		$server_groups = array();
		foreach ( $db_servers[$query_data['dataset']] as $server ) {
			 // they don't want us to use this server for this operations
			if ( $server[$operation] < 1 )
				continue;

			// Add a penality to those dbs not in our datacenter
			if ( $server['dc'] != DATACENTER )
				$server[$operation] += 10000;

			if ( isset($_server) && is_array($_server) )
				$server = array_merge($server, $_server);

			// Try the local hostname first when connecting within the DC
			if ( $server['dc'] == DATACENTER ) {
				$lserver = $server;
				$lserver['host'] = $lserver['lhost'];
				$server_groups[$server[$operation] - 0.5][] = $lserver;
			}

			$server_groups[$server[$operation]][] = $server;
		}

		// Randomize each group and add its members to
		$servers = array();
		ksort($server_groups);
		foreach ( $server_groups as $group ) {
			if ( count($group) > 1 )
				shuffle($group);
			$servers = array_merge($servers, $group);
		}

		// Connect to a database server
		foreach ( $servers as $server ) {
			//$this->timer_start();
			$host = $server['host'];

			$dbh = @mysql_connect( $host, $server['user'], $server['password'] );
			
			// For every new connection we should set the character set
			if ( $this->has_cap( 'collation' ) && !empty( $this->charset ) ) {
				if ( function_exists( 'mysql_set_charset' ) ) {
					mysql_set_charset( $this->charset, $this->dbhglobal );
					$this->real_escape = true;
				} else {
					$query = $this->prepare( 'SET NAMES %s', $this->charset );
					if ( ! empty( $this->collate ) )
						$query .= $this->prepare( ' COLLATE %s', $this->collate );
					@mysql_query( $query );
				}
			}

			if ( isset($dbh) && is_resource($dbh) )  {

				$this->dbh_connections[ $query_data['dataset'] ]['connection'] = $dbh;
				$this->dbh_connections[ $query_data['dataset'] ]['name'] = $server['name'];
				$this->dbh_connections[ $query_data['dataset'] ]['ds'] = $server['ds'];
				$this->dbh_connections[ $query_data['dataset'] ]['dc'] = $server['dc'];
				$this->dbh_connections[ $query_data['dataset'] ]['read'] = $server['read'];
				$this->dbh_connections[ $query_data['dataset'] ]['write'] = $server['write'];
				$this->dbh_connections[ $query_data['dataset'] ]['host'] = $server['host'];
				$this->dbh_connections[ $query_data['dataset'] ]['user'] = $server['user'];
				$this->dbh_connections[ $query_data['dataset'] ]['password'] = $server['password'];
				$this->dbh_connections[ $query_data['dataset'] ]['lhost'] = $server['lhost'];
				$dbhname = $server['name'];

				$this->open_connections[] = $query_data['dataset'];

				break;
			}
		} // end foreach ( $servers as $server )

		if ( !isset($dbh) && !is_resource($dbh) )
			$this->bail( sprintf( /*WP_I18N_DB_CONN_ERROR*/"
<h1>Error finding a database server</h1>
<p>This either means that the username and password information in your <code>db-config.php</code> file is incorrect, you haven't declared a global database or we can't contact the global database server. This could mean your host's database server is down.</p>
<ul>
	<li>Are you sure you have the correct username and password?</li>
	<li>Are you sure that you have typed the correct hostname?</li>
	<li>Are you sure that the database server is running?</li>
</ul>
<p>If you're unsure what these terms mean you should probably contact your host. If you still need help you can always visit the <a href='http://wordpress.org/support/'>WordPress Support Forums</a>.</p>
"/*/WP_I18N_DB_CONN_ERROR*/ ), 'db_connect_fail' );

		$this->select( $dbhname, $dbh );


		//while ( count($this->open_connections) > $this->max_connections )
		//	$this->disconnect(array_shift($this->open_connections));

		return $dbh;
	}

	function disconnect($dbhname) {
		if ( $k = array_search($dbhname, $this->open_connections) )
			unset($this->open_connections[$k]);

		if ( is_resource($this->dbh_connections[ $dbhname ]['connection']) ) {
			mysql_close($this->dbh_connections[ $dbhname ]['connection']);
			unset($this->dbh_connections[ $dbhname ]);
		}

	}

	function query($query) {
		$query_data = $this->analyze_query( $query );

		if ( ! $this->ready )
			return false;

		// some queries are made before the plugins have been loaded, and thus cannot be filtered with this method
		if ( function_exists( 'apply_filters' ) )
			$query = apply_filters( 'query', $query );

		$return_val = 0;
		$this->flush();

		// Log how the function was called
		$this->func_call = "\$db->query(\"$query\")";

		// Keep track of the last query for debug..
		$this->last_query = $query;

		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES )
			$this->timer_start();

		// use $this->dbh for read ops, and $this->dbhwrite for write ops
		// use $this->dbhglobal for gloal table ops
		//unset( $dbh );

		// Test the global is set and if not then set it

		$dbh = $this->db_connect( $query );
		if(!is_resource($dbh)) {
			$this->bail( sprintf( /*WP_I18N_DB_CONN_ERROR*/"
<h1>Error finding a database server</h1>
<p>This either means that the username and password information in your <code>db-config.php</code> file is incorrect, you haven't declared a global database or we can't contact the global database server. This could mean your host's database server is down.</p>
<ul>
	<li>Are you sure you have the correct username and password?</li>
	<li>Are you sure that you have typed the correct hostname?</li>
	<li>Are you sure that the database server is running?</li>
</ul>
<p>If you're unsure what these terms mean you should probably contact your host. If you still need help you can always visit the <a href='http://wordpress.org/support/'>WordPress Support Forums</a>.</p>
"/*/WP_I18N_DB_CONN_ERROR*/ ), 'db_connect_fail' );
		}

		$this->result = @mysql_query( $query, $dbh );
		$this->num_queries++;

		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES )
			$this->queries[] = array( $query, $this->timer_stop(), $this->get_caller() );

		// If there is an error then take note of it..
		if ( is_resource( $dbh ) && $this->last_error = mysql_error( $dbh ) ) {
			$this->print_error();
			return false;
		}

		if(!is_resource( $dbh )) {
			echo "oops";
		}

		if ( preg_match( "/^\\s*(insert|delete|update|replace|alter) /i", $query ) ) {
			$this->rows_affected = mysql_affected_rows( $dbh );
			// Take note of the insert_id
			if ( preg_match( "/^\\s*(insert|replace) /i", $query ) ) {
				$this->insert_id = mysql_insert_id($dbh);
			}
			// Return number of rows affected
			$return_val = $this->rows_affected;
		} else {
			$i = 0;
			while ( $i < @mysql_num_fields( $this->result ) ) {
				$this->col_info[$i] = @mysql_fetch_field( $this->result );
				$i++;
			}
			$num_rows = 0;
			while ( $row = @mysql_fetch_object( $this->result ) ) {
				$this->last_result[$num_rows] = $row;
				$num_rows++;
			}

			@mysql_free_result( $this->result );

			// Log number of rows the query returned
			// and return number of rows selected
			$this->num_rows = $num_rows;
			$return_val     = $num_rows;
		}

		if(!empty($this->last_result)) {
			//print_r($this->last_result);
		} else {
			//echo "no data\n";
		}

		return $return_val;
	}

	function analyze_query ( $query ) {
		global $original_table_prefix, $global_tables, $vip_blogs, $vip_blogs_datasets;
		//Save Query
		$original_query = $query;
		//Table
		If( substr( $query, -1 ) == ';' )
			$query = substr( $query, 0, -1 );
		if ( preg_match('/^\s*SELECT.*?\s+FROM\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*UPDATE IGNORE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*UPDATE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*INSERT INTO\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*REPLACE INTO\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*INSERT IGNORE INTO\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*REPLACE INTO\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*DELETE\s+FROM\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*(?:TRUNCATE|RENAME|OPTIMIZE|LOCK|UNLOCK)\s+TABLE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^SHOW TABLE STATUS (LIKE|FROM) \'?`?(\w+)\'?`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^SHOW TABLES LIKE \'?`?(\w+)\'?`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^SHOW INDEX FROM `?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^SHOW\s+\w*\s*COLUMNS (?:FROM|IN) `?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*SHOW CREATE TABLE `?(\w+?)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^SHOW CREATE TABLE (wp_[a-z0-9_]+)/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*CREATE\s+TABLE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*DROP\s+TABLE\s+IF\s+EXISTS\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*DROP\s+TABLE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*DESCRIBE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*ALTER\s+TABLE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$table_name = $maybe[1];
		} else if ( preg_match('/^\s*SELECT.*?\s+FOUND_ROWS\(\)/is', $query) ) {
			$table_name = $this->last_table;
		} else {
			$table_name = 'unknown';
		}
		//Global/Blog Table
		if ( in_array($table_name, $global_tables) || in_array(str_replace($original_table_prefix,'',$table_name), $global_tables) ) {
			$table_type = 'global';
		} else {
			$table_type = 'blog';
		}
		//Get Saved Query
		 $query = $original_query;
		//Get Blog ID
		if ( $table_type == 'blog' ){
			$match = $table_name;
			$base_table_name = str_replace($original_table_prefix,'',$table_name);
			preg_match("|[0-9]{1,20}_?|",$base_table_name,$base_match);

			if(isset($base_match[0])) {
				$base_table_name = str_replace($base_match[0],'',$base_table_name);
			}

			if(preg_match("|" . $original_table_prefix . "[0-9]{1,20}_?" . $base_table_name . "|",$match,$match) == true) {
				$blog_id = str_replace($original_table_prefix,'',$match[0]);
				$blog_id = str_replace('_' . $base_table_name,'',$blog_id);
			}
		} else {
			$blog_id = 'global';
		}
		//Get Saved Query
		 $query = $original_query;
		//Read/Write Query
		if ( substr( $query, -1 ) == ';' ) {
			$query = substr( $query, 0, -1 );
		}
		if ( preg_match('/^\s*SELECT.*?\s+FROM\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'read';
		}
		if ( preg_match('/^\s*UPDATE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*INSERT INTO\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*REPLACE INTO\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*INSERT IGNORE INTO\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*DELETE\s+FROM\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*OPTIMIZE\s+TABLE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^SHOW TABLE STATUS (LIKE|FROM) \'?`?(\w+)\'?`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*CREATE\s+TABLE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*SHOW CREATE TABLE `?(\w+?)`?.*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*DROP\s+TABLE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*DROP\s+TABLE\s+IF\s+EXISTS\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*ALTER\s+TABLE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*DESCRIBE\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'read';
		}
		if ( preg_match('/^\s*SHOW\s+INDEX\s+FROM\s+`?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'read';
		}
		if ( preg_match('/^SHOW\s+\w*\s*COLUMNS (?:FROM|IN) `?(\w+)`?\s*/is', $query, $maybe) ) {
			$query_type = 'read';
		}
		if ( preg_match('/^\s*SELECT.*?\s+FOUND_ROWS\(\)/is', $query) ) {
			$query_type = 'read';
		}
		if ( preg_match('/^\s*RENAME\s+TABLE\s+/i', $query) ) {
			$query_type = 'write';
		}
		if ( preg_match('/^\s*TRUNCATE\s|TABLE\s+/i', $query) ) {
			$query_type = 'write';
		}
		//Dataset
		if ( $table_type == 'global' ) {
			$dataset = 'global';
		} elseif( $table_type == 'blog' ) {
			//Is VIP?
			if ( !empty($blog_id) && in_array($blog_id, $vip_blogs) ) {
				//VIP Blog
				$dataset = $vip_blogs_datasets[$blog_id];
			} else {
				//Not VIP Blog
				// Check if the blog_id is set.
				if(empty($blog_id)) {
					// we are on a multi-site blog without a number, or we have an unidentified global table
					$blog_id = 'global';
					$dataset = 'global';
				} else {
					$hash_value = md5($blog_id);
					if (DB_SCALING == '16'){
						$dataset = substr($hash_value, 0, 1);
					} else if (DB_SCALING == '256'){
						$dataset = substr($hash_value, 0, 2);
					} else if (DB_SCALING == '4096'){
						$dataset = substr($hash_value, 0, 3);
					} else {
						$dataset = substr($hash_value, 0, 1);
					}
				}
			}
		}
		$return['table_name'] = $table_name;
		$return['table_type'] = $table_type;
		$return['blog_id'] = $blog_id;
		$return['query_type'] = $query_type;
		$return['dataset'] = $dataset;

		return $return;
	}

	function send_reads_to_masters() {
		$this->srtm = true;
	}

	/**
	 * Real escape, using mysql_real_escape_string() or addslashes()
	 *
	 * @see mysql_real_escape_string()
	 * @see addslashes()
	 * @since 2.8
	 * @access private
	 *
	 * @param  string $string to escape
	 * @return string escaped
	 */
	function _real_escape( $string ) {
		if ( is_resource($this->dbhglobal) && $this->real_escape )
			return mysql_real_escape_string( $string, $this->dbhglobal );
		else
			return addslashes( $string );
	}

	/**
	 * The database version number.
	 *
	 * @return false|string false on failure, version number on success
	 */
	function db_version() {
		return preg_replace( '/[^0-9.].*/', '', mysql_get_server_info( $this->dbhglobal ) );
	}

	//------------------------------------------------------------------------//
}

$wpdb = new m_wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
