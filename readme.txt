Convenzioni:
    * javascript : camelCase -> esempio, esempioSecondo, ClasseEsempio
    * php : snake_case -> esempio, esempio_secondo, Classe_esempio
    * html, css: kebab-case -> esempio, esempio-secondo, classe-esempio

Commenti:
    * in italiano
    * pls don't ignore them :(
    * !! per indicare importanza (si può usare TODO per indicare qualcosa da fare, ma in qualunque caso preceduto da !! così si trova subito)

Come usare dbh.inc.php:
    1) usare open_conn() che ritorna la connessione al db
    2) usare fetch_DB($conn, $query, ...$argomenti) per il fetch dei dati
        2.1) i risultati ritornati da fetch_DB sono un cursore, usare mysqli_fetch_assoc($results) per ritornare i risultati una riga alla volta
    3) usare insert_DB($conn, $tabella, ...$argomenti) per l'inserzione dei dati
        3.1) la funzione restiruirà un booleano che indica se la query è andata a buon fine
    3) chiudere la connessione con $conn -> close() (si consiglia di farlo sempre);

DB:
    * il file '/my_polibooklet.sql' è il file contenente la struttura del db. NON caricatelo su altervista, serve a noi così da importarlo sul pc e poter testare le query sui nostri database
        evitando di rompere il database di altervista

'/javascript/methods.js':
    * contiene i metodi javascript in comune

