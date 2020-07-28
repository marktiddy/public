<?php
require get_theme_file_path('keys.php');
require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');
//Cusomise the RESTAPI

function university_custom_rest()
{
    register_rest_field('post', 'authorName', array(
        'get_callback' => function () {return get_the_author();},
    ));

    //Adds this to the rest
    register_rest_field('note', 'userNoteCount', array(
        'get_callback' => function () {return count_user_posts(get_current_user_id(), 'note');},
    ));

}

add_action('rest_api_init', 'university_custom_rest');

//Custom function for page banners
function pageBanner($args = null)
{
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }
    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!$args['photo']) {
        if (get_field('page_banner_background_image')) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
      </div>
    </div>
  </div>
<?php
}

//Our function
function university_files()
{
    //Here we load out css and javascript
    //For JS wordpress needs to know about dependencies (null), a version and whether to load at footer
    wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=' . $apiKey, null, '1.0', true);

    //This is to check if we're running it locally for webpack
    if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
        wp_enqueue_script('main-university-js', 'http://localhost:3000/bundled.js', null, '1.0', true);
    } else {
        wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors~scripts.9678b4003190d41dd438.js'), null, '1.0', true);
        wp_enqueue_script('main-university-js', get_theme_file_uri('/bundled-assets/scripts.15630ade3c1098138699.js'), null, '1.0', true);
        wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.15630ade3c1098138699.css'));
    }

    //Function to get our url
    //JS file / made up name / data we want to be available in JS

    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest'),
    ));
}

//Wordpress function add_action. Needs a command and a function we create
add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLeftMenuLocation', 'Footer Menu Left');
    register_nav_menu('footerRightMenuLocation', 'Footer Menu Right');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    //Support for multiple image sizes
    //Add some arguments. Nickname, pixels wide, pixels tall, to crop or not
    //Cropiing takes an array to specify how to crop e.g. array('left','top')
    //Alternatively you might enable the manual image crop plugin by tomasz
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);

}

//Action for our title
add_action('after_setup_theme', 'university_features');

//Action to order our events page
function university_adjust_queries($query)
{
//Order our programs
    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() and is_post_type_archive('campus') and $query->is_main_query()) {
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        //We're going to sort by event date and remove the past
        //This is simular to custom query code
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric',
        )));

    }
}
add_action('pre_get_posts', 'university_adjust_queries');

//Setting up google api key

function universityMapKey($api)
{
    $api['key'] = $apiKey;
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');

//redirect subscriber accounts onto homepage
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend()
{
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar()
{
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

//Function to customise login screen
//First arg - object to change Second - Function
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl()
{
    return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS()
{
    wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.15630ade3c1098138699.css'));
}

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle()
{
    return get_bloginfo('name');
}

//Force note posts to be private, sanitize their content and limit number of posts per person
//We add a priority (10 is default) and 2 which says it can work with 2 paramaters
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr)
{
    //Dont alloow any html
    if ($data['post_type'] == 'note') {
        if (count_user_posts(get_current_user_id(), 'note') > 4 and !$postarr['ID']) {
            die('You have reached your note limit');
        }

        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);

    }

    //Only do this for notes when the status isnt trash
    if ($data['post_type'] == 'note' and $data['post_status'] != 'trash') {
        $data['post_status'] = 'private';
    }

    return $data;
}