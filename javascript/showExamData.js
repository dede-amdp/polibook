var matricola = "000000"; // !! TODO temporanteo: Prendi la matricola dal login
var lang = 'ita'; // !! TODO temporaneo: Prendi il settaggio della lingua dalla pagina
var inputs = { matricola: matricola, type: 'grades' };
var cfuCount;
request('../php/getExamData.php', inputs).then(examData => {
    var examListDiv = document.getElementById('exam-list'); //recupera il div che conterrà la tabella
    var examListString = ``; //stringa HTML da inserire nel div
    cfuCount = 0; //serve per l'areogramma dei cfu: conta i cfu degli esami superati
    if (examData != undefined && examData.length > 0) { //se la richiesta non ha fallito e ha un numero di esami > 0
        var gradesGraphData = []; // serve per memorizzare i dati da mostrare nel grafico dell'andamento dei voti
        var meanGraphData = []; // serve per memorizzare i dati da mostrare nel grafico dell'andamento della media
        var sum = 0; //per il calcolo della media
        var count = 1; //per il calcolo della media
        examData.forEach(exam => {
            // inserisco il voto di ogni esame nel grafico
            var reg = new RegExp(`^${lang}:.*`, 'm'); // predii dalla lista di traduzioni quella che corrisponde alla lingua corrente
            var riga = exam['nome'].match(reg)[0];
            var nome = riga.slice(riga.indexOf(':') + 1);
            gradesGraphData.push({
                value: exam['voto'],
                description: `${exam['voto']}${'L'.repeat(exam['lode'])}\n${nome}\n${exam['cfu']}\n${exam['data']}`
            });
            cfuCount += exam['cfu'];
            sum += exam['voto'];
            var mean = sum / count;
            meanGraphData.push({
                //inserisco la media aritmetica dopo ogni esame nel grafico
                value: mean,
                description: `mean: ${mean}`
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

        // inizio a comporre la tabella dei risultati degli esami superati
        examListString += '<tr>';
        Object.keys(examData[0]).forEach(key => {
            if (key != 'lode')
                examListString += `<th>${key}</th>`; //creo gli header
            /* // !! TODO: trovare un modo per tradurre i titoli in altre lingue (si può usare uno switch statement per capire la chiave che consideriamo,
                !! il problema è dove conserviamo tutte le traduzioni dei titoli? in un txt nella root di altervista?)*/
        });
        examListString += '</tr>';
        examData.forEach(exam => {
            examListString += '<tr>'
            for (var [key, value] of Object.entries(exam)) { //itera su ogni coppia chiave valore
                switch (key) {
                    case 'voto':
                        examListString += `<td>${value}`; //il voto potrebbe avere la lode quindi non chiudiamo il td
                        break;
                    case 'lode':
                        examListString += `${'L'.repeat(value)}</td>` //se il voto ha la lode aggiungi L altrimenti chiudi il td
                        break;
                    case 'nome':
                        var reg = new RegExp(`^${lang}:.*`, 'm'); // predii dalla lista di traduzioni quella che corrisponde alla lingua corrente
                        var riga = value.match(reg)[0];
                        var nome = riga.slice(riga.indexOf(':') + 1); //prendi solo il contenuto e non l'etichetta della lingua
                        examListString += `<td>${nome}</td>`; // aggiungi alla tabella il nome dell'esame
                        break;
                    case 'id':
                        examListString += `<td><a href='#'>${value}</a></td>`;
                        break;
                    default:
                        examListString += `<td>${value}</td>`; // gli altri dati dell'esame non hanno casi particolari e quindi possono essere inseriti direttamente
                }
            };
            examListString += '</tr>' // termina la riga della tabella
        });
        examListDiv.innerHTML = `<table border=2px id='grades-table'>${examListString}</table>`; // inserisci la tabella nel div selezionato prima
    } else if (examData.length == 0) { //se la richiesta non ha fallito ma ha un numero di esami pari a 0
        var examListDiv = document.getElementById('exam-list');
        examListDiv.innerHTML = "Non ci sono risultati da mostrare"; // non sono stati svolti esami
    }
    else { //se la richiesta ha fallito
        var examListDiv = document.getElementById('exam-list');
        examListDiv.innerHTML = "Please retry later"; // c'è un errore nella richiesta
    }

    request('../php/getExamData.php', { matricola: matricola, type: 'cfu' }).then(result => { //richiesta per sapere il numero totale di cfu
        if (result != undefined && result.length > 0) { //se la richiesta non fallisce e il numero di risultati è maggiore di 0
            cfu_totali = result[0]['cfu_totali'];
            data = [{ value: cfuCount, description: `CFU Esami sostenuti: ${cfuCount}`, color: '#009999', lineWidth: 50 },
            { value: cfu_totali - cfuCount, description: `CFU Esami mancanti: ${cfu_totali - cfuCount}`, color: '#00999955', lineWidth: 50 }];
            drawPieChart({
                //disegna l'areogramma
                id: 'cfu-canvas',
                data: data
            });
        }
    });
});
