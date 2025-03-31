<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue JS and CSS for the book archive
function enqueue_book_archive_assets() {
    // Enqueue JS
    wp_enqueue_script(
        'book-archive-script',
        plugin_dir_url(__DIR__) . 'assets/js/book-archive.js', 
        array('jquery'),
        null,
        true
    );

    wp_localize_script('book-archive-script', 'book_ajax', array(
        'url' => admin_url('admin-ajax.php'),
    ));

    // Enqueue CSS
    wp_enqueue_style(
        'book-archive-style',
        plugin_dir_url(__DIR__) . 'assets/css/book-archive.css',
        array(),
        filemtime(plugin_dir_path(__DIR__) . 'assets/css/book-archive.css') // Versioning
    );
}
add_action('wp_enqueue_scripts', 'enqueue_book_archive_assets');