<?php
    session_start();
    unset($_SESSION['id']); // elimina l'id di sessione
    unset($_SESSION['matricola']); // elimina la matricola
    session_destroy(); // distruggi la sessione
    header('Location: ../index.php'); // torna al login
?>