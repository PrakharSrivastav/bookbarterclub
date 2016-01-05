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
    
    public function showBooks(Request $request, $id, $book_id) {
        if (Auth::check()) {
            $owner = User::findOrFail($id);
            $title = "Borrow Book";
            $book = new Book();
            $the_book = $book->where('book_id', $book_id)->first();
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
            return view("profile.show-books", compact("owner", "title", "the_book", "books", "user", "other_users"));
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
        
        //
        
        
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
    
    public function createBooks(Request $request, $id) {
        
        // find the user
        $user = User::findOrFail($id);
        
        // get book-id
        $book_id = $request->input('id');
        
        // echo $book->book_id;
        // get type [have:want]
        $type = $request->input('book_type_for_user');
        
        // check if book exists in the database
        $val = $user->books()->where('book_id', $book_id)->get();
        if (count($val) > 0 && $type == "have") {
            $message = array("status" => 98, "message" => "Book is already available in your collection");
            die(json_encode($message));
        } 
        else {
            $message = array("status" => 99, "message" => "An error has occured. Please try after sometime.");
            if (count($val) > 0 && $type == "wanted") {
                
                // return the search results
                $book = new Book();
                $my_book = $book->where(['book_id' => $book_id, "is_lendable" => '1'])->get();
                
                // $response[]=$request->user->latitude;
                $current_user = User::findOrFail($request->user);
                if (empty($current_user['latitude']) || empty($current_user['longitude'])) {
                    $message = array("status" => 98, "message" => "Please save your location before finding books near you.");
                    die(json_encode($message));
                }
                $response = [];
                foreach ($my_book as $this_book) {
                    if ($this_book->user->id != $request->user) {
                        $found_user = $this_book->user;
                        if (empty($found_user['latitude']) || empty($found_user['longitude'])) {
                            continue;
                        } 
                        else {
                            $theta = doubleval($found_user['longitude']) - doubleval($current_user['longitude']);
                            $dist = sin(deg2rad(doubleval($found_user['latitude']))) * sin(deg2rad(doubleval($current_user['latitude']))) + cos(deg2rad(doubleval($found_user['latitude']))) * cos(deg2rad(doubleval($current_user['latitude']))) * cos(deg2rad($theta));
                            $dist = acos($dist);
                            $dist = rad2deg($dist);
                            $miles = round($dist * 60 * 1.1515 * 1.609344, 1);
                            
                            // distant in kilometers
                            $found_user['distance'] = $miles . " km";
                            $response[] = $found_user;
                        }
                    }
                }
                $message = ["status" => 101, "message" => $response];
            } 
            else {
                $book = new Book();
                
                // get rest of the data
                $book->book_id = $request->input('id');
                $book->title = $request->input('title');
                $book->desc = $request->input('description');
                $book->reviews = $request->input('text_reviews_count');
                $book->rating = $request->input('average_rating');
                $book->image = $request->input('image');
                $book->publisher = $request->input('publisher');
                $authors = $request->input('authors');
                $book->author_name = $authors['name'];
                $book->author_id = $authors['id'];
                $book->source = "goodreads";
                $book->isbn = $request->input('isbn') . "/" . $request->input("isbn13");
                
                if ($type == "wanted") {
                    $book->is_wishlist = '1';
                    $book->is_fav = '0';
                    $book->is_lendable = '0';
                    $book->is_sellable = '0';
                } 
                else if ($type == "have") {
                    $book->is_wishlist = '0';
                    $book->is_fav = '0';
                    $book->is_lendable = '1';
                    $book->is_sellable = '0';
                }
                
                // the search results are not in the database we need to persist them
                if ($user->books()->save($book)) {
                    $message = array("status" => 100, "message" => "success");
                    
                    // return the search results
                    if ($type == "wanted") {
                        $book = new Book();
                        $my_book = $book->where(['book_id' => $book_id, "is_lendable" => '1'])->get();
                        
                        // $response[]=$request->user->latitude;
                        $current_user = User::findOrFail($request->user);
                        if (empty($current_user['latitude']) || empty($current_user['longitude'])) {
                            $message = array("status" => 98, "message" => "Please save your location before finding books near you.");
                            die(json_encode($message));
                        }
                        $response = [];
                        foreach ($my_book as $this_book) {
                            if ($this_book->user->id != $request->user) {
                                $found_user = $this_book->user;
                                if (empty($found_user['latitude']) || empty($found_user['longitude'])) {
                                    continue;
                                } 
                                else {
                                    
                                    $theta = doubleval($found_user['longitude']) - doubleval($current_user['longitude']);
                                    $dist = sin(deg2rad(doubleval($found_user['latitude']))) * sin(deg2rad(doubleval($current_user['latitude']))) + cos(deg2rad(doubleval($found_user['latitude']))) * cos(deg2rad(doubleval($current_user['latitude']))) * cos(deg2rad($theta));
                                    $dist = acos($dist);
                                    $dist = rad2deg($dist);
                                    $miles = round($dist * 60 * 1.1515 * 1.609344, 1);
                                    
                                    // distant in kilometers
                                    $found_user['distance'] = $miles . " km";
                                    $response[] = $found_user;
                                }
                            }
                        }
                        $message = ["status" => 101, "message" => $response];
                    }
                }
            }
            echo json_encode($message);
        }
    }
    
    public function deleteBooks($id, $book_id) {
        $user = User::findOrFail($id);
        $user->books()->where('id', $book_id)->delete();
        return redirect()->route('user.get.books', $id);
    }
}
