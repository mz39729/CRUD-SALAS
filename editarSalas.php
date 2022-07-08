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
$sql = "SELECT * FROM sala WHERE codigo = '$codigo'";
$resultado = mysqli_query($con->conectar(), $sql);
$consulta = mysqli_fetch_array($resultado);
?>

<html>

<head>
    <title>Editar Sala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Amaranth|Bree+Serif|Stardos+Stencil" rel="stylesheet">
    <meta charset="utf-8" />
</head>

<body>
    <br><br>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" } aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                            <input type="text" class="form-control" id="name" name="codigo" required maxlength="10" value="<?php echo $consulta['CODIGO']; ?>" readonly>
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>SEDE</label>

                            <select name='sede'>
                                <?php
                                $query = $con->conectar()->query("SELECT codigo FROM sede");
                                while ($valores = $query->fetch_assoc()) {
                                    echo "<option  value=" . $valores['codigo'] . ">" . $valores['codigo'] . "</option>";
                                } ?>
                            </select>

                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>SALA</label>
                            <input type="number" class="form-control" id="cant" name="cantidad" required maxlength="10" value="<?php echo $consulta['CANTIDADPC']; ?>">

                            <p class="help-block"></p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sing-up btn-info" name="modificar">Modificar Sala</button>
                    <br>
                </form>
            </div>
        </div>
        <br>
    </div>
</body>

</html>

<?php
if (isset($_POST['modificar'])) {
    if (!isset($_POST["codigo"]) || !isset($_POST["sede"]) || !isset($_POST["cantidad"])) {
        echo "<div id='success'>
                <div class='alert alert-danger'>
                <strong>Es necesario completar todos los datos del formulario </strong>
                </div>
                </div>";
    } else {

        $codigo = $_POST['codigo'];
        $sede = $_POST['sede'];
        $cantidad = $_POST['cantidad'];


        if ($cantidad < $consulta['CANTIDADPC']) {
            echo "<div id='success'>
            <div class='alert alert-danger'>
            <strong>No se púede disminuir a un numero menor a los computadores que se encuentren creados</strong>
            </div>
            </div>";
        } else {

            $sql = "UPDATE sala SET codigo ='$codigo', sede='$sede', cantidadpc='$cantidad' WHERE codigo = '$codigo'";

            $ins = $con->conectar()->query($sql);
            if ($ins) {
                echo "<script> alert('Sala Modificada correctamente'); </script>";
                echo "<script>location.href='salas.php';</script>";
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