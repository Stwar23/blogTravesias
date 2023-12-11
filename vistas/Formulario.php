<?php
session_start();

ob_start();
if ($_SESSION['ROL'] != null) {
    $rolUsuario = $_SESSION["ROL"];
} else {
    header("Location:../index.php");
}

$TITULO_PUB = (isset($_POST['TITULO_PUB'])) ? $_POST['TITULO_PUB'] : "";
$FECHA_PUB = (isset($_POST['FECHA_PUB'])) ? $_POST['FECHA_PUB'] : "";
$DESCRIPCION_PUB = (isset($_POST['DESCRIPCION_PUB'])) ? $_POST['DESCRIPCION_PUB'] : "";
#$AUTOR_PUB = (isset($_POST['AUTOR_PUB'])) ? $_POST['AUTOR_PUB'] : "";
$AUTOR_NOMBRE = $_SESSION['NOM_USER'];
$CELULAR_PUB = (isset($_POST['CELULAR_PUB'])) ? $_POST['CELULAR_PUB'] : "";
$image = (isset($_FILES['image']['name'])) ? $_FILES['image']['name'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/conexion.php");

switch ($accion) {
    case 'crear':
        echo"Entro crear";
        $sentenciaSQL = $conn->prepare("INSERT INTO PUBLICACION (TITULO_PUB,FECHA_PUB,DESCRIPCION_PUB,AUTOR_PUB,CELULAR_PUB,IMG_PUB)
        VALUES(:TITULO_PUB,:FECHA_PUB,:DESCRIPCION_PUB,:AUTOR_PUB,:CELULAR_PUB,:IMG_PUB);");
        $sentenciaSQL->bindParam(':TITULO_PUB', $TITULO_PUB);
        $sentenciaSQL->bindParam(':FECHA_PUB', $FECHA_PUB);
        $sentenciaSQL->bindParam(':DESCRIPCION_PUB', $DESCRIPCION_PUB);
        $sentenciaSQL->bindParam(':AUTOR_PUB', $AUTOR_NOMBRE);
        $sentenciaSQL->bindParam(':CELULAR_PUB', $CELULAR_PUB);

        $fecha = new DateTime();
        $nombreArchivo = ($image != "") ? $fecha->getTimestamp() . "_" . $_FILES["image"]["name"] : "imagen.jpg";
        $tmpImg = $_FILES["image"]["tmp_name"];

        if ($tmpImg != "") {
            move_uploaded_file($tmpImg, "../img/" . $nombreArchivo);
        }

        $sentenciaSQL->bindParam(':IMG_PUB', $nombreArchivo);
        $sentenciaSQL->execute();
        header("Location:Blog.php");
        break; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='https://cdn.jsdelivr.net/gh/alphardex/aqua.css@master/dist/aqua.min.css'>
    <title>Formulario publicación</title>
</head>
<style>
body {
    background-image: url(Images/fondoregistro.webp);
    background-size: cover;
    background-position: center;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.form-container {
    background-color: rgba(32, 17, 59, 0.007);
    /* Fondo blanco con transparencia */
    border-radius: 10px;
    backdrop-filter: blur(10px);
    /* Efecto de desenfoque */
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.9);
    /* Sombra para resaltar el contenedor */
    font-weight: 600;
    max-width: 600px;
    /* Aumenta el ancho máximo del contenedor */
    margin: 10px;
    /* Agrega un margen para mejorar la apariencia */
    padding: 30px;
    width: 100%;
}

.form-column {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-input-material {
    position: relative;
    margin-bottom: 40px;
    width: 100%;
    /* Ancho al 100% */
    color: White;
}

.form-input-material input {
    width: 100%;
    padding: 15px 0;
    border: none;
    border-bottom: 1px solid #ccc;
    outline: none;
    font-size: 16px;
    transition: border-bottom-color 0.3s;
}

.form-input-material input:focus {
    border-bottom-color: #4caf50;
}

.form-input-material label {
    position: absolute;
    top: 0;
    left: 0;
    font-size: 16px;
    padding: 15px 0;
    pointer-events: none;
    transition: transform 0.6s, color 0.3s;
    color: white;
}

.form-input-material input:focus + label,
.form-input-material input:valid + label {
    transform: translateY(10PX)
    font-size: 14px;
}

.form-group label {
    color: White !important;
    /* Cambiar el color del texto del label a negro */
}

.btn-group {
    margin-top: 20px;
}

.btn-primary {
    background-color: #5e599cb2;
    color: #fff;
    border-radius: 10px;
    /* Añadir un border-radius al botón */
}

.btn-primary:hover {
    background-color: #5e599cfa;
}

a.navbar-right {
    margin-top: 10px;
    display: block;
    color: #322aa5fa;
    text-decoration: none;
}
</style>

<body>
    <form class="login-form" method="POST" enctype="multipart/form-data">
        <div class="form-container">

            <div class="form-column">
                <h2>Crear Publicación</h2>
                <div class="form-input-material">
                    <input type="text" value="<?php echo $TITULO_PUB; ?>" name="TITULO_PUB" id="TITULO_PUB"
                        placeholder=" " autocomplete="off" class="form-control-material" required>
                    <label for="title">Título</label>
                </div>
                <div class="form-input-material">
                    <input type="date" value="<?php echo $FECHA_PUB; ?>" name="FECHA_PUB" id="FECHA_PUB" placeholder=" "
                        autocomplete="off" class="form-control-material" required>
                    <label for="title">Fecha</label>
                </div>
                <div class="form-input-material">
                    <input type="text" value="<?php echo $DESCRIPCION_PUB; ?>" name="DESCRIPCION_PUB"
                        id="DESCRIPCION_PUB" placeholder=" " autocomplete="off" class="form-control-material" required>
                    <label for="description">Descripción</label>
                </div>
                <div class="form-input-material">
                    <input type="text" placeholder="<?php echo $AUTOR_NOMBRE?>" name="AUTOR_PUB" id="AUTOR_PUB"
                        autocomplete="off" class="form-control-material" disabled>
                    <label for="author">Autor</label>
                </div>
                <div class="form-input-material">
                    <input type="tel" value="<?php echo $CELULAR_PUB; ?>" name="CELULAR_PUB" id="CELULAR_PUB"
                        placeholder=" " autocomplete="off" class="form-control-material" required>
                    <label for="author">Celular</label>
                </div>
                <div class="form-input-material">
                    <input type="file" name="image" id="image" class="form-control-material">
                    <label for="author">Imagen</label>
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="crear" class="btn btn-primary">Publicar</button>
                </div>
                <a href="Blog.php" class="navbar-right">
                    <span></span> Volver
                </a>
            </div>
        </div>
        <script src="./formulario.js"></script>
    </form>
</body>
</html>