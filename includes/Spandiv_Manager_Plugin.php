<?php

if(!class_exists('Spandiv_Manager_Plugin')) {

class Spandiv_Manager_Plugin {
    // Get plugin directory path
    static function plugin_dir_path($file) {
        return plugin_dir_path(__DIR__) . $file;
    }

    // Add admin page
    function add_admin_page() {
        add_menu_page(
            'Spandiv Manager', // Page title
            'Spandiv Manager', // Menu title
            'manage_options', // Capability
            'spandiv-manager', // Menu slug
            array('Spandiv_Manager_Plugin', 'lists_page'), // Callable
            '', // Icon URL
            2 // Position
        );
    }

    // Callable lists page
    function lists_page() {
        global $wpdb;
        $table = $wpdb->prefix . 'spandiv_member';
        $results = $wpdb->get_results("SELECT * FROM $table ORDER BY member_last_sync DESC");

        // Update banner
        if(isset($_POST['banner'])) {
            foreach($_POST['banner'] as $key=>$banner) {
                $wpdb->query("UPDATE $table SET member_banner=$banner WHERE member_id=$key");
            }
        }

        // View
        include_once(self::plugin_dir_path('views/index.php'));
    }

    // Add action links
    function add_action_links($actions) {
        $mylinks = array(
            '<a href="' . admin_url('admin.php?page=spandiv-manager') . '" style="font-weight: 600; color: #1da867;">See Members</a>',
        );
        $actions = array_merge($mylinks, $actions);
        return $actions;
    }
}

}

?>