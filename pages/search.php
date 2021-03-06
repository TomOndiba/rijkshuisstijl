<?php
$site = elgg_get_site_entity();
elgg_set_page_owner_guid($site->guid);

$query = stripslashes(get_input('q', get_input('tag', '')));
$search_type = get_input('search_type', 'all');

$entity_type = get_input('entity_type', ELGG_ENTITIES_ANY_VALUE);
$entity_subtype = get_input('entity_subtype', ELGG_ENTITIES_ANY_VALUE);

$limit = get_input('limit', 10);
$offset = get_input('offset', 0);

$sort = 'relevance';
$order = 'desc';

$container_guid = get_input('container_guid', ELGG_ENTITIES_ANY_VALUE);
$profile_fields = get_input('elasticsearch_profile_fields');

global $CONFIG;
$subtypes = $CONFIG->search_subtypes;

if (!$entity_type) {
    $entity_type = 'object';
}

if (!$entity_subtype) {
    $entity_subtype = $subtypes[0];
}

$total_results = ESInterface::get()->search(
    $query,
    $search_type,
    $entity_type,
    $subtypes
);

$results = ESInterface::get()->search(
    $query,
    $search_type,
    $entity_type,
    $entity_subtype,
    $limit,
    $offset,
    $sort,
    $order,
    $container_guid,
    $profile_fields
);

if (function_exists('mb_convert_encoding')) {
    $sanitized_query = mb_convert_encoding($query, 'HTML-ENTITIES', 'UTF-8');
} else {
    // if no mbstring extension, we just strip characters
    $sanitized_query = preg_replace("/[^\x01-\x7F]/", "", $query);
}

$sanitized_query = htmlspecialchars($sanitized_query, ENT_QUOTES, 'UTF-8', false);

$title = elgg_echo("search");
$content = elgg_view("rijkshuisstijl/pages/search", array(
    'sanitized_query' => $sanitized_query,
    'search_type' => $search_type,
    'entity_type' => $entity_type,
    'entity_subtype' => $entity_subtype,
    'subtypes' => $subtypes,
    'limit' => $limit,
    'offset' => $offset,
    'sort' => $sort,
    'order' => $order,
    'container_guid' => $container_guid,
    'total_results' => $total_results,
    'results' => $results
));

echo elgg_view_page($title, $content, "default", array(
    'body_class' => 'background-grey'
));