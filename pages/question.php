<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Domande </title>
    <link href='../css/question.css' rel='Stylesheet' type='text/css'>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' >
    <meta name="description" 
          content="La pagina permette di rispondere alle domande riguardanti la qualità dell'attivitò didattica">
</head>

<body class='question'>
<?php
        session_start();
        if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non ha eseguito il login torna alla pagina di login
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        $matricola = $_SESSION['matricola'];
        $conn = open_conn();
        if($conn){
            $query = 'SELECT nome, cognome FROM studente WHERE matricola=?';
            $result = fetch_DB($conn, $query, $matricola);
            $conn -> close();
            if($result && $row = mysqli_fetch_assoc($result)){
                echo '<p>Ciao <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</p>';
            }
        }
    ?>
    <section aria-label="Questionario">
    <h2><span style="font-weight:normal;"> Questionario di automazione industriale </span></h2>
    <form>
        <div class='form-element radio-buttons'>
            <span> Le attivita didattiche (lezioni, esercitazioni, laboratori, ecc) online per questo insegnamento sono di facile utilizzo</span></br>
            <label for='firstAnswer'> 
                <input type="radio" id='Answer1-1' name='risposta1' value='Decisamente no' required>
                <span> Decisamente si </span>
            </label>
            </br>
            <label for='secondAnswer'> 
                <input type="radio" id='Answer1-2' name='risposta1' required>
                <span> Più no che si </span>
            </label>
            </br>
            <label for='firstAnswer'> 
                <input type="radio" id='Answer1-3' name='risposta1' required> 
                <span> Più si che no </span>
            </label>
            </br>
            <label for='firstAnswer'> 
                <input type="radio" id='Answer1-4' name='risposta1' required>
                <span> Decisamente si </span>
            </label>
        </div>
        <div class='form-element radio-buttons'>
            <span> Le lezioni in modalità a distanza per questo insegnamento consentono di seguire il corso in maniera appropriata ed efficace?</span></br>
            <label for='firstAnswer'> 
                <input type="radio" id='Answer2-1' name='risposta2' required>
                <span> Decisamente si </span>
            </label>
            </br>
            <label for='secondAnswer'> 
                <input type="radio" id='Answer2-2' name='risposta2' required>
                <span> Più no che si </span>
            </label>
            </br>
            <label for='firstAnswer'> 
                <input type="radio" id='Answer2-3' name='risposta2' required>
                <span> Più si che no </span>
            </label>
            </br>
            <label for='firstAnswer'> 
                <input type="radio" id='Answer2-4' name='risposta2' required>
                <span> Decisamente si </span>
            </label>
        </div>
        </br>
        <div class="form-element checkbox-button">
            <label for="answer">
            <span> Suggerimenti</span></p>
            <input type="checkbox" id="choice1-1" name="choice1">
            <span class="checkbox-button">Alleggerire il carico didattico complessivo​ </span>
            </label>
            </br>
            <label>
            <input type="checkbox" id="choice1-2" name="choice2">
            <span class="checkbox-button">Aumentare l'attività di supporto didattico​​ </span>
            </label>
            </br>
            <label>
            <input type="checkbox" id="choice1-3" name="choice3">
            <span class="checkbox-button">Fornire più conoscenze di base​​​ </span>
            </label>
            </br>
            <label>
            <input type="checkbox" id="choice1-4" name="choice4">
            <span class="checkbox-button">Eliminare dal programma argomenti già trattati in altri insegnamenti​ </span>
            </label>
            </br>
            <label>
            <input type="checkbox" id="choice1-5" name="choice5">
            <span class="checkbox-button">Migliorare il coordinamento con altri insegnamenti </span>
            </label>
            </br>
            <label>
            <input type="checkbox" id="choice1-6" name="choice6">
            <span class="checkbox-button">Migliorare la qualità del materiale didattico​​​ </span>
            </label>
            </br>
            <label>
            <input type="checkbox" id="choice1-7" name="choice7">
            <span class="checkbox-button">Fornire in anticipo il materiale didattico​ </span>
            </label>
            </br>
            <label>
            <input type="checkbox" id="choice1-8" name="choice8">
            <span class="checkbox-button">Inserire prove d'esame intermedie​​​ </span>
            </label>
            </br>
            <label>
            <input type="checkbox" id="choice1-9" name="choice9">
            <span class="checkbox-button">Attivare insegnamenti serali </span>
            </label>
        </div>
        </br>
        <div class="form-element">
            <label for='choise'>
            <span>Hai qualche suggerimento per migliorare la didattica a distanza (DaD) di questo insegnamento?​ </span>
            <textarea cols="100" rows="1"> </textarea>
            </label>
        </div>
        </br>
        <div class="form-element">
            <label for='choise'>
            <span>Hai qualche suggerimento per migliorare l'erogazione della didattica (riferita a questo insegnamento​?​ </span>
            <textarea cols="100" rows="1"> </textarea>
            </label>
        </div>
        <button type='Invia'>Invia questionario </button> 
    </form>
    </region>
</body>
</html>