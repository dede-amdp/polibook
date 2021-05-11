let prenotabiliButton = document.getElementById('prenotabili');
let prenotatiButton = document.getElementById('prenotati');
let prenotabiliTab = document.getElementById('prenotabili-tab');
let prenotatiTab = document.getElementById('prenotati-tab');

const matricola = '000000'; //!!Da cambiare
var lang = 'eng'; // !! Da cambiare
// richiesta degli esami prenotabili
request('../php/fetchPrenotabiliData.php', { matricola: matricola }).then(result => {
    if (result != undefined) {
        // creare la tabella che conterrà gli esami prenotabili
        ids = createTable(result, prenotabiliTab, '</br><font color=\'#009999\'>Confermi l\'iscrizione all\'esame?</font>', lang);
        if (ids != null) {
            // per ciascun id di riga selezionabile
            ids.forEach(id => {
                var row = document.getElementById(id);
                var modal = document.getElementById('modal-' + id); // trova il modal associato alla tabella
                var okButton = document.getElementById('confirm-button-' + id); // trova il pulsante di conferma
                var cancelButton = document.getElementById('cancel-button-' + id); // trova il pulsante ANNULLA
                okButton.addEventListener('click', () => insertExam(matricola, id)); // aggiunge gli event listeners per l'inserimento dell'iscrizione all'esame 
                cancelButton.addEventListener('click', () => modal.style.display = 'none'); // e per nascondere il modal 
                row.classList.add('selectable'); // aggiungi selectable alla classe di ciascuna riga selezionabile
                row.addEventListener('click', () => modal.style.display = 'block'); //mostra il modal
            });
        }
    }
}).catch(error => console.log(error));

// richiesta degli esami prenotati
request('../php/fetchPrenotatiData.php', { matricola: '000000' }).then(result => {
    if (result != undefined) {
        // crea la tabellache conterrà ciascuna prenotazione effettuata dall'utente
        ids = createTable(result, prenotatiTab, '</br><font color=\'#009999\'>Sei sicuro di voler annullare l\' iscrizione?</font>', lang);
        if (ids != null) { //per ciascuna riga selezionabile
            ids.forEach(id => {
                row = document.getElementById(id);
                var modal = document.getElementById('modal-' + id); // trova il modal associato alla tabella
                var okButton = document.getElementById('confirm-button-' + id); // trova il pulsante di conferma
                var cancelButton = document.getElementById('cancel-button-' + id); // trova il pulsante ANNULLA
                okButton.addEventListener('click', () => deleteExam(matricola, id)); // aggiunge gli event listeners per l'inserimento dell'iscrizione all'esame 
                cancelButton.addEventListener('click', () => modal.style.display = 'none'); // e per nascondere il modal 
                row.classList.add('selectable'); // modifica la classe della riga
                row.addEventListener('click', () => modal.style.display = 'block'); //mostra il modal
            });
        }
    }
}).catch(error => console.log(error));



prenotatiButton.onclick = function () {
    // scambia il colore di testo e sfondo ai tasti delle schede e rendi visibile la div corretta
    prenotatiTab.style.display = 'block';
    prenotabiliTab.style.display = 'none';
    prenotatiButton.style.backgroundColor = '#e7e7e7';
    prenotatiButton.style.color = '#000000';
    prenotabiliButton.style.backgroundColor = '#009999';
    prenotabiliButton.style.color = 'white';
    prenotabiliButton.style.cursor = 'pointer';
    prenotatiButton.style.cursor = 'default';
};
prenotabiliButton.onclick = function () {
    // scambia il colore di testo e sfondo ai tasti delle schede e rendi visibile la div corretta
    prenotatiTab.style.display = 'none';
    prenotabiliTab.style.display = 'block';
    prenotabiliButton.style.backgroundColor = '#e7e7e7';
    prenotabiliButton.style.color = '#000000';
    prenotatiButton.style.backgroundColor = '#009999';
    prenotatiButton.style.color = 'white';
    prenotatiButton.style.cursor = 'pointer';
    prenotabiliButton.style.cursor = 'default';
};

function createTableHeaders(keys, excluded = []) {
    // costruisci l'header di una tabella a partire da delle chiavi, eliminando alcune chiavi indicate in excluded
    // ** perchè non inserire direttamente le chiavi escludendo quelle da escludere? così posso fare tutto in una funzione e ho tutto in ordine
    var header_row = '';
    keys.forEach(key => {
        if (!excluded.includes(key)) {
            header_row += `<th>${key.charAt(0).toUpperCase() + key.slice(1)}</th>`; // prima di usare la chiave metto la prima lettera in maiuscolo
        }
    });
    return header_row;
}

function createTable(result, tableElement, confirm, lang) {
    var htmlString = ''; // conterrà la struttura ed i dati della tabella
    if (result.length > 0) { //se effettivamente result è accettabile
        ids = []; // inizializza una lista di id di righe selezionabili
        htmlString += '<tr>' + createTableHeaders(Object.keys(result[0]), ['id_docente', 'cognome_docente', 'messaggio', 'numero massimo di iscritti']) + '</tr>'; // header della tabella
        result.forEach(row => {
            var dt = new Date(); // serve per la data di oggi
            var today = Date.parse(dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate()); // scrive la data di oggi (Gennaio = 0)
            var date = Date.parse(row['disponibile fino al'].split(' ')[0]); // traduce la data_fine dell'appello
            id = `${row['corso']},${row['id']},${row['id_docente']},${row['ordinamento']},${row['data svolgimento']}`; //crea l'id unendo in una stringa tutte le chiavi
            var iscrivibile = row['numero iscritti'] != undefined ? (row['numero iscritti'] == 0 || row['numero_iscritti'] > row['numero massimo di iscritti']) : true; // se serve il numero di iscritti
            if (date >= today && iscrivibile) { // se la data di oggi precede quella di scadenza e il numero di iscritti è minore di quello massimo
                ids.push(id); // inserisce l'id nella lista di id selezionabili
            }
            htmlString += `<tr id='${id}' class='exam'>`; // assegna l'id alla riga
            var msg = ''; // il messaggio da visualizzare nel modal prima della conferma dell'esame
            for (var [key, element] of Object.entries(row)) {
                switch (key) {
                    case 'attività didattica':
                        var nome = translated(lang, element) // traduce il nome
                        htmlString += `<td>${nome}</td>`;
                        break;
                    case 'docente':
                        htmlString += `<td>${element} `; // unisce nome e cognome del docente in un'unica cella
                        break;
                    case 'cognome_docente':
                        htmlString += `${element}</td>`;
                        break;
                    case 'id_docente': // non mostrare l'id docente
                        break;
                    case 'messaggio':
                        msg = element;
                        break;
                    case 'numero iscritti':
                        htmlString += `<td>${element} `;
                        break;
                    case 'numero massimo di iscritti': // se 0 ignora perchè indica che il numero di iscritti non ha limite
                        if (element == 0) {
                            htmlString += `</td>`;
                        } else {
                            htmlString += `su ${element}</td>`;
                        }
                        break;
                    default:
                        htmlString += `<td>${element}</td>`;
                }
            }
            htmlString += `</tr>`;
            var toShow = msg != null && msg != '' ? '<b>Messaggio:</b></br>' + msg : '';
            htmlString += createModal(id, toShow + confirm); // aggiunge il modal alla pagina che poi verrà mostrato in seguito
        });
        tableElement.innerHTML = `<table border=2px>${htmlString}</table>`; // costruisce effettivamente la tabella
        return ids; //ritorna i valori
    } else { // result non è accettabile
        tableElement.innerHTML = '<p>No result found</p>';
        return null;
    }
}

function insertExam(matricola, id) {
    request('../php/insertExam.php', { matricola: matricola, dataString: id }).then(result => {
        if (result) {
            // avverti l'utente che l'iscrizione è avvenuta con successo
            alert('Iscrizione Effettuata');
            document.location.reload(); //ricarica la pagina
        } else {
            alert('Qualcosa è andato storto');
        }
    }).catch(error => console.log(error)); // !! che succede se è il trigger a impedire la query? Dobbiamo saperlo per avvisare l'utente che non può iscriversi causa numero di iscritti
}

function deleteExam(matricola, id) {
    if (confirm('Sei davvero sicuro di voler annullare l\'iscrizione?')) {
        // dato che il disiscriversi può essere irreparabile, la conferma è chiesta 2 volte
        // richiesta di eliminazione dell'iscrizione dalla tabella 'risultato'
        request('../php/deleteExam.php', { matricola: matricola, dataString: id }).then(result => {
            //!! per le delete queries mysql ritorna sempre false (anche se avviene con successo): come vedere se la disinscrizione non è avvenuta?
            alert('Hai annullato l\'iscrizione');
            document.location.reload(); //ricarica il documento
        });
    }
}

function createModal(id, msg) {
    // costruisce il modal con l'id specificato e con il messaggio specificato nel corpo del modal
    return `<div id='modal-${id}' class='modal'><div class='modal-content'><p>${msg}</p><button id='confirm-button-${id}'>OK</button><button id='cancel-button-${id}' class='cancel-button'>ANNULLA</button></div></div>`;
}