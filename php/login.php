<?php 
  //apertura del DB
    session_start();
    require_once('../php/dbh.inc.php'); 
    $conn = open_conn();   
    if(isset($_POST['matricola']) && isset($_POST['password'])){
        $matricola= mysqli_real_escape_string($conn, $_POST['matricola']);
        $password= mysqli_real_escape_string($conn, $_POST['password']);
        // controlla che la matricola abbia solo numeri e sia composta da 6 cifre
        $isMatricolaValid = filter_var( $matricola, 
                FILTER_VALIDATE_REGEXP, [
                    "options" => [ "regexp" => "/^[0-9]{6}$/i"
                    ]
                ]
                );

        if(empty($matricola) || empty($password)){
            $_SESSION['error_msg'] = 'Compila tutti i campi';
            header('Location: ../index.php');
        } elseif ($isMatricolaValid == false) {
            $_SESSION['error_msg'] = 'La matricola o la password inserite non sono valide!';
            header('Location: ../index.php');
        } else {
            $query = "
                SELECT password
                FROM studente
                WHERE matricola = ?
            ";
            if($conn){
                $result = fetch_DB($conn, $query, $matricola);
                $conn -> close();
                if($result && $pss = mysqli_fetch_assoc($result)){
                    if (password_verify($password, $pss['password'])) {
                        // se la password è corretta
                        $_SESSION['id'] = session_id();
                        $_SESSION['matricola'] = $matricola;
                        header('Location: ../pages/booklet.php'); // vai al libretto
                    } else {
                        $_SESSION['error_msg'] = 'La matricola o la password inserite non sono valide!';
                        header('Location: ../index.php');
                    }
                }else{
                    $_SESSION['error_msg'] = 'La matricola o la password inserite non sono valide!';
                    header('Location: ../index.php');
                }
            }else{
                $_SESSION['error_msg'] = 'Errore di connessione al server, la preghiamo di riprovare più tardi';
                header('Location: ../index.php');
            }
        }
    }else{
        $_SESSION['error_msg'] = 'Sembra che alcuni dati non siano stati inseriti correttamente';
        header('Location: ../index.php');
    }

?>