<?php

	if( ! defined( 'ABSPATH' ) ) exit;


	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
	function sl_rloader_myplugin_activate() {
		// register the uninstall function
		register_uninstall_hook( __FILE__, 'sl_rloader_uninstaller');
	}

	function sl_rloader_create_options() {
		
		$sl_rloader_options =  array(
							'bgcolor' => 'blue',
							'reviewgroupnum' => '5',
							'transitionstyle' => 'loadonclick'
						);

		add_option( 'sl_rloader_options', $sl_rloader_options );
		add_option( 'sl_rloader_admin_options', array( 
								'version' => '1.0',
								'advanced_options' => '1'
							), '', 'no' );



	} // End sl_rloader_create_options




	function sl_rloader_uninstaller() {
		// delete any options, tables, etc the plugin created
		delete_option( 'sl_rloader_options' );
	}




?>
