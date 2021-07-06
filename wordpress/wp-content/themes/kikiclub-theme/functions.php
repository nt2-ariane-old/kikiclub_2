<?php
add_theme_support('post-thumbnails');

add_action('rest_api_init', 'register_api_hooks');

function register_api_hooks()
{
    register_rest_route(
        'kikiclub',
        '/login/',
        array(
            'methods'  => 'POST',
            'callback' => 'login',
        )
    );
}

function login($request)
{
    $creds = array();
    $creds['user_login'] = $request["username"];
    $creds['user_password'] =  $request["password"];
    $creds['remember'] = true;
    $user = wp_signon($creds, false);

    if (is_wp_error($user))
        return $user->get_error_message();

    return $user;
}
