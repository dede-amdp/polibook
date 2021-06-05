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
        }).catch(error => alert('Errore nell\'esecuzione della richiesta, riprova più tardi')); //errore è loggato e non è mostrato all'utente
}