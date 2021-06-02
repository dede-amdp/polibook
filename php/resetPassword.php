<?php
    if(isset($_POST['email'])){
        require_once '../php/dbh.inc.php';
        $conn = open_conn();
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        print_r($email);
        $query = 'SELECT matricola FROM studente WHERE email = ?;';
        $result = fetch_DB($conn, $query, $email);
        if($result && $mat = mysqli_fetch_assoc($result)){
            $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $new_pass = '';
            for($i = 0; $i < 30; $i++){
                $index = rand(0, 36);
                $new_pass .= $chars[$index];
            }
            $oggetto = 'Password Temporanea';
            $messaggio = "Questa è la password temporanea:\n$password";
            $query = 'UPDATE studente SET password=? WHERE matricola=?;';
            //mail($email,$oggetto,$messaggio, 'From: noreply@polibooklet.com'
            if(update_DB($conn, $query, password_hash($new_pass, PASSWORD_BCRYPT),$mat['matricola'])){
                mail($email, $oggetto, $messaggio,'From: noreply@polibooklet.com');
                session_start();
                $_SESSION['error_msg'] = 'Una Password temporanea è stata inviata all\'indirizzo email indicato';
            }
        }
    }
    header('Location: ../index.php');
?>