<div class="book-item">
    <?php if (has_post_thumbnail()) : ?>
        <div class="book-thumbnail">
            <?php the_post_thumbnail('medium'); ?>
        </div>
    <?php endif; ?>

    <div class="book-details">
        <h2><?php the_title(); ?></h2>

        <div class="book-meta">
            <?php 
            $genre_list = get_the_term_list(get_the_ID(), 'genre', '', ', ');
            if ($genre_list) : ?>
                <p><strong>Genre:</strong> <?php echo $genre_list; ?></p>
            <?php endif; ?>
        </div>

        <div class="book-content">
            <?php the_excerpt(); ?>
        </div>

        <div class="book-author">
            <?php do_action('book_author_display'); ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
    </div>
</div>