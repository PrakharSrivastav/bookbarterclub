<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Message;
use Carbon\Carbon;
use App\Trend;

class MessageController extends Controller
{
    
    function __construct() {
        if (!Auth::check()) {
            Auth::logout();
            return redirect()->route('home');
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::check()) {
            Auth::logout();
            return redirect()->route('home');
        }
        $user = Auth::user();
        $first = Message::where("from", $user->id)->select('from as my_id', 'from_name as my_name', 'message', 'to as sender_id', 'to_name as sender_name', 'created_at');
        $all = Message::where("to", $user->id)->select('to as my_id', 'to_name as my_name', 'message', 'from as sender_id', 'from_name as sender_name', 'created_at')->union($first)->orderBy('created_at', 'desc')->get();
        $books = Trend::all();
        
        // print_r($all);
        $all_data = [];
        $count = 0;
        $sender_id = "";
        $id = "";
        $first_sender = "";
        foreach ($all as $senders) {
            
            $temp = [];

            if ($count == 0 || $id != $senders->sender_id) {
                $sender_name = $senders->sender_name;
                $id = $senders->sender_id;
                if ($count == 0) {
                    $first_sender['name'] = str_replace(" ", "_", $sender_id);
                    $first_sender['id'] = $senders->sender_id;
                }
                $temp['from'] = $senders->my_id;
                $temp['from_name'] = $senders->my_name;
                $temp['message'] = $senders->message;
                $temp['sender_id'] = $senders->sender_id;
                $temp['sender_name'] = $senders->sender_name;
                $temp['created_at'] = $senders->created_at;
                $all_data[$sender_name][] = $temp;
            } 
            else {
                $temp['from'] = $senders->my_id;
                $temp['from_name'] = $senders->my_name;
                $temp['message'] = $senders->message;
                $temp['sender_id'] = $senders->sender_id;
                $temp['sender_name'] = $senders->sender_name;
                $temp['created_at'] = $senders->created_at;
                $all_data[$sender_name][] = $temp;
            }
            $count++;
            // print_r($temp);
            // $all_data[] = $temp;
        }
        // print_r($all_data);
        return view("profile.message", compact("all_data", "user", "books", "first_sender"));
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
        $targetId = $request->input("user");
        $currentUser = Auth::user();
        $targetUser = User::findOrFail($targetId);
        $text = $request->input("data");
        
        // get a borrow request if any for this user
        $getMessage = Message::where(["from" => $currentUser->id, "to" => $targetUser->id, "type" => '1'])->orderBy('created_at', 'desc')->first();
        
        // if the borrow request is found
        if (count($getMessage) > 0) {
            $now = Carbon::now();
            $time = $getMessage->created_at;
            $diff = $now->diffInHours($time);
            
            if ($diff > 1) {
                $message = new Message();
                $message->from = $currentUser->id;
                $message->from_name = $currentUser->firstname;
                $message->to = $targetUser->id;
                $message->to_name = $targetUser->firstname;
                $message->type = '1';
                $message->message = $text;
                $message->save();
                $reply = ["code" => 100, "message" => "A borrow request has been sent to the Owner. Wait for his reply to continue further."];
                return die(json_encode($reply));
            } 
            else {
                $reply = ["code" => 101, "message" => "You have sent a borrow request recently. Please wait for the Owner to reply"];
                return die(json_encode($reply));
            }
        } 
        else {
            $message = new Message();
            $message->from = $currentUser->id;
            $message->from_name = $currentUser->firstname;
            $message->to = $targetUser->id;
            $message->to_name = $targetUser->firstname;
            $message->type = '1';
            $message->message = $text;
            $message->save();
        }
        $reply = ["code" => 100, "message" => "A borrow request has been sent to the Owner. Wait for his reply to continue further."];
        return die(json_encode($reply));
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
    
    public function conversation(Request $request) {
        
        $currentUser = Auth::user();
        // $currentUser = User::findOrFail($currentUser->id);
        $targetId = $request->input("to");
        $targetUser = User::findOrFail($targetId);
        $text = $request->input("text");

        $message = new Message();

        $message->from = $currentUser->id;
        $message->from_name = $currentUser->firstname;
        $message->to = $targetUser->id;
        $message->to_name = $targetUser->firstname;
        $message->type = '0';
        $message->message = $text;
        if($message->save()){
            $status = ["code"=>100,"message"=>"Message sent"];
            return die(json_encode($status));    
        }
        else{
            $status = ["code"=>101,"message"=>"There was error sending the message. Please try after sometime"];
            return die(json_encode($status));    
        }
        
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
        
        //
        
        
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
