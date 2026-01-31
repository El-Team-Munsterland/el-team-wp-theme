<?php
/*
Template Name: Solarchallenge Übersicht
Description: Listet alle Beiträge vom Typ 'solarchallenge' in einer Tabelle (Datum, Titel).
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

    <table class="presse-uebersicht" style="width:100%; border-collapse:collapse;">

        <tbody>
        <?php
        $presse_query = new WP_Query(array(
            'category_name' => 'solarchallenge',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ));

        if ($presse_query->have_posts()) :
            $current_year = null;
            
            while ($presse_query->have_posts()) : $presse_query->the_post();
                $post_year = get_the_date("Y");
                
                // Wenn Jahr sich ändert, Jahres-Header-Zeile einfügen
                if ($post_year !== $current_year) {
                    ?>
                    <tr>
                        <td style="padding:8px; vertical-align:middle; font-weight:bold; background-color:#f5f5f5; border-bottom:2px solid #999;">
                            <?php echo esc_html($post_year); ?>
                        </td>
                        <td style="padding:8px; background-color:#f5f5f5; border-bottom:2px solid #999;"></td>
                    </tr>
                    <?php
                    $current_year = $post_year;
                }
                ?>
                <tr>
                    <td style="padding:8px; vertical-align:top; border-bottom:1px solid #f0f0f0;"><?php echo esc_html(get_the_date("d.m.Y")); ?></td>
                    <td style="padding:8px; vertical-align:top; border-bottom:1px solid #f0f0f0;">
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <?php echo el_team_replace_title_prefix_with_logo( get_the_title() ); ?>
                        </a>
                    </td>
                </tr>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <tr>
                <td colspan="2" style="padding:8px;">Keine Beiträge vom Typ &quot;Solarchallenge&quot; gefunden.</td>
            </tr>
            <?php
        endif;
        ?>
        </tbody>
    </table>

</main>

<?php
get_footer();
