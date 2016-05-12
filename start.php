<?php

$FFD_TOPICS = array(
	'inkomstenbelasting' => 'Inkomstenbelasting',
	'loonheffingen' => 'Loonheffingen',
	'omzetbelasting' => 'Omzetbelasting',
	'toeslagen' => 'Toeslagen',
	'vennootschapsbelasting' => 'Vennootschapsbelasting'
);

include_once(dirname(__FILE__) . "/lib/functions.php");
include_once(dirname(__FILE__) . "/lib/hooks.php");

elgg_register_event_handler('init', 'system', 'rijkshuisstijl_init');

function rijkshuisstijl_init() {
    elgg_register_plugin_hook_handler('action', 'plugins/settings/save', 'rijkshuisstijl_plugins_settings_save');
	elgg_register_plugin_hook_handler("register", "menu:site", "rijkshuisstijl_menu_handler");
    elgg_register_plugin_hook_handler("route", "questions", "rijkshuisstijl_route_questions_hook");

    elgg_register_css('rijkshuisstijl', '/mod/rijkshuisstijl/assets/rijkshuisstijl.css');
    elgg_load_css('rijkshuisstijl');

    elgg_register_js('rijkshuisstijl', '/mod/rijkshuisstijl/assets/rijkshuisstijl.js', "footer");
    elgg_load_js('rijkshuisstijl');

    // revert hacks of older Elgg modules
    elgg_unextend_view('page/elements/head', 'subsite_manager/topbar_fix');

	elgg_register_plugin_hook_handler("index", "system", "rijkshuisstijl_custom_index", 40); // must be very early

    elgg_register_page_handler("profile", "rijkshuisstijl_profile_page_handler");
    elgg_register_page_handler("forum", "rijkshuisstijl_forum_page_handler");
    elgg_register_page_handler("news", "rijkshuisstijl_news_page_handler");
    elgg_register_page_handler("videos", "rijkshuisstijl_videos_page_handler");
    elgg_register_page_handler("topics", "rijkshuisstijl_topics_page_handler");
    elgg_register_page_handler("pinboard", "rijkshuisstijl_pinboard_page_handler");

	elgg_register_action("rijkshuisstijl/profile/setprofileparameter", dirname(__FILE__) . "/actions/profile/setprofileparameter.php");
	elgg_register_action("rijkshuisstijl/profile/changepassword", dirname(__FILE__) . "/actions/profile/changepassword.php");
	elgg_register_action("rijkshuisstijl/profile/setprofilefield", dirname(__FILE__) . "/actions/profile/setprofilefield.php");
	elgg_register_action("rijkshuisstijl/search", dirname(__FILE__) . "/actions/search.php");
	elgg_register_action("rijkshuisstijl/questions/vote", dirname(__FILE__) . "/actions/questions/vote.php");
}

/**
 * Profile page handler
 *
 * @param array $page Array of URL segments passed by the page handling mechanism
 * @return bool
 */
function rijkshuisstijl_profile_page_handler($page) {
	if (isset($page[0])) {
		$username = $page[0];
		$user = get_user_by_username($username);
		elgg_set_page_owner_guid($user->guid);
	} elseif (elgg_is_logged_in()) {
		forward(elgg_get_logged_in_user_entity()->getURL());
	}

	// short circuit if invalid or banned username
	if (!$user || ($user->isBanned() && !elgg_is_admin_logged_in())) {
		register_error(elgg_echo("profile:notfound"));
		forward();
	}

	$action = NULL;
	if (isset($page[1])) {
		$action = $page[1];
	}

	if ($action == "edit") {
		// use the core profile edit page
		require dirname(__FILE__) . "/pages/profile/edit.php";
		return true;
	}
	else if ($action == "interests")
	{
		require dirname(__FILE__) . "/pages/profile/interests.php";
		return true;
	}
	else if ($action == "settings")
	{
		require dirname(__FILE__) . "/pages/profile/settings.php";
		return true;
	}
	else
	{
		require dirname(__FILE__) . "/pages/profile/index.php";
		return true;
	}

	// main profile page
	$content = elgg_view("profile/wrapper");

	$body = elgg_view_layout("one_column", array("content" => $content));
	echo elgg_view_page($user->name, $body);
	return true;
}

/**
 * Forum page handler
 *
 * @param array $page Array of URL segments passed by the page handling mechanism
 * @return bool
 */
function rijkshuisstijl_forum_page_handler($page) {
	$action = NULL;
	if (isset($page[0])) {
		$action = $page[0];
	}

	if ($action == "category")
	{
		require dirname(__FILE__) . "/pages/forum/category.php";
		return true;
	}
	else
	{
		require dirname(__FILE__) . "/pages/forum/index.php";
		return true;
	}

	return true;
}

function rijkshuisstijl_news_page_handler($page) {
	require dirname(__FILE__) . "/pages/news.php";
	return true;
}

function rijkshuisstijl_videos_page_handler($page) {
	if ($page[0]) {
		set_input("topic", $page[0]);
	}

	require dirname(__FILE__) . "/pages/videos.php";
	return true;
}

function rijkshuisstijl_topics_page_handler($page) {
	if ($page[0]) {
		set_input("topic", $page[0]);
	}

	require dirname(__FILE__) . "/pages/topics.php";
	return true;
}

function rijkshuisstijl_pinboard_page_handler($page) {
	require dirname(__FILE__) . "/pages/pinboard.php";
	return true;
}

function rijkshuisstijl_route_questions_hook($hook_name, $entity_type, $return_value, $params) 
{
	$page = elgg_extract("segments", $return_value);
	switch ($page[0]) 
	{
		case "view":
			if (isset($page[1])) 
			{
				set_input("guid", $page[1]);
			}

			include(dirname(__FILE__) . "/pages/questions/view.php");
			return true;
			break;
	}
}