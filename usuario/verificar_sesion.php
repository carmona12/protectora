<?php
session_start();
// Verificamos si el usuario está autenticado
if (isset($_SESSION['usuario'])) {
    echo 'autenticado';
} else {
    echo 'no_autenticado';
}
