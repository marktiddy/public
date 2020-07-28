<?php

add_action('rest_api_init', 'universityLikeRoutes');

//This takes 3 arguments, endpoint, name and array
function universityLikeRoutes()
{

    //Post method
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike',
    ));

    //Delete method
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike',
    ));
}

function createLike($data)
{
    $professor = sanitize_text_field($data['professorId']);

    wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => 'Second PHP Create Post Test',
        'meta_input' => array(
            'liked_professor_id' => $professor,
        ),

    ));
}
function deleteLike()
{
    return 'tried to remove';
}
