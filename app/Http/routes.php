<?php
Route::get("/", "PagesController@home")->name("home");
// Route::get("/about", "PagesController@about")->name("about");
// Route::get("/contact", "PagesController@contact")->name("contact");
Route::get("/search/{query}","APIController@index")->name("search");
Route::get("/searchBook/{id}","APIController@searchBook")->name("searchBook");
Route::get("/stories","PagesController@stories")->name("stories");
Route::get("/user/{id}/deleteBooks/{book_id}","UserController@deleteBooks")->name('user.delete.books');


Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::resource('user', 'UserController');
    Route::get('/user/{user}/books',"UserController@books")->name('user.get.books');
    Route::post("/user/{user}/createBooks","UserController@createBooks")->name('user.create.books');
    Route::get("/user/{id}/showBooks/{book_id}","UserController@showBooks")->name('user.show.books');
    Route::get('/home', 'PagesController@dashboard')->name("dashboard");
    Route::post("/savemap","UserController@savemap")->name("savemap");
});

