<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Inicio</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="./js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
      <div class="container-fluid">
        <a class="navbar-brand" href="./index.php"><img src="./imagenes/logo.png" width="50px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Sobre nosotros</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Adoptar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Colabora</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./contactenos.php">Contáctenos</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <!--------------------------- FOTO PRINCIPAL ----------------------------->
  <div class="fotoInicio container-fluid">
    <h1 class="fw-bold"><br><br><br><br><br><br><br>¡<span>Adopta</span>! ¡Encuentra a tu <span>nuevo mejor<br> amigo</span> y haz feliz a un animalito<br> al mismo tiempo!</h1>
  </div>
  <!------------------------------ FOOTER -------------------------------->
  <footer class="bg-light text-center text-white">
    <div class="container p-4 pb-0">
      <section class="mb-4">
        <!-- Facebook -->
        <a class="btn text-white btn-floating m-1" style="background-color: #3b5998;" href="https://es-es.facebook.com/" role="button"><i class="fab fa-facebook-f"></i></a>
        <!-- Twitter -->
        <a class="btn text-white btn-floating m-1" style="background-color: #55acee;" href="https://twitter.com/?lang=es" role="button"><i class="fab fa-twitter"></i></a>
        <!-- Instagram -->
        <a class="btn text-white btn-floating m-1" style="background-color: #ac2bac;" href="https://www.instagram.com/" role="button"><i class="fab fa-instagram"></i></a>
        <!-- Google -->
        <a class="btn text-white btn-floating m-1" style="background-color: #dd4b39;" href="https://www.google.com/intl/es/gmail/about/" role="button"><i class="fab fa-google"></i></a>
        <!-- Ubicación -->
        <a class="btn text-white btn-floating m-1" style="background-color: #0082ca;" href="https://www.google.es/maps/@37.5278471,-6.0563723,311m/data=!3m1!1e3" role="button"><i class="fa-solid fa-house"></i></a>
        <!-- Número -->
        <a class="btn text-white btn-floating m-1" style="background-color: #333333;" href="#modalTelefono" role="button" data-bs-toggle="modal" data-bs-target="#modalTelefono"><i class="fa-solid fa-phone"></i></a>
      </section>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2023 Copyright: Esperanza Animal
    </div>
  </footer>
</body>

</html>