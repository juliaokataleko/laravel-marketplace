<?php

namespace App\Http\Controllers;

use App\models\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class MensagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();

        // count how many message are unread from the selected user
        $users = DB::select("select users.id, users.name, users.avatar, users.email, count(read_status) 
        as unread from users LEFT JOIN messages ON users.id = messages.user_send and read_status = 0 
        and messages.user_receive = ". Auth::id()." group 
        by users.id, users.name, users.avatar, users.email order by messages.id desc");

        return view('messages.index', compact('users'));
    }

    public function getMessage($id)
    {

        global $user_id;
        $user_id = $id;

        # getting all messages with the selected user
        $messages = Message::where(function ($query) {
            global $user_id;
            $query->where('user_send', Auth::user()->id)
                ->where('user_receive', $user_id);
        })->orWhere(function ($query) {
            global $user_id;
            $query->where('user_receive', Auth::user()->id)
                ->where('user_send', $user_id);
        })
            ->get();

        $user = User::findOrFail($id);

        return view('messages.messages', compact('messages', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $from = Auth::user()->id;
        $to = request('receiver_id');
        $message = request('message');

        $data = new Message();
        $data->user_send = $from;
        $data->user_receive = $to;
        $data->message = $message;
        if ($data->save()) echo json_encode($data);

        // $options = array(
        //     'cluster' => 'ap2',
        //     'useTLS' => true,
        // );

        // $pusher = new Pusher(
        //     env('PUSHER_APP_KEY'),
        //     env('PUSHER_APP_SECRET'),
        //     env('PUSHER_APP_ID'),
        //     $options
        // );

        // $data = ['from' => $from, 'to' => $to];
        // $pusher->trigger('my-channel', 'my-event', $data)

    }

    public function uploadFileMessage(Request $request)
    {
        $message = Message::findOrFail($_POST['id']);

        if (isset($_FILES['foto'])) {

            $arquivo = $_FILES['foto'];
            $tipo = $arquivo['type'];

            if (in_array($tipo, array('image/jpeg', 
            'image/png', 
            'audio/mpeg',
            'audio/x-mpeg',
            'audio/mp3',
            'audio/x-mp3',
            'audio/mpeg3',
            'audio/x-mpeg3',
            'audio/mpg',
            'video/mp4','video/ogg','video/webm',
            'audio/mpg'))) {
                $name = rand(100000, 999999) . $arquivo['name'];
                move_uploaded_file($arquivo['tmp_name'], 'uploads/messages/' . $name);
                //echo "Arquivo de ".$_POST['nome']." Enviado com sucesso.";
            }
        }

        $message->archive = $name;
        if ($message->save()) return 1;
        return 2;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
