<?php
Route::get("/search/{query}", "APIController@index")->name("search");
Route::get("/stories", "PagesController@stories")->name("stories");
Route::get("/user/{id}/deleteBooks/{book_id}", "UserController@deleteBooks")->name('user.delete.books');

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get("/", "PagesController@home")->name("home");
    Route::resource('user', 'UserController');
    Route::get('/user/{user}/books', "UserController@books")->name('user.get.books');
    // Route::post("/user/{user}/createBooks", "UserController@createBooks")->name('user.create.books');
    // Route::post("/user/{user}/getBookDetails/", "UserController@getBookDetails")->name('user.get.books');
    Route::get("/user/showBooks/{book_id}", "UserController@showBooks")->name('user.show.books');
    Route::post("/user/addWishlist","UserController@addToWishlist")->name('user.add.wishlist');
    Route::post("/user/addBookshelf","UserController@addToBookshelf")->name('user.add.bookshelf');
    Route::post("/user/addBookStore","UserController@addToBookstore")->name('user.add.bookstore');
    Route::post("/book/{id}/update","BookController@update")->name('edit.book.price');
    Route::get('/home', 'PagesController@dashboard')->name("dashboard");
    Route::post("/savemap", "UserController@savemap")->name("savemap");
    Route::get("/nearest_user/{book_id}", "PagesController@getNearestUser")->name("book.nearest.user");
    Route::post("/user_details", "PagesController@bookDetails")->name("book.details");
    Route::get("/searchBook/{id}", "APIController@searchBook")->name("searchBook");
    Route::post("/create/message","MessageController@store")->name("create.message");
    Route::get("/message","MessageController@index")->name("all_messages");
    Route::post("/send/message","MessageController@conversation")->name("send.message");
    
});

