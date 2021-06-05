request('../php/fetchAvvisi.php').then(result => { // richiesta degli avvisi
    if (result != undefined && result != null) {
        if (result.length > 0) {
            var msgList = `<ul>`;
            result.forEach(avviso => {
                msgList += `<div><li>${createMsg(avviso)}</li></div>`; // inserisci avviso nella lista
            });
            document.getElementById('dashboard-table').innerHTML = msgList + '</ul>'; // inserisci gli avvisi nella pagina
            Array.from(document.getElementsByClassName('db-interact')).forEach(button => { // associa un event listener al pulsante per mostrare o nascondere il contenuto degli avvisi
                var modal = document.getElementById(`modal-${button.id}`);
                button.addEventListener('click', () => { modal.classList.toggle('show'); button.classList.toggle('active'); });
            });
        } else {
            document.getElementById('dashboard-table').innerHTML = `<p>Non ci sono avvisi da mostrare</p>`;
        }
    }
}).catch(error => document.getElementById('dashboard-table').innerHTML = `<p>Non ci sono avvisi da mostrare</p>`); // a causa dell'odinamento della query il database puù lanciare un'eccezione nel caso in cui non ci siano avvisi

function createMsg(avviso) {
    // crea il pulsante di avviso ed il modal associato
    var msgButton = `<button class='db-interact' id='${avviso.timestamp}'><img class='arrow' alt='showing icon' width=10 src = '../assets/icons/arrow.svg'/><b>${avviso.timestamp} - ${avviso.titolo}</b></button>`;
    var msgModal = `<div class='msg-modal' id='modal-${avviso.timestamp}'><p>${avviso.contenuto}</p></div>`;
    return msgButton + '</li><li>' + msgModal;
}