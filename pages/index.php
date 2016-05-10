<?php
$site = elgg_get_site_entity();

elgg_set_page_owner_guid($site->guid);

$content = elgg_view('rijkshuisstijl/elements/forum');
$content .= elgg_view('rijkshuisstijl/elements/news');
$content .= elgg_view('rijkshuisstijl/elements/videos');

echo elgg_view_page("", $content, "default", array(
    'leader' => elgg_view('rijkshuisstijl/leader/home')
));