<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Trend;
Use Auth;
use \App\User;

class PagesController extends Controller
{
    public function __construct() {
        // $this->middleware('auth',["only"=>["dashboard"]]);
    }
    
    public function home() {
        $books = Trend::all();
        $title = "Book Barter Club";
        return view("static.homepage", compact("title", "books"));
        // return view("static.home", compact("title","books"));
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
            $books = Trend::all();
            $title = "My Dashboard";
            $user = Auth::user();
            return view('home', compact("title", "books", "user", "my_books"));
        }
        else{
            Auth::logout();
            return redirect()->route('home');
        }
    }
}
