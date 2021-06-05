let prenotabiliButton = document.getElementById('prenotabili');
let prenotatiButton = document.getElementById('prenotati');
let prenotabiliTab = document.getElementById('prenotabili-tab');
let prenotatiTab = document.getElementById('prenotati-tab');

// richiesta degli esami prenotabili
request('../php/fetchPrenotabiliData.php').then(result => {
    if (result != undefined && result != null) {
        // creare la tabella che conterrà gli esami prenotabili
        if (result.length > 0) {
            var ids = [];
            var noInteractIds = [];
            var header = `<tr><th>Corso</th><th>Docente</th><th>ID</th><th>Attività Didattica</th><th>Ordinamento</th><th>Data Svolgimento</th><th>Valido entro il</th><th>Aula</th><th>Iscritti</th></tr>`;
            var htmlString = '';
            result.forEach(row => {
                var id = createId(row);
                htmlString += `<tr id='${id}' class='exam'>`; // assegna l'id alla riga
                htmlString += `<td>${row.corso}</td><td>${row.cognome + "\n" + row.docente}</td><td>${row.id}</td><td>${row.nome}</td><td>${row.ordinamento}</td><td>${row.data}</td><td>${row.scadenza}</td><td>${row.aula}</td><td>${row.iscritti + (row.max_iscritti > 0 ? (' su ' + row.max_iscritti) : '')}</td></tr>`;
                var toShow = row.messaggio != null && row.messaggio != '' ? '<b>Messaggio:</b><br>' + row.messaggio : ''; // il messaggio da visualizzare nel modal prima della conferma dell'esame
                var msg = '';
                var legal = isLegal(row);
                if (legal.isLegal) {
                    msg = toShow + `<br><font color=#009999><b>Sei sicuro di volerti iscrivere all'esame?</b></font>`;
                    ids.push(id);
                } else {
                    msg = toShow + `<br><font color=#009999>Non puoi iscriverti all'esame perché ${legal.cause}</font>`;
                    noInteractIds.push(id);
                }
                htmlString += createModal(id, msg);
            });
            prenotabiliTab.innerHTML = `<table border=2px>${header + htmlString}</table>`; // costruisce effettivamente la tabella
            if (ids != null) {
                ids.forEach(id => {
                    assignCallback(id, insertExam);
                });
            }
            if (noInteractIds != null) {
                noInteractIds.forEach(id => {
                    assignCallback(id, null);
                });
            }
        } else
            prenotabiliTab.innerHTML = '<p>Nessun risultato trovato</p>';
    } else {
        prenotabiliTab.innerHTML = '<p>Riprova più tardi</p>';
    }
}).catch(error => alert('C\'è stato un errore imprevisto'));

// richiesta degli esami prenotati
request('../php/fetchPrenotatiData.php').then(result => {
    if (result != undefined && result != null) {
        // crea la tabella che conterrà ciascuna prenotazione effettuata dall'utente
        if (result.length > 0) {
            var ids = [];
            var noInteractIds = [];
            var header = `<tr><th>Corso</th><th>Docente</th><th>ID</th><th>Attività Didattica</th><th>Ordinamento</th><th>Data Svolgimento</th><th>Aula</th></tr>`;
            var htmlString = '';
            result.forEach(row => {
                var id = createId(row);
                htmlString += `<tr id='${id}' class='exam'>`; // assegna l'id alla riga
                htmlString += `<td>${row.corso}</td><td>${row.cognome + "\n" + row.docente}</td><td>${row.id}</td><td>${row.nome}</td><td>${row.ordinamento}</td><td>${row.data}</td><td>${row.aula}</td></tr>`;
                var toShow = row.messaggio != null && row.messaggio != '' ? '<b>Messaggio:</b><br>' + row.messaggio : ''; // il messaggio da visualizzare nel modal prima della conferma dell'esame
                var msg = '';
                var legal = isLegal(row);
                if (legal.isLegal) {
                    msg = toShow + `<br><font color=#009999><b>Sei sicuro di voler annullare l'iscrizione?</b></font>`;
                    ids.push(id);
                } else {
                    msg = toShow + `<br><font color=#009999>Non puoi annullare l'iscrizione all'esame perché ${legal.cause}</font>`;
                    noInteractIds.push(id);
                }
                htmlString += createModal(id, msg);
            });
            prenotatiTab.innerHTML = `<table border=2px>${header + htmlString}</table>`; // costruisce effettivamente la tabella
            if (ids != null) { //per ciascuna riga selezionabile
                ids.forEach(id => {
                    assignCallback(id, deleteExam);
                });
            }
            if (noInteractIds != null) {
                noInteractIds.forEach(id => {
                    assignCallback(id, null);
                });
            }
        } else
            prenotatiTab.innerHTML = '<p>Nessun risultato trovato</p>';
    } else {
        prenotatiTab.innerHTML = '<p>Riprova più tardi</p>';
    }
}).catch(error => alert('C\'è stato un errore imprevisto'));

prenotatiButton.onclick = function () {
    // scambia il colore di testo e sfondo ai tasti delle schede e rendi visibile la div corretta
    prenotatiTab.style.display = 'block';
    prenotabiliTab.style.display = 'none';
    prenotabiliButton.classList.add('active');
    prenotatiButton.classList.remove('active');
};
prenotabiliButton.onclick = function () {
    // scambia il colore di testo e sfondo ai tasti delle schede e rendi visibile la div corretta
    prenotatiTab.style.display = 'none';
    prenotabiliTab.style.display = 'block';
    prenotatiButton.classList.add('active');
    prenotabiliButton.classList.remove('active');
};

function assignCallback(id, callback = (id) => { }) {
    row = document.getElementById(id);
    var modal = document.getElementById('modal-' + id); // trova il modal associato alla tabella
    var okButton = document.getElementById('confirm-button-' + id); // trova il pulsante di conferma
    var cancelButton = document.getElementById('cancel-button-' + id); // trova il pulsante ANNULLA
    if (callback == null || callback == undefined)
        okButton.style.display = 'none';
    else
        okButton.addEventListener('click', () => callback(id)); // aggiunge gli event listeners per l'inserimento dell'iscrizione all'esame 
    cancelButton.addEventListener('click', () => modal.style.display = 'none'); // e per nascondere il modal 
    row.classList.add('selectable'); // modifica la classe della riga
    row.addEventListener('click', () => modal.style.display = 'block'); //mostra il modal

}

function createId(row) {
    return `${row.corso},${row.id},${row.id_docente},${row.ordinamento},${row.data}`; //crea l'id unendo in una stringa tutte le chiavi
}

function isLegal(row) {
    var dt = new Date(); // serve per la data di oggi
    var today = Date.parse(dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate()); // scrive la data di oggi (Gennaio = 0)
    var date = Date.parse(row.scadenza.split(' ')[0]); // traduce la data_fine dell'appello
    var iscrivibile = row.iscritti != undefined ? (row.iscritti == 0 || row.iscritti > row.max_iscritti) : true; // se serve il numero di iscritti
    var cause = (date < today ? 'fuori dal periodo utile' : '') + (date < today && !iscrivibile ? ' e ' : '') + (!iscrivibile ? 'è stato raggiunto il numero massimo di iscritti' : '');
    return { 'isLegal': date >= today && iscrivibile, 'cause': cause };
}

function insertExam(id) {
    request('../php/insertExam.php', { dataString: id }).then(result => {
        if (result) {
            if (result == 'inc')
                alert('Iscrizione non effettuata: i dati inseriti sono incoerenti');
            // avverti l'utente che l'iscrizione è avvenuta con successo
            else if (result) {
                alert('Iscrizione Effettuata');
                document.location.reload(); //ricarica la pagina
            } else {
                alert('Iscrizione non effettuata');
            }
        } else {
            alert('Qualcosa è andato storto');
        }
    }).catch(error => console.log(`C'è stato un errore durante l'iscrizione all'esame, la preghiamo di riprovare più tardi`));
}

function deleteExam(id) {
    if (confirm('Sei davvero sicuro di voler annullare l\'iscrizione?')) {
        // dato che il disiscriversi può essere irreparabile, la conferma è chiesta 2 volte
        // richiesta di eliminazione dell'iscrizione dalla tabella 'risultato'
        request('../php/deleteExam.php', { dataString: id }).then(result => {
            //!! per le delete queries mysql ritorna sempre false (anche se avviene con successo): come vedere se la disinscrizione non è avvenuta?
            alert('Hai annullato l\'iscrizione');
            document.location.reload(); //ricarica il documento
        }).catch(error => console.log(`C'è stato un errore durante l'annullamento dell'iscrizione all'esame, la preghiamo di riprovare più tardi`));;
    }
}

function createModal(id, msg) {
    // costruisce il modal con l'id specificato e con il messaggio specificato nel corpo del modal
    return `<div id='modal-${id}' class='modal'><div class='modal-content'><p>${msg}</p><button id='confirm-button-${id}'>OK</button><button id='cancel-button-${id}' class='cancel-button'>ANNULLA</button></div></div>`;
}