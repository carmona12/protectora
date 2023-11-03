<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Contáctenos</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="contactenos.js"></script>
</head>

<body class="bodyContacto">
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
    <div class="container my-3 containerContacto">
        <h1 class="text-warning">Cuéntanos qué te trae por aquí...</h1>
        <div class="row" id="containerContacto">
            <div class="col-lg-6 col-md-12">
                <img src="./imagenes/contactar.jpg" alt="" class="img-fluid">
                <div class="mb-3 ms-0" id="ubicacion">
                    <div class="">
                        <div class=" border p-2">
                            <h5 class="fw-bolder text-decoration-underline">Dónde encontrarnos</h5>
                            <p>Guillena</p>
                            <p>Tlfno: 958-21-49-53</p>
                            <p>C.P. 41210 (GUILLENA)</p>
                        </div>
                        <div class="p-2">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1609.2479253667395!2d-6.056240560435786!3d37.528151007720965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1ses!2ses!4v1677516648344!5m2!1ses!2ses" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 ">
                <form class="row rounded formularioContacto needs-validation" novalidate>
                    <div class="col">
                        <label for="inputNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" id="inputNombre" required>
                        <div class="invalid-feedback">
                            Introduzca un nombre, por favor!
                        </div>
                    </div>
                    <div class="col">
                        <label for="inputApellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" placeholder="Apellidos" aria-label="Apellidos" id="inputApellidos" required>
                        <div class="invalid-feedback">
                            Error, no puede dejar el campo vacío!!
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="inputEmail4" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail4" placeholder="example@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                        <div class="invalid-feedback">
                            Error, introduzca un email válido!!
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="inputAsunto" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="inputAsunto" required>
                        <div class="invalid-feedback">
                            Por favor, indique algún asunto!
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="textareaMensaje" class="form-label">Qué quieres decirnos, Coméntanos sin miedo!!</label>
                        <textarea class="form-control" id="textareaMensaje" rows="5" minlength="10" maxlength="500" required></textarea>
                        <div class="invalid-feedback">
                            Por favor ingrese su mensaje en el área de texto.
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                            <label class="form-check-label" for="flexCheckDefault">
                                He leído y acepto los términos y condiciones de uso.
                            </label>
                            <div class="invalid-feedback">
                                Debes aceptar antes de enviar.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        <button type="reset" class="btn btn-danger">Borrar</button>
                    </div>
                </form>
            </div>
        </div>
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
<script>
    // Script para validar los elementos del formulario con bootstrap
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

</html>