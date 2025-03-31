<?php
get_header();
?>

<div class="genre-archive">
    <h1><?php single_term_title(); ?> Books</h1>

    <div id="book-list">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php include plugin_dir_path(__FILE__) . 'book-item.php'; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No books found in this genre.</p>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
?>