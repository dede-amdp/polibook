<?php
    function open_conn(){
        $dbServerName = 'localhost';
        $dbUserName = 'root';
        $dbPassword = '';
        $dbName = 'my_polibooklet';
        $conn = mysqli_connect($dbServerName,$dbUserName, $dbPassword, $dbName); //apri la connessione al db
        return $conn; 
    }


    function fetch_DB($conn, $query, ...$vals){
        // fa una query parametrizzata per fare il fetch dei dati
        $statement = mysqli_stmt_init($conn); // inizializza lo statement
        if(!mysqli_stmt_prepare($statement, $query)){ // se c'è un problema con la query
            echo 'Errore nel fetch dei dati';
            return false;
        }else{
            if($vals != null && count($vals) > 0){
                $bindings = str_repeat('s', count($vals)); // serve per indicare quanti valori deve aspettarsi la il processo di collegamento
                mysqli_stmt_bind_param($statement, $bindings, ...$vals); // collega i valori inseriti con quelli indicati nella query 
            }
            mysqli_stmt_execute($statement); // esegui la query
            return mysqli_stmt_get_result($statement); // prendi i risultati
        }
        return null;
    }

    function insert_DB($conn, $table, ...$vals){
        // fa una query parametrizzata per inserire i dati
        /* 
            $table ha questa struttura: nomeTabella (colonna1, colonna2, ...)
            mi permetto di non parametrizzare questo argomento in quanto non fa parte dei dati inseriti dall'utente e quindi non può essere modificato da untenti
            malintenzionati.
        */
        $to_bind = str_repeat('?,', count($vals)); //serve per indicare quanti ? devono esserci per i valori
        $to_bind = substr($to_bind, 0, strlen($to_bind)-1); //elimino l'ultuima ','
        $query = 'INSERT INTO '.$table.' VALUES('.$to_bind.');'; // VALUES(?, ?, ?.....)
        $statement = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($statement, $query)){ // se c'è un problema con la query
            echo 'Errore nell\' insertion dei dati';
            return false;
        }else{
            if($vals != null && count($vals) > 0){
                $bindings = str_repeat('s', count($vals)); // serve per indicare quanti valori deve aspettarsi la il processo di collegamento
                mysqli_stmt_bind_param($statement, $bindings, ...$vals); // collega i valori inseriti con quelli indicati nella query 
            }
            mysqli_stmt_execute($statement); // esegui la query
            return true; //se la query va a buon fine la funzione ritorna 'vero'
        }
        return null;
    }
?>