<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Message;
use App\Trend;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function __construct()
    {
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
    public function index()
    {
        if (!Auth::check()) {
            Auth::logout();
            return redirect()->route('home');
        }
        $user         = Auth::user();
        $first        = Message::where("from", $user->id)->select('id','from as my_id', 'from_name as my_name', 'message', 'to as sender_id', 'to_name as sender_name', 'created_at', 'read', 'reader');
        $all          = Message::where("to", $user->id)->select('id','to as my_id', 'to_name as my_name', 'message', 'from as sender_id', 'from_name as sender_name', 'created_at', 'read', 'reader')->union($first)->orderBy('created_at', 'desc')->get();
        $books        = Trend::all();
        $all_data     = [];
        $count        = 0;
        $sender_id    = "";
        $id           = "";
        $first_sender = "";
        // return $all;
        foreach ($all as $senders) {
            $temp = [];
            if ($count == 0 || $id != $senders->sender_id) {
                $sender_name = $senders->sender_name;
                $id          = $senders->sender_id;
                if ($count == 0) {
                    $first_sender['name'] = str_replace(" ", "_", $sender_id);
                    $first_sender['id']   = $senders->sender_id;
                }
                $temp['from']             = $senders->my_id;
                $temp['from_name']        = $senders->my_name;
                $temp['message']          = $senders->message;
                $temp['sender_id']        = $senders->sender_id;
                $temp['sender_name']      = $senders->sender_name;
                $temp['created_at']       = $senders->created_at;
                $temp['read']             = $senders->read;
                $temp['reader']           = $senders->reader;
                $temp['id']           = $senders->id;
                $all_data[$sender_name][] = $temp;
            } else {
                $temp['from']             = $senders->my_id;
                $temp['from_name']        = $senders->my_name;
                $temp['message']          = $senders->message;
                $temp['sender_id']        = $senders->sender_id;
                $temp['sender_name']      = $senders->sender_name;
                $temp['created_at']       = $senders->created_at;
                $temp['read']             = $senders->read;
                $temp['reader']           = $senders->reader;
                $temp['id']           = $senders->id;
                $all_data[$sender_name][] = $temp;
            }
            $count++;
        }
        return view("profile.message", compact("all_data", "user", "books", "first_sender"));
    }

    public function create()
    {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->input("book_id");
        $targetId    = $request->input("user");
        $currentUser = Auth::user();
        $book_id     = $request->input("book_id");

        $targetUser = User::findOrFail($targetId);
        $text       = $request->input("data");

        // get a borrow request if any for this user
        $getMessage = Message::where([
            "from"    => $currentUser->id,
            "to"      => $targetUser->id,
            "type"    => '1',
            "book_id" => $book_id]
        )->orderBy('created_at', 'desc')->first();

        // if the borrow request is found
        if (count($getMessage) > 0) {
            $now  = Carbon::now();
            $time = $getMessage->created_at;
            $diff = $now->diffInHours($time);

            if ($diff > 1) {
                $message            = new Message();
                $message->from      = $currentUser->id;
                $message->from_name = $currentUser->name;
                $message->to        = $targetUser->id;
                $message->to_name   = $targetUser->name;
                $message->type      = '1';
                $message->message   = $currentUser->name . " said .. : " . $text;
                $message->book_id   = $book_id;
                $message->read      = '1';
                $message->reader    = $targetUser->id;
                $message->save();
                // $currentUser->notif = 1;
                // $currentUser->save();
                $reply = ["code" => 100, "message" => "A borrow request has been sent to the Owner, please wait for owner to reply.<br>In the meanwhile you can add or search for more books."];
                return die(json_encode($reply));
            } else {
                $reply = ["code" => 101, "message" => "You have recently sent a borrow request for this book, please wait for owner to reply.<br>In the meanwhile you can add or search for more books"];
                return die(json_encode($reply));
            }
        } else {
            $message            = new Message();
            $message->from      = $currentUser->id;
            $message->from_name = $currentUser->name;
            $message->to        = $targetUser->id;
            $message->to_name   = $targetUser->name;
            $message->type      = '1';
            $message->message   = $currentUser->name . " said .. : " . $text;
            $message->book_id   = $book_id;
            $message->read      = '1';
            $message->reader    = $targetUser->id;
            $message->save();
            // $currentUser->notif = 1;
            // $currentUser->save();
        }
        $reply = ["code" => 100, "message" => "A borrow request has been sent to the Owner, please wait for owner to reply.<br>In the meanwhile you can add or search for more books."];
        return die(json_encode($reply));
    }

    public function show($id)
    {}

    public function conversation(Request $request)
    {
        $currentUser        = Auth::user();
        $targetId           = $request->input("to");
        $targetUser         = User::findOrFail($targetId);
        $text               = $request->input("text");
        $message            = new Message();
        $message->from      = $currentUser->id;
        $message->from_name = $currentUser->name;
        $message->to        = $targetUser->id;
        $message->to_name   = $targetUser->name;
        $message->type      = '0';
        $message->read      = '1';
        $message->reader    = $targetUser->id;
        $message->message   = $currentUser->name . " said .. : " . $text;
        if ($message->save()) {
            $status = ["code" => 100, "message" => "Message sent"];
            // $currentUser->notif = 1;
            // $currentUser->save();
            return die(json_encode($status));
        } else {
            $status = ["code" => 101, "message" => "There was error sending the message. Please try after sometime"];
            return die(json_encode($status));
        }
    }

    public function purchaseReq(Request $request)
    {
        $targetId    = $request->input("user");
        $currentUser = Auth::user();
        $targetUser  = User::findOrFail($targetId);
        $text        = $request->input("data");
        $book_id     = $request->input("book_id");

        // get the latest purchase request if any for this user
        $getMessage = Message::where([
            "from" => $currentUser->id,
            "to"   => $targetUser->id,
            "type" => '2',
        ])->orderBy('created_at', 'desc')->first();

        // if the purchase request is found
        if (count($getMessage) > 0) {
            $now  = Carbon::now();
            $time = $getMessage->created_at;
            $diff = $now->diffInHours($time);

            if ($diff > 1) {
                $message            = new Message();
                $message->from      = $currentUser->id;
                $message->from_name = $currentUser->name;
                $message->to        = $targetUser->id;
                $message->to_name   = $targetUser->name;
                $message->type      = '2';
                $message->message   = $currentUser->name . " said .. : " . $text;
                $message->book_id   = $book_id;
                $message->read      = '1';
                $message->reader    = $targetUser->id;
                $message->save();
                // $currentUser->notif = 1;
                // $currentUser->save();
                $reply = ["code" => 100, "message" => "A purchse request has been sent to the Owner, please wait for owner to reply.<br> In the meanwhile you can add or search for more books."];
                return die(json_encode($reply));
            } else {
                $reply = ["code" => 101, "message" => "You have sent a purchase request recently, please wait for owner to reply.<br> In the meanwhile you can add or search for more books."];
                return die(json_encode($reply));
            }
        } else {
            $message            = new Message();
            $message->from      = $currentUser->id;
            $message->from_name = $currentUser->name;
            $message->to        = $targetUser->id;
            $message->to_name   = $targetUser->name;
            $message->type      = '2';
            $message->message   = $currentUser->name . " said .. : " . $text;
            $message->book_id   = $book_id;
            $message->read      = '1';
            $message->reader    = $targetUser->id;
            $message->save();
            // $currentUser->notif = 1;
            // $currentUser->save();
        }
        $reply = ["code" => 100, "message" => "A purchase request has been sent to the Owner, please wait for owner to reply.<br>In the meanwhile you can add or search for more books."];
        return die(json_encode($reply));
    }

    public function edit($id)
    {}
    public function update(Request $request, $id)
    {}
    public function destroy($id)
    {}

    public function getUnreadCount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $message = Message::where(["read"=>'1',"reader"=>$user->id])->get();
            # get the unread messages for current user
            $result = [];
            foreach ($message as $msg) {
                $temp = [];
                $temp['id'] = $msg->id;
                $temp['read'] = $msg->read;
                $temp['reader'] = $msg->reader;
                $result[]=$temp;
            }
            return $result;
        }
        else{
            Auth::logout();
            return redirect()->route('home');
        }

    }

    public function markAsRead(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $id = $request->input("message_id");
            $msg = Message::findOrFail($id);
            $msg->read = '0';
            $msg->save();

            $message = Message::where(["read"=>'1',"reader"=>$user->id])->get();
            # get the unread messages for current user
            $result = [];
            foreach ($message as $msg) {
                $temp = [];
                $temp['id'] = $msg->id;
                $temp['read'] = $msg->read;
                $temp['reader'] = $msg->reader;
                $result[]=$temp;
            }
            return $result;
        }
        else{
            Auth::logout();
            return redirect()->route('home');
        }

    }
}
