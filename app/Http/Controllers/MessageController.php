<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function storeMessage() {

        $request_array = [
            'telefon' => 'numeric|nullable',
            'msg' => 'required|string|min:3'
        ];

        $message_array = [
            'telefon.numeric' => 'Bitte nur Ziffern eintippen!',
            'msg.min' => 'Bitte mind. 3 Ziffern eintippen!',
            'msg.required' => 'Bitte Nachricht eingeben!',
        ];

        if (!Auth::check()) {
            $request_array += ['username' => 'required|string|min:3|max:10'];
        }
        request()->validate($request_array, $message_array);  
        
        $message = new Messages;

        /*
        $data = [
            'telefon' => request('telefon'),
            'msg' => request('msg'),           
        ];
        if (!Auth::check()) {
            $data += ['username' => request('username')];
        }else{
            $data += ['username' => Auth::user()->name];
        }
        */

        $data = [
            'username' => (Auth::check()) ? Auth::user()->name : request('username'),
            'telefon' => request('telefon'),
            'msg' => request('msg'),           
        ];

        $message->username = $data['username'];
        $message->telefon = $data['telefon'];
        $message->msg = $data['msg'];
        if (Auth::check()) $message->userid = Auth::user()->id;

        $message->save();

        return redirect('/contact')->with('info', 'Nachricht erfolgreich versendet')->with('data', $data);

        /**
         * VAR      $data
         * KEY      'data'
         * ['data' => $data]
         * 
         */
    }

    public function showMessages() {
        
        // if (Auth::user()->role != 0) {
            $data = Messages::paginate(5);
            
            return view('/admin/admin', compact('data')); 
        // }
        // return redirect('/home');
    }





    // supporter1
    //            user       group            von wem
    // comment1   rwx        ---              supporter1
    // comment2   rwx        ---              supporter1
    // comment3   ---        ---              supporter2
    
    // admin
    //            user       group            von wem
    // comment1   rwx        rwx              supporter1
    // comment2   rwx        rwx              supporter1
    // comment3   rwx        rwx              supporter2
    
    // user
    //            user       group            von wem
    // comment1   ---        ---              supporter1
    // comment2   ---        ---              supporter1
    // comment3   ---        ---              supporter2
    
    public function showMessage($id = 0) {
        
        $data = Messages::select(
            'messages.id AS id',
            'messages.telefon AS telefon',
            'messages.msg AS msg',
            'messages.status AS status',
            'messages.username AS m_username',
            'comments.comment AS comment',
            'comments.status_set AS status_set'
        )
        ->addSelect('messages.created_at AS m_created_at')
        ->addSelect('messages.updated_at AS m_updated_at')
        ->addSelect('messages.userid AS m_userid')

        ->addSelect('comments.created_at AS c_created_at')
        ->addSelect('comments.updated_at AS c_updated_at')
        ->addSelect('comments.userid AS c_userid')

        ->addSelect('users.name AS c_username')

        ->leftJoin('comments', 'messages.id', '=', 'comments.message_id')
        ->leftJoin('users', 'users.id', '=', 'comments.userid')
            ->where('messages.id', $id)
            ->orderby('comments.id', 'desc')
            ->get();

        if (isset($data[0]->id)) {
        $d = null;
        if (isset($data[0]->comment)) { 
            foreach ($data as $m) {
                $d[] = [
                    'comment' => $m->comment,
                    'c_created_at' => $m->c_created_at,
                    'status_set' => $m->status_set,
                    'userid' => $m->c_userid,
                    'username' => $m->c_username,
                ];
            }
        }
        
        $message = [
            'id' => $data[0]->id,
            'userid' => $data[0]->m_userid,
            'username' => $data[0]->m_username,
            'telefon' => $data[0]->telefon,
            'msg' => $data[0]->msg,
            'status' => $data[0]->status,
            'comments' => $d,
        ];

        return view('/admin/admin', compact('message')); 
        }
        return abort(404); 
    }

    public function findMessage () {

        $id = request('search');
        $data = Messages::find($id);
        if (isset($data)) {
            return redirect('/admin/' . $id);
        }
        return redirect('/admin');

    }
}
