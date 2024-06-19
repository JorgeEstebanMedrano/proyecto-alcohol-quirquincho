<?php

namespace App\Http\Controllers;

abstract class Controller
{
    function comprobar_admin()
    {
        //SI NO SOMOS EMPLEADOS DE VENTAS NO PODEMOS ENTRAR
        if ($_SESSION['rol'] != 'Admin') {
            header('Location:/');
            exit();
        }
    }    
    function comprobar_ventas()
    {
        //SI NO SOMOS EMPLEADOS DE VENTAS NO PODEMOS ENTRAR
        if ($_SESSION['rol'] != 'Admin' && $_SESSION['rol'] != 'Ventas') {
            header('Location:/');
            exit();
        }
    }    
    function comprobar_distribucion()
    {
        //SI NO SOMOS EMPLEADOS DE VENTAS NO PODEMOS ENTRAR
        if ($_SESSION['rol'] != 'Admin' && $_SESSION['rol'] != 'Distribucion') {
            header('Location:/');
            exit();
        }
    }
}
