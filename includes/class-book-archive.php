<?php
class Book_Archive {
    public function __construct() {
        // Register AJAX actions
        add_action('wp_ajax_filter_books', array($this, 'filter_books'));
        add_action('wp_ajax_nopriv_filter_books', array($this, 'filter_books'));
    }

    // AJAX handler for book filtering
    public function filter_books() {
        $genre = isset($_GET['genre']) ? sanitize_text_field($_GET['genre']) : '';
        $year = isset($_GET['year']) ? sanitize_text_field($_GET['year']) : '';

        // Set up the query arguments
        $args = array(
            'post_type' => 'book',
            'posts_per_page' => -1, // Retrieve all posts
            'post_status' => 'publish',
            'meta_query' => array(),
        );

        // Filter by genre
        if ($genre && $genre !== '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'genre',
                    'field' => 'slug',
                    'terms' => $genre,
                ),
            );
        }

        // Filter by year (extracting the year from the publication_date field)
        if ($year && $year !== '0') {
            $args['meta_query'][] = array(
                'key'     => '_publication_date',  // Corrected meta key with underscore
                'value'   => $year,
                'compare' => 'LIKE',              // Match year within the date
            );
        }


        // Execute the query
        $query = new WP_Query($args);

        // Output the books
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                // Use a template part for consistent layout
                include plugin_dir_path(__FILE__) . '../templates/book-item.php';
            }
        } else {
            echo '<p>No books found.</p>';
        }

        wp_reset_postdata();
        die();
    }
}

// Instantiate the class
new Book_Archive();