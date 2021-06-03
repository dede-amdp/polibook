var searchButton = document.getElementById('search-button');
var annoBt = document.getElementById('annobt');
var facBt = document.getElementById('facoltabt');
var cdlBt = document.getElementById('cdlbt');
var clear = document.getElementById('clear');

clear.addEventListener('click', () => {
    var inputs = document.getElementsByClassName('input');
    Array.from(inputs).forEach(element => {
        element.value = '';
    });
    document.getElementById('annobt').innerHTML = ' --- ';
    document.getElementById('facoltabt').innerHTML = ' --- ';
    document.getElementById('cdlbt').innerHTML = ' --- ';
});

annoBt.addEventListener('click', () => {
    var annoDiv = document.getElementById('anno-div');
    annoDiv.classList.toggle('active');
    if (annoDiv.classList.contains('active')) {
        request('../php/fetchOrdinamento.php').then(res => {
            annoDiv.innerHTML = `<button id='clear-anno'> --- </button>`;
            res.forEach(element => {
                annoDiv.innerHTML += `<button id='${element.ordinamento}'>${element.ordinamento}</button>`;
            });
            document.getElementById('clear-anno').addEventListener('click', () => {
                var annoBt = document.getElementById('annobt');
                annoBt.innerHTML = ' --- ';
                document.getElementById('anno').value = '';
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

cdlBt.addEventListener('click', () => {
    var cdlDiv = document.getElementById('cdl-div');
    cdlDiv.classList.toggle('active');
    if (cdlDiv.classList.contains('active')) {
        request('../php/fetchCorsiDL.php').then(res => {
            cdlDiv.innerHTML = `<button id='clear-cdl'> --- </button>`;
            res.forEach(element => {
                cdlDiv.innerHTML += `<button id='${element.nome}'>${element.nome}</button>`;
            });
            document.getElementById('clear-cdl').addEventListener('click', () => {
                var cdlBt = document.getElementById('cdlbt');
                cdlBt.innerHTML = ' --- ';
                document.getElementById('cdl').value = '';
            });
            res.forEach(element => {
                document.getElementById(element.nome).addEventListener('click', () => {
                    var cdlBt = document.getElementById('cdlbt');
                    cdlBt.innerHTML = element.nome;
                    document.getElementById('cdl').value = element.nome;
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
            facDiv.innerHTML = `<button id='clear-fac'> --- </button>`;
            res.forEach(element => {
                facDiv.innerHTML += `<button id='${element.nome}'>${element.nome}</button>`;
            });
            document.getElementById('clear-fac').addEventListener('click', () => {
                var facBt = document.getElementById('facoltabt');
                facBt.innerHTML = ' --- ';
                document.getElementById('dipartimento').value = '';
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
    search(data.anno, data.attDid, data.dipartimento, data.cdl, data.docente.replace(/\s/g, ''));
});

function search(anno, attdid, fac, cdl, doc) {
    document.getElementById('search-res').innerHTML = '';
    request('../php/search.php', { "anno": anno, "attDid": attdid, "dipartimento": fac, "docente": doc, 'cdl': cdl }).then(result => {
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
                    var href = `../pages/cdl.php?cdl=${row.id_cdl}`;
                    rowString = `<li><a href='${href}'>${row.id_cdl} - ${row.nome_cdl}</a><br>
                                        ${row.id_facolta} - ${row.nome_facolta}</li>`;
                }
                htmlString += rowString;
            });
            resdiv.innerHTML = htmlString;
        } else {
            document.getElementById('search-res').innerHTML = '<p>Nessun risultato trovato</p>';
        }
    })//.catch();
}