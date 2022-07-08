<?php
include 'conexion.php';
$con = new conexion();
$sql = "SELECT * FROM sala";
$resultado = mysqli_query($con->conectar(), $sql);


session_start();

if (isset($_SESSION['username'])) {
    $usuarioEnSession = $_SESSION['username'];
} else {
    header('location: index.php');
}


?>
<html>

<head>
    <title>Salas</title>
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
        <div class="row justify-content-center">
            <div class="col-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <label>Codigo:</label>
                    <input type="text" name="codigo" placeholder="Codigo Sala" required style="width:13%">&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>Sede:</label>
                    <select name="sede">
                        <option value="0">Seleccione:</option>
                        <?php
                        $query = $con->conectar()->query("SELECT codigo FROM sede");
                        while ($valores = $query->fetch_assoc()) {
                            echo "<option value=" . $valores['codigo'] . ">" . $valores['codigo'] . "</option>";
                        }
                        ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>Cantidad computadores:</label>
                    <input type="number" name="cantidad" required style="width:8%">&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-sing-up btn-info" name="anadirSala">Añadir Sala</button>
                    <br>
                </form>
            </div>
        </div>
        <br>



        <div class="col-md-12">
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <th scope="col" class="text-center">CODIGO </th>
                    <th scope="col" class="text-center">SEDE</th>
                    <th scope="col" class="text-center">CANTIDAD COMPUTADORES</th>
                    <th scope="col" class="text-center">Editar</th>
                    <th scope="col" class="text-center">Eliminar</th>
                </thead>

                <tbody>
                    <?php while ($fil = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td class="text-center"><?php echo $fil['CODIGO'] ?></td>
                            <td class="text-center"><?php echo $fil['SEDE'] ?></td>
                            <td class="text-center"><?php echo $fil['CANTIDADPC'] ?></td>
                            <td class="text-center"><a class="btn btn-primary btn-xs" href="editarSalas.php?codigo=<?php echo $fil['CODIGO']; ?>"><span class="glyphicon glyphicon-pencil">Editar</span></a></td>
                            <td class="text-center">
                                <form action="" method="post">
                                    <input name="codigoE" type="hidden" value="<?php echo $fil['CODIGO']; ?>">
                                    <button class="btn btn-danger btn-xs" type="submit" name="eliminar"></a><span class="glyphicon glyphicon-trash">Eliminar</span></button>
                                </form>
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

if (isset($_POST['anadirSala'])) {
    if (!isset($_POST["codigo"]) || !isset($_POST["sede"]) || !isset($_POST["cantidad"]) || $_POST["sede"] == "0") {
        echo "<div id='success'>
                <div class='alert alert-danger'>
                <strong>Es necesario completar todos los datos del formulario </strong>
                </div>
                </div>";
    } else {
        $codigo = $_POST['codigo'];
        $sede = $_POST['sede'];
        $cantidad = $_POST['cantidad'];

        $sql1 = "SELECT COUNT(*) as total FROM sala WHERE sede='$sede'";
        $resultado1 = mysqli_query($con->conectar(), $sql1);

        $sql2 = "SELECT CANTIDADSALAS as totalsalas FROM sede WHERE codigo='$sede'";
        $resultado2 = mysqli_query($con->conectar(), $sql2);

        $cons1 = mysqli_fetch_array($resultado1);
        $cons2 = mysqli_fetch_array($resultado2);

        if (($cons1['total']) >= $cons2['totalsalas']) {

            echo "<div id='success'>
            <div class='alert alert-danger'>
            <strong>Error la sede tiene el maximo numero de salas asignadas </strong>
            </div>
            </div>";
        } else {
            $ins = $con->conectar()->query("INSERT INTO sala(codigo,sede,cantidadpc)
            VALUES('$codigo','$sede','$cantidad')");
            if ($ins) {
                echo "<script> alert('Sala guardada correctamente'); </script>";
                echo "<script>location.href='salas.php';</script>";
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

    $sqlE = "DELETE FROM sala WHERE codigo='$codigoE'";


    if ($con->conectar()->query($sqlE) === TRUE) {

        echo "<script> alert('Sala eliminada correctamente'); </script>";
        echo "<script>location.href='salas.php';</script>";
    } else {
        echo "<div id='success'>
    <div class='alert alert-danger'>
    <strong>Error al eliminar </strong>
    </div>
    </div>";
    }
}

?>