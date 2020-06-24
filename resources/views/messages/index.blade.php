@extends('layouts.messages')

@section('title', config('app.name', 'Laravel').' - Mensagens')

@section('content')

<div class="row" style="height: 100%">
    <div class="col-md-4 desktop" style="height: 100%; padding: 0 !important;">
        <div class="user-wrapper">
            <ul class="users">

                @foreach($users as $key => $user)
                <li class="user" id="{{ $user->id }}">

                    @if($user->unread)
                    <span class="pending"> {{ $user->unread > 9 ? '9' : $user->unread }} </span>
                    @endif
                    <div class="media">
                        <div class="media-left">
                            <?php if(!null == $user->avatar && file_exists('uploads/avatar/'.$user->avatar)): ?>
                            <img src="{{ BASE_URL }}/uploads/avatar/{{ $user->avatar }}" alt="" class="media-object">
                            <?php else: ?>
                            <img src="{{ BASE_URL }}/images/person.png" alt="" class="media-object">
                            <?php endif; ?>
                        </div>
                        <div class="media-body">
                            <p class="name">{{ $user->name }}</p>
                            <p class="email">j{{ $user->email }}</p>
                        </div>
                    </div>
                </li>
                @endforeach

            </ul>

        </div>
    </div>

    <!-- Messages -->
    <div class="col-md-8" id="messages" 
    style="height: 100%; padding: 0 !important;">

    </div>
</div>

<script>
    receiver_id = '';

    $(function() {
        // alert("Jquery carregado...");

        // Enable pusher logging - don't include this in production
        {{-- Pusher.logToConsole = true;

        var pusher = new Pusher('72243d3f6af2d07d139f', {
        cluster: 'eu'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
        alert(JSON.stringify(data));
        }); --}}
        
        var my_id = "{{ Auth::id() }}";

        $('.user').click(function() {
            $('.user').removeClass('active');
            $(this).addClass('active');

            receiver_id = $(this).attr('id');
            //alert(receive_id)

            $.ajax({
                type: 'get',
                url: 'message/'+receiver_id,
                data: '',
                cache: false,
                success: function(data) {
                    $("#messages").html(data);
                }
            })
        });

    });

    function updateMessages() {
        $.ajax({
            type: 'get',
            url: 'message/'+receiver_id,
            data: '',
            cache: false,
            success: function(data) {
                $("#messages").html(data);
                scrollDown();
            }
        })
    }

    
    function sendMessage() {

        var message = $("#message").val();

        if(message && receiver_id) {
            $("#message").val('');
            // alert(receiver_id)
            var dataStr = "_token={{ csrf_token() }}&" + "receiver_id=" + receiver_id + "&message=" + message;
            $.ajax({
                type: "post",
                url: 'message',
                data: dataStr,
                cache: false,
                success: function(data) {
                    newData = JSON.parse(data);
                    // (newData)
                    // alert(newData.id)

                    var data = new FormData();
                    var arquivos = $("#archive")[0].files;

                    if (arquivos.length > 0) {
                        
                        data.append('id', newData.id);
                        data.append('foto', arquivos[0]);

                        $.ajax({
                            type: 'POST',
                            url: 'message/upload',
                            data: data,
                            contentType: false,
                            processData: false,
                            success: function (msg) {
                                alert(msg);
                            },
                            error: function() {
                                alert("Erro...")
                            }
                        });

                        updateMessages();
                    } else {
                        updateMessages();
                    }

                    
                },
                error: function (jqXHR, status, err) {

                },
                complete: function() {

                }
            })
        }
    }

    function scrollDown() {
        $('.messages').animate({
            scrollTop: $('.messages').get(0).scrollHeight
        }, 50);
    }
</script>

@endsection