<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <link href="{{ asset('CSS/styles.css') }}" rel="stylesheet">

    <title>Editar empleado</title>
</head>

<body>
    <div class="users-form">
        <h2>Editar Usuario</h2>
        <form action="/edit_user" method="POST">
            @csrf
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="text" name="name" placeholder="Nombre" value="<?= $row['name'] ?>">
            <input type="text" name="lastname" placeholder="Apellidos" value="<?= $row['lastname'] ?>">
            <input type="text" name="username" placeholder="Username" value="<?= $row['username'] ?>">
            <input type="text" name="email" placeholder="Email" value="<?= $row['email'] ?>">

            <input type="submit" value="Actualizar">
        </form>
    </div>
</body>

</html>
