<?php
include 'conexion.php';
$con = new conexion();

$sql = "SELECT * FROM sede";
$resultado = mysqli_query($con->conectar(), $sql);



session_start();

if (isset($_SESSION['username'])) {
    $usuarioEnSession = $_SESSION['username'];
} else {
    header('location: index.php');
}

if (isset($_POST['salir'])) {
    session_destroy();
    header("location: index.php");
    exit();
}
?>
<html>

<head>
    <title>Sedes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Amaranth|Bree+Serif|Stardos+Stencil" rel="stylesheet">
    <meta charset="utf-8" />
</head>

<body>

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
    </nav>
    <br><br><br><br>

    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <label class="font-weight-bold">Nombre Sede:</label>
            <input type="text" name="nombre" placeholder="Nombre Sede" required style="width:13%" maxlength="30">
            <label class="font-weight-bold">Codigo:</label>
            <input type="text" name="codigo" placeholder="Codigo sede" required style="width:13%" maxlength="10">
            <label class="font-weight-bold">Direccion:</label>
            <input type="text" name="direccion" required style="width:13%" oninput="this.value = this.value.replace(/[^a-zA-Z0-9 ]/,'')">
            <label class="font-weight-bold">Telefono</label>
            <input type="text" name="telefono" placeholder="Ej. 3000000" required style="width:13%" oninput="this.value = this.value.replace(/[^0-9]/,'')" maxlength="10" minlength="7">
            <label class="font-weight-bold">Cant. salas</label>
            <input type="number" name="cantidad" required style="width:8%">
            <button type="submit" class="btn btn-sing-up btn-info font-weight-bold" name="anadirSede">Añadir
                Sede</button>
            <br>
        </form>
    </div>
    <br>
    <div class="container-fluid">

        <div class="col-md-12">
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <th scope="col" class="text-center">CODIGO </th>
                    <th scope="col" class="text-center">NOMBRE SEDE</th>
                    <th scope="col" class="text-center">DIRECCION</th>
                    <th scope="col" class="text-center">NUMERO TELEFONO</th>
                    <th scope="col" class="text-center">CANTIDAD SALAS</th>
                    <th scope="col" class="text-center">Editar</th>
                    <th scope="col" class="text-center">Eliminar</th>
                </thead>
                <tbody>
                    <?php while ($fil = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td class="text-center"><?php echo $fil['CODIGO'] ?></td>
                            <td class="text-center"><?php echo $fil['NOMBRESEDE'] ?></td>
                            <td class="text-center"><?php echo $fil['DIRECCION'] ?></td>
                            <td class="text-center"><?php echo $fil['TELEFONO'] ?></td>
                            <td class="text-center"><?php echo $fil['CANTIDADSALAS'] ?></td>
                            <td class="text-center"><a class="btn btn-primary btn-xs" href="editarSedes.php?codigo=<?php echo $fil['CODIGO']; ?>"><span class="glyphicon glyphicon-pencil">Editar</span></a></td>
                            <td class="text-center">
                                <form action="" method="post">
                                    <input name="codigoE" type="hidden" value="<?php echo $fil['CODIGO']; ?>">
                                    <button class="btn btn-danger btn-xs" type="submit" name="eliminar"><span class="glyphicon glyphicon-trash">Eliminar</span></button>
                            </td>
                        </tr>
                    <?php }  ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>
<?php
if (isset($_POST['anadirSede'])) {
    if (
        !isset($_POST["nombre"]) || !isset($_POST["codigo"])   || !isset($_POST["direccion"])  || !isset($_POST["telefono"])
        || !isset($_POST["cantidad"])
    ) {
        echo "<div id='success'>
                <div class='alert alert-danger'>
                <strong>Es necesario completar todos los datos del formulario </strong>
                </div>
                </div>";
    } else {

        $nombre = $_POST['nombre'];
        $codigo = $_POST['codigo'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $cantidad = $_POST['cantidad'];
        $ins = $con->conectar()->query("INSERT INTO sede(nombresede,codigo,direccion,telefono,cantidadsalas) 
                                     VALUES('$nombre','$codigo','$direccion','$telefono','$cantidad')");
        if ($ins) {
            echo "<script> alert('Sede guardada correctamente'); </script>";
            echo "<script>location.href='sedes.php';</script>";
        } else {
            echo "<div id='success'>
                <div class='alert alert-danger'>
                <strong>Error al guardar </strong>
                </div>
                </div>";
        }
    }
}


if (isset($_POST['eliminar'])) {
    $codigoE = $_POST['codigoE'];

    $sqlE = "DELETE FROM sede WHERE codigo='$codigoE'";


    if ($con->conectar()->query($sqlE) === TRUE) {

        echo "<script> alert('Sede eliminada correctamente'); </script>";
        echo "<script>location.href='sedes.php';</script>";
    } else {
        echo "<div id='success'>
    <div class='alert alert-danger'>
    <strong>Error al eliminar </strong>
    </div>
    </div>";
    }
}

?>