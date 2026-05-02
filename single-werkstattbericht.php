<?php
/**
 * Single Werkstattbericht Template
 */
get_header();
?>
<main id="site-content" role="main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            $related_fahrzeug_id = get_post_meta( get_the_ID(), '_el_team_werkstatt_fahrzeug_id', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <?php if ( $related_fahrzeug_id ) :
                    $related_fahrzeug = get_post( $related_fahrzeug_id );
                    if ( $related_fahrzeug ) : ?>
                        <p class="werkstattbericht-fahrzeug-link">
                            <?php esc_html_e( 'Zu diesem Fahrzeug:', 'el-team-wp-theme' ); ?>
                            <a href="<?php echo esc_url( get_permalink( $related_fahrzeug_id ) ); ?>">
                                <?php echo esc_html( get_the_title( $related_fahrzeug ) ); ?>
                            </a>
                        </p>
                    <?php endif;
                endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();
                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'el-team-wp-theme' ),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>
            </article>
            <?php
        endwhile;
    endif;
    ?>
</main>

<?php get_footer();
