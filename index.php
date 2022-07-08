<?php
session_start();
if(isset($_SESSION['username'])){
    header("location: inicio.php");
}
?>
<html>
<head>
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Amaranth|Bree+Serif|Stardos+Stencil" rel="stylesheet">
    <meta charset="utf-8" />
</head>

<body>
    <div class="container-fluid" width="80%">
        <br><br>
        <div class="row justify-content-center">

            <h2 class="font-weight-bold text-center">iniciar sesion </h2>
        </div>

        <form action="usuarios.php" method="post" enctype="multipart/form-data">

            <div class="row justify-content-center">
                <div class="col-lg-1">
                    <label>Usuario</label>
                </div>
                <div class="col-lg-2">
                    <input type="text" name="username" placeholder="Nombre de Usuario" required>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="col-lg-1">
                    <label>Contraseña</label>
                </div>
                <div class="col-lg-2">
                    <input type="password" name="password" placeholder="password" required>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary" name="ingresar">Iniciar Sesión</button><br>
                </div>
            </div>
        </form>

        <div class="row justify-content-center">
            <div class="col-lg-2">
                <a href="registrar.php"><button type="button" class="btn btn-success">Registrarse</button></a>
            </div>
        </div>
    </div>
</body>
</html>

