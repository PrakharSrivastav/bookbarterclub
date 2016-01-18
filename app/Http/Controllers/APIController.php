<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Book;


class APIController extends Controller
{
    private $key;
    private $url;
    private $bookUrl;
    function __construct() {
        $this->key = "dTSlo84cL7VoH1TyZLKwNw";
        $this->url = "https://www.goodreads.com/search/index.xml?key=__API_KEY__&q=__QUERY__";
        $this->bookUrl = "https://www.goodreads.com/book/show/__QUERY__?format=xml&key=__API_KEY__";
    }
    
    public function index($query) {
        $query = str_replace(" ", "+", $query);
        $url = str_replace("__QUERY__", $query, $this->url);
        $url = str_replace("__API_KEY__", $this->key, $url);
        
        $ch = curl_init();
        $message = "";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $output = curl_exec($ch);
        if ($output === false) {
            $message = ["status" => 100, "errono" => curl_errno($ch), "message" => curl_error($ch) ];
        } 
        else {
            $message = json_encode(simplexml_load_string($output));
        }
        curl_close($ch);
        return $message;
    }
    
    public function searchBook( $id) {
        if (!empty($id)) {
            
            // $query = str_replace(" ", "+", $query);
            $url = str_replace("__QUERY__", $id, $this->bookUrl);
            $url = str_replace("__API_KEY__", $this->key, $url);
            
            // return $url;
            $ch = curl_init();
            $message = "";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            $message = curl_exec($ch);
            if ($message === false) {
                $message = ["status" => 100, "errono" => curl_errno($ch), "message" => curl_error($ch) ];
            } 
            else {
                $message = simplexml_load_string($message);
            }
            curl_close($ch);
            
            $message_response['id'] = (string)$message->book->id;
            $message_response['book_id'] = (string)$message->book->id;
            $message_response['title'] = (string)$message->book->title;
            $message_response['isbn'] = (string)$message->book->isbn;
            $message_response['isbn13'] = (string)$message->book->isbn13;
            $message_response['image'] = (string)$message->book->image_url;
            $message_response['small_image'] = (string)$message->book->small_image_url;
            $message_response['publisher'] = (string)$message->book->publisher;
            $message_response['description'] = (string)$message->book->description;
            $message_response['average_rating'] = (string)$message->book->average_rating;
            $message_response['text_reviews_count'] = (string)$message->book->text_reviews_count;
            $message_response['ratings_count'] = (string)$message->book->ratings_count;
            $message_response['authors'] = [];
            if (isset($message->book->authors->author)) {
                foreach ($message->book->authors->author as $auth) {
                    $author = [];
                    $author['id'] = (string)$auth->id;
                    $author['name'] = (string)$auth->name;
                    $author['image_url'] = (string)$auth->image_url;
                    $author['average_rating'] = (string)$auth->average_rating;
                    $author['ratings_count'] = (string)$auth->ratings_count;
                    $author['text_reviews_count'] = (string)$auth->text_reviews_count;
                    $author['image_url'] = (string)$auth->image_url;
                    $message_response['authors'] = $author;
                }
            }
            $message_response['source'] = "Good Reads";
            $message_response['subtitle'] = "";
            $message_response['reviews_widget'] = (string)$message->book->reviews_widget;
            $all_books = Book::where(["book_id"=>$message->book->id,"is_wishlist"=>'0'])->get();
            // $books = [];
            $user = Auth::user();
            $user_count = [];
            foreach ($all_books as $book) {
                if($book->user_id != $user->id){
                    // $books[] = $book;
                    if(!in_array($book->user_id, $user_count)){
                        $user_count[] = $book->user_id;
                    }
                }
            }
            $message_response['count'] = count($user_count);
            return $message_response;
        } 
        else {
            $message = ["status" => 100, "errono" => 100, "message" => "Invalid Request"];
            return $message;
        }
    }
}
