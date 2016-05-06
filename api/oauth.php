<?php

// Config
$api_config = json_decode(file_get_contents('../config/api.json'));

// Api
require_once '../classes/api.class.php';
$api = new Api();

// Redirect URL
$redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];

// Oauth callback
if(!empty($_GET) && !empty($_GET['code']))
{
    $result = $api->call(
        'https://bitbucket.org/site/oauth2/access_token',
        array(
            'grant_type'   => 'authorization_code',
            'code'         => $_GET['code'],
            'redirect_uri' => $redirect_url
        ),
        true,
        $api_config->key.':'.$api_config->secret
    );

    echo '<pre>';
    print_r($result);
    echo '</pre>';
    exit;
}

// Oauth redirect
else
{
    $oauth_url = 'https://bitbucket.org/site/oauth2/authorize?client_id='.$api_config->key.'&response_type=code&redirect_uri='.urlencode($redirect_url);
    header('Location:'.$oauth_url);
    exit;
}
