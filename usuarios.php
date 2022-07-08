<?php
session_start();
include 'conexion.php';
$con = new conexion();


if (isset($_POST['ingresar'])) {
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        echo "<div id='success'>
                <div class='alert alert-danger '>
                <strong>Es necesario completar todos los datos del formulario </strong>
                </div>
                </div>";
    } else {
        $usuario = $_POST['username'];
        $clave = $_POST['password'];
        $clave = md5($clave);

        $sql = "SELECT * FROM usuarios WHERE username='$usuario' and password = '$clave'";
        $resultado = mysqli_query($con->conectar(), $sql);
        $consulta = mysqli_fetch_array($resultado);

        if (!isset($_SESSION['username'])) {

            if ($consulta['USERNAME'] == $usuario && $consulta['PASSWORD'] == $clave) {

                $_SESSION['username'] = $usuario;

                header("location: inicio.php");
            } else if ($consulta['USERNAME'] != $usuario && $consulta['PASSWORD'] != $clave) {
                echo "<div id='success'>
                    <div class='alert alert-danger'>
                    <strong>Por favor confirme el usuario y/o contraseñas </strong>
                    </div>
                    </div>";
            } else {
                echo "<div id='success'>
                    <div class='alert alert-danger'>
                    <strong>Error de conexion </strong>
                    </div>
                    </div>";
            }
        } else {
           
            echo "<br>No entro session";
        }
    }
}

if (isset($_POST['registrar'])) {
    if (!isset($_POST["nombre"]) || !isset($_POST["correo"])   || !isset($_POST["usuario"])  || !isset($_POST["password"])) {
        echo "<div id='success'>
                <div class='alert alert-danger'>
                <strong>Es necesario completar todos los datos del formulario </strong>
                </div>
                </div>";
    } else {

        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $correo = $_POST['correo'];
        $clave =  $_POST['password'];
        $clave = md5($clave);
        $ins = $con->conectar()->query("INSERT INTO usuarios(nombre,username,password,correo) VALUES('$nombre','$usuario','$clave','$correo')");

        if ($ins) {
            header("location: index.php");
        } else {
            echo "<div id='success'>
                <div class='alert alert-danger'>
                <strong>Error de conexion </strong>
                </div>
                </div>";
        }
    }
}
