<?php
/**
 * View a list of items
 *
 * @package Elgg
 *
 * @uses $vars['items']       Array of ElggEntity or ElggAnnotation objects
 * @uses $vars['offset']      Index of the first list item in complete list
 * @uses $vars['limit']       Number of items per page. Only used as input to pagination.
 * @uses $vars['count']       Number of items in the complete list
 * @uses $vars['base_url']    Base URL of list (optional)
 * @uses $vars['pagination']  Show pagination? (default: true)
 * @uses $vars['position']    Position of the pagination: before, after, or both
 * @uses $vars['full_view']   Show the full view of the items (default: false)
 * @uses $vars['list_class']  Additional CSS class for the <ul> element
 * @uses $vars['item_class']  Additional CSS class for the <li> elements
 */

$items = $vars['items'];
$offset = elgg_extract('offset', $vars);
$limit = elgg_extract('limit', $vars);
$count = elgg_extract('count', $vars);
$base_url = elgg_extract('base_url', $vars, '');
$display_as_list = elgg_extract('display_as_list', $vars, true);
$pagination = elgg_extract('pagination', $vars, true);
$offset_key = elgg_extract('offset_key', $vars, 'offset');

$list_class = 'elgg-list';
if (isset($vars['list_class'])) {
    $list_class = "$list_class {$vars['list_class']}";
}

$item_class = 'elgg-item';
if (isset($vars['item_class'])) {
    $item_class = "$item_class {$vars['item_class']}";
}

$html = "";
$nav = "";

if ($display_as_list) {
    $html .= "<ul class=\"$list_class\">";
}

if (is_array($items) && count($items) > 0) {
    foreach ($items as $item) {
        $li = elgg_view_list_item($item, $vars);
        if ($li) {
            if (elgg_instanceof($item)) {
                $id = "elgg-{$item->getType()}-{$item->getGUID()}";
            } else {
                $id = "item-{$item->getType()}-{$item->id}";
            }

            if ($display_as_list) {
                $html .= "<li id=\"$id\" class=\"$item_class\">$li</li>";
            } else {
                $html .= $li;
            }
        }
    }
}

if ($display_as_list) {
    $html .= '</ul>';
}

if ($pagination && $count) {
    $html .= '<div class="forum__pagination">';
    $html .= elgg_view('navigation/pagination', array(
        'base_url' => $base_url,
        'offset' => $offset,
        'count' => $count,
        'limit' => $limit,
        'offset_key' => $offset_key,
    ));
    $html .= '</div>';
}

echo $html;
