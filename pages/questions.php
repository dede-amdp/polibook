<!DOCTYPE html>
<html lang='it'>

    <head>
        <title> 
            Domande </title>
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
        ?>
        <section aria-label="Questionario">
            <h2><span style="font-weight:normal;"> Questionario di automazione industriale </span></h2>
            <form class="domande" id='quest' action='../php/insertAnswers.php' method='POST'>
                <input type='hidden' name='id' value= <?php echo '\''.$_GET['id'].'\''; ?> >
                <div class='form-element radio-buttons'>
                    <span> Le attivita didattiche (lezioni, esercitazioni, laboratori, ecc) online per questo insegnamento sono di facile utilizzo</span><br>
                    <label for='Answer1-1'> 
                        <input type="radio" id='Answer1-1' name='dom1' value='4' required>
                        <span> Decisamente sì </span>
                    </label>
                    <br>
                    <label for='Answer1-2'> 
                        <input type="radio" id='Answer1-2' name='dom1' value='3' required>
                        <span> Più sì che no </span>
                    </label>
                    <br>
                    <label for='Answer1-3'> 
                        <input type="radio" id='Answer1-3' name='dom1' value='2' required> 
                        <span> Più no che sì </span>
                    </label>
                    <br>
                    <label for='Answer1-4'> 
                        <input type="radio" id='Answer1-4' name='dom1' value='1' required>
                        <span> Decisamente no </span>
                    </label>
                </div>
                <div class='form-element radio-buttons'>
                    <span> Le lezioni in modalità a distanza per questo insegnamento consentono di seguire il corso in maniera appropriata ed efficace?</span><br>
                    <label for='Answer2-1'> 
                        <input type="radio" id='Answer2-1' name='dom2' value='4' required>
                        <span> Decisamente sì </span>
                    </label>
                    <br>
                    <label for='Answer2-2'> 
                        <input type="radio" id='Answer2-2' name='dom2' value='3' required>
                        <span> Più sì che no </span>
                    </label>
                    <br>
                    <label for='Answer2-3'> 
                        <input type="radio" id='Answer2-3' name='dom2' value='2' required>
                        <span> Più no che si </span>
                    </label>
                    <br>
                    <label for='Answer2-4'> 
                        <input type="radio" id='Answer2-4' name='dom2' value='1' required>
                        <span> Decisamente no </span>
                    </label>
                </div>
                <br>
                <div class="form-element checkbox-button">
                    <label for="choice1-1">
                    <span> Suggerimenti</span><br>
                    <input type="checkbox" id="choice1-1" name="choice1-1">
                    <span class="checkbox-button">Alleggerire il carico didattico complessivo​ </span>
                    </label>
                    <br>
                    <label for="choice1-2">
                    <input type="checkbox" id="choice1-2" name="choice1-2">
                    <span class="checkbox-button">Aumentare l'attività di supporto didattico​​ </span>
                    </label>
                    <br>
                    <label for="choice1-3">
                    <input type="checkbox" id="choice1-3" name="choice1-3">
                    <span class="checkbox-button">Fornire più conoscenze di base​​​ </span>
                    </label>
                    <br>
                    <label for="choice1-4">
                    <input type="checkbox" id="choice1-4" name="choice1-4">
                    <span class="checkbox-button">Eliminare dal programma argomenti già trattati in altri insegnamenti​ </span>
                    </label>
                    <br>
                    <label for="choice1-5">
                    <input type="checkbox" id="choice1-5" name="choice1-5">
                    <span class="checkbox-button">Migliorare il coordinamento con altri insegnamenti </span>
                    </label>
                    <br>
                    <label for="choice1-6">
                    <input type="checkbox" id="choice1-6" name="choice1-6">
                    <span class="checkbox-button">Migliorare la qualità del materiale didattico​​​ </span>
                    </label>
                    <br>
                    <label for="choice1-7">
                    <input type="checkbox" id="choice1-7" name="choice1-7">
                    <span class="checkbox-button">Fornire in anticipo il materiale didattico​ </span>
                    </label>
                    <br>
                    <label for="choice1-8">
                    <input type="checkbox" id="choice1-8" name="choice1-8" >
                    <span class="checkbox-button">Inserire prove d'esame intermedie​​​ </span>
                    </label>
                    <br>
                    <label for="choice1-9">
                    <input type="checkbox" id="choice1-9" name="choice1-9">
                    <span class="checkbox-button">Attivare insegnamenti serali </span>
                    </label>
                </div>
                <br>
                <div class="form-element">
                    <label for='choice1'>
                        <span>Hai qualche suggerimento per migliorare la didattica a distanza (DaD) di questo insegnamento?​ </span>
                        <textarea cols="100" id='choice1' rows="1" form='quest' name='sugg1'>
                        </textarea>
                    </label>
                </div>
                <br>
                <div class="form-element">
                    <label for='choice2'>
                        <span>Hai qualche suggerimento per migliorare l'erogazione della didattica (riferita a questo insegnamento​?​ </span>
                        <textarea cols="100" id='choice2' rows="1" form='quest' name='sugg2'> 
                        </textarea>
                    </label>
                </div>
                <button class="pulsante" type='submit'>Invia questionario</button> 
            </form>
        </region>
    </body>
</html>