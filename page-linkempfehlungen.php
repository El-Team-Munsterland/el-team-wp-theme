<?php
/*
Template Name: Linkempfehlungen
Description: Seite zum Anzeigen von Linkempfehlungen mit Logos
*/
get_header();
?>
<div class="content-wrapper <?php echo el_team_has_subpages() ? 'has-sidebar' : ''; ?>">
    <main id="site-content" role="main" class="main-content">
    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <div class="page-content">
        <?php the_content(); ?>
    </div>

    <?php
    $links = el_team_get_link_recommendations( get_the_ID() );

    if ( ! empty( $links ) ) :
        ?>
        <div class="el-team-links-grid">
            <?php foreach ( $links as $link ) : ?>
                <div class="el-team-link-card">
                    <?php if ( ! empty( $link['image_id'] ) ) : ?>
                        <div class="el-team-link-logo">
                            <?php 
                            $image_src = wp_get_attachment_image_src( $link['image_id'], 'full' );
                            if ( $image_src ) {
                                echo '<img src="' . esc_url( $image_src[0] ) . '" class="el-team-link-logo-img" alt="' . esc_attr( isset( $link['title'] ) ? $link['title'] : '' ) . '" />';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <h3 class="el-team-link-title">
                        <a href="<?php echo esc_url( isset( $link['url'] ) ? $link['url'] : '#' ); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo esc_html( isset( $link['title'] ) ? $link['title'] : '' ); ?>
                        </a>
                    </h3>
                    
                    <?php if ( ! empty( $link['description'] ) ) : ?>
                        <p class="el-team-link-description">
                            <?php echo esc_html( $link['description'] ); ?>
                        </p>
                    <?php endif; ?>
                    
                    <a href="<?php echo esc_url( isset( $link['url'] ) ? $link['url'] : '#' ); ?>" class="el-team-link-button" target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e( 'Webseite aufrufen', 'el-team-wp-theme' ); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p><?php esc_html_e( 'Es sind noch keine Linkempfehlungen vorhanden.', 'el-team-wp-theme' ); ?></p>
    <?php endif; ?>
    </main>

    <?php if ( el_team_has_subpages() ) get_sidebar(); ?>
</div>

<?php
get_footer();
