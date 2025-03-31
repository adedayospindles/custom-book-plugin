<?php get_header(); ?>

<div class="container">
    <h1 class="archive-title">Books Archive</h1>

    <div class="filter-container">
        <!-- Filter Text -->
        <div class="filter-text">
            <h3>Filter:</h3>
        </div>

        <!-- Filter by Genre -->
        <div class="filter-item">
            <label for="genre-select">Genre:</label>
            <select id="genre-select">
                <option value="0">All Genres</option>
                <?php
                $genres = get_terms(array(
                    'taxonomy' => 'genre',
                    'hide_empty' => true,
                ));

                if (!empty($genres) && !is_wp_error($genres)) {
                    foreach ($genres as $genre) {
                        echo '<option value="' . esc_attr($genre->slug) . '">' . esc_html($genre->name) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Filter by Year -->
        <div class="filter-item">
            <label for="year-select">Year:</label>
            <select id="year-select">
                <option value="0">All Years</option>
                <?php
                global $wpdb;
                $years = $wpdb->get_results("
                    SELECT DISTINCT YEAR(meta_value) AS year
                    FROM {$wpdb->postmeta} 
                    WHERE meta_key = '_publication_date'
                    AND meta_value != ''
                    ORDER BY year DESC
                ");
                
                echo '<pre>';
                print_r($years);
                echo '</pre>';
                
                if ($years) {
                    foreach ($years as $year) {
                        echo '<option value="' . esc_attr($year->year) . '">' . esc_html($year->year) . '</option>';
                    }
                }                           
                ?>
            </select>
        </div>
    </div>

    <!-- Book list container -->
    <div id="book-list" class="book-list">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php include plugin_dir_path(__FILE__) . 'book-item.php'; ?>
        <?php endwhile; else: ?>
            <p>No books found.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>