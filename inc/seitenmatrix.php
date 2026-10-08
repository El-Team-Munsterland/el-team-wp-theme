<?php
/**
 * Hierarchische Seitenmatrix für WordPress.
 * Shortcodes: [seitenmatrix] und [seitenmatrix id="123"]
 */
if (!defined('ABSPATH')) { exit; }

if (!function_exists('sm_build_tree')) {
    function sm_build_tree($parent_id) {
        $pages = get_pages(array(
            'parent' => (int) $parent_id,
            'sort_column' => 'menu_order,post_title',
            'post_status' => 'publish',
        ));
        $nodes = array();
        foreach ($pages as $page) {
            $nodes[] = array('page' => $page, 'children' => sm_build_tree($page->ID));
        }
        return $nodes;
    }
}

if (!function_exists('sm_leaf_count')) {
    function sm_leaf_count($node) {
        if (empty($node['children'])) { return 1; }
        $sum = 0;
        foreach ($node['children'] as $child) { $sum += sm_leaf_count($child); }
        return $sum;
    }
}

if (!function_exists('sm_depth')) {
    function sm_depth($node) {
        $depth = 1;
        foreach ($node['children'] as $child) {
            $depth = max($depth, 1 + sm_depth($child));
        }
        return $depth;
    }
}

/** Render rows as arrays of cells, avoiding string replacement of HTML. */
if (!function_exists('sm_append_rows')) {
    function sm_append_rows($node, $level, $max_depth, &$rows) {
        $span = sm_leaf_count($node);
        $page = $node['page'];
        $cell = '<td class="sm-level-' . (int) $level . '"';
        if ($span > 1) { $cell .= ' rowspan="' . (int) $span . '"'; }
        if (empty($node['children']) && $max_depth > $level) {
            $cell .= ' colspan="' . (int) ($max_depth - $level + 1) . '"';
        }
        $cell .= '><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a></td>';

        if (empty($node['children'])) {
            $rows[] = array($cell);
            return;
        }
        $start = count($rows);
        foreach ($node['children'] as $child) {
            sm_append_rows($child, $level + 1, $max_depth, $rows);
        }
        array_unshift($rows[$start], $cell);
    }
}

if (!function_exists('sm_seitenmatrix_shortcode')) {
    function sm_seitenmatrix_shortcode($atts) {
        $atts = shortcode_atts(array('id' => 0), $atts, 'seitenmatrix');
        $page_id = absint($atts['id']);
        if (!$page_id) { $page_id = get_queried_object_id(); }
        if (!$page_id || get_post_type($page_id) !== 'page') { return ''; }
        $tree = sm_build_tree($page_id);
        if (!$tree) { return ''; }
        $depth = 1;
        foreach ($tree as $node) { $depth = max($depth, sm_depth($node)); }
        $rows = array();
        foreach ($tree as $node) { sm_append_rows($node, 1, $depth, $rows); }
        $html = '<div class="sm-wrapper"><table class="sm-table"><tbody>';
        foreach ($rows as $cells) { $html .= '<tr>' . implode('', $cells) . '</tr>'; }
        return $html . '</tbody></table></div>';
    }
}
add_shortcode('seitenmatrix', 'sm_seitenmatrix_shortcode');

add_action('wp_enqueue_scripts', function () {
    $css = '.sm-wrapper{width:100%;overflow-x:auto;margin:20px 0}'
        .'.sm-table{width:100%;border-collapse:collapse;table-layout:auto}'
        .'.sm-table td{vertical-align:top;text-align:left;padding:12px 16px;border:0;border-right:6px solid #777;min-width:160px;background:transparent}'
        .'.sm-table td:last-child{border-right:0}'
        .'.sm-table a{color:#000080;font-weight:600;text-decoration:none;line-height:1.5}'
        .'.sm-table a:hover{text-decoration:underline}'
        .'.sm-table .sm-level-1 a{color:#000;font-weight:700}'
        .'.sm-table .sm-level-2 a{color:#000080;font-weight:700}'
        .'.sm-table .sm-level-3 a,.sm-table .sm-level-4 a,.sm-table .sm-level-5 a{color:#000;font-weight:400;font-size:14px}'
        .'@media(max-width:768px){.sm-table td{min-width:140px;padding:10px}}';
    wp_register_style('sm-seitenmatrix', false, array(), '1.0.0');
    wp_enqueue_style('sm-seitenmatrix');
    wp_add_inline_style('sm-seitenmatrix', $css);
});
