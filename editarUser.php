<?php
include 'conexion.php';
$con = new conexion();

session_start();
if (isset($_SESSION['username'])) {
    $usuarioEnSession = $_SESSION['username'];
} else {
    header('location: index.php');
}

$username = $_GET['username'];
$sql = "SELECT * FROM usuarios WHERE username = '$username'";
$resultado = mysqli_query($con->conectar(), $sql);
$consulta = mysqli_fetch_array($resultado);
?>

<html>

<head>
    <title>Editar usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Amaranth|Bree+Serif|Stardos+Stencil" rel="stylesheet">
    <meta charset="utf-8" />
</head>

<body>
    <br><br>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" }
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link text-primary navbar-brand" href="inicio.php">Usuario: <?php echo $usuarioEnSession ?></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link text-primary" href="sedes.php">Sedes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="salas.php">Salas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="pc.php">Computadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="user.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" type="submit" name="salir" href="salir.php">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-4">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>USUARIO</label>
                            <input type="text" class="form-control" id="name" name="usuario" required maxlength="20"
                                value="<?php echo $consulta['USERNAME']; ?>" readonly>
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>NOMBRE</label>
                            <input type="text" class="form-control" id="name" name="nombre" required maxlength="20"
                                value="<?php echo $consulta['NOMBRE']; ?>">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>CONTRASEÑA</label>
                            <input type="password" class="form-control" id="name" name="password" required
                                maxlength="27">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>CONFIRMAR CONTRASEÑA</label>
                            <input type="password" class="form-control" id="name" name="confPassword" required
                                maxlength="20">
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>CORREO</label>
                            <input type="text" class="form-control" id="name" name="correo" required maxlength="27"
                                value="<?php echo $consulta['CORREO']; ?>">
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sing-up btn-info" name="modificar">Modificar usuario</button>
                    <br>
                </form>
            </div>
        </div>
        <br>
    </div>
</body>

</html>

<?php
if(isset($_POST['modificar'])){
    if (!isset($_POST["nombre"]) || !isset($_POST["usuario"]) || !isset($_POST["password"])  || !isset($_POST["confPassword"]) 
    || !isset($_POST["correo"])) {
        echo "<div id='success'>
                <div class='alert alert-danger'>
                <strong>Es necesario completar todos los datos del formulario </strong>
                </div>
                </div>";
    } else {
        
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $password =md5($password);
        $confPassword = $_POST['confPassword'];
        $confPassword =md5($confPassword);
        $correo = $_POST['correo'];

    if($confPassword != $password){
        echo "<div id='success'>
            <div class='alert alert-danger'>
            <strong>Por favor confirme que las contraseñas sean iguales </strong>
            </div>
            </div>";
    }else{ 

        $sql = "UPDATE usuarios SET NOMBRE ='$nombre', CORREO='$correo', PASSWORD='$password' WHERE USERNAME = '$usuario'";

        $ins = $con->conectar()-> query($sql);
        if($ins){
           echo "<script> alert('Usuario Modificado correctamente'); </script>";
           echo "<script>location.href='user.php';</script>";
        } else {
            echo "<div id='success'>
            <div class='alert alert-danger'>
            <strong>Error de conexion </strong>
            </div>
            </div>";
        }

    }

        
    }
}
?>