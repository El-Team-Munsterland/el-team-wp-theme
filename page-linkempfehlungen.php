<?php
/*
Template Name: Linkempfehlungen
Description: Seite zum Anzeigen von Linkempfehlungen mit Logos
*/
get_header();
?>
<main id="site-content" role="main">
    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <div class="page-content">
        <?php the_content(); ?>
    </div>

    <?php
    $links = get_post_meta( get_the_ID(), '_el_team_links', true );
    
    if ( ! empty( $links ) && is_array( $links ) ) :
        // Sort links by link_order
        usort( $links, function( $a, $b ) {
            $order_a = isset( $a['link_order'] ) ? $a['link_order'] : 0;
            $order_b = isset( $b['link_order'] ) ? $b['link_order'] : 0;
            return $order_a - $order_b;
        } );
        ?>
        <div class="el-team-links-grid">
            <?php foreach ( $links as $link ) : ?>
                <div class="el-team-link-card">
                    <?php if ( ! empty( $link['image_id'] ) ) : ?>
                        <div class="el-team-link-logo">
                            <?php echo wp_get_attachment_image( $link['image_id'], array( 120, 120 ), false, array(
                                'class' => 'el-team-link-logo-img',
                                'alt'   => esc_attr( isset( $link['title'] ) ? $link['title'] : '' ),
                            ) ); ?>
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
                        <?php esc_html_e( 'Webseite aufrufen →', 'el-team-wp-theme' ); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <style>
            .el-team-links-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 30px;
                margin-top: 30px;
                margin-bottom: 30px;
            }
            
            .el-team-link-card {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                padding: 20px;
                background: #ffffff;
                transition: box-shadow 0.3s ease, transform 0.3s ease;
                display: flex;
                flex-direction: column;
            }
            
            .el-team-link-card:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            }
            
            .el-team-link-logo {
                text-align: center;
                margin-bottom: 15px;
                height: 120px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f9f9f9;
                border-radius: 4px;
            }
            
            .el-team-link-logo-img {
                max-width: 100%;
                height: auto;
                max-height: 120px;
            }
            
            .el-team-link-title {
                margin: 10px 0;
                font-size: 1.2em;
                line-height: 1.4;
            }
            
            .el-team-link-title a {
                text-decoration: none;
                color: inherit;
                transition: color 0.2s ease;
            }
            
            .el-team-link-title a:hover {
                color: #007bff;
            }
            
            .el-team-link-description {
                flex-grow: 1;
                color: #666;
                font-size: 0.95em;
                line-height: 1.5;
                margin: 10px 0;
            }
            
            .el-team-link-button {
                display: inline-block;
                margin-top: 15px;
                padding: 10px 15px;
                background: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                transition: background 0.2s ease;
                font-weight: 500;
                text-align: center;
            }
            
            .el-team-link-button:hover {
                background: #0056b3;
            }
            
            @media (max-width: 768px) {
                .el-team-links-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    <?php else : ?>
        <p><?php esc_html_e( 'Es sind noch keine Linkempfehlungen vorhanden.', 'el-team-wp-theme' ); ?></p>
    <?php endif; ?>

</main>

<?php
get_footer();
