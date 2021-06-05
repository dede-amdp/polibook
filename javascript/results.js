var tabella = document.getElementById('exam-result-table');
request('../php/fetchResults.php').then(result => {
    if (result != undefined && result != null) {
        if (result.length > 0) {
            var htmlString = '<tr><th>ID</th><th>Attività Didattica</th><th>Data Svolgimento</th><th>Scadenza</th><th>Risultato</th></tr>';
            var ids = [];
            result.forEach(exam => {
                var id = `${exam.corso},${exam.id},${exam.docente},${exam.ordinamento},${exam.data_svolgimento}`; // id dell'esame
                var idoneo = exam.status == 'IDONEO' || exam.status == 'ACCETTATO' || exam.status == 'RIFIUTATO'; // verifica se il voto può essere accettato/rifiutato
                var grade = idoneo ? (exam.risultato) + 'L'.repeat(exam.lode) : exam.status; // mostra voto
                var gradeToShow = grade + (exam.status == 'ACCETTATO' || exam.status == 'RIFIUTATO' ? ` <img alt='${exam.status}' src='../assets/icons/${exam.status == 'ACCETTATO' ? 'green' : 'red'}.svg' width=20></img>` : ''); // mostra icona green.svg o red.svg nel caso il voto sia stato accettato o rifiutato
                htmlString += `<tr id='${id}' class='exam${idoneo ? '-selectable' : ''}'><td>${exam.id}</td><td>${exam.nome}</td><td>${exam.data_svolgimento}</td><td>${exam.data_scadenza}</td><td>${gradeToShow}</td></tr>`; // costruisci la riga
                htmlString += idoneo ? createModal(id, '<p><font color=#009999><b>Vuoi accettare il risultato?</b></font></p>') : ''; // crea il modal solo se lo studente può accettare/rifiutare il voto
                ids.push(id);
            });
            tabella.innerHTML = htmlString;
            ids.forEach(id => assignCallback(id));
        } else {
            var div = document.getElementById('exam-result-div');
            div.innerHTML = `<p>Non ci sono risultati da mostrare</p><img alt='Nessun risultato' class='no-result' width=250 src='../assets/NonPidove.svg'></img>`; // mostra un immagine in caso di assenza di risultati
        }
    }
}).catch(error => alert('C\'è stato un errore imprevisto'));

function createModal(id, msg) {
    // costruisce il modal con l'id specificato e con il messaggio specificato nel corpo del modal
    return `<div id='modal-${id}' class='modal'><div class='modal-content'><p>${msg}</p><button id='confirm-button-${id}'>ACCETTA</button><button id='refuse-button-${id}'>RIFIUTA</button><button id='cancel-button-${id}' class='cancel-button'>ANNULLA</button></div></div>`;
}

function assignCallback(id) {
    // assegna la callback ai pulsanti nel modal
    var row = document.getElementById(id);
    var modal = document.getElementById('modal-' + id);
    var acceptButton = document.getElementById('confirm-button-' + id);
    var refuseButton = document.getElementById('refuse-button-' + id);
    var cancelButton = document.getElementById('cancel-button-' + id);
    acceptButton.addEventListener('click', () => accept(id, true));
    refuseButton.addEventListener('click', () => { if (confirm('Vuoi davvero rifiutare il voto?')) accept(id, false); });
    cancelButton.addEventListener('click', () => modal.style.display = 'none');
    row.classList.add('selectable');
    row.addEventListener('click', () => modal.style.display = 'block');
}

function accept(id, acpt) {
    // richiesta per accettare/rifiutare un voto
    request('../php/acceptResult.php', { "dataString": id, "status": acpt ? 'ACCETTATO' : 'RIFIUTATO' }).then(result => {
        console.log(result);
        if (result != null && result != undefined) {
            var message = 'Qualcosa è andato storto...';
            if (result) message = `L'operazione è avvenuta con successo`;
            alert(message);
        }
        var modal = document.getElementById('modal-' + id);
        modal.style.display = 'none';
        document.location.reload();
    });
}