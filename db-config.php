<?php
//	Multi-DB plugin's database configuration file
//	Plugin URI https://premium.wpmudev.org/project/multi-db/

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
add_dc_ip('127.0.0.', 'dc1');

//------------------------------------------------------------------------//
//---Global Tables--------------------------------------------------------//
//------------------------------------------------------------------------//
//	Do not include default global tables
//	Leave off base prefix (eg: wp_)
//  You don't really have to register these, they will work fine without.
//  However registering at least your busiest ones might shave a few milliseconds off by avoiding some regexes.
//
//	Usage: add_global_table(TABLE_NAME)
//	EX: add_global_table('something');
add_global_table('affiliatedata');
add_global_table('affiliatereferrers');
add_global_table('am_actions');
add_global_table('am_queue');
add_global_table('am_schedule');
add_global_table('autoblog');

add_global_table('bp_activity');
add_global_table('bp_activity_meta');
add_global_table('bp_friends');
add_global_table('bp_groups');
add_global_table('bp_groups_groupmeta');
add_global_table('bp_groups_members');
add_global_table('bp_messages_messages');
add_global_table('bp_messages_notices');

add_global_table('bp_messages_recipients');
add_global_table('bp_notifications');
add_global_table('bp_user_blogs');
add_global_table('bp_user_blogs_blogmeta');
add_global_table('bp_xprofile_data');
add_global_table('bp_xprofile_fields');
add_global_table('bp_xprofile_groups');

add_global_table('domain_mapping');

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
add_db_server('global', 'dc1', 1, 1,'localhost','localhost', 'wpglobal', 'root',  'root');

add_db_server('0', 'dc1', 1, 1,'localhost','localhost', 'wp0', 'root',  'root');
add_db_server('1', 'dc1', 1, 1,'localhost','localhost', 'wp1', 'root',  'root');
add_db_server('2', 'dc1', 1, 1,'localhost','localhost', 'wp2', 'root',  'root');
add_db_server('3', 'dc1', 1, 1,'localhost','localhost', 'wp3', 'root',  'root');
add_db_server('4', 'dc1', 1, 1,'localhost','localhost', 'wp4', 'root',  'root');
add_db_server('5', 'dc1', 1, 1,'localhost','localhost', 'wp5', 'root',  'root');
add_db_server('6', 'dc1', 1, 1,'localhost','localhost', 'wp6', 'root',  'root');
add_db_server('7', 'dc1', 1, 1,'localhost','localhost', 'wp7', 'root',  'root');
add_db_server('8', 'dc1', 1, 1,'localhost','localhost', 'wp8', 'root',  'root');
add_db_server('9', 'dc1', 1, 1,'localhost','localhost', 'wp9', 'root',  'root');
add_db_server('a', 'dc1', 1, 1,'localhost','localhost', 'wpa', 'root',  'root');
add_db_server('b', 'dc1', 1, 1,'localhost','localhost', 'wpb', 'root',  'root');
add_db_server('c', 'dc1', 1, 1,'localhost','localhost', 'wpc', 'root',  'root');
add_db_server('d', 'dc1', 1, 1,'localhost','localhost', 'wpd', 'root',  'root');
add_db_server('e', 'dc1', 1, 1,'localhost','localhost', 'wpe', 'root',  'root');
add_db_server('f', 'dc1', 1, 1,'localhost','localhost', 'wpf', 'root',  'root');

//------------------------------------------------------------------------//
//---VIP Blogs------------------------------------------------------------//
//------------------------------------------------------------------------//
//	Usage: add_vip_blog(BLOG_ID, DS)
//  VIP blogs are only useful if they have traffic that warrants them being put on a SEPARATE PHYSICAL SERVER.
//  If you do not plan to put them on their own server, don't use them, it's not worth it!

//	add_vip_blog(1, 'vip1');
