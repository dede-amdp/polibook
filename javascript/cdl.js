const passed = (new URLSearchParams(window.location.search)).entries();// recupera i parametri get dall'url
var param = {};
for (element of passed) {
    param[element[0]] = element[1];
};
console.log(param);
request('../php/fetchCdl.php', param).then(result => {
    if (result != undefined && result != null && result.length > 0) {
        const data = result[0];
        const titolo = data.id_cdl + ' - ' + data.nome_cdl;
        const facolta = data.id_facolta + ' - ' + data.nome_facolta;
        // costruisce info-generali
        const durata = 'Durata:\t' + data.durata + '<br>';
        const cfu = 'CFU Totali:\t' + data.cfu + '<br>';
        const tipologia = 'Tipologia:\t' + data.tipologia + '<br>';
        document.getElementById('titolo').innerHTML = `<h1><font color='#009999'>${titolo}</font></h1><br>
                                                        <p>${facolta}</p>`;
        document.getElementById('info-generali').innerHTML = durata + cfu + tipologia;
        //costuisce descrizione
        document.getElementById('descrizione').innerHTML = data.descrizione;
        //costruisce programma
        var prog = '<ul>';
        data.programma.forEach(attdid => {
            prog += `<li><a href='../activity.php?atd=${attdid.id}&ord=${attdid.ordinamento}'>${attdid.id} - ${attdid.nome}</a> - CFU ${attdid.cfu}</br>${attdid.ordinamento}</li>`;
        });
        document.getElementById('programma').innerHTML = prog + '</ul>';
    } else {
        document.getElementById('content').innerHTML = '<p>Non ci sono dati riguardanti questo corso di laurea</p>';
    }
}).catch(error => {
    document.getElementById('content').innerHTML = '<p>Nessun dato</p>';
    alert('Non è stato possibile trovare i dati del corso di laurea, riprova più tardi');
});