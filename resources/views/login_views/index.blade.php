<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Alcoholes Quirquincho</title>
    <link href="{{ asset('CSS/style.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="code.js"></script>
</head>
<body>
    <div class="container-page" id="Container">
        <div class="login-container" id="LoginContainer">
            <h1 class="title">Iniciar Sesion</h1>
            <?php if(isset($_SESSION['login_error'])): ?>
                <p style="color: red;"><?php echo $_SESSION['login_error']; ?></p>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>
            <form action="/login" method="POST">
                @csrf
                <div class="input-line-container">
                    <span class="name-input">Usuario</span>
                    <input type="text" name="username" class="input-line" id="username">
                </div>
                <div class="input-line-container">
                    <span class="name-input">Contraseña</span>
                    <input type="password" name="password" class="input-line" id="password">
                </div>
                <input type="submit" value="Ingresar" class="button-login">
                <a href="registro" class="button-second">Registrarse</a>
            </form>
        </div>
    </div>
</body>
</html>
