<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Trend;
Use Auth;
use \App\User;
use \App\Book;

class PagesController extends Controller
{
    public function __construct() {
        
        // $this->middleware('auth',["only"=>["dashboard"]]);
        
        
    }
    
    public function home() {
        session_start();
        if (session_id() != "" || isset($_SESSION['latitude'])) {
            unset($_SESSION['latitude']);
            unset($_SESSION['longitude']);
            session_unset();
            session_destroy();
        }
        $books = Trend::all();
        $title = "Book Barter Club";
        return view("static.homepage", compact("title", "books"));
    }
    
    public function stories() {
        $title = "User Stories";
        return view("static.stories", compact("title"));
    }
    
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function dashboard() {
        if (Auth::check()) {
            $my_books = Auth::user()->books->all();
            
            foreach ($my_books as $book_arr) {
                // get in stock and wishlist book
                if ($book_arr->is_lendable == '1') {
                    $in_stock[] = $book_arr;
                }
                if ($book_arr->is_wishlist == '1') {
                    $wish_list[] = $book_arr;
                }
            }
            // return $in_stock;    
            $books = Trend::all();
            $title = "My Dashboard";
            $user = Auth::user();
            return view('home', compact("title", "books", "user","in_stock","wish_list"));
        } 
        else {
            Auth::logout();
            return redirect()->route('home');
        }
    }
    
    public function bookDetails(Request $request) {
        $book_id = $request->input("book");
        $book_id = trim($book_id);
        $book = Book::where('book_id', $book_id)->get();
        if (count($book) > 0) {
            $latitude = trim($request->input("latitude"));
            $longitude = trim($request->input("longitude"));
            if (session_id() == "" || !isset($_SESSION['latitude'])) {
                session_start();
                $_SESSION['latitude'] = $latitude;
                $_SESSION['longitude'] = $longitude;
            } 
            else {
                unset($_SESSION['longitude']);
                unset($_SESSION['latitude']);
                $_SESSION['latitude'] = $latitude;
                $_SESSION['longitude'] = $longitude;
            }
            session_commit();
            $message = ["code" => 100, "message" => "success"];
        } 
        else $message = ["code" => 101, "message" => "fail"];
        return $message;
    }
    
    public function getNearestUser(Request $request, $book_id) {
        session_start();
        if (session_id() == "" || !isset($_SESSION['latitude'])) {
            return redirect()->route('home');
        } 
        else {
            if (isset($_SESSION['latitude'])) {
                
                // get all the books from the book database.
                $books = Book::where("book_id", $book_id)->get();
                $valid_users = [];
                foreach ($books as $book) {
                    $matches = [];
                    $found_user = $book->user;
                    $theta = doubleval($found_user['longitude']) - doubleval($_SESSION['longitude']);
                    $dist = sin(deg2rad(doubleval($found_user['latitude']))) * sin(deg2rad(doubleval($_SESSION['latitude']))) + cos(deg2rad(doubleval($found_user['latitude']))) * cos(deg2rad(doubleval($_SESSION['latitude']))) * cos(deg2rad($theta));
                    $dist = acos($dist);
                    $dist = rad2deg($dist);
                    $miles = round($dist * 60 * 1.1515 * 1.609344, 1);
                    $matches['location_name'] = $found_user['location_name'];
                    $matches['firstname'] = $found_user['name'];
                    $matches['distance'] = $miles;
                    $valid_users[] = $matches;
                }
                
                // more suggestions based on your location
                $suggestions = [];
                $more_books = Book::all()->take(100);
                foreach ($more_books as $more) {
                    $matches = [];
                    $found_user = $more->user;
                    $theta = doubleval($found_user['longitude']) - doubleval($_SESSION['longitude']);
                    $dist = sin(deg2rad(doubleval($found_user['latitude']))) * sin(deg2rad(doubleval($_SESSION['latitude']))) + cos(deg2rad(doubleval($found_user['latitude']))) * cos(deg2rad(doubleval($_SESSION['latitude']))) * cos(deg2rad($theta));
                    $dist = acos($dist);
                    $dist = rad2deg($dist);
                    $miles = round($dist * 60 * 1.1515 * 1.609344, 1);
                    $matches['location_name'] = $found_user['location_name'];
                    $matches['firstname'] = $found_user['name'];
                    $matches['distance'] = $miles;
                    $matches['title'] = $more->title;
                    $matches['image'] = $more->image;
                    $matches['rating'] = $more->rating;
                    $matches['publisher'] = $more->publisher;
                    $matches['isbn'] = $more->isbn;
                    $suggestions[] = $matches;
                }
                
                // sort the array based on distance
                uasort($valid_users, function ($a) {
                    return $a['distance'];
                });
                $valid_users = array_slice($valid_users, 0, 3);
                
                // sort the array based on distance
                uasort($suggestions, function ($b) {
                    return $b['distance'];
                });
                $suggestions = array_slice($suggestions, 0, 8);
                $book = $books[0];
                
                // return $suggestions;
                return view("static.foundBooks", compact("valid_users", "book", "suggestions"));
            }
        }
    }
}
