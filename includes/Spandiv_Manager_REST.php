<?php

if(!class_exists('Spandiv_Manager_REST')) {

class Spandiv_Manager_REST {
	// Get member
	function get_member($request) {
		global $wpdb;
		$table = $wpdb->prefix . 'spandiv_member';
		$results = $wpdb->get_results("SELECT * FROM $table WHERE member_url='{$request['url']}'");
		$result = count($results) > 0 ? $results[0] : [];
		
        // Set response
        $response = new WP_REST_Response($result);
        $response->set_status(200);
        return $response;
	}
	
	// Sync member
	function sync_member($request) {
		global $wpdb;
		$table = $wpdb->prefix . 'spandiv_member';
		$count = count($wpdb->get_results("SELECT * FROM $table WHERE member_url='{$request['url']}'"));
		date_default_timezone_set("Asia/Jakarta");
		$now = date('Y-m-d H:i:s');

		// If exists: update data
		if($count > 0)
			$wpdb->query("UPDATE $table SET member_last_sync='{$now}' WHERE member_url='{$request['url']}'");
		// If no exists: insert data
		else
			$wpdb->query("INSERT INTO $table(member_url,member_banner,member_last_sync) VALUES('{$request['url']}',0,'{$now}')");
	}
}
	
}