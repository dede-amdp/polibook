<!DOCTYPE html>
<html lang='it'>

    <head>

        <title>Profilo</title>
        <meta name='viewport' 
            content='width=device-width, initial-scale=1.0' > <!-- serve per far si che su uno schermo più piccolo appaia a dimensioni sensate-->
        <meta name="description" 
            content="Questa pagina permette di visualizzare e modificare i dati dell'utente">
        <meta charset='UTF-8'>
        <link href='../css/profile.css' rel='Stylesheet' type='text/css'>
        <?php
            session_start();
            if(isset($_SESSION['userData_msg'])){ // se contiene un messaggio
                $message = $_SESSION['userData_msg'];
                unset($_SESSION['userData_msg']); // togle il messaggio dalla sessione
                echo "<script type='text/javascript'> window.onload = function() {alert('$message');};</script>"; // mostra il messaggio in alto
            }
        ?>

    </head>

    <body class='profile-body'> 
        <?php
            include '../sidenav.html';
            require_once '../php/dbh.inc.php';
            if(!isset($_SESSION['id'])) header('Location: ../index.php');
            $matricola=$_SESSION['matricola'];
            $conn = open_conn();
            if($conn){
                $query = 'SELECT nome, cognome FROM studente WHERE matricola=?'; // recupera nome e cognome dal database 
                $result = fetch_DB($conn, $query, $matricola);
                $conn -> close();
                if($result && $row = mysqli_fetch_assoc($result)){
                    echo '<p>Ciao <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</p>';
                }
            }

        ?>
        <section aria-label="Profilo">
            <p>In questa pagina puoi visualizzare e modificare i dati anagrafici inseriti e la password.</p>
            <section aria-label="pulsanti modifica">
                <button id='password'>Modifica la tua Password</button>
                <button id='email'>Modifica la tua email</button>
                <button id='address'>Modifica il tuo indirizzo</button>
                <button id='photo'>Modifica la tua foto profilo</button>
            </section>
            <!-- Form per modificare la password -->
            <section aria-label="Modifica password">
                <div id='password-div' class='profile'><form action='../php/updatePassword.php' method='POST'>
                    <label>Password attuale</label><br>
                    <input type='password' name='old_p' placeholder='Password attuale'  maxlength=50 minlength=6 required><br>
                    <label>Nuova Password</label><br>
                    <input type='password' name='new_p' placeholder='Password' maxlength=50 minlength=6 required><br>
                    <label>Conferma la password</label><br>
                    <input type='password' name='confirm_p' placeholder='Conferma password' maxlength=50 minlength=6 required><br>
                    <button type='submit' class='submit'>Cambia Password</button>
                </form></div>
            </section>
            <!-- Form per modificare l'email -->
            <section aria-label="Modifica email">
            <div id='email-div' class='profile'><form action='../php/updateEmail.php' method='POST'>
                <label>Password</label><br>
                <input type='password' name='password' placeholder='Password' maxlength=50 minlength=6 required><br>
                <label>Nuova Email</label><br>
                <input type='email' name='email' placeholder='esempio@email.com' required><br>
                <button type='submit' class='submit'>Cambia email</button>
            </form></div>
            </section>
            <!-- Form per modificare l'indirizzo -->
            <section aria-label="Modifica indirizzo">
                <div id='address-div' class='profile'><form action='../php/updateAddress.php' method='POST'>
                    <label>Password</label><br>
                    <input type='password' name='password' placeholder='Password' maxlength=50 minlength=6 required><br>
                    <label>Nuovo Indirizzo</label><br>
                    <input type='text' name='address' placeholder='Via nome civico' required><br>
                    <button type='submit' class='submit'>Cambia indirizzo</button>
                </form></div>
            </section>
            <section aria-label="Modifica foto profilo">
                <div id='photo-div' class='profile'>
                    <form action='../php/updatePhoto.php' method='POST' enctype="multipart/form-data">
                    <label>Password</label><br>
                    <input type='password' name='password' placeholder='Password' maxlength=50 minlength=6 required><br>
                    <label>Nuova Foto Profilo (.jpeg,.jpg,.png massimo 2MB)</label><br>
                    <input type='file' name='photo' required><br>
                    <button type='submit' class='submit'>Cambia Foto Profilo</button>
                </form></div>
            </section>
            <div id='userData'></div>
        </section>
    </body>
    <script src='../javascript/methods.js'></script>
    <script src='../javascript/profile.js'></script>
    <?php
        // questa sezione serve per evitare che i form si chiudano se ho sbagliato a inserire la password
        if(isset($_SESSION['section'])){
            switch($_SESSION['section']){
                case 'password':
                    echo '<script>document.getElementById(\'password-div\').style.display = \'block\';'.
                    'document.getElementById(\'password\').classList.toggle(\'active\');</script>';
                    break;
                case 'address':
                    echo '<script>document.getElementById(\'address-div\').style.display = \'block\';'. 
                    'document.getElementById(\'address\').classList.toggle(\'active\');</script>';
                    break;
                case 'email':
                    echo '<script>document.getElementById(\'email-div\').style.display = \'block\';'.
                    'document.getElementById(\'email\').classList.toggle(\'active\');</script>';
                    break;
                case 'photo':
                    echo '<script>document.getElementById(\'photo-div\').style.display = \'block\';'.
                    'document.getElementById(\'photo\').classList.toggle(\'active\');</script>';
                    break;
            }
            unset($_SESSION['section']);
        }
    ?>
</html>