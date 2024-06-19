<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;
use function Laravel\Prompts\select;



function generatePassword($nombre, $apellido){
    $password = substr($nombre, 0, 2) . substr($apellido, 0, 2);
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $chars_length = strlen($chars);
    $password .= $chars[rand(0, $chars_length - 1)];
    return $password;
}
class AdminController extends Controller
{
    public function admin()
    {
        Controller::class::comprobar_admin();
        $result = DB::select("SELECT MAX(employee_number) AS ultimo_codigo FROM users");
        if (count($result) > 0) {
            $row = get_object_vars($result[0]);
            $lastCod = $row["ultimo_codigo"];
            $lastDigit = intval(substr($lastCod, -4));
            $newDigit = $lastDigit + 1;
            $newCodEmpleado = str_pad($newDigit, 4, '0', STR_PAD_LEFT);
        } else {
            $newCodEmpleado = "0001";
        }

        $sql = DB::select("SELECT * FROM users");

        return view("admin_views/admin", [
            'emp' => $sql,
            'newCodEmpleado' => $newCodEmpleado
        ]);
    }
    public function update_user(Request $req)
    {
        Controller::class::comprobar_admin();
        $id = $req['id'];
        $sql = DB::select("CALL buscar($id)");
        $row = get_object_vars($sql[0]);
        return view("admin_views/update_user", [
            'row' => $row
        ]);
    }
    public function edit_user(Request $req)
    {
        Controller::class::comprobar_admin();
        $id = $req['id'];
        $name = $req['name'];
        $lastname = $req['lastname'];
        $username = $req['username'];
        $email = $req['email'];

        $sql = DB::update("CALL actualizar_usuario ($id,'$name', '$lastname', '$username', '$email')");

        if ($sql) {
            Header("Location: /adminpag");
            exit();
        } else {
            Header("Location: login");
        }
    }
    public function insert_user(Request $req){
        Controller::class::comprobar_admin();
        $name = $req['name'];
        $lastname = $req['lastname'];
        $email = $req['email'];
        $telefono = $req['telefono'];
        $fecha = $req['fecha'];
        $type = $req['type'];
        $employee_number = $req['employee_number'];
        $prefix = "";
        $carnet = $req['carnet'];
        $salario = 7000;
        if ($type == 3000) {
            $prefix = "ALM-";
            $salario = 7500;
        }
        elseif ($type == 3500) {
            $prefix = "DIS-";
            $salario = 8900;
        }
        elseif ($type == 4000) {
            $prefix = "VEN-";
            $salario = 9500;
        }
        //GENERAR USUARIO
        $name_upper = strtoupper(substr($name, 0, 3));
        $lastname_upper = strtoupper(substr($lastname, 0, 3));
        $username = $prefix . $name_upper . $lastname_upper;
        //GENERAR CONTRASEÑA
        $password = generatePassword($name, $lastname);
        DB::insert('call insert_user(?, ?, ?, ?, ?, ?, ?, ?, ?)', [$name, $lastname, $username, $email, $telefono, $employee_number, $fecha, $type, $password]);
        DB::insert("CALL registro_alc('$email','$username','$password','$carnet')");
        DB::insert('call insertar_empleado(?,?,?,?,?)', [$carnet, $name, $lastname, $telefono, $salario]);
        $sql = DB::select('SELECT ultimo_empleado() AS id');
        if ($type == 4000) {
            DB::insert('call insertar_empleado_ventas(?)', [$sql[0]->id]);
        }
        return redirect("/adminpag");
    }
    public function ver_usuarios(){
        Controller::class::comprobar_admin();
        $sql = DB::select("call vista_usuarios()");
        return view("/reportes/vista_usuarios", [
            "usuario"=> $sql
        ]);
    }    
    public function ver_almacenes(){
        Controller::class::comprobar_admin();
        $sql = DB::select("call vista_almacen()");
        return view("/reportes/vista_almacen", [
            "almacen"=> $sql
        ]);
    }
    public function ver_ordenes(){
        Controller::class::comprobar_admin();
        $sql = DB::select("call vista_orden()");        
        return view("/reportes/vista_ordenes", [
            "ordenes"=> $sql
        ]);
    }
}
