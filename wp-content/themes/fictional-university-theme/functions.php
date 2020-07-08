<?php
//Our function
function university_files() {
  //Here we load out css and javascript
  //For JS wordpress needs to know about dependencies (null), a version and whether to load at footer
  wp_enqueue_script('main-university-js',get_theme_file_uri('/js/scripts-bundled.js'),NULL,'1.0',true);
  wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
  wp_enqueue_style('font-awesome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  //wp function
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());
}


//Wordpress function add_action. Needs a command and a function we create
add_action('wp_enqueue_scripts','university_files');


function university_features() {
  register_nav_menu('headerMenuLocation','Header Menu Location');
  register_nav_menu('footerLeftMenuLocation','Footer Menu Left');
  register_nav_menu('footerRightMenuLocation','Footer Menu Right');

  add_theme_support('title-tag');

}

//Action for our title
add_action('after_setup_theme','university_features');