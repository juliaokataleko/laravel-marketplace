<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mensagens</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('/images/logo.png') }}" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script defer src="{{ asset('js/script.js') }}"></script>
    
    <style>
        ul {
            margin: 0;
            padding: 0;
        }
        li {
            list-style: none;
        }
        .user-wrapper {
            border: 1px solid #dddddd;
            overflow-y: hidden;
        }

        .container {
            height: calc(100vh - 50px);
            margin-top: 50px;
            overflow-y: auto;
        }

        .user-wrapper, .message-wrapper {
            height: 100%;
            overflow-y: auto;
        }

        .user {
            cursor: pointer;
            padding: 5px 0;
            position: relative;
            transition: 0.4s;
        }

        .user:hover {
            background: #dddddd
        }

        .user:last-child {
            margin-bottom: 0;
        }

        .pending {
            position: absolute;
            left: 13px;
            top: 9px;
            background: #be1717;
            margin: 0;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            line-height: 18px;
            padding-left: 5px;
            color: #ffffff;
            font-size: 12px;
        }

        .media-left {
            margin: 0 10px
        }

        .media-left img {
            width: 64px;
            border-radius: 64px;
        }

        .media-body p {
            margin: 4px 0;
            font-size: 17px;
            width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .message-wrapper {
            height: 100%;
            background: #eeeeee;
            overflow-y: auto;
        }

        .messages .message {
            margin-bottom: 15px;
        }

        .received, .sent {
            width: 65%;
            padding: 3px 10px;
            border-radius: 10px;
        }

        .received {
            background: #ffffff;
        }
        .sent {
            background: #0644ca;
            color: #ffffff;
            float: right;
            text-align: right;
        }

        .message p {
            margin: 5px 0;
        }

        .message .date {
            color: #cccccc;
            font-size: 13px;
        }

        li.active {
            background: #eeeeee;
            color: #0644ca
        }
    </style>
</head>

<body>
    @include('includes.header')

    <div class="py-1 container">
        @yield('content')
    </div>
</body>

</html>