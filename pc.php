<?php
include 'conexion.php';
$con = new conexion();


$sql = "SELECT * FROM pc";
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
    <title>Computadores</title>
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

    <div class="container">
        <div class="row">
            <form action="" method="post" enctype="multipart/form-data">
                <label>Codigo PC:</label>
                <input type="text" name="codigo" placeholder="Codigo Computador" required style="width:13%">&nbsp;&nbsp;&nbsp;&nbsp;
                <label>Sede:</label>
                <select name='sede'>
                    <option value="Sin asignar">Seleccione:</option>
                    <?php
                    $query = $con->conectar()->query("SELECT codigo FROM sede");
                    while ($valores = $query->fetch_assoc()) {
                        echo "<option  value=" . $valores['codigo'] . ">" . $valores['codigo'] . "</option>";
                    }
                    ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
                <label>Sala:</label>
                <select name='sala'>
                    <option value="Sin asignar">Seleccione:</option>
                    <?php
                    $query = $con->conectar()->query("SELECT codigo FROM sala");
                    while ($valores = $query->fetch_assoc()) {
                        echo "<option  value=" . $valores['codigo'] . ">" . $valores['codigo'] . "</option>";
                    }
                    ?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-sing-up btn-info" name="anadirPC">Añadir PC</button>
                <br>
            </form>
        </div>
        <br>

        <div class="col-md-12">
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <th scope="col" class="text-center">CODIGO </th>
                    <th scope="col" class="text-center">SEDE</th>
                    <th scope="col" class="text-center">SALA</th>
                    <th scope="col" class="text-center">Editar</th>
                    <th scope="col" class="text-center">Eliminar</th>
                </thead>
                <tbody>
                    <?php while ($fil = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td class="text-center"><?php echo $fil['CODIGO'] ?></td>
                            <td class="text-center"><?php echo $fil['SEDE'] ?></td>
                            <td class="text-center"><?php echo $fil['SALA'] ?></td>
                            <td class="text-center"><a class="btn btn-primary btn-xs" href="editarPC.php?codigo=<?php echo $fil['CODIGO']; ?>"><span class="glyphicon glyphicon-pencil">Editar</span></a></td>
                            <td class="text-center">
                                <form action="" method="post">
                                    <input name="codigoE" type="hidden" value="<?php echo $fil['CODIGO']; ?>">
                                    <button class="btn btn-danger btn-xs" type="submit" name="eliminar"><span class="glyphicon glyphicon-trash">Eliminar</span></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>

<?php
if (isset($_POST['anadirPC'])) {
    if (!isset($_POST["codigo"])) {
        echo "<div id='success'>
                <div class='alert alert-danger'>
                <strong>Es necesario completar todos los datos del formulario, en este cado el codigo </strong>
                </div>
                </div>";
    } else {

        $codigo = $_POST['codigo'];
        $sede = $_POST['sede'];
        $sala = $_POST['sala'];

        $sql1 = "SELECT COUNT(*) as total FROM pc WHERE sala='$sala'";
        $resultado1 = mysqli_query($con->conectar(), $sql1);

        $sql2 = "SELECT CANTIDADPC as totalPC FROM sala WHERE codigo='$sala'";
        $resultado2 = mysqli_query($con->conectar(), $sql2);

        $cons1 = mysqli_fetch_array($resultado1);
        $cons2 = mysqli_fetch_array($resultado2);

        if (($cons1['total']) >= $cons2['totalPC']) {

            echo "<div id='success'>
                    <div class='alert alert-danger'>
                    <strong>Error la sala tiene el maximo de computadores asignadas </strong>
                    </div>
                    </div>";
        } else {

            $ins = $con->conectar()->query("INSERT INTO pc(codigo,sede,sala)
                                        VALUES('$codigo','$sede','$sala')");

            if ($ins) {
                echo "<script> alert('Computador guardado correctamente'); </script>";
                echo "<script>location.href='pc.php';</script>";
            } else {
                echo "<div id='success'>
                    <div class='alert alert-danger'>
                    <strong>Error al guardar </strong>
                    </div>
                    </div>";
            }
        }
    }
}



if (isset($_POST['eliminar'])) {
    $codigoE = $_POST['codigoE'];

    $sqlE = "DELETE FROM pc WHERE codigo='$codigoE'";


    if ($con->conectar()->query($sqlE) === TRUE) {

        echo "<script> alert('Computador eliminado correctamente'); </script>";
        echo "<script>location.href='pc.php';</script>";
    } else {
        echo "<div id='success'>
    <div class='alert alert-danger'>
    <strong>Error al eliminar </strong>
    </div>
    </div>";
    }
}


?>