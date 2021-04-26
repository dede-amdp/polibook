<?php
    function openConn(){
        $dbServerName = 'localhost';
        $dbUserName = 'root';
        $dbPassword = '';
        $dbName = 'my_polibooklet';
        $conn = mysqli_connect($dbServerName,$dbUserName, $dbPassword, $dbName); //apri la connessione al db
        return $conn; 
    }


    function fetchDB($conn, $query, ...$vals){
        // fa una query parametrizzata
        $statement = mysqli_stmt_init($conn); // inizializza lo statement
        if(!mysqli_stmt_prepare($statement, $query)){ // se c'è un problema con la query
            echo 'Errore nel fetch dei dati';
            return null;
        }else{
            if($vals != null && count($vals) > 0){
                $bindings = str_repeat('s', count($vals)); // serve per indicare quanti valori deve aspettarsi la il processo di collegamento
                mysqli_stmt_bind_param($statement, $bindings, ...$vals); // collega i valori inseriti con quelli inidicati nella query 
            }
            mysqli_stmt_execute($statement); // esegui la query
            return mysqli_stmt_get_result($statement); // prendi i risultati
        }
        return null;
    }
?>