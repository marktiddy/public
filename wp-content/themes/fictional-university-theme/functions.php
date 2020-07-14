<?php
//Our function
function university_files() {
  //Here we load out css and javascript
  //For JS wordpress needs to know about dependencies (null), a version and whether to load at footer
  wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
  wp_enqueue_style('font-awesome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  //This is to check if we're running it locally for webpack
  if (strstr($_SERVER['SERVER_NAME'],'localhost')) {
    wp_enqueue_script('main-university-js','http://localhost:3000/bundled.js',NULL,'1.0',true);
  } else {
    wp_enqueue_script('our-vendors-js',get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'),NULL,'1.0',true);
    wp_enqueue_script('main-university-js',get_theme_file_uri('/bundled-assets/scripts.291f4fbd3120f33dcc5a.js'),NULL,'1.0',true);
    wp_enqueue_style('our-main-styles',get_theme_file_uri('/bundled-assets/styles.291f4fbd3120f33dcc5a.css'));
  }
}


//Wordpress function add_action. Needs a command and a function we create
add_action('wp_enqueue_scripts','university_files');


function university_features() {
  register_nav_menu('headerMenuLocation','Header Menu Location');
  register_nav_menu('footerLeftMenuLocation','Footer Menu Left');
  register_nav_menu('footerRightMenuLocation','Footer Menu Right');

  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  //Support for multiple image sizes
  //Add some arguments. Nickname, pixels wide, pixels tall, to crop or not
  //Cropiing takes an array to specify how to crop e.g. array('left','top')
  //Alternatively you might enable the manual image crop plugin by tomasz
  add_image_size('professorLandscape',400,260,true);
  add_image_size('professorPortrait',480,650,true);
  add_image_size('pageBanner',1500,350,true);

}

//Action for our title
add_action('after_setup_theme','university_features');

//Action to order our events page
function university_adjust_queries($query) {
//Order our programs
if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
    $query->set('orderby','title');
    $query->set('order','ASC');
    $query->set('posts_per_page',-1);
}

  if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
   //We're going to sort by event date and remove the past
   //This is simular to custom query code
   $today = date('Ymd');
   $query->set('meta_key','event_date');
   $query->set('orderby','meta_value_num');
   $query->set('order','ASC');
   $query->set('meta_query',array(array(
    'key'=> 'event_date',
    'compare'=> '>=',
    'value' => $today,
    'type' => 'numeric'
,              )));


  }  
}
add_action('pre_get_posts','university_adjust_queries');