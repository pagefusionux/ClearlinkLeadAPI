<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// root request
$app->get('/', function () use ($app) {
    return "ClearlinkLeadAPI for ClearlinkLead: " . $app->version();
});

// get access token
$app->post('/access_token', function() use ($app){
  return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
});

// refresh access token
$app->post('/refresh_token', function() use ($app){
  return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
});

// return user instance
$app->get('/access_token/me', 'UsersController@me');

// users
$app->get('/users/', 'UsersController@index');
$app->post('/users/', 'UsersController@store');
$app->get('/users/{user_id}', 'UsersController@show');
$app->put('/users/{user_id}', 'UsersController@update');
$app->delete('/users/{user_id}', 'UsersController@destroy');

// user types
$app->get('/userTypes','UserTypesController@index');
$app->post('/userTypes','UserTypesController@store');
$app->get('/userTypes/{user_type_id}','UserTypesController@show');
$app->put('/userTypes/{user_type_id}', 'UserTypesController@update');
$app->delete('/userTypes/{user_type_id}', 'UserTypesController@destroy');

// posts
$app->get('/posts','PostController@index');
$app->post('/posts','PostController@store');
$app->get('/posts/{post_id}','PostController@show');
$app->put('/posts/{post_id}', 'PostController@update');
$app->delete('/posts/{post_id}', 'PostController@destroy');

// comments
$app->get('/comments', 'CommentController@index');
$app->get('/comments/{comment_id}', 'CommentController@show');

// comments of a post
$app->get('/posts/{post_id}/comments', 'PostCommentController@index');
$app->post('/posts/{post_id}/comments', 'PostCommentController@store');
$app->put('/posts/{post_id}/comments/{comment_id}', 'PostCommentController@update');
$app->delete('/posts/{post_id}/comments/{comment_id}', 'PostCommentController@destroy');
