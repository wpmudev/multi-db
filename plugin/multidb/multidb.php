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

	}

	function add_adminmenu() {

	}

}

?>