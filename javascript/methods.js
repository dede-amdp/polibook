async function request(url = '', data = {}) {
    // il metodo esegue una richiesta AJAX 
    return fetch(url, //url dello script da eseguire per il fetch dei dati
        {
            method: 'POST',
            body: JSON.stringify(data) //ingresso per lo script
        }).then(result => {
            if (!result.ok) { //se ricevo un errore nella risposta 
                throw new Error('No result'); //ho un errore
            }
            return result.json(); //se ho risposta corretta
        })//.catch(error => console.log(`C'è stato un errore nella richiesta, riprova più tardi`)); //errore è loggato e non è mostrato all'utente
}

function translated(lang, toTranslate) {
    // una stringa contenente più traduzioni è suddivisa e la funzione ritorna solo il valore con la traduzione corretta
    var reg = new RegExp(`^${lang}:.*`, 'm'); // prende dalla lista di traduzioni quella che corrisponde alla lingua corrente
    var riga = toTranslate.match(reg)[0];
    return riga.slice(riga.indexOf(':') + 1);
}