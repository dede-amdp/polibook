var lang = 'ita';
request('../php/fetchUserData.php').then(result => { // richiesta per i dati dell'utente
    if (result != null && result != undefined) {
        var table = document.getElementById('userData');
        var data = `<table border=2><tr><th><font color=#009999><b>Nome:</b></font></th><td>${result.nome_studente}</td></tr><tr><th><font color=#009999><b>Cognome:</b></font></th><td>${result.cognome}</td></tr><tr><th><font color=#009999><b>Codice Fiscale:</b></font></th><td>${result.cf}</td></tr><tr><th><font color=#009999><b>Data di Nascita:</b></font></th><td>${result.data_nascita}</td></tr><tr><th><font color=#009999><b>Indirizzo di Residenza:</b></font></th><td>${result.indirizzo}</td></tr><tr><th><font color=#009999><b>` +
            `Matricola:</b></font></th><td>${result.matricola}</td></tr><tr><th><font color=#009999><b>Indirizzo e-mail:</b></font></th><td>${result.email}</td></tr><tr><th><font color=#009999><b>Corso di Laurea:</b></font></th><td>${translated(lang, result.nome_cdl)} [${result.cdl_id}]</td></tr><tr><th><font color=#009999><b>Percorso:</b></font></th><td>${result.percorso}</td></tr><tr><th><font color=#009999><b>Facoltà:</b></font></th><td>${result.nome_facolta} [${result.facolta_id}]</td></tr><tr><th><font color=#009999><b>` +
            `Anno di iscrizione:</b></font></th><td>${result.anno_iscrizione}</td></tr><tr><th><font color=#009999><b>Anno di corso:</b></font></th><td>${result.anno_di_corso}</td></tr></table>`;
        table.innerHTML = data; // inserisce la tabella così costruita nella pagina
    } else {
        document.getElementById('userData').innerHTML = '<p>Nessun Dato Trovato</p>';
    }
}).catch(error => alert('Non è stato possibile trovare i dati dell\'utente, riprova più tardi'));

var passwordButton = document.getElementById('password'); // pulsante per mostrare la sezione di modifica della password
var emailButton = document.getElementById('email'); // pulsante per mostrare la sezione di modifica della email
var addressButton = document.getElementById('address'); // pulsante per mostrare la sezione di modifica dell'indirizzo

passwordButton.addEventListener('click', () => {
    // rende attivo il pulsante cliccato (così che il css possa cambiarne l'aspetto)
    // disattiva gli altri due pulsanti
    passwordButton.classList.toggle('active');
    emailButton.classList.remove('active');
    addressButton.classList.remove('active');
    Array.from(document.getElementsByClassName('profile')).forEach(div => div.style.display = 'none'); // nascondi tutte le sezioni di modifica
    if (passwordButton.classList.contains('active')) document.getElementById('password-div').style.display = 'block'; // mostra la sezione di modifica corretta
});
emailButton.addEventListener('click', () => {
    // rende attivo il pulsante cliccato (così che il css possa cambiarne l'aspetto)
    // disattiva gli altri due pulsanti
    passwordButton.classList.remove('active');
    emailButton.classList.toggle('active');
    addressButton.classList.remove('active');
    Array.from(document.getElementsByClassName('profile')).forEach(div => div.style.display = 'none'); // nascondi tutte le sezioni di modifica
    if (emailButton.classList.contains('active')) document.getElementById('email-div').style.display = 'block'; // mostra la sezione di modifica corretta
});
addressButton.addEventListener('click', () => {
    // rende attivo il pulsante cliccato (così che il css possa cambiarne l'aspetto)
    // disattiva gli altri due pulsanti
    passwordButton.classList.remove('active');
    emailButton.classList.remove('active');
    addressButton.classList.toggle('active');
    Array.from(document.getElementsByClassName('profile')).forEach(div => div.style.display = 'none'); // nascondi tutte le sezioni di modifica
    if (addressButton.classList.contains('active')) document.getElementById('address-div').style.display = 'block'; // mostra la sezione di modifica corretta
});
