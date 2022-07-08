<?php
include 'conexion.php';
$con = new conexion();

$sql = "SELECT * FROM usuarios";
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
    <title>Usuarios</title>
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
    <br><br><br>

    <div class="container">
        <div class="col-md-12">
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <th scope="col" class="text-center">NOMBRE </th>
                    <th scope="col" class="text-center">USUARIO</th>
                    <th scope="col" class="text-center">CORREO</th>
                    <th scope="col" class="text-center">EDITAR</th>
                    <th scope="col" class="text-center">ELIMINAR</th>
                </thead>
                <tbody>
                    <?php while ($fil = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td class="text-center"><?php echo $fil['NOMBRE'] ?></td>
                            <td class="text-center"><?php echo $fil['USERNAME'] ?></td>
                            <td class="text-center"><?php echo $fil['CORREO'] ?></td>
                            <td class="text-center"><a class="btn btn-primary btn-xs" href="editarUser.php?username=<?php echo $fil['USERNAME']; ?>"><span class="glyphicon glyphicon-pencil">Editar</span></a></td>
                            <td class="text-center">
                                <form action="" method="post">
                                    <input name="usernameE" type="hidden" value="<?php echo $fil['USERNAME']; ?>">
                                    <button class="btn btn-danger btn-xs" type="submit" name="eliminar"><span class="glyphicon glyphicon-trash">Eliminar</span></button>
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
if (isset($_POST['eliminar'])) {
    $usernameE = $_POST['usernameE'];

    $sqlE = "DELETE FROM usuarios WHERE username='$usernameE'";

    if ($con->conectar()->query($sqlE) === TRUE) {

        echo "<script> alert('Usuario eliminado correctamente'); </script>";
        echo "<script>location.href='user.php';</script>";
    } else {
        echo "<div id='success'>
     <div class='alert alert-danger'>
     <strong>Error al eliminar </strong>
     </div>
     </div>";
    }
}
?>