<?php
/** Seitenmatrix: Shortcode + dynamischer Gutenberg-Block. */
if (!defined('ABSPATH')) { exit; }

if (!function_exists('sm_build_tree')) {
    function sm_build_tree($parent_id, $remaining = 0) {
        $pages = get_pages(array('parent' => (int) $parent_id, 'sort_column' => 'menu_order,post_title', 'post_status' => 'publish'));
        $nodes = array();
        foreach ($pages as $page) {
            $nodes[] = array('page' => $page, 'children' => ($remaining === 1 ? array() : sm_build_tree($page->ID, $remaining > 1 ? $remaining - 1 : 0)));
        }
        return $nodes;
    }
}
if (!function_exists('sm_leaf_count')) {
    function sm_leaf_count($node) {
        if (!$node['children']) { return 1; }
        $sum = 0;
        foreach ($node['children'] as $child) { $sum += sm_leaf_count($child); }
        return $sum;
    }
}
if (!function_exists('sm_depth')) {
    function sm_depth($node) {
        $depth = 1;
        foreach ($node['children'] as $child) { $depth = max($depth, 1 + sm_depth($child)); }
        return $depth;
    }
}
if (!function_exists('sm_cell_content')) {
    function sm_cell_content($page, $style) {
        $url = esc_url(get_permalink($page->ID));
        $title = esc_html(get_the_title($page->ID));
        if ($style !== 'bilder') { return '<a href="' . $url . '">' . $title . '</a>'; }
        $image = get_the_post_thumbnail($page->ID, 'medium', array('class' => 'sm-card-image', 'loading' => 'lazy'));
        $excerpt = trim((string) $page->post_excerpt);
        if ($excerpt === '') {
            $excerpt = wp_trim_words(wp_strip_all_tags(strip_shortcodes($page->post_content)), 24, '…');
        }
        $html = '<div class="sm-card">';
        if ($image) { $html .= '<a class="sm-card-media" href="' . $url . '">' . $image . '</a>'; }
        $html .= '<div class="sm-card-body"><a class="sm-card-title" href="' . $url . '">' . $title . '</a>';
        if ($excerpt !== '') { $html .= '<p class="sm-card-excerpt">' . esc_html($excerpt) . '</p>'; }
        return $html . '</div></div>';
    }
}
if (!function_exists('sm_append_rows')) {
    function sm_append_rows($node, $level, $max_depth, $style, &$rows) {
        $span = sm_leaf_count($node);
        $cell = '<td class="sm-level-' . (int) $level . '"';
        if ($span > 1) { $cell .= ' rowspan="' . (int) $span . '"'; }
        if (!$node['children'] && $max_depth > $level) { $cell .= ' colspan="' . (int) ($max_depth - $level + 1) . '"'; }
        $cell .= '>' . sm_cell_content($node['page'], $style) . '</td>';
        if (!$node['children']) { $rows[] = array($cell); return; }
        $start = count($rows);
        foreach ($node['children'] as $child) { sm_append_rows($child, $level + 1, $max_depth, $style, $rows); }
        array_unshift($rows[$start], $cell);
    }
}
if (!function_exists('sm_render_matrix')) {
    function sm_render_matrix($page_id = 0, $max_depth = 0, $style = 'werkstatthandbuch') {
        $page_id = absint($page_id);
        if (!$page_id) { $page_id = get_queried_object_id(); }
        if (!$page_id || get_post_type($page_id) !== 'page') { return ''; }
        $max_depth = max(0, (int) $max_depth);
        $style = $style === 'bilder' ? 'bilder' : 'werkstatthandbuch';
        $tree = sm_build_tree($page_id, $max_depth);
        if (!$tree) { return ''; }
        $depth = 1;
        foreach ($tree as $node) { $depth = max($depth, sm_depth($node)); }
        $rows = array();
        foreach ($tree as $node) { sm_append_rows($node, 1, $depth, $style, $rows); }
        $html = '<div class="sm-wrapper sm-style-' . esc_attr($style) . '"><table class="sm-table"><tbody>';
        foreach ($rows as $cells) { $html .= '<tr>' . implode('', $cells) . '</tr>'; }
        return $html . '</tbody></table></div>';
    }
}
if (!function_exists('sm_seitenmatrix_shortcode')) {
    function sm_seitenmatrix_shortcode($atts) {
        $atts = shortcode_atts(array('id' => 0, 'tiefe' => 0, 'stil' => 'werkstatthandbuch'), $atts, 'seitenmatrix');
        return sm_render_matrix($atts['id'], $atts['tiefe'], $atts['stil']);
    }
}
add_shortcode('seitenmatrix', 'sm_seitenmatrix_shortcode');

if (!function_exists('sm_render_block')) {
    function sm_render_block($attributes, $content = '', $block = null) {
        $page_id = isset($attributes['pageId']) ? absint($attributes['pageId']) : 0;
        // Im Editor kann der Block die bearbeitete Seite übergeben; im Frontend wird
        // standardmäßig die aktuell angezeigte Seite verwendet.
        $depth = isset($attributes['maxDepth']) ? (int) $attributes['maxDepth'] : 0;
        $style = isset($attributes['style']) ? $attributes['style'] : 'werkstatthandbuch';
        return sm_render_matrix($page_id, $depth, $style);
    }
}
add_action('init', function () {
    $js_path = dirname(__DIR__) . '/assets/seitenmatrix-block.js';
    wp_register_script('sm-seitenmatrix-editor', get_stylesheet_directory_uri() . '/assets/seitenmatrix-block.js', array('wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-server-side-render', 'wp-i18n', 'wp-data'), file_exists($js_path) ? filemtime($js_path) : '2.0.0', true);
    register_block_type('seitenmatrix/matrix', array(
        'api_version' => 2,
        'editor_script' => 'sm-seitenmatrix-editor',
        'attributes' => array(
            'maxDepth' => array('type' => 'number', 'default' => 0),
            'style' => array('type' => 'string', 'default' => 'werkstatthandbuch'),
            'pageId' => array('type' => 'number', 'default' => 0),
        ),
        'render_callback' => 'sm_render_block',
    ));
});

add_action('enqueue_block_assets', function () {
    $css = '.sm-wrapper{width:100%;overflow-x:auto;margin:20px 0}'
        .'.sm-table{width:100%;border-collapse:collapse;table-layout:auto}'
        .'.sm-table td{vertical-align:top;text-align:left;padding:12px 16px;border:0;border-right:6px solid #777;min-width:160px;background:transparent}'
        .'.sm-table td:last-child{border-right:0}'
        .'.sm-table a{text-decoration:none;line-height:1.5}'
        .'.sm-table a:hover{text-decoration:underline}'
        .'.sm-style-werkstatthandbuch .sm-table a{color:#000080;font-weight:600}'
        .'.sm-style-werkstatthandbuch .sm-level-1>a{color:#000;font-weight:700}'
        .'.sm-style-werkstatthandbuch .sm-level-3>a,.sm-style-werkstatthandbuch .sm-level-4>a{font-weight:400;font-size:14px}'
        .'.sm-style-bilder .sm-table td{min-width:220px;border-right:2px solid #ddd}'
        .'.sm-card{display:flex;flex-direction:column;gap:10px;max-width:340px}'
        .'.sm-card-image{display:block;width:100%;height:auto;aspect-ratio:16/9;object-fit:cover;border-radius:4px}'
        .'.sm-card-title{font-weight:700;color:#173d71}'
        .'.sm-card-excerpt{margin:6px 0 0;font-size:14px;line-height:1.5;color:#444}'
        .'@media(max-width:768px){.sm-table td{min-width:140px;padding:10px}.sm-style-bilder .sm-table td{min-width:190px}}';
    wp_register_style('sm-seitenmatrix', false, array(), '2.0.0');
    wp_enqueue_style('sm-seitenmatrix');
    wp_add_inline_style('sm-seitenmatrix', $css);
});
