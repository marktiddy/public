<?php 

//Custom Post Types
function university_post_types() {
  //Name of custom post
  //Array of options to describe those options
  //The labels sets things like name e.g. 'Page' 'Post'
  register_post_type('event',array(
    'show_in_rest'=>true,
    'supports'=> array('title','editor','excerpt'),
    'rewrite' => array(
      'slug'=> 'events'
    ),
    'has_archive'=>true,
    'public' => true,
    'labels'=> array(
      'name'=> 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items'=> 'All Events',
      'singular_name'=>'Event'
    ),
    'menu_icon'=> 'dashicons-calendar-alt'
  ));
}


//Add the action
add_action('init','university_post_types');

?>