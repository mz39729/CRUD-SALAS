<html>

<head>
    <title>Crear usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Amaranth|Bree+Serif|Stardos+Stencil" rel="stylesheet">
    <meta charset="utf-8" />
</head>


<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-4">

                <div class="control-group form-group">
                    <div class="controls">
                        <h2 class="titulo">Crear usuario</h2>
                    </div>
                </div>
                <form action="usuarios.php" method="post" enctype="multipart/form-data">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre y apellido"
                                required>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Usuario</label>
                            <input type="text" class="form-control" name="usuario" placeholder="Nombre de Usuario"
                                required>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Correo</label>
                            <input type="email" name="correo" class="form-control" placeholder="mi@correo.com" required>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
<br>
                    <div class="control-group form-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-sing-up btn-primary" name="registrar">Registrarse</button><br>
                        </div>
                    </div>

                </form>
                <div class="row">
                    <div class="col-lg-3">
                        <a href="index.php"><button type="button" class="btn btn-success">Inisiar sesion</button></a>
                    </div>
                </div>
</body>

</html>