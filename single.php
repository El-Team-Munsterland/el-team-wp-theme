<?php
/**
 * Single Post Template
 * Zeigt einen einzelnen Beitrag an, ohne Kategorie-Links.
 */
get_header();
?>

<main id="site-content" role="main">
    <?php
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="posted-on">
                            <?php
                            printf(
                                esc_html_x( 'Veröffentlicht: %s', 'post date', 'el-team-wp-theme' ),
                                '<time class="entry-date published" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>'
                            );
                            ?>
                        </span>
                        <?php
                        $author = get_the_author();
                        if ( ! empty( $author ) && $author !== 'admin' ) {
                            echo ' | <span class="byline"><span class="author vcard">' . esc_html( $author ) . '</span></span>';
                        }
                        ?>
                    </div>
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

                <footer class="entry-footer">
                    <!-- Kategorie-Links absichtlich NICHT angezeigt -->
                </footer>
            </article>

            <?php
            // Navigation zwischen Posts (optional)
            the_post_navigation(
                array(
                    'prev_text' => esc_html__( '&larr; Vorheriger Beitrag', 'el-team-wp-theme' ),
                    'next_text' => esc_html__( 'Nächster Beitrag &rarr;', 'el-team-wp-theme' ),
                )
            );
        }
    }
    ?>
</main>

<?php
get_footer();
