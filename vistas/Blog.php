<?php
session_start();

ob_start();
if ($_SESSION['ROL'] != null) {
    $rolUsuario = $_SESSION["ROL"];
} else {
    header("Location:../index.php");
}

include("../config/conexion.php");

$sentenciaSQL = $conn->prepare("SELECT PUBLICACION.TITULO_PUB,PUBLICACION.FECHA_PUB,PUBLICACION.DESCRIPCION_PUB, PUBLICACION.AUTOR_PUB,PUBLICACION.CELULAR_PUB, PUBLICACION.IMG_PUB
FROM PUBLICACION
ORDER BY PUBLICACION.ID_PUB;");
$sentenciaSQL->execute();
$lista_pub = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/712575d4a5.js" crossorigin="anonymous"></script>
    <title>Blog Nodo Travesias</title>
</head>
<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-image: url('Images/fondoblog.webp');
    font-family: Poppins;
    background-size: cover;
    background-position: center;
}

a {
    text-decoration: none;
}

ul {
    list-style: none;
}


/* Navbar Style */

header {
    background-image: linear-gradient( 359.8deg,  rgba(252,255,222,1) 2.2%, rgb(141, 241, 123) 99.3% );
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.navbar-left {
    padding: 0;
    font-family: poppins;
    font-style: italic;
    font-weight: 600;
}

.navbar-right {
    margin-right: 10px;
}

.navbar-left img {
    width: 60px;
    height: 70px;
}

.navbar-right a {
    position: relative;
    display: inline-block;
    padding: 10px 20px;
    color: #0061b1;
    background: rgb(75, 199, 59);
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-decoration: none;
    font-size: 14px;
    overflow: hidden;
    transition: 0.2s;
}

.navbar-right a:hover {
    color: #255784;
    background: #21f360;
    box-shadow: 0 0 10px #21f360, 0 0 40px #21f360, 0 0 80px #21f360;
    transition-delay: 1s;
}

a span {
    position: absolute;
    display: block;
}

a span:nth-child(1) {
    top: 0;
    left: -100%;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, transparent, #2196f3);
}

a:hover span:nth-child(1) {
    left: 100%;
    transition: 1s;
}

a span:nth-child(2) {
    top: -100%;
    right: 0;
    width: 2px;
    height: 100%;
    background: linear-gradient(100deg, transparent, #2196f3);
}

a:hover span:nth-child(2) {
    top: 100%;
    transition: 1s;
    transition-delay: 0.25s;
}

a span:nth-child(3) {
    bottom: 0;
    right: -100%;
    width: 100%;
    height: 2px;
    background: linear-gradient(270deg, transparent, #2196f3);
}

a:hover span:nth-child(3) {
    right: 100%;
    transition: 1s;
    transition-delay: 0.5s;
}

a span:nth-child(4) {
    bottom: -100%;
    left: 0;
    width: 2px;
    height: 100%;
    background: linear-gradient(360deg, transparent, #2196f3);
}

a:hover span:nth-child(4) {
    bottom: 100%;
    transition: 1s;
    transition-delay: 0.75s;
}


/* Blog Style */

#blog {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.blog-heading {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.blog-heading span {
    color: #aaf321;
    font-weight: 700;
    font-size: 18px;
}

.blog-heading h3 {
    font-size: 2.4rem;
    color: black;
    font-weight: 600;
    margin-bottom: 15px
}

.buscar {
    position: relative;
    padding: 5px;
}

.buscar input {
    width: 0px;
    height: 40px;
    padding: 0 20px;
    font-size: 16px;
    color: black;
    outline: none;
    border: 1px solid silver;
    border-radius: 30px;
    transition: all 0.6s ease;
}

.btn {
    position: absolute;
    top: 0;
    right: 0;
    width: 50px;
    height: 50px;
    line-height: 50px;
    text-align: center;
    background: #8BB497;
    color: antiquewhite;
    font-size: 18px;
    border-radius: 50%;
    cursor: pointer;
}

.buscar:hover input {
    width: 240px;
}

.buscar input:focus {
    width: 240px;
}

#categories {
    position: fixed;
    left: 1%;
    top: 55%;
    transform: translateY(-50%);
    background-color: #fff;
    padding: 20px;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

#categories h2 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

#categories ul {
    list-style: none;
}

#categories li {
    margin-bottom: 10px;
}

#categories a {
    text-decoration: none;
    color: #2196f3;
}

#categories a:hover {
    color: #7868e6;
}


/* Blog Container */

.container-fluid {
    display: flex;
    justify-content: space-between; /* Distribuye el espacio entre las publicaciones */
    align-items: flex-start; /* Alinea las publicaciones arriba */
    flex-wrap: wrap;
    margin: 20px 0;
    gap: 20px; /* Espaciado entre las publicaciones */
}
.blog-post {
    width: 450px;
    background-color: #ffffff98;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.6);
    border-radius: 12px;
    overflow: hidden;
    margin: 20px;
    cursor: pointer;
    transition: transform ease 300ms;
}

.blog-post:hover {
    box-shadow: 0 5px 20px rgb(6, 202, 39);
    transform: translate(0, -10px);
}

.blog-img {
    width: 100%;
    height: auto;
}

.blog-img img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    object-position: center;
}

.blog-text {
    padding: 30px;
    display: flex;
    flex-direction: column;
}

.blog-heading span {
    color: #493aaa;
    font-size: 1.2rem;
}

.blog-text .blog-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #272727;
}

.blog-text .blog-title:hover {
    color: #7868e6;
    transition: all ease 0.3s;
}

.blog-text p {
    color: #383737;
    font-size: 0.9rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: 20px 0px;
}

.blog-text a {
    color: #0f0f0f;
}

.blog-text a:hover {
    color: #7868e6;
    transition: all ease 0.3s;
}

.blog-text .details {
    position: relative;
    display: inline-block;
    width: 40%;
    padding: 10px 10px;
    border-radius: 10px;
    color: #005eaa;
    background: #A4D4AF;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-decoration: none;
    font-size: 14px;
    overflow: hidden;
    transition: 0.2s;
}

.blog-text .details:hover {
    color: #183752;
    font-weight: 600;
    background: #21f360;
    box-shadow: 0 0 10px #21f360, 0 0 40px #21f360, 0 0 80px #21f360;
    transition-delay: 1s;
}

.blog-text .details span {
    position: absolute;
    display: block;
}

.blog-text .details span:nth-child(4) {
    bottom: 100%;
    left: 0;
    width: 2px;
    height: 100%;
    background: linear-gradient(360deg, transparent, #21f360);
}

.blog-text .details span:nth-child(4) {
    bottom: -100%;
    transition: 1s;
    transition-delay: 0.75s;
}

/* Responsive */

@media (max-width: 1250px) {
    .blog-post {
        width: 300px;
    }
}

@media (max-width: 1100px) {
    .blog-post {
        width: 70%;
    }
}

@media (max-width: 550px) {
    .blog-post {
        margin: 20px 10px;
        width: 100%;
    }

    #blog {
        padding: 20px;
    }
}
</style>

<body>
    <header>
        <nav class="navbar">
            <div class="navbar-left">
                <img src="./Images/logo.png" alt="">
            </div>
            <div class="navbar-right">
                <a href="Formulario.php">
                    <span></span> Publicar
                </a>
                <a href="Cerrar.php">
                    <span></span> Cerrar sesión
                </a>

            </div>
        </nav>
    </header>
    <main>
        <section id="blog">
            <div class="blog-heading">
                <span>Publicaciones recientes</span>
                <h3>Blog Nodo Travesias</h3>
            </div>
            <div class="buscar">
                <input type="text" placeholder="Buscar" id="" required>
                <div class="btn">
                    <i class="fas fa-search icon"></i>
                </div>
            </div>

            <div class="container-fluid">
                <?php foreach ($lista_pub as $lista) { ?>
                <br>
                <div class="blog-post expanded">
                    <div class="card">
                        <div class="blog-text">
                            <div class="blog-img">
                                <img class="img-thumbnail rounded" src="../img/<?php echo $lista['IMG_PUB']; ?>"
                                    width="40" alt="">
                            </div>
                            <form method="POST">
                                <h4 class="card-title">Titulo: <?php echo ($lista['TITULO_PUB']); ?></h4>
                                <p class="card-text">Fecha: <?php echo ($lista['FECHA_PUB']); ?></p>
                                <p class="card-text">Descripción: <?php echo ($lista['DESCRIPCION_PUB']); ?></p>
                                <p class="card-text">Autor: <?php echo ($lista['AUTOR_PUB']); ?></p>
                                <p class="card-text">Celular: <?php echo ($lista['CELULAR_PUB']); ?></p>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
    </main>
    <script src="/Vista Principal/Blog.js"></script>
</body>

</html>