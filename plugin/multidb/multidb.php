<?php
/*
Plugin Name: Multi-db plugin
Plugin URI:
Description: This plugin allows you to setup and monitor your Multi-database installation
Author: Barry
Version: 1.0
Author URI: http://incsub.com
WDP ID: 1
Network: True
*/

class multidb {

	var $db;

	function __construct() {

		global $wpdb;

		$this->db =& $wpdb;

		add_action( 'plugins_loaded', array(&$this, 'load_textdomain'));

		add_action('init', array(&$this, 'initialise_plugin'));

		add_action('load-toplevel_page_multidb', array(&$this, 'add_admin_header_multidb'));
		//add_action('load-autoblog_page_autoblog_admin', array(&$this, 'add_admin_header_autoblog_admin'));
		//add_action('load-autoblog_page_autoblog_options', array(&$this, 'add_admin_header_autoblog_options'));
		//add_action('load-autoblog_page_autoblog_plugins', array(&$this, 'add_admin_header_autoblog_plugins'));


		if(function_exists('is_multisite') && is_multisite()) {
			if(function_exists('is_network_admin') && is_network_admin()) {
				add_action('network_admin_menu', array(&$this,'add_adminmenu'));
			}
		}
	}

	function multidb() {
		$this->__construct();
	}

	function initialise_plugin() {

	}

	function load_textdomain() {
		$locale = apply_filters( 'autoblog_locale', get_locale() );
		$mofile = autoblog_dir( "autoblogincludes/languages/autoblog-$locale.mo" );

		if ( file_exists( $mofile ) )
			load_textdomain( 'autoblogtext', $mofile );
	}

	function add_adminmenu() {

		global $menu, $admin_page_hooks;

		if(function_exists('is_multisite') && is_multisite()) {
			if(function_exists('is_plugin_active_for_network') && is_plugin_active_for_network('multidb/multidb.php')) {
				if(function_exists('is_network_admin') && is_network_admin()) {
					add_menu_page(__('Multi DB','multidb'), __('Multi DB','multidb'), 'manage_options',  'multidb', array(&$this,'handle_dash_page'), multidbg_url('images/menu.png'));
				}
			}
		}


		// Fix WP translation hook issue
		if(isset($admin_page_hooks['multidb'])) {
			$admin_page_hooks['autoblog'] = 'multidb';
		}

		// Add the sub menu
		add_submenu_page('autoblog', __('Edit feeds','autoblog'), __('Edit feeds','autoblog'), 'manage_options', "autoblog_admin", array(&$this,'handle_admin_page'));

		do_action('multidb_network_menu');

	}

}

?>