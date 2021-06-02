<?php
    if(isset($_POST['email'])){
        require_once '../php/dbh.inc.php';
        $conn = open_conn();
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $query = 'SELECT matricola FROM studente where email = ?';
        $result = fetch_DB($conn, $query, $email);
        if($result)
    }
?>