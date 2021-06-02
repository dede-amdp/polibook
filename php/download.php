<?php 
    require_once './dbh.inc.php';
    if(isset($_GET['id']) && isset($_GET['ord'])){
        $conn = open_conn();
        if($conn){
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $ord = mysqli_real_escape_string($conn, $_GET['ord']);
            $query = 'SELECT programma FROM attivita_didattica WHERE id=? AND ordinamento=?;';
            $result = fetch_DB($conn, $query, $id, $ord);
            if($result){
                $prog = mysqli_fetch_assoc($result);
                header("Content-type: application/pdf");
                header("Content-Disposition: attachment; filename=Programma.pdf");
                $conn -> close();
                echo $prog['programma'];
            }
        }
    }
    die();
?>