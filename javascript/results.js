// id-nome-data-data_verb.-risultato + popup(accetta-rifiuta-annulla)
var tabella = docuemnt.getElementById(''); // !! inserire l'id della tabella nel documento che ancora non esiste
request('../php/fetchResults.php').then(result => {
    if (result != undefined && result != null) {
        if (result.length > 0) {
            var htmlString = '<tr><th>ID</th><th>Attività Didattica</th><th>Data Svolgimento</th><th>Scadenza</th><th>Risultato</th></tr>';
            var ids = [];
            result.forEach(exam => {
                var id = `${exam.corso},${exam.id},${exam.docente},${exam.ordinamento},${exam.data_svolgimento}`;
                htmlString += `<tr id='${id}'><td>${exam.id}</td><td>${exam.nome}</td><td>${exam.data_svolgimento}</td><td>${exam.data_scadenza}</td><td>${exam.status == 'IDONEO' ? (exam.risultato) + 'L'.repeat(exam.lode) : exam.status}</td></tr>`;
                htmlString += exam.status == 'IDONEO' ? createModal($id, '<p><font color=#009999>Vuoi accettare il risultato?</font></p>') : '';
                ids.push(id);
            });
            tabella.innerHTML = htmlString;
            ids.forEach(id => assignCallback(id));
        }
    }
});


function createModal(id, msg) {
    // costruisce il modal con l'id specificato e con il messaggio specificato nel corpo del modal
    return `<div id='modal-${id}' class='modal'><div class='modal-content'><p>${msg}</p><button id='confirm-button-${id}'>ACCETTA</button><button id='refuse-button-${id}'>RIFIUTA</button><button id='cancel-button-${id}' class='cancel-button'>ANNULLA</button></div></div>`;
}

function assignCallback(id) {
    var row = document.getElementById(id);
    var modal = document.getElementById('modal-' + id);
    var acceptButton = document.getElementById('confirm-button-' + id);
    var refuseButton = document.getElementById('refuse-button-' + id);
    var cancelButton = document.getElementById('cancel-button-' + id);
    acceptButton.addEventListener('click', () => accept(id, true));
    refuseButton.addEventListener('click', () => accept(id, false));
    cancelButton.addEventListener('click', () => modal.style.display = 'none');
    row.classList.add('selectable');
    row.addEventListener('click', () => modal.style.display = 'block');
}

function accept(id, acpt) {
    // !! Inserire richiesta update dello stato dell'esame in accettato o rifiutato
}