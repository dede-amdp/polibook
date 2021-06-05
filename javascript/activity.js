const passed = (new URLSearchParams(window.location.search)).entries();// recupera i parametri get dall'url
var param = {};
for (element of passed) {
    param[element[0]] = element[1];
};
console.log(param);
request('../php/fetchActivity.php', param).then(result => {
    console.log(result);
    if (result != undefined && result != null && result.length > 0) {
        const data = result[0];
        const titolo = data.id_attdid + ' - ' + data.nome;
        const cdl = data.id_cdl + ' - ' + data.nome_cdl;
        // costruisce info-generali
        const annocorso = 'Anno di corso:\t' + data.anno + '<br>';
        const ordinamento = 'Ordinamento:\t' + data.ordinamento + '<br>';
        const semestre = 'Semestre:\t' + data.semestre + '<br>';
        const docente = param.doc ? 'Docente:\t' + data.cognome_docente + ' ' + data.nome_docente + '<br>' : '';
        const caratt = 'Caratterizzante:\t' + (data.caratterizzante ? 'Sì' : 'No') + '<br>';
        const cfu = 'Peso in CFU:\t' + data.cfu + '<br>';
        document.getElementById('titolo').innerHTML = `<h1><font color='#009999'>${titolo}</font></h1><a href='../pages/cdl.php?cdl=${data.id_cdl}'>${cdl}</a>`;
        document.getElementById('info-generali').innerHTML = annocorso + ordinamento + semestre + docente + caratt + cfu;
        //costuisce descrizione
        document.getElementById('descrizione').innerHTML = data.descrizione;
        //costruisce programma
        document.getElementById('programma').innerHTML = `<a href='../php/download.php?id=${data.id_attdid}&ord=${data.ordinamento}'>Programma ${data.nome}</a>`;
    } else {
        document.getElementById('content').innerHTML = '<p>Non ci sono dati riguardanti questa Attività didattica</p>';
    }
}).catch(error => {
    document.getElementById('content').innerHTML = '<p>Nessun dato</p>';
    alert('Non è stato possibile trovare i dati del corso di laurea, riprova più tardi');
});