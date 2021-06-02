var searchButton = document.getElementById('search-button');
var annoBt = document.getElementById('annobt');
var facBt = document.getElementById('facoltabt');

annoBt.addEventListener('click', () => {
    var annoDiv = document.getElementById('anno-div');
    annoDiv.classList.toggle('active');
    if (annoDiv.classList.contains('active')) {
        request('../php/fetchOrdinamento.php').then(res => {
            annoDiv.innerHTML = '';
            res.forEach(element => {
                annoDiv.innerHTML += `<button id='${element.ordinamento}'>${element.ordinamento}</button>`;
            });
            res.forEach(element => {
                document.getElementById(element.ordinamento).addEventListener('click', () => {
                    var annoBt = document.getElementById('annobt');
                    annoBt.innerHTML = element.ordinamento;
                    document.getElementById('anno').value = element.ordinamento;
                });
            });
        });
    }
});

facBt.addEventListener('click', () => {
    var facDiv = document.getElementById('facolta-div');
    facDiv.classList.toggle('active');
    if (facDiv.classList.contains('active')) {
        request('../php/fetchFacolta.php').then(res => {
            facDiv.innerHTML = '';
            res.forEach(element => {
                facDiv.innerHTML += `<button id='${element.nome}'>${element.nome}</button>`;
            });
            res.forEach(element => {
                document.getElementById(element.nome).addEventListener('click', () => {
                    var facBt = document.getElementById('facoltabt');
                    facBt.innerHTML = element.nome;
                    document.getElementById('dipartimento').value = element.nome;
                });
            });
        });
    }
});

searchButton.addEventListener('click', () => {
    var inputs = document.getElementsByClassName('input');
    var data = {};
    Array.from(inputs).forEach(element => {
        data[element.id] = element.value;
    });
    console.log(data);
    search(data.anno, data.attDid, data.dipartimento, data.docente.replace(/\s/g, ''));
});

function search(anno, attdid, doc, fac) {
    request('../php/search.php', { "anno": anno, "attDid": attdid, "dipartimento": fac, "docente": doc }).then(result => {
        console.log(result);
        if (result != undefined && result != null && result.length > 0) {
            var resdiv = document.getElementById('search-res');
            var htmlString = '';
            result.forEach(row => {
                var rowString = '';
                if (row.nome_attdid != null && row.nome_attdid != '') {
                    //attdid
                    var href = `../pages/activity.php?atd=${row.id}&ord=${row.ordinamento}&cdl=${row.id_cdl}&doc=${row.id_docente}`;
                    rowString = `<li><a href='${href}'>${row.id} - ${row.nome_attdid} - CFU ${row.cfu} - ${row.cognome_docente} ${row.nome_docente}</a><br>
                                        Ordinamento: ${row.ordinamento}<br>
                                        ${row.id_cdl} - ${row.nome_cdl}<br>
                                        ${row.id_facolta} - ${row.nome_facolta}</li>`;
                } else {
                    //cdl
                    var href = `../pages/activity.php?cdl=${row.id_cdl}`;
                    rowString = `<li><a href='${href}'>${row.id_cdl} - ${row.nome_cdl}</a><br>
                                        ${row.id_facolta} - ${row.nome_facolta}</li>`;
                }
                htmlString += rowString;
            });
            resdiv.innerHTML = htmlString;
        } else {
            document.getElementById('search-res').innerHTML = '<p>Nessun risultato trovato</p>';
        }
    }).catch();
}