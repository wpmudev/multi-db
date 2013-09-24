<?php
//	Multi-DB plugin's database configuration file
//	Plugin URI http://premium.wpmudev.org/project/Multiple-Databases
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
add_global_table('some_global_table');
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
add_db_server('global', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_global', 'db_user_name',  'db_user_name_pass');

add_db_server('0', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_0', 'db_user_name',  'db_user_name_pass');
add_db_server('1', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_1', 'db_user_name',  'db_user_name_pass');
add_db_server('2', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_2', 'db_user_name',  'db_user_name_pass');
add_db_server('3', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_3', 'db_user_name',  'db_user_name_pass');
add_db_server('4', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_4', 'db_user_name',  'db_user_name_pass');
add_db_server('5', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_5', 'db_user_name',  'db_user_name_pass');
add_db_server('6', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_6', 'db_user_name',  'db_user_name_pass');
add_db_server('7', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_7', 'db_user_name',  'db_user_name_pass');
add_db_server('8', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_8', 'db_user_name',  'db_user_name_pass');
add_db_server('9', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_9', 'db_user_name',  'db_user_name_pass');
add_db_server('a', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_a', 'db_user_name',  'db_user_name_pass');
add_db_server('b', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_b', 'db_user_name',  'db_user_name_pass');
add_db_server('c', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_c', 'db_user_name',  'db_user_name_pass');
add_db_server('d', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_d', 'db_user_name',  'db_user_name_pass');
add_db_server('e', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_e', 'db_user_name',  'db_user_name_pass');
add_db_server('f', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_f', 'db_user_name',  'db_user_name_pass');

add_db_server('vip1', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_vip_1', 'db_user_name',  'db_user_name_pass');
//------------------------------------------------------------------------//
//---VIP Blogs------------------------------------------------------------//
//------------------------------------------------------------------------//
//	Usage: add_vip_blog(BLOG_ID, DS)
//	EX: add_vip_blog(1, 'vip1');

add_vip_blog(1, 'vip1');
?>