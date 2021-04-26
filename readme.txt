Convenzioni:
    * javascript : camelCase -> esempio, esempioSecondo, ClasseEsempio
    * php : snake_case -> esempio, esempio_secondo, Classe_esempio
    * html, css: kebab-case -> esempio, esempio-secondo, classe-esempio

Commenti:
    * in italiano
    * pls don't ignore them :(
    * !! per indicare importanza (si può usare TODO per indicare qualcosa da fare, ma in qualunque caso preceduto da !! così si trova subito)

Come usare dbh.inc.php:
    1) usare opneConn() che ritorna la connessione al db
    2) usare fetchDB($conn, $query, ...$argomenti) che ritorna i risultati
    3) chiudere la connessione con $conn -> close();
    4) i risultati ritornati da fetchDB sono un cursore, usare mysqli_fetch_assoc($results) per ritornare i risultati una riga alla volta

DB:
    * il file '/my_polibooklet.sql' è il file contenente la struttura del db. NON caricatelo su altervista, serve a noi così da importarlo sul pc e poter testare le query sui nostri database
        evitando di rompere il database di altervista

'/javascript/methods.js':
    * contiene i metodi javascript in comune

