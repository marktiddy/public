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
  //Program Post Type
  register_post_type('program',array(
    'show_in_rest'=>true,
    'supports'=> array('title','editor'),
    'rewrite' => array(
      'slug'=> 'programs'
    ),
    'has_archive'=>true,
    'public' => true,
    'labels'=> array(
      'name'=> 'Programs',
      'add_new_item' => 'Add New Program',
      'edit_item' => 'Edit Event',
      'all_items'=> 'All Programs',
      'singular_name'=>'Program'
    ),
    'menu_icon'=> 'dashicons-awards'
  ));
  //Professor Post Type
  register_post_type('professor',array(
    'show_in_rest'=>true,
    'supports'=> array('title','editor','thumbnail'),
    'public' => true,
    'labels'=> array(
      'name'=> 'Professors',
      'add_new_item' => 'Add New Professor',
      'edit_item' => 'Edit Professor',
      'all_items'=> 'All Professors',
      'singular_name'=>'Professor'
    ),
    'menu_icon'=> 'dashicons-welcome-learn-more'
  ));
}


//Add the action
add_action('init','university_post_types');

?>