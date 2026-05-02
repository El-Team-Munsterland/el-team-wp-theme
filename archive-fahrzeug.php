<?php
/**
 * Fahrzeug Archive Template
 */
get_header();
?>
<main id="site-content" role="main">
    <header class="page-header">
        <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
    </header>

    <?php if ( have_posts() ) : ?>
        <div class="fahrzeug-archive-list">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'fahrzeug-item' ); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="fahrzeug-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                    </header>

                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>

                    <a class="fahrzeug-read-more" href="<?php the_permalink(); ?>">
                        <?php esc_html_e( 'Zum Fahrzeug', 'el-team-wp-theme' ); ?>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(); ?>

    <?php else : ?>
        <p><?php esc_html_e( 'Keine Fahrzeuge gefunden.', 'el-team-wp-theme' ); ?></p>
    <?php endif; ?>
</main>

<?php get_footer();
