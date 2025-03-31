<?php get_header(); ?>

<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="single-book">
            <h1 class="book-title"><?php the_title(); ?></h1>

            <?php if (has_post_thumbnail()) : ?>
                <div class="book-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="book-meta">
                <?php 
                $genre_list = get_the_term_list(get_the_ID(), 'genre', '', ', ');
                if ($genre_list) : ?>
                    <p><strong>Genre:</strong> <?php echo $genre_list; ?></p>
                <?php endif; ?>
            </div>

            <div class="book-content">
                <?php the_content(); ?>
            </div>

            <!-- Display the author & publication name after the content -->
            <div class="book-author">
                <?php do_action('book_author_display'); ?>
            </div>

            <div class="book-navigation">
                <?php previous_post_link('<span class="prev-book">%link</span>', 'Previous Book'); ?>
                <?php next_post_link('<span class="next-book">%link</span>', 'Next Book'); ?>
            </div>
        </div>
    <?php endwhile; else: ?>
        <p>No book found.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>