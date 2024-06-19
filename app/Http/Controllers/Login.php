<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

use function Laravel\Prompts\select;

class Login extends Controller
{
    //Index
    public function index()
    {
        return view("login_views/index", []);
    }
    public function registro()
    {
        return view("login_views/registro", []);
    }
    public function insert(Request $req)
    {
        $error_message = 'no entro';
        $email = $req['email'];
        $user = $req['username'];
        $password = $req['password'];
        $nombre = $req['nombre'];
        $apellido = $req['apellido'];
        $carnet = $req['carnet'];
        $direccion = $req['direccion'];
        $telefono = $req['telefono'];
        // Verificar si el nombre de usuario ya existe en la base de datos
        $sql_check_user = DB::select("SELECT COUNT(*) AS count FROM regist WHERE user = '$user'");
        $check_user = get_object_vars($sql_check_user[0])['count'];
        if ($check_user > 0) {
            // Si el nombre de usuario ya existe, mostrar el mensaje de error
            $error_message = 'El nombre de usuario ya está en uso. Por favor, elige otro.';
        } else {
            $rol = substr($user, 0, 3);
            if ($rol == 'DIS' || $rol == 'VEN' || $rol == 'ALM') {
                $error_message = 'Nombre de usuario no valido';
                return $error_message; // Devolver el mensaje de error si lo hay*/
            }
            $sql = DB::insert('call insertar_cliente(?, ?, ?, ?, ?, ?)', [$carnet, $nombre, $apellido, $direccion, $telefono, 0]);
            if (!$sql) {
                // Si hubo un error devolvemos este mensaje
                $error_message = 'Hubo un problema al registrarte. Por favor, intenta de nuevo más tarde.';
                return $error_message;
            }
            // Si no existe, proceder con la inserción
            $sql = DB::insert("CALL registro_alc('$email','$user','$password','$carnet')");

            if ($sql) {
                // Si el registro es exitoso, enviamos una respuesta al cliente que indica éxito
                return "success";
            } else {
                // Si ocurre un error en la inserción
                $error_message = 'Hubo un problema al registrarte. Por favor, intenta de nuevo más tarde.';
            }
        }
        return $error_message; // Devolver el mensaje de error si lo hay*/

    }
    public function login(Request $req)
    {
        $username = $req['username'];
        $password = $req['password'];
        $sql_procedure = DB::select("CALL obtener_datos_join_regist()");
        if ($sql_procedure) {
            foreach ($sql_procedure as $obj) {
                $row = get_object_vars($obj);
                if (($row['regist_user'] == $username || $row['users_username'] == $username) &&
                    ($row['regist_password'] == $password || $row['users_password'] == $password)
                ) {
                    setcookie('sesion', true , time() + 60*10);
                    $_SESSION['username'] = $username;
                    $rol = substr($username, 0, 3);
                    if ($row['regist_user'] == 'admin') {
                        $_SESSION['rol'] = "Admin";
                        header("Location: /adminpag");
                    } elseif ($rol == 'DIS') {
                        $_SESSION['rol'] = "Distribucion";
                        header("Location: /hoja_carga");
                    } elseif ($rol == 'VEN') {
                        $_SESSION['rol'] = "Ventas";
                        header("Location: /admin_ventas");
                    } elseif ($rol == 'ALM') {
                        $_SESSION['rol'] = "Almacenes";
                        header("Location: /almacen");
                    } else {
                        $_SESSION['rol'] = "Cliente";
                        header("Location: /pag_principal");
                    }
                    exit();
                }
            }
        }
        $_SESSION['login_error'] = "Usuario o contraseña incorrectos";
        header("Location: /");
        exit();
    }
    public function logout(){
        $_SESSION['rol'] = 'cambiar';
        return redirect('/');
    }
}
