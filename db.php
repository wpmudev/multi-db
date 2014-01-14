<?php
/*
Plugin Name: Multi-DB
Plugin URI: http://premium.wpmudev.org/project/multi-db
Description: Allows you to scale your standard Multisite install to allow for millions of blogs and segment your database across multiple physical servers.
Author: Incsub
Version: 3.2.2
Author URI: http://premium.wpmudev.org/
WDP ID: 1

Extends WordPress DB Class
ORIGINAL CODE FROM:
Justin Vincent (justin@visunet.ie)
http://php.justinvincent.com
*/

// +----------------------------------------------------------------------+
// | Copyright Incsub (http://incsub.com/)                                |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License, version 2, as  |
// | published by the Free Software Foundation.                           |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston,               |
// | MA 02110-1301 USA                                                    |
// +----------------------------------------------------------------------+

global $wpdb, $table_prefix;
global $original_table_prefix, $db_servers, $global_tables, $vip_blogs, $vip_blogs_datasets, $dc_ips;

$original_table_prefix = $table_prefix;
$db_servers = $global_tables = $vip_blogs = $vip_blogs_datasets = $dc_ips = array();

/**
 * Adds database server.
 *
 * @global array $db_servers
 * @param type $ds
 * @param type $dc
 * @param type $read
 * @param type $write
 * @param type $host
 * @param type $lhost
 * @param type $name
 * @param type $user
 * @param type $password
 */
function add_db_server( $ds, $dc, $read, $write, $host, $lhost, $name, $user, $password ) {
	global $db_servers;

	$server = compact( 'ds', 'dc', 'read', 'write', 'host', 'name', 'user', 'password' );
	if ( !empty( $lhost ) ) {
		$server['lhost'] = $lhost;
	}

	$db_servers[$ds][] = $server;
}

/**
 * Adds global database table.
 *
 * @global type $global_tables
 * @param type $table_name
 */
function add_global_table( $table_name ) {
	global $global_tables;
	$global_tables[$table_name] = $table_name;
}

/**
 * Adds vip blog.
 *
 * @global array $vip_blogs
 * @global array $vip_blogs_datasets
 * @param type $blog_id
 * @param type $dataset
 */
function add_vip_blog( $blog_id, $dataset ) {
	global $vip_blogs, $vip_blogs_datasets;
	$vip_blogs[] = $blog_id;
	$vip_blogs_datasets[$blog_id] = $dataset;
}

/**
 * Adds data center ip.
 *
 * @global type $dc_ips
 * @param type $ip
 * @param type $dc
 */
function add_dc_ip( $ip, $dc ) {
	global $dc_ips;
	$dc_ips[$ip] = $dc;
}

// setup the list of known global database tables
add_global_table( 'blogs' );
add_global_table( 'blog_versions' );
add_global_table( 'registration_log' );
add_global_table( 'signups' );
add_global_table( 'site' );
add_global_table( 'sitecategories' );
add_global_table( 'sitemeta' );
add_global_table( 'usermeta' );
add_global_table( 'users' );
add_global_table( 'bp_activity_sitewide' );
add_global_table( 'bp_activity_user_activity' );
add_global_table( 'bp_activity_user_activity_cached' );
add_global_table( 'bp_friends' );
add_global_table( 'bp_groups' );
add_global_table( 'bp_groups_groupmeta' );
add_global_table( 'bp_groups_members' );
add_global_table( 'bp_groups_wire' );
add_global_table( 'bp_messages_messages' );
add_global_table( 'bp_messages_notices' );
add_global_table( 'bp_messages_notices' );
add_global_table( 'bp_messages_recipients' );
add_global_table( 'bp_messages_threads' );
add_global_table( 'bp_messages_threads' );
add_global_table( 'bp_notifications' );
add_global_table( 'bp_user_blogs' );
add_global_table( 'bp_user_blogs_blogmeta' );
add_global_table( 'bp_user_blogs_comments' );
add_global_table( 'bp_user_blogs_posts' );
add_global_table( 'bp_xprofile_data' );
add_global_table( 'bp_xprofile_fields' );
add_global_table( 'bp_xprofile_groups' );
add_global_table( 'bp_xprofile_wire' );
add_global_table( 'bp_activity' );
add_global_table( 'bp_activity_meta' );

require_once WP_CONTENT_DIR . '/db-config.php';

if ( !defined( 'DATACENTER' ) ) {
	foreach ( $dc_ips as $dc_ip => $dc ) {
		if ( substr( $_SERVER['SERVER_ADDR'], 0, strlen( $dc_ip ) ) == $dc_ip ) {
			define( 'DATACENTER', $dc );
			break;
		}
	}
}

if ( file_exists( WP_CONTENT_DIR . '/db-list.php' ) ) {
	require_once WP_CONTENT_DIR . '/db-list.php';
}

// To allow extending of database class
$wpdb = 'we-need-to-pre-populate-this-variable';
require_once ABSPATH . WPINC . '/wp-db.php';

if ( !defined( 'MULTI_DB_VERSION' ) )   define( 'MULTI_DB_VERSION', '3.2.2' );
if ( !defined( 'WP_USE_MULTIPLE_DB' ) ) define( 'WP_USE_MULTIPLE_DB', false );
if ( !defined( 'DB_SCALING' ) )         define( 'DB_SCALING', '16' );
if ( !defined( 'EZSQL_VERSION' ) )      define( 'EZSQL_VERSION', 'WP1.25' );
if ( !defined( 'OBJECT' ) )             define( 'OBJECT', 'OBJECT', true );
if ( !defined( 'OBJECT_K' ) )           define( 'OBJECT_K', 'OBJECT_K', false );
if ( !defined( 'ARRAY_A' ) )            define( 'ARRAY_A', 'ARRAY_A', false );
if ( !defined( 'ARRAY_N' ) )            define( 'ARRAY_N', 'ARRAY_N', false );

/**
 * Multi-DB database access abstraction class.
 */
class m_wpdb extends wpdb {

	/**
	 * The array of open connections.
	 *
	 * @access protected
	 * @var array
	 */
	var $dbh_connections = array();

	/**
	 * The maximum number of open connections.
	 *
	 * @access protected
	 * @var type
	 */
	var $max_connections = 10;

	/**
	 * Current database handle
	 *
	 * @access protected
	 * @var resource
	 */
	var $dbh;

	/**
	 * Global database handle
	 *
	 * @access protected
	 * @var resource
	 */
	var $dbhglobal;

	/**
	 * The array containing the last query data received from analyze_query method.
	 *
	 * @access protected
	 * @var array
	 */
	protected $_last_query_data;

	/**
	 * Connects to the database server and selects a database
	 *
	 * @access public
	 * @param string $dbuser MySQL database user
	 * @param string $dbpassword MySQL database password
	 * @param string $dbname MySQL database name
	 * @param string $dbhost MySQL database host
	 */
	public function __construct( $dbuser, $dbpassword, $dbname, $dbhost ) {
		register_shutdown_function( array( $this, '__destruct' ) );

		if ( WP_DEBUG && WP_DEBUG_DISPLAY ) {
			$this->show_errors();
		}

		$this->init_charset();

		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbname = $dbname;
		$this->dbhost = $dbhost;

		// Try to connect to the database
		$global = $this->_get_global_read();
		$this->dbhglobal = @mysql_connect( $global['host'], $global['user'], $global['password'], true );
		$this->dbh = @mysql_connect( $global['host'], $global['user'], $global['password'], true );

		if ( !$this->dbhglobal ) {
			$this->_bail_db_connection_error();
		}

		$this->set_charset( $this->dbhglobal );
		$this->ready = true;
		$this->select( $global['name'], $this->dbhglobal );
	}

	/**
	 * Wraps database connection error in a nice header and footer and dies.
	 * Will not die if wpdb::$show_errors is false.
	 *
	 * @access private
	 * @return false|void
	 */
	private function _bail_db_connection_error() {
		return $this->bail( sprintf( /*WP_I18N_DB_CONN_ERROR*/"
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

	/**
	 * Returns global database information
	 *
	 * @access private
	 * @global array $db_servers The array of databases.
	 * @return boolean|array The global database information on success, otherwise FALSE.
	 */
	private function _get_global_read() {
		global $db_servers;

		if ( is_array( $db_servers['global'] ) ) {
			if ( count( $db_servers['global'] ) > 1 ) {
				$dc = defined( 'DATACENTER' ) ? DATACENTER : false;
				foreach ( $db_servers['global'] as $global ) {
					if ( $global['dc'] == $dc && $global['read'] > 0 ) {
						return $global;
					}
				}

				// If still here we can't find a local readable global database so return first readable one
				foreach ( $db_servers['global'] as $global ) {
					if ( $global['read'] > 0 ) {
						return $global;
					}
				}

				// Nope, none of those either so exit.
				return false;
			} else {
				return $db_servers['global'][0];
			}
		}

		return false;
	}

	/**
	 * Real escapes, using mysql_real_escape_string() or addslashes()
	 *
	 * @see mysql_real_escape_string()
	 * @see addslashes()
	 *
	 * @access private
	 * @param  string $string The string to escape.
	 * @return string Escaped string.
	 */
	function _real_escape( $string ) {
		if ( is_resource( $this->dbhglobal ) )
			return mysql_real_escape_string( $string, $this->dbhglobal );
		else
			return addslashes( $string );
	}

	/**
	 * Returns global database version number.
	 *
	 * @access public
	 * @return false|string The version number on success, otherwise FALSE.
	 */
	public function db_version() {
		return is_resource( $this->dbhglobal )
			? preg_replace( '/[^0-9.].*/', '', @mysql_get_server_info( $this->dbhglobal ) )
			: false;
	}

	/**
	 * Returns all tables available in the database.
	 *
	 * @filter tables_to_repair
	 *
	 * @access public
	 * @param array $tables The initial array of tables.
	 * @return array The array of database tables.
	 */
	public function get_all_tables( $tables ) {
		$blogs_ids = $this->get_col( "SELECT blog_id FROM {$this->base_prefix}blogs WHERE deleted = 0 AND spam = 0 AND archived = '0'" );

		foreach ( $blogs_ids as $blog_id ) {
			$new_tables = $this->get_col( "SHOW TABLES LIKE '{$this->base_prefix}{$blog_id}_%';" );
			if ( $new_tables && is_array( $new_tables ) && count( $new_tables ) > 0 ) {
				$tables = array_merge( $tables, $new_tables );
			}
		}

		return $tables;
	}

	/**
	 * Connects to database based on incoming query.
	 *
	 * @access public
	 * @param string $query The query which will be executed.
	 * @return boolean|resource The database connection resource on success, otherwise FALSE.
	 */
	public function db_connect( $query = 'SELECT 1' ) {
		if ( empty( $query ) ) {
			return false;
		}

		$dbh = false;
		$this->_last_query_data = $query_data = $this->analyze_query( $query );
		$this->last_table = $query_data['table_name'];
		$this->last_db_used = $query_data['query_type'];

		$operation = $query_data['query_type'] == 'write' ? 'write' : 'read';

		// Return a global read database as if already have it connected
		if ( $operation == 'read' && $query_data['dataset'] == 'global' && is_resource( $this->dbhglobal ) ) {
			return $this->dbhglobal;
		}

		if ( $query_data['query_type'] == 'write' && defined( 'MASTER_DB_DEAD' ) ) {
			die( "We're updating the database, please try back in 5 minutes. If you are posting to your blog please hit the refresh button on your browser in a few minutes to post the data again. It will be posted as soon as the database is back online again." );
		}

		// check if we're already connected.
		$dataset_key = "{$query_data['dataset']}.{$operation}";
		if ( isset( $this->dbh_connections[$dataset_key] ) && is_resource( $this->dbh_connections[$dataset_key]['connection'] ) ) {
			return $this->dbh_connections[$dataset_key]['connection'];
		}

		foreach ( self::_get_servers( $query_data['dataset'], $operation ) as $server ) {
			if ( ( $dbh = $this->_connect_to_server( $server, $query_data['dataset'], $operation ) ) ) {
				return $dbh;
			}
		}

		$this->_bail_db_connection_error();
		return false;
	}

	/**
	 * Closes MySQL connection to a database.
	 *
	 * @access public
	 * @param string $dbhname The database name to close connection to.
	 */
	public function disconnect( $dbhname ) {
		if ( isset( $this->dbh_connections[$dbhname]['connection'] ) && is_resource( $this->dbh_connections[$dbhname]['connection'] ) ) {
			@mysql_close( $this->dbh_connections[$dbhname]['connection'] );
			unset( $this->dbh_connections[$dbhname] );
		}
	}

	/**
	 * Sanitizes select query's table names by adding database prefixes.
	 *
	 * This function solves the issue when we have JOINs in a select query,
	 * which connects global tables from global database. For instance:
	 *
	 * SELECT * FROM {$wpdb->posts} AS p LEFT JOIN {$wpdb->users} AS u ON u.ID = p.post_author WHERE p.ID = 2;
	 *
	 * @since 3.1.2
	 * @filter query
	 *
	 * @access public
	 * @global array $global_tables The array of globals tables.
	 * @param string $query The initial query.
	 * @return string Sanitized query.
	 */
	public function sanitize_multidb_query_tables( $query ) {
		global $global_tables;

		// add whitespace at the end of the query to make our patterns working properly
		$query = trim( $query ) . ' ';

		// don't touch non select queries.
		if ( !preg_match( '/^SELECT\s+/is', $query ) ) {
			return $query;
		}

		$global = $this->_get_global_read();
		$prefix = isset( $this->base_prefix ) ? $this->base_prefix : $this->prefix;

		// look through all global tables and add global database prefix if it has been found
		foreach ( $global_tables as $table ) {
			$query = preg_replace( "/\s{$prefix}{$table}(\s|\.|,)/", " {$global['name']}.{$prefix}{$table}$1", $query );
		}

		// look through all local tables and add blog database prefix if it has been found
		if ( $this->blogid > 1 ) {
			$blog_database = self::_get_servers( self::_get_blog_dataset( $this->blogid ), 'read' );
			if ( !empty( $blog_database ) ) {
				$blog_database = $blog_database[0]['name'];
				$query = preg_replace( "/\s{$this->prefix}(.*?)(\s|\.|,|\()/", " {$blog_database}.{$this->prefix}$1$2", $query );
			}
		}

		return trim( $query );
	}

	/**
	 * Performs a MySQL database query, using current database connection.
	 *
	 * @access public
	 * @param string $query Database query to execute.
	 * @return int|false Number of rows affected/selected or false on error
	 */
	public function query( $query ) {
		if ( !$this->ready ) {
			return false;
		}

		// some queries are made before the plugins have been loaded, and thus cannot be filtered with this method
		if ( function_exists( 'apply_filters' ) ) {
			$query = apply_filters( 'query', $query );
		}

		$return_val = 0;
		$this->flush();

		// use $this->dbh for read ops, and $this->dbhwrite for write ops
		// use $this->dbhglobal for gloal table ops
		//unset( $dbh );

		// Test the global is set and if not then set it
		$dbh = $this->db_connect( $query );
		if ( !is_resource( $dbh ) ) {
			$this->_bail_db_connection_error();
			return false;
		}

		// Log how the function was called
		$this->func_call = '$db->query("' . $query . '")';
		// Keep track of the last query for debug..
		$this->last_query = $query;

		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES ) {
			$this->timer_start();
		}

		$this->result = @mysql_query( $query, $dbh );
		$this->num_queries++;

		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES ) {
			$this->queries[] = array( $query, $this->timer_stop(), $this->get_caller() );
		}

		// If there is an error then take note of it..
		if ( is_resource( $dbh ) && ( $this->last_error = mysql_error( $dbh ) ) ) {
			$this->print_error( $this->last_error );
			return false;
		}

		if ( preg_match( "/^\\s*(insert|delete|update|replace|alter) /i", $query ) ) {
			$this->rows_affected = mysql_affected_rows( $dbh );
			// Take note of the insert_id
			if ( preg_match( "/^\\s*(insert|replace) /i", $query ) ) {
				$this->insert_id = mysql_insert_id( $dbh );
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

			// Log number of rows the query returned and return number of rows selected
			$this->num_rows = $num_rows;
			$return_val     = $num_rows;
		}

		return $return_val;
	}

	/**
	 * Returns connection information based on incoming query.
	 *
	 * @access public
	 * @global type $original_table_prefix
	 * @global type $global_tables
	 * @global array $vip_blogs
	 * @global array $vip_blogs_datasets
	 * @param string $query The query string to analyze.
	 * @return array The connection information array.
	 */
	public function analyze_query( $query ) {
		global $original_table_prefix, $global_tables, $vip_blogs, $vip_blogs_datasets;

		// trim query
		$query = rtrim( trim( $query ), ';' );
		// Set initial force local stuff.
		$forcelocal = false;

		$maybe = $return = array();
		$table_name = 'unknown';
		if ( preg_match( '/^SELECT.*?\s+FROM\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^UPDATE IGNORE\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^UPDATE\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^INSERT.*?\s+INTO\s+`?([0-9,a-z,A-Z$_]+)`?[\(\s]/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^REPLACE.*?\s+INTO\s+`?([0-9,a-z,A-Z$_]+)`?[\(\s]/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^DELETE.*?\s+FROM\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^(?:TRUNCATE|RENAME|OPTIMIZE|LOCK|UNLOCK)\s+TABLE\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^(?:TRUNCATE|RENAME|OPTIMIZE|LOCK|UNLOCK)\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^SHOW TABLE STATUS (LIKE|FROM) \'?`?([0-9,a-z,A-Z$_]+)\'?`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^SHOW TABLES LIKE \'?`?([0-9,a-z,A-Z$_]+)\'?`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^SHOW TABLES/is', $query, $maybe ) ) {
			$forcelocal = true;
		} else if ( preg_match( '/^SHOW INDEX FROM `?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^SHOW\s+\w*\s*COLUMNS (?:FROM|IN) `?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS\s+`?([0-9,a-z,A-Z$_]+)`?\s+/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^SHOW CREATE TABLE `?([0-9,a-z,A-Z$_]+?)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^CREATE\s+TABLE\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^DROP\s+TABLE\s+IF\s+EXISTS\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^DROP\s+TABLE\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^DESCRIBE\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^ALTER\s+TABLE\s+`?([0-9,a-z,A-Z$_]+)`?\s+/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^CHECK\s+TABLE\s+?([0-9,a-z,A-Z$_]+)?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else if ( preg_match( '/^ANALYZE\s+TABLE\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query, $maybe ) ) {
			$table_name = $maybe[1];
		} else {
			$select_without_from = preg_match( '/^SELECT\s+/is', $query ) && !preg_match( '/^SELECT.*?\s+FROM\s+`?([0-9,a-z,A-Z$_]+)`?\s*/is', $query );
			$transaction_stuff = preg_match( '/^(START TRANSACTION|BEGIN|COMMIT|ROLLBACK)/is', $query );
			$set = preg_match( '/^SET\s+/is', $query );
			if ( $select_without_from || $transaction_stuff || $set ) {
				if ( $this->_last_query_data ) {
					return $this->_last_query_data;
				}
			}
		}

		$table_name = explode( '.', $table_name );
		$table_name = array_pop( $table_name );

		// determine whether global or blog table type is
		$blog_id = false;
		if ( $forcelocal == true ) {
			$table_type = 'blog';
			$blog_id = $this->blogid;
		} else {
			$base_table_name = substr( $table_name, strlen( $original_table_prefix ) );
			if ( in_array( $base_table_name, $global_tables ) ) {
				// This is a global table
				$table_type = 'global';
				$blog_id = 'global';
			} else {
				// Should be a blog related table
				$table_type = 'blog';

				$base_match = array();
				if ( preg_match( "|^[0-9]{1,20}_?|", $base_table_name, $base_match ) && isset( $base_match[0] ) ) {
					$base_table_name = str_replace( $base_match[0], '', $base_table_name );
				}

				if ( preg_match( "|^{$original_table_prefix}([0-9]{1,20})_?{$base_table_name}|", $table_name, $match ) ) {
					$blog_id = absint( $match[1] );
				}
			}
		}

		$query_type = 'read';
		$patterns = array(
			'/^UPDATE/is',
			'/^INSERT/is',
			'/^REPLACE/is',
			'/^DELETE/is',
			'/^OPTIMIZE/is',
			'/^SHOW\s+TABLE\s+STATUS/is',
			'/^CREATE\s+TABLE/is',
			'/^TRUNCATE\s+TABLE/is',
			'/^SHOW\s+CREATE\s+TABLE/is',
			'/^DROP\s+TABLE/is',
			'/^ALTER\s+TABLE/is',
			'/^RENAME\s+TABLE/i',
		);

		foreach ( $patterns as $pattern ) {
			if ( preg_match( $pattern, $query ) ) {
				$query_type = 'write';
				break;
			}
		}

		// dataset
		if ( $table_type == 'global' ) {
			$dataset = 'global';
		} elseif ( $table_type == 'blog' ) {
			// is VIP?
			if ( in_array( $blog_id, $vip_blogs ) ) {
				// VIP Blog
				$dataset = $vip_blogs_datasets[$blog_id];
			} else {
				// not VIP Blog
				// check if the blog_id is set.
				if ( empty( $blog_id ) ) {
					// we are on a multi-site blog without a number, or we have an unidentified global table
					$blog_id = 'global';
					$dataset = 'global';
				} else {
					$dataset = self::_get_blog_dataset( $blog_id );
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

	/**
	 * Returns blog dataset.
	 *
	 * @since 3.2.0
	 *
	 * @static
	 * @access protected
	 * @param int $blog_id The blog ID.
	 * @return string The dataset string.
	 */
	protected static function _get_blog_dataset( $blog_id ) {
		$hash_value = md5( $blog_id );
		if ( defined( 'DB_SCALING' ) ) {
			if ( DB_SCALING == 4096 ) {
				return substr( $hash_value, 0, 3 );
			} elseif ( DB_SCALING == 256 ) {
				return substr( $hash_value, 0, 2 );
			}
		}

		return substr( $hash_value, 0, 1 );
	}

	/**
	 * Returns the array of appropriate servers to connect to.
	 *
	 * @since 3.2.0
	 *
	 * @static
	 * @access protected
	 * @global array $db_servers The array of database servers.
	 * @param string $dataset The current dataset to use.
	 * @param string $operation The operation type (read/write).
	 * @return array The array of servers to connect to.
	 */
	protected static function _get_servers( $dataset, $operation ) {
		global $db_servers;

		$dc = defined( 'DATACENTER' ) ? DATACENTER : false;

		// Group eligible servers by R (plus 10,000 if remote)
		$server_groups = array();
		if ( isset( $db_servers[$dataset] ) ) {
			foreach ( $db_servers[$dataset] as $server ) {
				if ( $server[$operation] ) {
					// Add a penality to those dbs not in our datacenter
					if ( $server['dc'] != $dc ) {
						$server[$operation] += 10000;
					}

					// Try the local hostname first when connecting within the DC
					if ( $server['dc'] == $dc ) {
						$lserver = $server;
						if ( isset( $lserver['lhost'] ) ) {
							$lserver['host'] = $lserver['lhost'];
						}

						$priority = $server[$operation] - 0.5;
						$server_groups["{$priority}"][] = $lserver;
					}

					$priority = $server[$operation];
					$server_groups["{$priority}"][] = $server;
				}
			}
		}

		// Randomize each group and add its members to
		$servers = array();
		ksort( $server_groups );
		foreach ( $server_groups as $group ) {
			if ( count( $group ) > 1 ) {
				shuffle( $group );
			}

			$servers = array_merge( $servers, $group );
		}

		return $servers;
	}

	/**
	 * Connects to the server.
	 *
	 * @since 3.2.0
	 *
	 * @access protected
	 * @param array $server The server configuration info.
	 * @param string $dataset The current dataset to use.
	 * @param string $operation The operation type (read/write).
	 * @return resource|boolean The MySQL connection on success, otherwise FALSE.
	 */
	protected function _connect_to_server( $server, $dataset, $operation ) {
		$dbh = @mysql_connect( $server['host'], $server['user'], $server['password'], true );
		if ( !is_resource( $dbh ) )  {
			return false;
		}

		$this->set_charset( $dbh );
		$this->select( $server['name'], $dbh );

		// save connection
		$this->dbh_connections["{$dataset}.{$operation}"] = array(
			'connection' => $dbh,
			'name'       => $server['name'],
			'ds'         => $server['ds'],
			'dc'         => $server['dc'],
			'read'       => $server['read'],
			'write'      => $server['write'],
			'host'       => $server['host'],
			'user'       => $server['user'],
			'password'   => $server['password'],
			'lhost'      => isset( $server['lhost'] ) ? $server['lhost'] : '',
		);

		// disconnect old connection if total number of connections more then allowed one
		while ( $this->max_connections > 0 && count( $this->dbh_connections ) > $this->max_connections ) {
			reset( $this->dbh_connections );
			$this->disconnect( key( $this->dbh_connections ) );
		}

		return $dbh;
	}

	/**
	 * Sets blog id.
	 *
	 * @since 3.2.0
	 *
	 * @access public
	 * @param int $blog_id
	 * @param int $site_id Optional.
	 * @return string previous blog id
	 */
	public function set_blog_id( $blog_id, $site_id = 0 ) {
		$old_blog_id = parent::set_blog_id( $blog_id, $site_id );
		if ( $old_blog_id == $blog_id ) {
			return $old_blog_id;
		}

		$dataset = self::_get_blog_dataset( $blog_id );
		foreach ( array( 'write', 'read' ) as $operation ) {
			$dataset_key = "{$dataset}.{$operation}";
			if ( !isset( $this->dbh_connections[$dataset_key] ) || !is_resource( $this->dbh_connections[$dataset_key]['connection'] ) ) {
				foreach ( self::_get_servers( $dataset, $operation ) as $server ) {
					if ( $this->_connect_to_server( $server, $dataset, $operation ) ) {
						break;
					}
				}
			} else {
				// move connection to the end
				$connection = $this->dbh_connections[$dataset_key];
				unset( $this->dbh_connections[$dataset_key] );
				$this->dbh_connections[$dataset_key] = $connection;
			}
		}

		return $old_blog_id;
	}

}

// redefine database connection class
$wpdb = new m_wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );

add_filter( 'tables_to_repair', array( $wpdb, 'get_all_tables' ) );
add_filter( 'query', array( $wpdb, 'sanitize_multidb_query_tables' ) );