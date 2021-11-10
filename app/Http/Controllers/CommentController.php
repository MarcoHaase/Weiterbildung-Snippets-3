<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\Messages;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function showComments ($mid = 0) {

    }

    public function storeComment ($mid = 0) {

        request()->validate([
            'comment' => 'required|string|min:1|max:1000',
            'status' => 'required|numeric'
        ]);

        $comment = new Comments;

        $data = [
            'comment' => request('comment'),
            'status_set' => request('status'),
            'message_id' => $mid,
        ];

        $comment->comment = $data['comment'];
        $comment->status_set = $data['status_set'];
        $comment->message_id = $data['message_id'];
        if (Auth::check()) $comment->userid = Auth::user()->id;

        $comment->save();

        $message = Messages::find($mid);
        if (isset($message)) {
            $message->status = $data['status_set'];
            $message->save();
        }  

        return redirect('/admin/'.$mid)->with('info', 'Kommentar erfolgreich angefügt')->with('data', $data);

    }
}
