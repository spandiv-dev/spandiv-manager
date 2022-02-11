<?php

/*
Plugin Name: Spandiv Manager
Plugin URI: https://spandiv.xyz/
Description: Manage Spandiv Member.
Version: 1.0.0
Author: Spandiv
Author URI: https://spandiv.xyz/
License: GPL2
*/


// Require classes
require_once('includes/Spandiv_Manager_Plugin.php');
require_once('includes/Spandiv_Manager_REST.php');

// Add admin menu
add_action('admin_menu', array('Spandiv_Manager_Plugin', 'add_admin_page'));

// Add action links
add_filter('plugin_action_links_' . plugin_basename(__FILE__), array('Spandiv_Manager_Plugin', 'add_action_links'));

// Add REST API
add_action('rest_api_init', function() {
	register_rest_route( 'spandiv/v1', 'get-member', array(
		'methods'  => 'GET',
		'callback' => array('Spandiv_Manager_REST', 'get_member')
	));
	register_rest_route( 'spandiv/v1', 'sync-member', array(
		'methods'  => 'POST',
		'callback' => array('Spandiv_Manager_REST', 'sync_member')
	));
});

?>
