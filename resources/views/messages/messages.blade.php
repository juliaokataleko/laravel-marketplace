<?php use Illuminate\Support\Facades\Auth; ?>
<div class="message-wrapper" style="height: 100%">
    <div class="" style="background: #fff; line-height: calc(3em - 1px); 
    padding: 0 10px;  ">
        {{ $user->name }}
    </div>
    <ul class="messages" style="height: calc(100% - 6em); 
    overflow-y: auto; padding: 10px;">
        @foreach($messages as $key => $message)
        <li class="message clearfix">
            <div class="{{ $message->user_send == Auth::user()->id ? 'sent' : 'received' }}">
                <p>{{ $message->message }}</p>
                <?php if(!null == $message->archive && file_exists('uploads/messages/'.$message->archive)): 
                $ext = pathinfo('uploads/messages/'.$message->archive, PATHINFO_EXTENSION);
                if($ext == 'jpg' || $ext == 'png'):
                ?>
                <p>
                    <img style="width: 100%;" src="{{ BASE_URL }}/uploads/messages/{{ $message->archive }}" alt="">
                </p>
                <?php endif; 

                if($ext == 'mp3' || $ext == 'wav'):
                ?>
                <p>
                    <audio style="width: 100%"" controls="controls" 
                    src="{{ BASE_URL }}/uploads/messages/{{ $message->archive }}"></audio>
                </p>
                <?php endif; 
                
                if($ext == 'mp4' || $ext == 'wmv'):
                ?>
                <p>
                    <video style="width: 100%" controls="controls" 
                    src="{{ BASE_URL }}/uploads/messages/{{ $message->archive }}"></video>
                </p>
                <?php endif; ?>
                @endif
                <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
            </div>
        </li>
        @endforeach

    </ul>

    <div class="form-send" style="height: calc(3em - 1px);
    border-top: 1px solid #ddd; 
    display: flex; 
    flex-direction: column; 
    justify-content: center; align-items: center; 
    background: #fff; padding: 0 10px">
        <div class="input-group">
            <input type="file" style="width: 200px" name="archive" 
            id="archive">
            <input type="text" placeholder="digite sua mensagem" class="form-control" 
            name="message" id="message" autocomplete="off">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" onclick="sendMessage();" type="button"> <i class="fa fa-paper-plane"></i> </button>
            </div>
        </div>
    </div>
</div>

<script>

    // Get the input field
    var input = document.getElementById("message") ?? '';

    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
        sendMessage();
    }
    });

</script>