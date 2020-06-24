<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email de Confirmação</title>
</head>
<body>
    <h1>Olá {{ $data['name'] }}!</h1>
    Enviamos uma nova senha para acessar a sua conta <br>

    A sua nova senha é <b>{{ $data['senha']  }}</b> <br><br>
    <a href='{{ BASE_URL }}/login'><h2>Inicie sessão</h2></a>
    
    <hr>
    Obrigado por fazerparte de nós. <b>Estamos juntos!</b>
</body>
</html>