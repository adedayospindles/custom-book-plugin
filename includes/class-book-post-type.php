<?php
class Book_Post_Type {
    public function __construct() {
        add_action('init', array($this, 'register_book_post_type'));
    }

    public function register_book_post_type() {
        $labels = array(
            'name'               => 'Books',
            'singular_name'      => 'Book',
            'menu_name'          => 'Books',
            'name_admin_bar'     => 'Book',
            'add_new'            => 'Add New Book',
            'add_new_item'       => 'Add New Book',
            'edit_item'          => 'Edit Book',
            'new_item'           => 'New Book',
            'view_item'          => 'View Book',
            'search_items'       => 'Search Books',
            'all_items'          => 'All Books',
            'not_found'          => 'No books found.',
            'not_found_in_trash' => 'No books found in Trash.',
            'parent_item_colon'  => 'Parent Book:',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'menu_icon'          => 'dashicons-book-alt',
            'supports'           => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'books'),
            'has_archive'        => true,
            'show_in_rest'       => true,
        );

        register_post_type('book', $args);
    }
}

new Book_Post_Type();