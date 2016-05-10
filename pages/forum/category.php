<?php
  gatekeeper();

  /*$user = elgg_get_page_owner_entity();
  if (!$user) {
    register_error(elgg_echo("profile:notfound"));
    forward();
  }*/

  if (get_input('group_guid')) {
    elgg_set_page_owner_guid(get_input('group_guid'));
  } else {
    elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
  }

  $options = array(
      'type' => 'object',
      'subtype' => 'question'
  );

  $questions = elgg_get_entities($options, 'elgg_get_entities_from_private_settings');
  
  $body = $body . elgg_view('forum/category', array('questions' => $questions));

  //elgg_set_context('profile_edit');

  $title = elgg_echo('profile:edit');
  echo elgg_view_page($title, $body);
?>