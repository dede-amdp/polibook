<!DOCTYPE html>
<html>
    <head>
        <title> Reset password </title>

        <link href='../css/resetPage.css' type='text/css' rel='Stylesheet'/>
        <meta name='viewport' 
            content='width=device-width, initial-scale=1.0' >
        <meta name="description" 
            content="Questa pagina permette di resettare la password utente">
    </head>

    <body class="resetPage">

        <?php
            session_start();
            include '../topbar.html';
        ?>
        <div class="contenitore">
            <h1 class="titolo"> Recupero password </h1>
            <p class="indicazioni">Per gli utenti già registrati, è possibile da questa pagina (inserendo la propria e-mail) ricevere un messaggio di posta elettronica contenente una nuova password temporanea per accedere al servizio.</p>
            <form class="recupero" action='../php/resetPassword.php' method='POST'>
                <input class="placeholder" type='text' placeholder='email@esempio.com' name='email'>
                <button type='submit' class="pulsante"> Reset Password</button>
            </form>
        </div>
    </body>
</html>