<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;


class BookController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        //
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
        //
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        //
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
        //
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
        //
        
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if (Auth::check()) {
            $selling_price = $request->input("selling_price");
            $book = Book::findOrFail($id);
            $book->selling_price = $selling_price;
            if ($book->save()) {
                return ["code" => 100, "message" => "The selling price of the book is updated in the system"];
            } 
            else {
                return ["code" => 101, "message" => "We cannot update the book prices right now. Please try again after sometime."];
            }
        }
        else{
            return ["code" => 101, "message" => "You are not authenticated to change price"];
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
}
