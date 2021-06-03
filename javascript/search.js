// recupera gli elementi di input per eseguire la ricerca
var searchButton = document.getElementById('search-button');
var annoBt = document.getElementById('annobt');
var facBt = document.getElementById('facoltabt');
var cdlBt = document.getElementById('cdlbt');
var clear = document.getElementById('clear');

// pulsante per svuotare tutti gli input
clear.addEventListener('click', () => {
    var inputs = document.getElementsByClassName('input');
    Array.from(inputs).forEach(element => {
        element.value = '';
    });
    document.getElementById('annobt').innerHTML = ' --- ';
    document.getElementById('facoltabt').innerHTML = ' --- ';
    document.getElementById('cdlbt').innerHTML = ' --- ';
});

// pulsante per selezionare l'ordinamento
annoBt.addEventListener('click', () => {
    var annoDiv = document.getElementById('anno-div');
    annoDiv.classList.toggle('active'); // mostra gli ordinamenti presenti
    if (annoDiv.classList.contains('active')) {
        request('../php/fetchOrdinamento.php').then(res => { // richiedi gli ordinamenti
            annoDiv.innerHTML = `<button id='clear-anno'> --- </button>`; // inserisci un pulsante per svuotare il campo
            res.forEach(element => {
                annoDiv.innerHTML += `<button id='${element.ordinamento}'>${element.ordinamento}</button>`; // aggiungi alla lista tutti gli ordinamenti trovati
            });
            document.getElementById('clear-anno').addEventListener('click', () => {
                // se seleziono l'elemento vuoto, svuota il campo di ricerca riguardante l'anno
                var annoBt = document.getElementById('annobt');
                annoBt.innerHTML = ' --- ';
                document.getElementById('anno').value = '';
            });
            res.forEach(element => {
                document.getElementById(element.ordinamento).addEventListener('click', () => {
                    // se seleziono un ordinamento prendi il valore
                    var annoBt = document.getElementById('annobt');
                    annoBt.innerHTML = element.ordinamento;
                    document.getElementById('anno').value = element.ordinamento;
                });
            });
        });
    }
});

// pulsante per selezionare il corso di laurea
cdlBt.addEventListener('click', () => {
    var cdlDiv = document.getElementById('cdl-div');
    cdlDiv.classList.toggle('active'); // mostra i cdl
    if (cdlDiv.classList.contains('active')) {
        request('../php/fetchCorsiDL.php').then(res => {
            cdlDiv.innerHTML = `<button id='clear-cdl'> --- </button>`; // pulsante vuoto
            res.forEach(element => {
                cdlDiv.innerHTML += `<button id='${element.nome}'>${element.nome}</button>`;
            });
            document.getElementById('clear-cdl').addEventListener('click', () => {
                // svuota il campo cdl
                var cdlBt = document.getElementById('cdlbt');
                cdlBt.innerHTML = ' --- ';
                document.getElementById('cdl').value = '';
            });
            res.forEach(element => {
                document.getElementById(element.nome).addEventListener('click', () => {
                    // seleziona il cdl
                    var cdlBt = document.getElementById('cdlbt');
                    cdlBt.innerHTML = element.nome;
                    document.getElementById('cdl').value = element.nome;
                });
            });
        });
    }
});

// pulsante per selezionare il dipartimento
facBt.addEventListener('click', () => {
    var facDiv = document.getElementById('facolta-div');
    facDiv.classList.toggle('active'); // mostra i dipartimenti
    if (facDiv.classList.contains('active')) {
        request('../php/fetchFacolta.php').then(res => {
            facDiv.innerHTML = `<button id='clear-fac'> --- </button>`; // pulsante vuoto
            res.forEach(element => {
                facDiv.innerHTML += `<button id='${element.nome}'>${element.nome}</button>`;
            });
            document.getElementById('clear-fac').addEventListener('click', () => {
                // svuota il campo
                var facBt = document.getElementById('facoltabt');
                facBt.innerHTML = ' --- ';
                document.getElementById('dipartimento').value = '';
            });
            res.forEach(element => {
                // seleziona il dipartimento
                document.getElementById(element.nome).addEventListener('click', () => {
                    var facBt = document.getElementById('facoltabt');
                    facBt.innerHTML = element.nome;
                    document.getElementById('dipartimento').value = element.nome;
                });
            });
        });
    }
});

// aggiungo al tasto di ricerca la funzione per eseguire la query
searchButton.addEventListener('click', () => {
    // prendi gli input dai campi di ricerca
    document.getElementById('search-res').classList.add('risultati-ricerca');
    var inputs = document.getElementsByClassName('input');
    var data = {};
    Array.from(inputs).forEach(element => {
        data[element.id] = element.value;
    });
    search(data.anno, data.attDid, data.dipartimento, data.cdl, data.docente.replace(/\s/g, '')); // inserisci nella ricerca
    // alla stringa del docente sono rimossi gli spazi così da migliorare il confronto con la stringa salvata nel database
});

function search(anno, attdid, fac, cdl, doc) {
    document.getElementById('search-res').innerHTML = ''; // svuota il campo dei risultati
    request('../php/search.php', { "anno": anno, "attDid": attdid, "dipartimento": fac, "docente": doc, 'cdl': cdl }).then(result => {
        if (result != undefined && result != null && result.length > 0) {
            var resdiv = document.getElementById('search-res');
            var htmlString = '';
            result.forEach(row => {
                var rowString = '';
                // dato che i risukltati possono contenere solo cdl o attdid, se è assente il nome dell'esame allora è un cdl
                if (row.nome_attdid != null && row.nome_attdid != '') {
                    //aggiungi i risultati che riguardano le attdid
                    var href = `../pages/activity.php?atd=${row.id}&ord=${row.ordinamento}&cdl=${row.id_cdl}&doc=${row.id_docente}`;
                    rowString = `<li><a href='${href}'>${row.id} - ${row.nome_attdid} - CFU ${row.cfu} - ${row.cognome_docente} ${row.nome_docente}</a><br>
                                        Ordinamento: ${row.ordinamento}<br>
                                        ${row.id_cdl} - ${row.nome_cdl}<br>
                                        ${row.id_facolta} - ${row.nome_facolta}</li>`;
                } else {
                    //aggiungi i risultati che riguardano i cdl
                    var href = `../pages/cdl.php?cdl=${row.id_cdl}`;
                    rowString = `<li><a href='${href}'>${row.id_cdl} - ${row.nome_cdl}</a><br>
                                        ${row.id_facolta} - ${row.nome_facolta}</li>`;
                }
                htmlString += rowString; // aggiungi il risultato della ricerca
            });
            resdiv.innerHTML = htmlString; // mostra i risultati
        } else {
            document.getElementById('search-res').innerHTML = '<p>Nessun risultato trovato</p>';
        }
    }).catch(error => alert('Errore nella ricerca, riprova più tardi'));
}