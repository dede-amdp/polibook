var superatiTab = document.getElementById('superati-tab'); //recupera il div che conterrà la tabella degli esami superati
var pianificatiTab = document.getElementById('pianificati-tab'); //recupera il div che conterrà la tabella degli esami preparati
var superatiButton = document.getElementById('superati');  // recupera i pulsanti per cambiare tab
var pianificatiButton = document.getElementById('pianificati');
var statsDiv = document.getElementById('statistics'); // recupera il div che conterrà media e cfu

var cfuCount;

//richiede gli esami superati
request('../php/fetchPassedExams.php', { type: 'grades', passed: true }).then(examData => {
    cfuCount = 0; //serve per l'areogramma dei cfu: conta i cfu degli esami superati
    if (examData != undefined && examData != null && examData.length > 0) { //se la richiesta non ha fallito e ha un numero di esami > 0
        graphs(examData); // disegna i grafici (dato che non è collegato al resto, la funzione è asincrona quindi non bloccante)

        // inizia a comporre la tabella dei risultati degli esami superati
        var examListString = '<tr><th>ID</th><th>Attività Didattica</th><th>CFU</th><th>Docente</th><th>Data</th><th>Voto</th></tr>'; // crea gli header della tabella
        examData.forEach(exam => {
            examListString += `<tr><td><a href='../pages/activity.php?atd=${exam.id}&ord=${exam.ordinamento}&cdl=${exam.id_cdl}&doc=${exam.id_docente}'>${exam.id}</a></td><td>${exam.nome}</td><td>${exam.cfu}</td><td>${exam.cognome + '\n' + exam.docente}</td><td>${exam.data}</td><td>${(exam.voto || 'IDN') + 'L'.repeat(exam.lode)}</td></tr>`; //aggiungi le inforazioni dell'esame alla tabella
            // il link associato all'id dell'esame serve per poter visualizzare le informazioni dell'esame con un click
        });
        superatiTab.innerHTML = `<table border=2px id='grades-table' class='exam-table'>${examListString}</table>`; // inserisce la tabella nel div selezionato prima
    } else if (examData != undefined && examData.length == 0) { //se la richiesta non ha fallito ma ha un numero di esami pari a 0
        superatiTab.innerHTML = "Non ci sono risultati da mostrare"; // non sono stati svolti esami
    }
    else { //se la richiesta ha fallito
        superatiTab.innerHTML = "<p>Riprova più tardi<p>"; // c'è un errore nella richiesta
    }

}).catch(error => alert('C\'è stato un errore imprevisto'));

// richiede gli esami pianificati
request('../php/fetchPassedExams.php', { type: 'grades', passed: false }).then(examData => {
    if (examData != undefined && examData.length > 0) { //se la richiesta non ha fallito e ha un numero di esami > 0

        // inizia a comporre la tabella degli esami pianificati
        var examListString = '<tr><th>ID</th><th>Attività Didattica</th><th>CFU</th><th>Docente</th></tr>'; //crea gli header
        examData.forEach(exam => {
            examListString += `<tr><td><a href='../pages/activity.php?atd=${exam.id}&ord=${exam.ordinamento}&cdl=${exam.id_cdl}&doc=${exam.id_docente}'>${exam.id}</a></td><td>${exam.nome}</td><td>${exam.cfu}</td><td>${exam.cognome + '\n' + exam.docente}</td></tr>`; // popolo la tabella
            // come prima: il link serve per accedere all'informazioni dell'esame
        });
        pianificatiTab.innerHTML = `<table border=2px id='programmed-table' class='exam-table'>${examListString}</table>`; // inserisce la tabella nel div selezionato prima
    } else if (examData != undefined && examData.length == 0) { //se la richiesta non ha fallito ma ha un numero di esami pari a 0
        pianificatiTab.innerHTML = "Non ci sono risultati da mostrare"; // non ci sono esami da fare
    }
    else { //se la richiesta ha fallito
        pianificatiTab.innerHTML = "<p>Riprova più tardi<p>"; // c'è un errore nella richiesta
    }
}).catch(error => alert('C\'è stato un errore imprevisto'));

// le seguenti callback associate ai pulsanti servono per scambiare le due tabelle (esami superati e pianificati)
superatiButton.onclick = function () {
    superatiTab.style.display = 'block';
    pianificatiTab.style.display = 'none';
    pianificatiButton.classList.add('active');
    superatiButton.classList.remove('active');
}

pianificatiButton.onclick = function () {
    pianificatiTab.style.display = 'block';
    superatiTab.style.display = 'none';
    superatiButton.classList.add('active');
    pianificatiButton.classList.remove('active');
}

async function graphs(examData) {
    var gradesGraphData = []; // serve per memorizzare i dati da mostrare nel grafico dell'andamento dei voti
    var meanGraphData = []; // serve per memorizzare i dati da mostrare nel grafico dell'andamento della media
    var sum = 0; //per il calcolo della media
    var count = 1; //per il calcolo della media
    var mean = 0;
    examData.forEach(exam => {
        // inserisce il voto di ogni esame nel grafico
        var nome = exam.nome;
        nome = nome.replace('\<br\>', ' ').replace('\<br\>', ' ');
        gradesGraphData.push({
            value: exam.voto,
            description: `Voto: ${exam.voto}${'L'.repeat(exam.lode)}\nAD: ${nome}\nCFU: ${exam.cfu}\nData: ${exam.data}`
        });
        cfuCount += exam.cfu;
        sum += exam.voto;
        mean = sum / count;
        meanGraphData.push({
            //inserisce la media aritmetica dopo ogni esame nel grafico
            value: mean,
            description: `Media: ${mean.toFixed(2)}`
        });
        count++;
    });
    // sono le strutture dei grafici
    const gradesGraphStructure = {
        data: gradesGraphData,
        id: 'grade-canvas',
        min: 18,
        max: 30,
        isCircle: true,
        lineWidth: 1.3,
        ylevels: 12,
        r: 5,
        lineColor: '#009999',
        dotColor: '#009999',
        padding: 8
    };

    const meanGraphStructure = {
        data: meanGraphData,
        id: 'grade-canvas',
        min: 18,
        max: 30,
        isCircle: false,
        lineWidth: 1.3,
        ylevels: 12,
        r: 5,
        lineColor: '#004D4D',
        dotColor: '#004D4D',
        padding: 8
    };
    // disegno i grafici
    drawGraph(meanGraphStructure);
    drawGraph(gradesGraphStructure);

    // richiede il numero di cfu totali
    request('../php/fetchPassedExams.php', { type: 'cfu' }).then(result => { //richiesta per sapere il numero totale di cfu
        if (result != undefined && result.length > 0) { //se la richiesta non fallisce e il numero di risultati è maggiore di 0
            cfu_totali = result[0]['cfu_totali'];
            data = [{ value: cfuCount, description: `CFU Esami sostenuti: ${cfuCount}`, color: '#009999', lineWidth: 50 },
            { value: cfu_totali - cfuCount, description: `CFU Esami mancanti: ${cfu_totali - cfuCount}`, color: '#00999955', lineWidth: 50 }];
            drawPieChart({
                //disegna l'areogramma
                id: 'cfu-canvas',
                data: data
            });
            // inserisce in formato testuale media e cfu conseguiti (così da evitare la dipendenza dal grafico)
            statsDiv.innerHTML =
                `<table>
                <tr><th>Media</th><th>CFU</th></tr>
                <tr><td>${mean == undefined ? 'No data' : mean.toFixed(2)}</td><td>${cfuCount}/${cfu_totali}</td></tr>
                </table>`;
        }
    });
}