<?php
/*
Plugin Name: Social Sub Button
Plugin URI: https://github.com/sepmsi/social-sub-btn
Description: Display your yt, spotify, github social media accounts for quick follow on wordpress website
Version: 1.0.0
Author: Sepehr Mohseni
Author URI: https://github.com/sepmsi
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load Scripts
require_once(plugin_dir_path(__FILE__) . '/includes/ssb-scripts.php');

// Load Class
require_once(plugin_dir_path(__FILE__) . '/includes/ssb-class.php');

// Register Widget
function register_ssb()
{
    register_widget('Social_Sub_Btns_Widget');
}

// Hook in function
add_action('widgets_init', 'register_ssb');
