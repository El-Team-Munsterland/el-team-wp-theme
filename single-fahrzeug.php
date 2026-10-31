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

                <?php
                // Beitragsbild, Steckbrief, Herkunft, Chronik, Werkstattberichte, Unterlagen und Fahrzeugpapiere
                // aus dem Plugin "CityEL Werkstatt" vor dem Fahrzeugtext; der Text aus dem Blockeditor kommt zum Schluss.
                // Steht der Block "CityEL Fahrzeug-Steckbrief" im Text, setzt er die Teile selbst.
                $el_team_plugin_profile = function_exists( 'cityel_the_vehicle_profile' );
                if ( $el_team_plugin_profile && ! ( function_exists( 'cityel_has_vehicle_profile_block' ) && cityel_has_vehicle_profile_block() ) ) {
                    cityel_the_vehicle_profile( get_the_ID(), array( 'parts' => array( 'bild', 'steckbrief', 'historie', 'chronik', 'berichte', 'unterlagen', 'papiere' ) ) );
                }
                ?>

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
            // Ohne Plugin: Werkstattberichte als einfache Liste.
            $werkstatt_query = $el_team_plugin_profile ? null : el_team_get_werkstattberichte_for_fahrzeug( get_the_ID() );
            if ( $werkstatt_query && $werkstatt_query->have_posts() ) :
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
