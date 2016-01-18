<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Trend;
use App\Book;
use Auth;
use Validator;
use App\Http\Controllers\APIController;

class UserController extends Controller
{
    
    public function __construct() {
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
    }
    
    public function showBooks(Request $request, $book_id) {
        if (Auth::check()) {
            $title = "Borrow Book";
            $book = new Book();
            $the_book = $book->where('book_id', $book_id)->first();
            if (count($the_book) < 1) {
                $api = new APIController();
                $the_book = $api->searchBook($book_id);
            } 
            else {
                $the_book['description'] = $the_book['desc'];
                $the_book['text_reviews_count'] = $the_book['reviews'];
                $the_book['average_rating'] = $the_book['rating'];
                unset($the_book['reviews']);
                unset($the_book['rating']);
                unset($the_book['desc']);
            }
            if (!isset($the_book['author_name'])) {
                $the_book['author_name'] = "";
            }
            
            if (!isset($the_book['author_id'])) {
                $the_book['author_id'] = "";
            }
            $the_book['reviews_widget'] = str_replace(array("565px", "565"), "100%", $the_book['reviews_widget']);
            $the_book['reviews_widget'] = str_replace(array("padding: 18px 0;"), "padding:0 !important;margin:0px !important;", $the_book['reviews_widget']);
            $the_book['reviews_widget'] = str_replace(array("<style>"), "<style> #the_iframe{padding-left:10px;margin:0px !important}", $the_book['reviews_widget']);
            
            $books = Trend::all();
            $user = Auth::user();
            $other_books = $book->where(['book_id' => $book_id, "is_lendable" => '1'])->get();
            $other_users = [];
            $user_filter = [];
            foreach ($other_books as $booka) {
                if ($booka->user_id != $user->id && !in_array($booka->user_id, $user_filter)) {
                    $other_users[] = $booka->user;
                    $user_filter[] = $booka->user_id;
                }
            }
            
            // get more suggestions for books around your area
            $suggestions = [];
            $more_books = Book::all()->take(100);
            foreach ($more_books as $more) {
                $matches = [];
                $found_user = $more->user;
                $theta = doubleval($found_user['longitude']) - doubleval($user->longitude);
                $dist = sin(deg2rad(doubleval($found_user['latitude']))) * sin(deg2rad(doubleval($user->latitude))) + cos(deg2rad(doubleval($found_user['latitude']))) * cos(deg2rad(doubleval($user->latitude))) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = round($dist * 60 * 1.1515 * 1.609344, 1);
                $matches['location_name'] = $found_user['location_name'];
                $matches['firstname'] = $found_user['firstname'];
                $matches['distance'] = $miles;
                $matches['title'] = $more->title;
                $matches['image'] = $more->image;
                $matches['rating'] = $more->rating;
                $matches['publisher'] = $more->publisher;
                $matches['isbn'] = $more->isbn;
                $matches['id'] = $more->book_id;
                $matches['desc'] = $more->desc;
                $suggestions[] = $matches;
            }
            
            uasort($suggestions, function ($b) {
                return $b['distance'];
            });
            $suggestions = array_slice($suggestions, 0, 4);
            return view("profile.show-books", compact("title", "the_book", "books", "user", "other_users", "suggestions"));
        } 
        else {
            Auth::logout();
            return redirect()->route('home');
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
    }
    
    public function addToWishlist(Request $request) {
        
        $book = new Book();
        
        $book->user_id = Auth::user()->id;
        $book->book_id = $request->input("book_id");
        $book->title = $request->input("title");
        $book->desc = $request->input("description");
        $book->reviews = $request->input("reviews");
        $book->rating = $request->input("rating");
        $book->image = $request->input("image");
        $book->publisher = $request->input("publisher");
        $book->author_name = $request->input("author_name");
        $book->author_id = $request->input("author_id");
        $book->source = $request->input("source");
        $book->subtitle = $request->input("subtitle");
        $book->isbn = $request->input("isbn");
        $book->reviews_widget = $request->input("reviews_widget");
        $book->is_wishlist = '1';
        $book->is_fav = '0';
        $book->is_lendable = '0';
        $book->is_sellable = '0';
        
        $my_books = Auth::user()->books;
        
        foreach ($my_books as $books) {
            if ($books->book_id == $book->book_id) {
                $message = ["code" => 100, "message" => "This book already exists in your collection. Please chose another book to add to wishlist"];
                return die(json_encode($message));
                
                // break;
                
            }
        }
        $user = Auth::user();
        if ($user->books()->save($book)) {
            $message = ["code" => 101, "message" => "The book has been added to your wishlist."];
        }
        return $message;
    }
    
    public function addToBookStore(Request $request) {
        $my_books = Auth::user()->books;
        $book_id = $request->input("book_id");
        $found_book = [];
        // see if the book already exists in the user books
        foreach ($my_books as $books) {
            if ($books->book_id == $book_id) {
                $found_book[] = $books;
            }
        }
        // return $found_book;
        if (count($found_book) > 0) {
            $message = [];
            // check if the book is in the bookshelf
            foreach ($found_book as $test_this_book) {
                // code...
                if ($test_this_book->is_sellable == '1') {
                    $message = ["code" => 100, "message" => "This book is already in your book store.<br>To edit the price go to 'My Books' and edit the book in your book store"];
                    return die(json_encode($message));
                }
                // check if the book is in the wishlist:
                else if ($test_this_book->is_wishlist) {
                    $found_book->is_wishlist = '0';
                    # a book can be both lendable as well as sellable
                    // $found_book->is_lendable = "0";
                    $found_book->is_sellable = "1";
                    $found_book->save();
                    $message = ["code" => 101, "message" => "The book is added to your bookshelf."];
                    return die(json_encode($message));
                }
            }
        }
        // if the logic pases through above then book is not in bookshelf.
        // the logic should create a new book and add it to the users booklist.
        $book = new Book();
        
        // $book->user_id = Auth::user()->id;
        $book->book_id = $request->input("book_id");
        $book->title = $request->input("title");
        $book->desc = $request->input("description");
        $book->reviews = $request->input("reviews");
        $book->rating = $request->input("rating");
        $book->image = $request->input("image");
        $book->publisher = $request->input("publisher");
        $book->author_name = $request->input("author_name");
        $book->author_id = $request->input("author_id");
        $book->source = $request->input("source");
        $book->subtitle = $request->input("subtitle");
        $book->isbn = $request->input("isbn");
        $book->reviews_widget = $request->input("reviews_widget");
        $book->is_wishlist = '0';
        $book->is_fav = '0';
        $book->is_lendable = '0';
        $book->is_sellable = '1';
        $book->selling_price = $request->input("selling_price");
        $user = Auth::user();
        if ($user->books()->save($book)) {
            $message = ["code" => 101, "message" => "The book is added to your bookstore and available to other users to buy."];
        }
        return $message;
    }
    
    public function addToBookshelf(Request $request) {
        $my_books = Auth::user()->books;
        $book_id = $request->input("book_id");
        $found_book = [];
        // see if the book already exists in the user books
        foreach ($my_books as $books) {
            if ($books->book_id == $book_id) {
                $found_book = $books;
                break;
            }
        }
        
        if (count($found_book) > 0) {
            $message = [];
            // check if the book is in the bookshelf
            if ($found_book->is_lendable) {
                $message = ["code" => 100, "message" => "This book is already on your book shelf."];
                return die(json_encode($message));
            }
            // check if the book is in the wishlist:
            else if ($found_book->is_wishlist) {
                $found_book->is_wishlist = '0';
                $found_book->is_lendable = "1";
                # commented below because book can be sellable as well as lendable
                // $found_book->is_sellable = "0";
                $found_book->save();
                $message = ["code" => 101, "message" => "The book is added to your bookshelf."];
                return die(json_encode($message));
            }
        }
        // if the logic pases through above then book is not in bookshelf.
        // the logic should create a new book and add it to the users booklist.
        $book = new Book();
        
        // $book->user_id = Auth::user()->id;
        $book->book_id = $request->input("book_id");
        $book->title = $request->input("title");
        $book->desc = $request->input("description");
        $book->reviews = $request->input("reviews");
        $book->rating = $request->input("rating");
        $book->image = $request->input("image");
        $book->publisher = $request->input("publisher");
        $book->author_name = $request->input("author_name");
        $book->author_id = $request->input("author_id");
        $book->source = $request->input("source");
        $book->subtitle = $request->input("subtitle");
        $book->isbn = $request->input("isbn");
        $book->reviews_widget = $request->input("reviews_widget");
        $book->is_wishlist = '0';
        $book->is_fav = '0';
        $book->is_lendable = '1';
        $book->is_sellable = '0';
        $user = Auth::user();
        if ($user->books()->save($book)) {
            $message = ["code" => 101, "message" => "The book is added to your bookshelf."];
        }
        return $message;
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::find($id);
        $title = "Edit Profile";
        $books = Trend::all();
        return view("profile.edit", compact("user", "title", "books"));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), ["firstname" => "required|min:2|max:255", "lastname" => "required|min:2|max:255", "gender" => "required", "about" => "min:10", "dob" => "required|date_format:Y-m-d", "fav_quote" => "min:5", "contact_num" => "digits_between:8,12", "mobile_num" => "digits_between:8,12"]);
        if ($validator->fails()) {
            return redirect()->route('user.edit', ['id' => $id])->withErrors($validator)->withInput();
        } 
        else {
            $user = User::findOrFail($id);
            $user->firstname = $request->input("firstname");
            $user->lastname = $request->input("lastname");
            $user->about = $request->input("about");
            $user->dob = $request->input("dob");
            $user->fav_quote = $request->input("fav_quote");
            $user->contact_num = $request->input("contact_num");
            $user->mobile_num = $request->input("mobile_num");
            $user->gender = $request->input("gender");
            $user->save();
            return redirect()->route('dashboard');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
    }
    
    public function savemap(Request $request) {
        $user_id = $request->input("user");
        $location_name = $request->input("name");
        $location_cord = $request->input("location");
        $location_cord = str_replace(array("(", ")", " "), "", $location_cord);
        $location_cord = explode(",", $location_cord);
        
        $user = User::find($user_id);
        $user->latitude = $location_cord[0];
        $user->longitude = $location_cord[1];
        $user->location_name = $location_name;
        
        if ($user->save()) {
            $message = ["status" => 100, "location_name" => $location_name];
            return $message;
        }
        return false;
    }
    
    public function books($id) {
        $user = User::findOrFail($id);
        $my_books = $user->books;
        $title = "Edit Books";
        $books = Trend::all();
        return view("profile.get-books", compact("user", "title", "books", "my_books"));
    }
    
    public function getBookDetails(Request $request, $id) {
    }
  
    public function deleteBooks($id, $book_id) {
        $user = User::findOrFail($id);
        $user->books()->where('id', $book_id)->delete();
        return redirect()->route('user.get.books', $id);
    }
}
