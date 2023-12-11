<?php
 
include("../config/conexion.php");

$num_doc = (isset($_POST['num_doc'])) ? $_POST['num_doc'] : "";
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
$contrasena = (isset($_POST['contrasena'])) ? $_POST['contrasena'] : " ";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch ($accion) {
    case 'crear':

        $sentenciaCom = $conn->prepare("SELECT NOMBRE_USUARIO 
        FROM USUARIO
        WHERE DOC_USUARIO = :doc;");

        $sentenciaCom->bindParam(':doc', $num_doc);
        $sentenciaCom->execute();
        $validacion = $sentenciaCom->fetch(PDO::FETCH_LAZY);

        if ($validacion != null) {
            $mensaje = "Error: Usuario ya existe";
        } else {
            $sentenciaSQL = $conn->prepare("INSERT INTO USUARIO(DOC_USUARIO,NOMBRE_USUARIO,CONTRASENA_USUARIO,ROL_USUARIO)
            VALUES (:num_doc, :nombre, :contrasena,'Usuario');");
            $sentenciaSQL->bindParam(':num_doc', $num_doc);
            $sentenciaSQL->bindParam(':nombre', $nombre);
            $sentenciaSQL->bindParam(':contrasena', $contrasena);
            $sentenciaSQL->execute();
            header("Location:../index.php");
        }
        break;
}

?>


<!doctype html>
<html lang="es">

<head>
    <title>Registro</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Registro.css">
    <link rel="icon" href="Images/logo.png">
</head>

<body>
<div class="col-md-3">

<div class="card">
    <div class="card-header">
    Registro de usuario
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <?php if (isset($mensaje)) { ?>
                <div class="alert alert-danger" role="alert">
                    <strong><?php echo $mensaje; ?></strong>
                </div>
            <?php } ?>
            <div class="form-group">
                <label>Documento de identidad:</label>
                <input type="number" class="form-control" value="<?php echo $num_doc; ?>" name="num_doc" id="num_doc" required="" pattern="[0-9]+">
            </div>
            <div class="form-group">
                <label>Nombre completo</label>
                <input type="text" class="form-control" value="<?php echo $nombre; ?>" name="nombre" id="nombre" required="">
            </div>
            <div class="form-group">
                <label for="" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" value="<?php echo $contrasena; ?>" name="contrasena" id="contrasena" required="">
            </div>
            <br>
            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" value="crear" class="btn btn-primary">Crear</button>
            </div>
        </form>
        
    </div>
</div>
</div>

</body>
