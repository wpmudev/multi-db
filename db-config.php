<?php
//	Plugin Name: Multi-DB
//	Plugin URI: http://premium.wpmudev.org/project/Multiple-Databases
//	Author: Andrew Billits (Incsub)
//  Version: 2.9.2
//------------------------------------------------------------------------//
//---DB Scaling-----------------------------------------------------------//
//------------------------------------------------------------------------//
//	16,256,4096
define ('DB_SCALING', '16');
//------------------------------------------------------------------------//
//---DC IPs---------------------------------------------------------------//
//------------------------------------------------------------------------//
//	Usage: add_dc_ip(IP, DC)
//	EX: add_dc_ip('123.123.123.', 'dc1');
add_dc_ip('123.123.123.', 'dc1');
//------------------------------------------------------------------------//
//---Global Tables--------------------------------------------------------//
//------------------------------------------------------------------------//
//	Do not include default global tables
//	Leave off base prefix (eg: wp_)
//
//	Usage: add_global_table(TABLE_NAME)
//	EX: add_global_table('something');
add_global_table('something');
//------------------------------------------------------------------------//
//---DB Servers-----------------------------------------------------------//
//------------------------------------------------------------------------//
//	Database servers grouped by dataset.
//	R can be 0 (no reads) or a positive integer indicating the order
//	in which to attempt communication (all locals, then all remotes)
//
//	Usage: add_db_server(DS, DC, READ, WRITE, HOST, LAN_HOST, NAME, USER, PASS)
//	EX: add_db_server('global', 'dc1', 1, 1,'global.mysql.example.com:3509','global.mysql.example.lan:3509', 'global-db', 'globaluser',  'globalpassword');
//
//	Note: you can also place this section in a file called db-list.php in wp-content
//  EX: add_db_server('global', 'dc1', 1, 1,'global.mysql.example.com:3509','global.mysql.example.lan:3509', 'global-db', 'globaluser',  'globalpassword');
//------------------------------------------------------------------------//
//---VIP Blogs------------------------------------------------------------//
//------------------------------------------------------------------------//
//	Usage: add_vip_blog(BLOG_ID, DS)
//	EX: add_vip_blog(1, 'vip1');

?>