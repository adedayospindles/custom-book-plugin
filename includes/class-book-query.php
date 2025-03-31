<?php
// Code Debug Assignment - Part 1b
// Modify the query on the book archive page
function modify_books_archive_query($query) {
    
    if (is_post_type_archive('book') && !is_admin() && $query->is_main_query()) {
        
        $tax_query = array(
            array(
                'taxonomy' => 'genre',
                'field'    => 'slug', 
                'terms'    => 'science-fiction', 
            ),
        );
        $query->set('tax_query', $tax_query);
    }
}

add_action('pre_get_posts', 'modify_books_archive_query');