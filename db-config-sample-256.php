<?php
//	Plugin Name: Multi-DB
//	Plugin URI: http://premium.wpmudev.org/project/Multiple-Databases
//	Author: Andrew Billits (Incsub)
//  Version: 2.9.2
//------------------------------------------------------------------------//
//---DB Scaling-----------------------------------------------------------//
//------------------------------------------------------------------------//
//	16,256,4096
define ('DB_SCALING', '256');
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

add_db_server('00', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_00', 'db_user_name',  'db_user_name_pass');
add_db_server('01', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_01', 'db_user_name',  'db_user_name_pass');
add_db_server('02', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_02', 'db_user_name',  'db_user_name_pass');
add_db_server('03', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_03', 'db_user_name',  'db_user_name_pass');
add_db_server('04', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_04', 'db_user_name',  'db_user_name_pass');
add_db_server('05', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_05', 'db_user_name',  'db_user_name_pass');
add_db_server('06', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_06', 'db_user_name',  'db_user_name_pass');
add_db_server('07', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_07', 'db_user_name',  'db_user_name_pass');
add_db_server('08', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_08', 'db_user_name',  'db_user_name_pass');
add_db_server('09', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_09', 'db_user_name',  'db_user_name_pass');
add_db_server('0a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_0a', 'db_user_name',  'db_user_name_pass');
add_db_server('0b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_0b', 'db_user_name',  'db_user_name_pass');
add_db_server('0c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_0c', 'db_user_name',  'db_user_name_pass');
add_db_server('0d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_0d', 'db_user_name',  'db_user_name_pass');
add_db_server('0e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_0e', 'db_user_name',  'db_user_name_pass');
add_db_server('0f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_0f', 'db_user_name',  'db_user_name_pass');
add_db_server('10', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_10', 'db_user_name',  'db_user_name_pass');
add_db_server('11', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_11', 'db_user_name',  'db_user_name_pass');
add_db_server('12', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_12', 'db_user_name',  'db_user_name_pass');
add_db_server('13', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_13', 'db_user_name',  'db_user_name_pass');
add_db_server('14', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_14', 'db_user_name',  'db_user_name_pass');
add_db_server('15', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_15', 'db_user_name',  'db_user_name_pass');
add_db_server('16', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_16', 'db_user_name',  'db_user_name_pass');
add_db_server('17', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_17', 'db_user_name',  'db_user_name_pass');
add_db_server('18', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_18', 'db_user_name',  'db_user_name_pass');
add_db_server('19', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_19', 'db_user_name',  'db_user_name_pass');
add_db_server('1a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_1a', 'db_user_name',  'db_user_name_pass');
add_db_server('1b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_1b', 'db_user_name',  'db_user_name_pass');
add_db_server('1c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_1c', 'db_user_name',  'db_user_name_pass');
add_db_server('1d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_1d', 'db_user_name',  'db_user_name_pass');
add_db_server('1e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_1e', 'db_user_name',  'db_user_name_pass');
add_db_server('1f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_1f', 'db_user_name',  'db_user_name_pass');
add_db_server('20', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_20', 'db_user_name',  'db_user_name_pass');
add_db_server('21', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_21', 'db_user_name',  'db_user_name_pass');
add_db_server('22', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_22', 'db_user_name',  'db_user_name_pass');
add_db_server('23', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_23', 'db_user_name',  'db_user_name_pass');
add_db_server('24', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_24', 'db_user_name',  'db_user_name_pass');
add_db_server('25', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_25', 'db_user_name',  'db_user_name_pass');
add_db_server('26', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_26', 'db_user_name',  'db_user_name_pass');
add_db_server('27', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_27', 'db_user_name',  'db_user_name_pass');
add_db_server('28', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_28', 'db_user_name',  'db_user_name_pass');
add_db_server('29', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_29', 'db_user_name',  'db_user_name_pass');
add_db_server('2a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_2a', 'db_user_name',  'db_user_name_pass');
add_db_server('2b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_2b', 'db_user_name',  'db_user_name_pass');
add_db_server('2c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_2c', 'db_user_name',  'db_user_name_pass');
add_db_server('2d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_2d', 'db_user_name',  'db_user_name_pass');
add_db_server('2e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_2e', 'db_user_name',  'db_user_name_pass');
add_db_server('2f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_2f', 'db_user_name',  'db_user_name_pass');
add_db_server('30', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_30', 'db_user_name',  'db_user_name_pass');
add_db_server('31', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_31', 'db_user_name',  'db_user_name_pass');
add_db_server('32', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_32', 'db_user_name',  'db_user_name_pass');
add_db_server('33', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_33', 'db_user_name',  'db_user_name_pass');
add_db_server('34', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_34', 'db_user_name',  'db_user_name_pass');
add_db_server('35', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_35', 'db_user_name',  'db_user_name_pass');
add_db_server('36', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_36', 'db_user_name',  'db_user_name_pass');
add_db_server('37', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_37', 'db_user_name',  'db_user_name_pass');
add_db_server('38', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_38', 'db_user_name',  'db_user_name_pass');
add_db_server('39', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_39', 'db_user_name',  'db_user_name_pass');
add_db_server('3a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_3a', 'db_user_name',  'db_user_name_pass');
add_db_server('3b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_3b', 'db_user_name',  'db_user_name_pass');
add_db_server('3c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_3c', 'db_user_name',  'db_user_name_pass');
add_db_server('3d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_3d', 'db_user_name',  'db_user_name_pass');
add_db_server('3e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_3e', 'db_user_name',  'db_user_name_pass');
add_db_server('3f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_3f', 'db_user_name',  'db_user_name_pass');
add_db_server('40', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_40', 'db_user_name',  'db_user_name_pass');
add_db_server('41', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_41', 'db_user_name',  'db_user_name_pass');
add_db_server('42', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_42', 'db_user_name',  'db_user_name_pass');
add_db_server('43', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_43', 'db_user_name',  'db_user_name_pass');
add_db_server('44', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_44', 'db_user_name',  'db_user_name_pass');
add_db_server('45', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_45', 'db_user_name',  'db_user_name_pass');
add_db_server('46', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_46', 'db_user_name',  'db_user_name_pass');
add_db_server('47', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_47', 'db_user_name',  'db_user_name_pass');
add_db_server('48', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_48', 'db_user_name',  'db_user_name_pass');
add_db_server('49', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_49', 'db_user_name',  'db_user_name_pass');
add_db_server('4a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_4a', 'db_user_name',  'db_user_name_pass');
add_db_server('4b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_4b', 'db_user_name',  'db_user_name_pass');
add_db_server('4c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_4c', 'db_user_name',  'db_user_name_pass');
add_db_server('4d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_4d', 'db_user_name',  'db_user_name_pass');
add_db_server('4e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_4e', 'db_user_name',  'db_user_name_pass');
add_db_server('4f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_4f', 'db_user_name',  'db_user_name_pass');
add_db_server('50', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_50', 'db_user_name',  'db_user_name_pass');
add_db_server('51', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_51', 'db_user_name',  'db_user_name_pass');
add_db_server('52', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_52', 'db_user_name',  'db_user_name_pass');
add_db_server('53', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_53', 'db_user_name',  'db_user_name_pass');
add_db_server('54', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_54', 'db_user_name',  'db_user_name_pass');
add_db_server('55', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_55', 'db_user_name',  'db_user_name_pass');
add_db_server('56', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_56', 'db_user_name',  'db_user_name_pass');
add_db_server('57', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_57', 'db_user_name',  'db_user_name_pass');
add_db_server('58', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_58', 'db_user_name',  'db_user_name_pass');
add_db_server('59', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_59', 'db_user_name',  'db_user_name_pass');
add_db_server('5a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_5a', 'db_user_name',  'db_user_name_pass');
add_db_server('5b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_5b', 'db_user_name',  'db_user_name_pass');
add_db_server('5c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_5c', 'db_user_name',  'db_user_name_pass');
add_db_server('5d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_5d', 'db_user_name',  'db_user_name_pass');
add_db_server('5e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_5e', 'db_user_name',  'db_user_name_pass');
add_db_server('5f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_5f', 'db_user_name',  'db_user_name_pass');
add_db_server('60', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_60', 'db_user_name',  'db_user_name_pass');
add_db_server('61', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_61', 'db_user_name',  'db_user_name_pass');
add_db_server('62', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_62', 'db_user_name',  'db_user_name_pass');
add_db_server('63', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_63', 'db_user_name',  'db_user_name_pass');
add_db_server('64', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_64', 'db_user_name',  'db_user_name_pass');
add_db_server('65', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_65', 'db_user_name',  'db_user_name_pass');
add_db_server('66', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_66', 'db_user_name',  'db_user_name_pass');
add_db_server('67', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_67', 'db_user_name',  'db_user_name_pass');
add_db_server('68', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_68', 'db_user_name',  'db_user_name_pass');
add_db_server('69', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_69', 'db_user_name',  'db_user_name_pass');
add_db_server('6a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_6a', 'db_user_name',  'db_user_name_pass');
add_db_server('6b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_6b', 'db_user_name',  'db_user_name_pass');
add_db_server('6c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_6c', 'db_user_name',  'db_user_name_pass');
add_db_server('6d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_6d', 'db_user_name',  'db_user_name_pass');
add_db_server('6e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_6e', 'db_user_name',  'db_user_name_pass');
add_db_server('6f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_6f', 'db_user_name',  'db_user_name_pass');
add_db_server('70', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_70', 'db_user_name',  'db_user_name_pass');
add_db_server('71', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_71', 'db_user_name',  'db_user_name_pass');
add_db_server('72', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_72', 'db_user_name',  'db_user_name_pass');
add_db_server('73', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_73', 'db_user_name',  'db_user_name_pass');
add_db_server('74', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_74', 'db_user_name',  'db_user_name_pass');
add_db_server('75', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_75', 'db_user_name',  'db_user_name_pass');
add_db_server('76', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_76', 'db_user_name',  'db_user_name_pass');
add_db_server('77', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_77', 'db_user_name',  'db_user_name_pass');
add_db_server('78', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_78', 'db_user_name',  'db_user_name_pass');
add_db_server('79', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_79', 'db_user_name',  'db_user_name_pass');
add_db_server('7a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_7a', 'db_user_name',  'db_user_name_pass');
add_db_server('7b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_7b', 'db_user_name',  'db_user_name_pass');
add_db_server('7c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_7c', 'db_user_name',  'db_user_name_pass');
add_db_server('7d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_7d', 'db_user_name',  'db_user_name_pass');
add_db_server('7e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_7e', 'db_user_name',  'db_user_name_pass');
add_db_server('7f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_7f', 'db_user_name',  'db_user_name_pass');
add_db_server('80', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_80', 'db_user_name',  'db_user_name_pass');
add_db_server('81', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_81', 'db_user_name',  'db_user_name_pass');
add_db_server('82', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_82', 'db_user_name',  'db_user_name_pass');
add_db_server('83', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_83', 'db_user_name',  'db_user_name_pass');
add_db_server('84', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_84', 'db_user_name',  'db_user_name_pass');
add_db_server('85', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_85', 'db_user_name',  'db_user_name_pass');
add_db_server('86', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_86', 'db_user_name',  'db_user_name_pass');
add_db_server('87', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_87', 'db_user_name',  'db_user_name_pass');
add_db_server('88', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_88', 'db_user_name',  'db_user_name_pass');
add_db_server('89', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_89', 'db_user_name',  'db_user_name_pass');
add_db_server('8a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_8a', 'db_user_name',  'db_user_name_pass');
add_db_server('8b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_8b', 'db_user_name',  'db_user_name_pass');
add_db_server('8c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_8c', 'db_user_name',  'db_user_name_pass');
add_db_server('8d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_8d', 'db_user_name',  'db_user_name_pass');
add_db_server('8e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_8e', 'db_user_name',  'db_user_name_pass');
add_db_server('8f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_8f', 'db_user_name',  'db_user_name_pass');
add_db_server('90', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_90', 'db_user_name',  'db_user_name_pass');
add_db_server('91', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_91', 'db_user_name',  'db_user_name_pass');
add_db_server('92', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_92', 'db_user_name',  'db_user_name_pass');
add_db_server('93', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_93', 'db_user_name',  'db_user_name_pass');
add_db_server('94', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_94', 'db_user_name',  'db_user_name_pass');
add_db_server('95', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_95', 'db_user_name',  'db_user_name_pass');
add_db_server('96', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_96', 'db_user_name',  'db_user_name_pass');
add_db_server('97', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_97', 'db_user_name',  'db_user_name_pass');
add_db_server('98', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_98', 'db_user_name',  'db_user_name_pass');
add_db_server('99', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_99', 'db_user_name',  'db_user_name_pass');
add_db_server('9a', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_9a', 'db_user_name',  'db_user_name_pass');
add_db_server('9b', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_9b', 'db_user_name',  'db_user_name_pass');
add_db_server('9c', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_9c', 'db_user_name',  'db_user_name_pass');
add_db_server('9d', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_9d', 'db_user_name',  'db_user_name_pass');
add_db_server('9e', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_9e', 'db_user_name',  'db_user_name_pass');
add_db_server('9f', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_9f', 'db_user_name',  'db_user_name_pass');
add_db_server('a0', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a0', 'db_user_name',  'db_user_name_pass');
add_db_server('a1', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a1', 'db_user_name',  'db_user_name_pass');
add_db_server('a2', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a2', 'db_user_name',  'db_user_name_pass');
add_db_server('a3', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a3', 'db_user_name',  'db_user_name_pass');
add_db_server('a4', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a4', 'db_user_name',  'db_user_name_pass');
add_db_server('a5', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a5', 'db_user_name',  'db_user_name_pass');
add_db_server('a6', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a6', 'db_user_name',  'db_user_name_pass');
add_db_server('a7', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a7', 'db_user_name',  'db_user_name_pass');
add_db_server('a8', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a8', 'db_user_name',  'db_user_name_pass');
add_db_server('a9', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_a9', 'db_user_name',  'db_user_name_pass');
add_db_server('aa', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_aa', 'db_user_name',  'db_user_name_pass');
add_db_server('ab', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ab', 'db_user_name',  'db_user_name_pass');
add_db_server('ac', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ac', 'db_user_name',  'db_user_name_pass');
add_db_server('ad', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ad', 'db_user_name',  'db_user_name_pass');
add_db_server('ae', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ae', 'db_user_name',  'db_user_name_pass');
add_db_server('af', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_af', 'db_user_name',  'db_user_name_pass');
add_db_server('b0', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b0', 'db_user_name',  'db_user_name_pass');
add_db_server('b1', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b1', 'db_user_name',  'db_user_name_pass');
add_db_server('b2', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b2', 'db_user_name',  'db_user_name_pass');
add_db_server('b3', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b3', 'db_user_name',  'db_user_name_pass');
add_db_server('b4', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b4', 'db_user_name',  'db_user_name_pass');
add_db_server('b5', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b5', 'db_user_name',  'db_user_name_pass');
add_db_server('b6', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b6', 'db_user_name',  'db_user_name_pass');
add_db_server('b7', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b7', 'db_user_name',  'db_user_name_pass');
add_db_server('b8', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b8', 'db_user_name',  'db_user_name_pass');
add_db_server('b9', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_b9', 'db_user_name',  'db_user_name_pass');
add_db_server('ba', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ba', 'db_user_name',  'db_user_name_pass');
add_db_server('bb', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_bb', 'db_user_name',  'db_user_name_pass');
add_db_server('bc', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_bc', 'db_user_name',  'db_user_name_pass');
add_db_server('bd', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_bd', 'db_user_name',  'db_user_name_pass');
add_db_server('be', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_be', 'db_user_name',  'db_user_name_pass');
add_db_server('bf', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_bf', 'db_user_name',  'db_user_name_pass');
add_db_server('c0', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c0', 'db_user_name',  'db_user_name_pass');
add_db_server('c1', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c1', 'db_user_name',  'db_user_name_pass');
add_db_server('c2', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c2', 'db_user_name',  'db_user_name_pass');
add_db_server('c3', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c3', 'db_user_name',  'db_user_name_pass');
add_db_server('c4', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c4', 'db_user_name',  'db_user_name_pass');
add_db_server('c5', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c5', 'db_user_name',  'db_user_name_pass');
add_db_server('c6', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c6', 'db_user_name',  'db_user_name_pass');
add_db_server('c7', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c7', 'db_user_name',  'db_user_name_pass');
add_db_server('c8', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c8', 'db_user_name',  'db_user_name_pass');
add_db_server('c9', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_c9', 'db_user_name',  'db_user_name_pass');
add_db_server('ca', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ca', 'db_user_name',  'db_user_name_pass');
add_db_server('cb', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_cb', 'db_user_name',  'db_user_name_pass');
add_db_server('cc', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_cc', 'db_user_name',  'db_user_name_pass');
add_db_server('cd', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_cd', 'db_user_name',  'db_user_name_pass');
add_db_server('ce', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ce', 'db_user_name',  'db_user_name_pass');
add_db_server('cf', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_cf', 'db_user_name',  'db_user_name_pass');
add_db_server('d0', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d0', 'db_user_name',  'db_user_name_pass');
add_db_server('d1', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d1', 'db_user_name',  'db_user_name_pass');
add_db_server('d2', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d2', 'db_user_name',  'db_user_name_pass');
add_db_server('d3', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d3', 'db_user_name',  'db_user_name_pass');
add_db_server('d4', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d4', 'db_user_name',  'db_user_name_pass');
add_db_server('d5', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d5', 'db_user_name',  'db_user_name_pass');
add_db_server('d6', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d6', 'db_user_name',  'db_user_name_pass');
add_db_server('d7', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d7', 'db_user_name',  'db_user_name_pass');
add_db_server('d8', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d8', 'db_user_name',  'db_user_name_pass');
add_db_server('d9', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_d9', 'db_user_name',  'db_user_name_pass');
add_db_server('da', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_da', 'db_user_name',  'db_user_name_pass');
add_db_server('db', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_db', 'db_user_name',  'db_user_name_pass');
add_db_server('dc', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_dc', 'db_user_name',  'db_user_name_pass');
add_db_server('dd', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_dd', 'db_user_name',  'db_user_name_pass');
add_db_server('de', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_de', 'db_user_name',  'db_user_name_pass');
add_db_server('df', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_df', 'db_user_name',  'db_user_name_pass');
add_db_server('e0', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e0', 'db_user_name',  'db_user_name_pass');
add_db_server('e1', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e1', 'db_user_name',  'db_user_name_pass');
add_db_server('e2', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e2', 'db_user_name',  'db_user_name_pass');
add_db_server('e3', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e3', 'db_user_name',  'db_user_name_pass');
add_db_server('e4', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e4', 'db_user_name',  'db_user_name_pass');
add_db_server('e5', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e5', 'db_user_name',  'db_user_name_pass');
add_db_server('e6', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e6', 'db_user_name',  'db_user_name_pass');
add_db_server('e7', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e7', 'db_user_name',  'db_user_name_pass');
add_db_server('e8', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e8', 'db_user_name',  'db_user_name_pass');
add_db_server('e9', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_e9', 'db_user_name',  'db_user_name_pass');
add_db_server('ea', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ea', 'db_user_name',  'db_user_name_pass');
add_db_server('eb', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_eb', 'db_user_name',  'db_user_name_pass');
add_db_server('ec', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ec', 'db_user_name',  'db_user_name_pass');
add_db_server('ed', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ed', 'db_user_name',  'db_user_name_pass');
add_db_server('ee', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ee', 'db_user_name',  'db_user_name_pass');
add_db_server('ef', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ef', 'db_user_name',  'db_user_name_pass');
add_db_server('f0', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f0', 'db_user_name',  'db_user_name_pass');
add_db_server('f1', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f1', 'db_user_name',  'db_user_name_pass');
add_db_server('f2', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f2', 'db_user_name',  'db_user_name_pass');
add_db_server('f3', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f3', 'db_user_name',  'db_user_name_pass');
add_db_server('f4', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f4', 'db_user_name',  'db_user_name_pass');
add_db_server('f5', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f5', 'db_user_name',  'db_user_name_pass');
add_db_server('f6', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f6', 'db_user_name',  'db_user_name_pass');
add_db_server('f7', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f7', 'db_user_name',  'db_user_name_pass');
add_db_server('f8', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f8', 'db_user_name',  'db_user_name_pass');
add_db_server('f9', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_f9', 'db_user_name',  'db_user_name_pass');
add_db_server('fa', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_fa', 'db_user_name',  'db_user_name_pass');
add_db_server('fb', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_fb', 'db_user_name',  'db_user_name_pass');
add_db_server('fc', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_fc', 'db_user_name',  'db_user_name_pass');
add_db_server('fd', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_fd', 'db_user_name',  'db_user_name_pass');
add_db_server('fe', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_fe', 'db_user_name',  'db_user_name_pass');
add_db_server('ff', 'dc1', 1, 1,'192.168.0.101','64.120.23.72', 'wpmu_ff', 'db_user_name',  'db_user_name_pass');

add_db_server('vip1', 'dc1', 1, 1,'64.120.23.72','192.168.0.101', 'wpmu_vip_1', 'db_user_name',  'db_user_name_pass');
//------------------------------------------------------------------------//
//---VIP Blogs------------------------------------------------------------//
//------------------------------------------------------------------------//
//	Usage: add_vip_blog(BLOG_ID, DS)
//	EX: add_vip_blog(1, 'vip1');

add_vip_blog(1, 'vip1');
?>