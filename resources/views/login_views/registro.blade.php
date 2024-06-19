<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('CSS/style.css')}}" rel="stylesheet">
    <title>Registrarse</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#registrationForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "insert",
                data: $(this).serialize(),
                success: function(response){
                    if(response.trim() === "success") {
                        // Si la respuesta indica éxito, redirigimos al usuario a index.php
                        window.location.href = "/";
                    } else {
                        // Si hay un error, mostramos el mensaje de error
                        $('#response').html(response);
                    }
                }
            });
        });
    });
    </script>
</head>
<body>

<div class="container-page" id="Container">
    <div class="login-container" id="LoginContainer">
        <h1 class="title">Registro</h1>
        <form id="registrationForm">
            @csrf
            <div class="input-line-container">
                <span class="name-input">Carnet</span>
                <input type="number" name="carnet" class="input-line" required>
            </div>
            <div class="input-line-container">
                <span class="name-input">Nombre</span>
                <input type="text" name="nombre" class="input-line" required>
            </div>
            <div class="input-line-container">
                <span class="name-input">Apellido</span>
                <input type="text" name="apellido" class="input-line" required>
            </div>
            <div class="input-line-container">
                <span class="name-input">Direccion</span>
                <input type="text" name="direccion" class="input-line" required>
            </div>
            <div class="input-line-container">
                <span class="name-input">Telefono</span>
                <input type="number" name="telefono" class="input-line" required>
            </div>
            <div class="input-line-container">
                <span class="name-input">Correo</span>
                <input type="email" name="email" class="input-line" required>
            </div>
            <div class="input-line-container">
                <span class="name-input">Usuario</span>
                <input type="text" name="username" class="input-line" required>
            </div>
            <div class="input-line-container">
                <span class="name-input">Contraseña</span>
                <input type="password" name="password" class="input-line" required>
            </div>
            <input type="submit" value="Registrarse" class="button-login">
            <a href="/" class="button-second">Volver al Inicio</a>
        </form>
        <div id="response" class="error-message"></div>
    </div>
</div>

</body>
</html>
