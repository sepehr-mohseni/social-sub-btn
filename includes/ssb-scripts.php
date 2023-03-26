<?php
// Add Scripts
function ssb_add_scripts()
{
    // Add YT Script
    wp_register_script('google', 'https://apis.google.com/js/platform.js');
    wp_enqueue_script('google');

    // Add Spotify Script
    wp_register_script('spotify', 'https://open.spotify.com/embed-podcast/iframe-api/v1');
    wp_enqueue_script('spotify');

    // Add Github Script
    wp_register_script('github', 'https://buttons.github.io/buttons.js');
    wp_enqueue_script('github');
}

// Register Scripts
add_action('wp_enqueue_scripts', 'ssb_add_scripts');
