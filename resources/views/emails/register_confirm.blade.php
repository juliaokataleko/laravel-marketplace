<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email de Confirmação</title>
</head>
<body>
    <h1>Olá {{ $data['name'] }}, Obrigado por estar aqui!</h1>
    Envio do Link de Confirmação da sua conta <br>

    Clica no link abaixo para confirmar a sua conta <br><br>
    <a href='http://www.kataleko.com/confirm_account?email={{ $data['email'] }}&token={{ $data['token'] }}'>
    Clique aqui para confirmar</a>
    <hr>
    Muito obrigado por se cadastrar na nossa plataforma. <b>Estamos juntos!</b>
</body>
</html>