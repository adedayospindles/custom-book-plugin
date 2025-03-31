<?php
class Book_Taxonomy {
    public function __construct() {
        add_action('init', array($this, 'register_genre_taxonomy'));
    }

    public function register_genre_taxonomy() {
        $labels = array(
            'name'                       => 'Genres',
            'singular_name'              => 'Genre',
            'search_items'               => 'Search Genres',
            'popular_items'              => 'Popular Genres',
            'all_items'                  => 'All Genres',
            'edit_item'                  => 'Edit Genre',
            'update_item'                => 'Update Genre',
            'add_new_item'               => 'Add New Genre',
            'new_item_name'              => 'New Genre Name',
            'separate_items_with_commas' => 'Separate genres with commas',
            'add_or_remove_items'        => 'Add or remove genres',
            'choose_from_most_used'      => 'Choose from the most used genres',
            'not_found'                  => 'No genres found.',
            'menu_name'                  => 'Genres',
        );

        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'hierarchical'      => false, // Non-hierarchical like tags
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true, // Enable Gutenberg support
            'query_var'         => true,
            'rewrite'           => array('slug' => 'genre'),
        );

        register_taxonomy('genre', 'book', $args);
    }
}

// Instantiate the class
new Book_Taxonomy();