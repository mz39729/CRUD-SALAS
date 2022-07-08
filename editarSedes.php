<?php
include 'conexion.php';
$con = new conexion();

session_start();
if (isset($_SESSION['username'])) {
    $usuarioEnSession = $_SESSION['username'];
} else {
    header('location: index.php');
}

$codigo = $_GET['codigo'];
$sql = "SELECT * FROM sede WHERE codigo = '$codigo'";
$resultado = mysqli_query($con->conectar(), $sql);
$consulta = mysqli_fetch_array($resultado);
?>

<html>

<head>
    <title>Editar Sede</title>
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
                            <label>CODIGO</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required maxlength="10"
                                value="<?php echo $consulta['CODIGO']; ?>">
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>NOMBRE DE LA SEDE</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre Sede" required maxlength="30"
                                value="<?php echo $consulta['NOMBRESEDE']; ?>">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>DIRECCION</label>
                            <input type="text" class="form-control" name="direccion" required maxlength="50"
                                value="<?php echo $consulta['DIRECCION']; ?>" oninput="this.value = this.value.replace(/[^a-zA-Z0-9 ]/,'')">
                             <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>TELEFONO</label>
                            <input type="text" class="form-control" name="telefono" placeholder="Ej. 3000000" required maxlength="10"
                                value="<?php echo $consulta['TELEFONO']; ?>">

                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>CANTIDAD DE SALAS</label>
                            <input type="number" class="form-control" name="cantidad" required maxlength="10"
                                value="<?php echo $consulta['CANTIDADSALAS']; ?>">
                             <p class="help-block"></p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sing-up btn-info" name="modificar">Modificar Sede</button>
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
    if (!isset($_POST["codigo"]) || !isset($_POST["nombre"]) || !isset($_POST["direccion"])|| !isset($_POST["telefono"])|| !isset($_POST["cantidad"])) {
        echo "<div id='success'>
        <div class='alert alert-danger'>
        <strong>Es necesario completar todos los datos del formulario </strong>
        </div>
        </div>";
    } else {
        
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST["direccion"];
        $telefono = $_POST["telefono"];
        $cantidad=$_POST["cantidad"];


        if($cantidad<$consulta['CANTIDADSALAS']){
            echo "<div id='success'>
            <div class='alert alert-danger'>
            <strong>No se púede disminuir a un numero menor a las salas que se encuentren creadas</strong>
            </div>
            </div>";

        }else{

            $sql = "UPDATE sede SET codigo ='$codigo', nombresede='$nombre', direccion='$direccion', telefono='$telefono', cantidadsalas='$cantidad' WHERE codigo = '$codigo'";

            $ins = $con->conectar()-> query($sql);
            if($ins){
            echo "<script> alert('Sede Modificada correctamente'); </script>";
            echo "<script>location.href='sedes.php';</script>";
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