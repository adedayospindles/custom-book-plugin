<?php
class Book_Meta_Box {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_book_meta_box'));
        add_action('save_post', array($this, 'save_book_meta'));

        // Hook to display the author's name and publication date on the frontend (single or archive)
        add_action('book_author_display', array($this, 'display_author_name'));

        // Add Author column in the backend book list
        add_filter('manage_book_posts_columns', array($this, 'add_author_column'));
        add_action('manage_book_posts_custom_column', array($this, 'display_author_column'), 10, 2);
    }

    // Add the custom meta box
    public function add_book_meta_box() {
        add_meta_box(
            'book_details',
            'Book Details',
            array($this, 'display_book_meta_box'),
            'book',
            'side',
            'default'
        );
    }

    // Display the meta box
    public function display_book_meta_box($post) {
        $author_name = get_post_meta($post->ID, '_author_name', true);
        $publication_date = get_post_meta($post->ID, '_publication_date', true);

        wp_nonce_field('save_book_meta', 'book_meta_nonce');
        ?>
        <p>
            <label for="author_name">Author Name:</label>
            <input type="text" id="author_name" name="author_name" value="<?php echo esc_attr($author_name); ?>" class="widefat">
        </p>
        <p>
            <label for="publication_date">Publication Date:</label>
            <input type="date" id="publication_date" name="publication_date" value="<?php echo esc_attr($publication_date); ?>" class="widefat">
        </p>
        <?php
    }

    // Save the meta box data
    public function save_book_meta($post_id) {
        // Verify nonce
        if (!isset($_POST['book_meta_nonce']) || !wp_verify_nonce($_POST['book_meta_nonce'], 'save_book_meta')) {
            return;
        }

        // Prevent autosave from triggering the save action
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check user permission
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save author name if set
        if (isset($_POST['author_name'])) {
            $author_name = sanitize_text_field($_POST['author_name']);
            // Update meta data (do not add a new row if it already exists)
            update_post_meta($post_id, '_author_name', $author_name);
        }

        // Save publication date if set
        if (isset($_POST['publication_date'])) {
            $publication_date = sanitize_text_field($_POST['publication_date']);
            // Update meta data (do not add a new row if it already exists)
            update_post_meta($post_id, '_publication_date', $publication_date);
        }
    }



    // Unified method to display the author's name and publication date on the frontend
    public function display_author_name() {
        // Check if the output has already been displayed to avoid duplication
        if (did_action('book_author_displayed_' . get_the_ID())) {
            return;
        }

        $author_name = get_post_meta(get_the_ID(), '_author_name', true);
        $publication_date = get_post_meta(get_the_ID(), '_publication_date', true);

        if ($author_name || $publication_date) {
            echo '<div class="book-info">';
            
            if ($author_name) {
                echo '<p><strong>Author Name:</strong> ' . esc_html($author_name) . '</p>';
            }

            if ($publication_date) {
                echo '<p><strong>Publication Date:</strong> ' . esc_html(date('F j, Y', strtotime($publication_date))) . '</p>';
            }

            echo '</div>';

            // Mark the action as done to prevent duplicate display
            do_action('book_author_displayed_' . get_the_ID());
        }
    }


    // Add custom column for Author and Publication Date in the admin list
    public function add_author_column($columns) {
        $columns['book_author'] = 'Author Name';
        $columns['publication_date'] = 'Publication Date';
        return $columns;
    }


    // Display the author name and publication date in the custom column
    public function display_author_column($column, $post_id) {
        // Avoid multiple executions for the same column
        static $displayed = array();

        // Check if this combination has already been displayed
        if (isset($displayed[$post_id][$column])) {
            return;
        }

        if ($column === 'book_author') {
            $author_name = get_post_meta($post_id, '_author_name', true);
            echo $author_name ? esc_html($author_name) : '—';
        }

        if ($column === 'publication_date') {
            $publication_date = get_post_meta($post_id, '_publication_date', true);
            echo $publication_date ? esc_html(date('F j, Y', strtotime($publication_date))) : '—';
        }

        // Mark this combination as displayed
        $displayed[$post_id][$column] = true;
    }



}

// Instantiate the class
new Book_Meta_Box();
?>