<?php
/**
 * Plugin Name: Custom Book Plugin
 * Description: A plugin to create a Book custom post type with genre taxonomy and custom meta box.
 * Version: 1.1
 * Author: Adedayo Spindle Agboola
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once plugin_dir_path(__FILE__) . 'includes/class-book-post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-book-taxonomy.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-book-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-book-archive.php';
require_once plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';

// This is enabled so that only books from the science-fiction genre is displayed
require_once plugin_dir_path(__FILE__) . 'includes/class-book-query.php'; 


// Initialize the classes
function custom_book_plugin_init() {
    new Book_Post_Type();
    new Book_Taxonomy();
    new Book_Meta_Box();
    new Book_Archive();
}

add_action('init', 'custom_book_plugin_init');

function custom_book_template($template) {
    if (is_post_type_archive('book')) {
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/archive-book.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    if (is_singular('book')) {
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/single-book.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    return $template;
}
add_filter('template_include', 'custom_book_template');


// Adjust excerpt length specifically for books
function book_custom_excerpt_length($length) {
    if (is_post_type_archive('book') || is_singular('book') || is_tax('genre')) {
        return 20; // Adjust the number to control the word count
    }
    return $length;
}
add_filter('excerpt_length', 'book_custom_excerpt_length', 999);
