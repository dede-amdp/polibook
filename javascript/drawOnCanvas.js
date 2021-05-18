function drawGraph(graphData = {
    'data': [],
    'id': '',
    'ylevels': 1,
    'padding': 4,
    'r': 3,
    'isCircle': false,
    'lineColor': '#000000',
    'lineWidth': '1',
    'dotColor': '#000000',
    'max': 100,
    'min': 0
}) {
    /*Questa funzione prende in ingresso un oggetto javascript contenente i dati per il grafico e i valori da usare per l'aspetto grafico.
    {
        data: è un array usato per costruire il grafico: i suoi elementi devono essere oggetti con un valore 'value' e una descrizione 'description'
        id: è l'id del canvas sul quale disegnare il grafico
        ylevels: è usato per le line sullo sfondo del grafico. Il suo valore è 1 di default (l'altezza sarà divisa per il numero di livelli)
        padding: è lo spazio tra il bordo del canvas e il grafico stesso
        r: è il raggio dei punti/quadrati usati per rappresentare i dati
        isCircle: è un booleano usato per per indicare la forma dei punti che rappresentano i dati
        lineColor, dotColor: sono i colori della linea e dei punti del grafico
        lineWidth: è lo spessore della linea del grafico
        min, max: sono i valori minimi e massimi rappresentabili sul grafico
        Controlla sempre che i valori siano sempre compresi tra massimo e minimo altrimenti non saranno rappresentati correttamente
        * Il metodo associa un eventListener che mostrerà la descrizione dei dati quando il mouse è posto sopra di essi
    }
    */
    //estazione dei valori dall'oggetto
    var points = 'data' in graphData ? graphData['data'] : [];
    var canvasId = 'id' in graphData ? graphData['id'] : '';
    var ylevels = 'ylevels' in graphData ? graphData['ylevels'] : 1;
    var padding = 'padding' in graphData ? graphData['padding'] : 4;
    var r = 'r' in graphData ? graphData['r'] : 3;
    var isCircle = 'isCircle' in graphData ? graphData['isCircle'] : false;
    var lineColor = 'lineColor' in graphData ? graphData['lineColor'] : '#000000';
    var dotColor = 'dotColor' in graphData ? graphData['dotColor'] : '#000000';
    var lineWidth = 'lineWidth' in graphData ? graphData['lineWidth'] : 1;
    var min = 'min' in graphData ? graphData['min'] : 0;
    var max = 'max' in graphData ? graphData['max'] : 100;

    //query per trovare l'elemento canvas
    var canvas = document.getElementById(canvasId); //recupero il canvas dal documento tramite DOM
    var context = canvas.getContext('2d'); //prendo il contesto per disegnare

    //creazione della struttura dati che conterrà le posizioni di tutti i dati
    var data = [];

    for (var i = 0; i < points.length; i++) {
        data.push({
            'text': points[i]['description'], //will be shown on mouse hover
            'x': scale(i, 0, points.length - 1, padding, canvas.width - padding),
            'y': scale(points[i]['value'], min, max, canvas.height - padding, padding),
            'r': r //is also used to check if the mouse cursor is on the data-dot
        });
    }

    //disegno delle sezioni orizzontali
    with (context) {
        var step = (canvas.height - 2 * padding) / ylevels;
        for (var i = 0; i < ylevels + 1 + 1; i++) {
            strokeStyle = 'rgb(0, 0, 0, 0.2)';
            moveTo(0, padding + i * step);
            lineTo(canvas.width, padding + i * step);
        }
        stroke();

        //disegno del grafico
        strokeStyle = lineColor;
        lineWidth = lineWidth;
        fillStyle = dotColor;
        beginPath();
        moveTo(data[0].x, data[0].y);
        data.forEach(tip => {
            lineTo(tip.x, tip.y); //first the lines
        });
        stroke();
        //poi i dati
        data.forEach(tip => {
            if (isCircle) {
                beginPath();
                arc(tip.x, tip.y, tip.r, 0, 2 * Math.PI);
                moveTo(tip.x, tip.y);
                fill();
                closePath();
            } else
                fillRect(tip.x - tip.r, tip.y - tip.r, 2 * tip.r, 2 * tip.r)
        });
    }
    // associo il mousemove event handler e specifico i dati da mostrare sul canvas
    canvas.addEventListener('mousemove', e => handleTipEvent(e, data));
    canvas.addEventListener('mouseout', e => { e.currentTarget.title = ''; });
}

function drawPieChart(graphData = {
    'id': '',
    'data': [{
        'value': 1,
        'description': '',
        'color': '#000000',
        'lineWidth': 1
    }]
}) {
    /*Questa funzione è usata per disegnare un aerogramma su un canvas. Accetta un oggetto javascrip che contiene:
    id: id del canvas sul quale sarà disegnato l'aerogramma
    data: array che contiene i dati da mostrare. Ogni elemento deve essere un oggetto javascript contenete un valore, una descrizione, un colore e uno spessore
    */
    var data = 'data' in graphData ? graphData.data : [];
    var canvasId = 'id' in graphData ? graphData.id : '';

    var canvas = document.getElementById(canvasId);
    var context = canvas.getContext('2d');

    var total = 0;
    data.forEach(element => {
        total += element.value;
    });

    const TWO_PI = 2 * Math.PI;
    var lastpos = 0;
    for (var i = 0; i < data.length; i++) {
        data[i]['angleStart'] = lastpos;
        data[i]['angleFinish'] = lastpos + (data[i].value / total) * TWO_PI;
        lastpos += (data[i].value / total) * TWO_PI;
    }

    var cx = canvas.width / 2;
    var cy = canvas.height / 2;
    var r = (Math.min(cx, cy)) / 2;
    with (context) {
        translate(cx, cy);
        //rotate(-Math.PI / 2);

        data.forEach(element => {
            strokeStyle = element.color;
            lineWidth = element.lineWidth / 2;
            beginPath();
            arc(0, 0, r, element['angleStart'], element['angleFinish'], false);
            stroke();
            closePath();
        });
    }

    canvas.addEventListener('mousemove', e => handlePieEvent(e, data, r));
}

function handlePieEvent(e, data, r) {
    var position = e.currentTarget.getBoundingClientRect();
    var canvasX = position.x; //prendi la posizione x del canvas
    var canvasY = position.y; //prendi la posizione y del canvas
    var relativeX = e.clientX - (canvasX + e.currentTarget.width / 2); //prendi la posizione x del cursore rispetto al centro del canvas
    var relativeY = e.clientY - (canvasY + e.currentTarget.height / 2); //prendi la posizione y del cursore rispetto al centro del canvas
    var cursorAngle = Math.atan2(relativeY, relativeX); // calcola l'angolo
    cursorAngle = (cursorAngle < 0 ? cursorAngle + 2 * Math.PI : cursorAngle); //atan2 da un angolo tra -pi and +pi, ci serve tra 0 e 2pi
    var dist = relativeX * relativeX + relativeY * relativeY;
    data.forEach(element => {
        var rm = r - element.lineWidth / 2;
        var rM = r + element.lineWidth / 2;
        if (cursorAngle >= element.angleStart
            && cursorAngle < element.angleFinish
            && dist >= rm * rm && dist <= rM * rM) {
            //se il cursore è su un elemento
            e.currentTarget.title = element.description;
        }
    });
}

function handleTipEvent(e, data) {
    var position = e.currentTarget.getBoundingClientRect();
    var canvasX = position.x; //prendi la posizione x del canvas
    var canvasY = position.y; //prendi la posizione y del canvas
    var relativeX = e.clientX - canvasX; //prendi la posizione x del cursore relativa alla posizione del canvas
    var relativeY = e.clientY - canvasY; //prendi la posizione y del cursore relativa alla posizione del canvas
    data.forEach(tip => {
        var dx = relativeX - tip.x; //distanza cursore -> data-dot
        var dy = relativeY - tip.y;
        if (dx * dx + dy * dy <= (tip.r + 1) * (tip.r + 1)) {
            e.currentTarget.title = tip.text; //cambia il titolo del canvas così che il pop up mostri la descrizione
        }
    });
}

function scale(value, min, max, min1, max1) {
    var range = max - min == 0 ? 1 : max - min; //se max-min = 0, la divisione che segue non sarebbe possibile, in quel caso setto range = 1 (in ogni caso, se max=min allora il valore deve essere max o min, la funzione ritornerebbe 0 in ogni caso)
    var norm = (value - min) / range; //normalizzo il valore
    return norm * (max1 - min1) + min1; //moltiplico il valore normalizzato e aggiungo il minimo
}