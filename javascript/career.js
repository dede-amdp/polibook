var tabella = document.getElementById('career-table'); // seleziona carrer-table dal document
var cfuConseguiti = 0; // i cfu conseguiti in tutta la carriera
var cfuMancanti = 0; // i cfu mancanti al completamento della carriera
var cfuTotali = 0; // cfu totali da avere per il conseguimento della carriera
var htmlString = '<tr><th>Regola</th><th>CFU Totali</th><th>CFU Conseguiti</th><th>CFU Mancanti</th><th>Superato</th></tr>';
//BASE - richiede gli esami non caratterizzanti
request('../php/fetchCareer.php', { type: 'A' }).then(result => {
    var data = buildSection(result, 'A - Base');
    htmlString += data['htmlString']; // aggiunge la sezione alla tabella
    cfuMancanti += data['man'] || 0;
    cfuConseguiti += data['con'] || 0;
    cfuTotali += data['tot'] || 0;

    //CARATTERIZZANTI - richiede gli esami caratterizzanti
    request('../php/fetchCareer.php', { type: 'B' }).then(result => {
        var data = buildSection(result, 'B - Caratterizzanti');
        htmlString += data['htmlString']; // aggiunge la sezione alla tabella
        cfuMancanti += data['man'] || 0;
        cfuConseguiti += data['con'] || 0;
        cfuTotali += data['tot'] || 0;

        //LINGUA,PROVA FINALE E TIROCINIO/STAGE - richiede gli esami di lingua, prova finale e tirocinio
        request('../php/fetchCareer.php', { type: 'C' }).then(result => {
            var data = buildSection(result, 'C - Lingua, Prova finale e Tirocinio/Stage');
            htmlString += data['htmlString']; // aggiunge la sezione alla tabella
            cfuMancanti += data['man'] || 0;
            cfuConseguiti += data['con'] || 0;
            cfuTotali += data['tot'] || 0;

            htmlString += `<tr><td>TOTALE</td><td>${cfuTotali}</td><td>${cfuConseguiti}</td><td>${cfuMancanti}</td><td><img width=20 alt='${cfuMancanti == 0 ? 'Attività superata' : 'Attività Programmata'}' title='${cfuMancanti == 0 ? 'Attività superata' : 'Attività Programmata'}' src='../assets/icons/${cfuMancanti == 0 ? 'green' : 'red'}.svg'></img></td></tr>`; // aggiunge la riga del totale
            tabella.innerHTML = htmlString; // mostra i dati nella tabella
        }).catch(error => alert('C\'è stato un errore imprevisto'));
    }).catch(error => alert('C\'è stato un errore imprevisto'));
}).catch(error => alert('C\'è stato un errore imprevisto'));

function buildSection(data, title) {
    /* Costruisce la sezione della tabella*/
    var toReturn = {}; // conterrà tutti i dati della sezione così da poterli usare nella tabella
    var htmlString = ''; // struttura della sezione
    if (data != undefined && data != null) {
        if (data.length > 0) {
            var htmlHeader = ''; // subheader della sezione
            var htmlData = ''; // dati della sezione
            var cfuConseguiti = 0;
            var cfuMancanti = 0;
            var cfuTotali = 0;
            data.forEach(exam => {
                cfuTotali += exam.cfu;
                if (exam.superato) cfuConseguiti += exam.cfu;
                else cfuMancanti += exam.cfu;
                htmlData += `<tr><td>${exam.SSD} - ${exam.nome} (${exam.id})</td><td>${exam.cfu}</td><td>${exam.superato ? exam.cfu : 0}</td><td>${exam.superato ? 0 : exam.cfu}</td><td><img width=20 alt='${exam.superato ? 'Attività superata' : 'Attività Programmata'}' title='${exam.superato ? 'Attività superata' : 'Attività Programmata'}' src='../assets/icons/${exam.superato ? 'green' : 'red'}.svg'></img></td></tr>`;
            });
            htmlHeader = `<tr><td><b>${title}</b></td><td>${cfuTotali}</td><td>${cfuConseguiti}</td><td>${cfuMancanti}</td><td><img width=20 alt='${cfuMancanti == 0 ? 'Attività superata' : 'Attività Programmata'}' title='${cfuMancanti == 0 ? 'Attività superata' : 'Attività Programmata'}' src='../assets/icons/${cfuMancanti == 0 ? 'green' : 'red'}.svg'></img></td></tr>`;
            htmlString += htmlHeader + htmlData; // aggiungi subheader e dati alla sezione
            toReturn['htmlString'] = htmlString;
            toReturn['con'] = cfuConseguiti;
            toReturn['man'] = cfuMancanti;
            toReturn['tot'] = cfuTotali;
        } else {
            // se la lunghezza degli esami è nulla
            htmlString += `<tr><td>Non ci sono dati in questa categoria</td><td></td><td></td><td></td><td></td></tr>`;
            toReturn['htmlString'] = htmlString;
        }
    } else {
        // la richiesta non è andata a buon fine
        htmlString += `<tr><td>C'è stato un problema, riprova più tardi</td><td></td><td></td><td></td><td></td></tr>`;
        toReturn['htmlString'] = htmlString;
    }
    return toReturn;
}