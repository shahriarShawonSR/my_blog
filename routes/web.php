<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', 'HomeController@index')->name('home');
Route::get('posts', 'PostDetailsController@index')->name('post.index');
Route::get('post/{slug}', 'PostDetailsController@details')->name('post.details');
//Show post by category
Route::get('category/{slug}', 'PostDetailsController@postByCategory')->name('category.posts');
//Show post by tag
Route::get('tag/{slug}', 'PostDetailsController@postByTag')->name('tag.posts');
//Author Profile controller
Route::get('profile/{username}', 'AuthorController@profile')->name('author.profile');
// Subscriber Controller Route
Route::post('subscriber', 'SubscriberController@store')->name('subscriber.store');
// Search controller Route
Route::get('/search', 'SearchController@search')->name('search');


Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::post('favorite/{post}/add', 'FavoriteController@add')->name('post.favorite');
    Route::post('comment/{post}', 'commentController@store')->name('comment.store');
});
// Admin Route
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');
    Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');


    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');

    // Pending or Approval route
    Route::get('pending/post', 'PostController@pending')->name('post.pending');
    Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');

    // Favorite Controller
    Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');

    // Show all author controller
    Route::get('authors', 'AuthorController@index')->name('author.index');
    Route::delete('authors/{id}', 'AuthorController@destroy')->name('author.destroy');

    // Admin/commentController
    Route::get('comments', 'CommentController@index')->name('comment.index');
    Route::delete('comments/{id}', 'CommentController@destroy')->name('comment.destroy');

    // Subscriber route
    Route::get('/subscriber', 'SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}', 'SubscriberController@destroy')->name('subscriber.destroy');
});
// Author Route
Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');
    Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');

    // Author/commentController
    Route::get('comments', 'CommentController@index')->name('comment.index');
    Route::delete('comments/{id}', 'CommentController@destroy')->name('comment.destroy');

    Route::resource('post', 'PostController');

    // Favorite Controller
    Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');
});
// View composers
// View::composer('*',function($view){

// });
View::composer('layouts.frontend.partial.footer', function ($view) {
    $categories = App\Category::all();
    $view->with('categories', $categories);
});
