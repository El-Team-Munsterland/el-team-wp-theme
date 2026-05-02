<?php
/**
 * Single Fahrzeug Template
 */
get_header();
?>
<main id="site-content" role="main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

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
            $werkstatt_query = el_team_get_werkstattberichte_for_fahrzeug( get_the_ID() );
            if ( $werkstatt_query->have_posts() ) :
                ?>
                <section class="fahrzeug-werkstattberichte">
                    <h2><?php esc_html_e( 'Werkstattberichte zum Fahrzeug', 'el-team-wp-theme' ); ?></h2>
                    <ul>
                        <?php while ( $werkstatt_query->have_posts() ) : $werkstatt_query->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                <span class="werkstattbericht-date">(<?php echo esc_html( get_the_date() ); ?>)</span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </section>
                <?php
                wp_reset_postdata();
            endif;
        endwhile;
    endif;
    ?>
</main>

<?php get_footer();
