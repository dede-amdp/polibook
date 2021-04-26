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
    /*This function takes as inputs a javascript object containing the data for the graph and the values to use aesthetic puposes.
    data is an array used to build the graph: its elements must be objects with a 'value' and a 'description'
    id is the canvas on which the graph will be drawn
    ylevels is used to draw lines across the canvas. It is 1 by default (the entire height will be divided in ylevels sections)
    padding is the space between the canvas border and the graph itself
    r is the dot radius or the square side length if isCicle is set to false
    isCircle is used to decide if the data-dots will be shown as circles or squares
    lineColor and dotColor are used to chose the color of the lines and the data-dots of the graph
    lineWidth is the width of the lines used to show the graph.
    min is the smallest value to show on the graph
    max is the biggest value to show on the graph
    make sure that the values of the graph are all between min and max or the will not be shown
    this function will also attach to the canvas element an event handler of type mousemove that will show the data information on hover
    */
    //extraction of the values from the object
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

    //query to find the canvas html element
    var canvas = document.getElementById(canvasId); //recupero il canvas dal documento tramite DOM
    var context = canvas.getContext('2d'); //prendo il contesto per disegnare

    //creating the data structure that will hold the data positions and informations
    var data = [];

    for (var i = 0; i < points.length; i++) {
        data.push({
            'text': points[i]['description'], //will be shown on mouse hover
            'x': scale(i, 0, points.length - 1, padding, canvas.width - padding),
            'y': scale(points[i]['value'], min, max, canvas.height - padding, padding),
            'r': r //is also used to check if the mouse cursor is on the data-dot
        });
    }

    //drawing the horizontal sections (background grid)
    with (context) {
        var step = (canvas.height - 2 * padding) / ylevels;
        for (var i = 0; i < ylevels + 1 + 1; i++) {
            strokeStyle = 'rgb(0, 0, 0, 0.2)';
            moveTo(0, padding + i * step);
            lineTo(canvas.width, padding + i * step);
        }
        stroke();

        //drawing the graph
        strokeStyle = lineColor;
        lineWidth = lineWidth;
        fillStyle = dotColor;
        beginPath();
        moveTo(data[0].x, data[0].y);
        data.forEach(tip => {
            lineTo(tip.x, tip.y); //first the lines
        });
        stroke();
        //then the data-dots
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
    // attaching the mousemove event handler on the canvas specifing the data to show and the canvas
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
    /*this function is used to draw a piechart on a canvas.It accepts a javascript object as input that has to contain:
    id: the id of the canvas on which the graph will be drown
    data: an array which contains the data to show. Each element of the array must be a javascript object containing a value, a description, a color and a linewidth
        that will be used to draw the data
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
    var canvasX = position.x; //get the canvas x position
    var canvasY = position.y; //get the canvas y position
    var relativeX = e.clientX - (canvasX + e.currentTarget.width / 2); //get the cursor x position relative to the canvas' center position
    var relativeY = e.clientY - (canvasY + e.currentTarget.height / 2); //get the cursor y position relative to the canvas' center position
    var cursorAngle = Math.atan2(relativeY, relativeX); // calculate the angle from the center
    cursorAngle = (cursorAngle < 0 ? cursorAngle + 2 * Math.PI : cursorAngle); //atan2 returns an angle between -pi and +pi, we need it between 0 and 2pi
    var dist = relativeX * relativeX + relativeY * relativeY;
    data.forEach(element => {
        var rm = r - element.lineWidth / 2;
        var rM = r + element.lineWidth / 2;
        if (cursorAngle >= element.angleStart
            && cursorAngle < element.angleFinish
            && dist >= rm * rm && dist <= rM * rM) {
            //if the cursor is on an element
            e.currentTarget.title = element.description;
        }
    });
}



function handleTipEvent(e, data) {
    var position = e.currentTarget.getBoundingClientRect();
    var canvasX = position.x; //get the canvas x position
    var canvasY = position.y; //get the canvas y position
    var relativeX = e.clientX - canvasX; //get the cursor x position relative to the canvas' position
    var relativeY = e.clientY - canvasY; //get the cursor y position relative to the canvas' position
    data.forEach(tip => {
        var dx = relativeX - tip.x; //distance cursor -> data-dot
        var dy = relativeY - tip.y;
        if (dx * dx + dy * dy <= (tip.r + 1) * (tip.r + 1)) {
            e.currentTarget.title = tip.text; //change the title so that the pop up shows data information
        }
    });
}

function scale(value, min, max, min1, max1) {
    var range = max - min == 0 ? 1 : max - min; //if max-min is 0, the division that comes next would be impossible, in that case we set range to 1 (besides, if max=min then value has to be max or min, so the function returns 0 in any case)
    var norm = (value - min) / range; //normalizing the value
    return norm * (max1 - min1) + min1; //multipling the normalized value and then adding the minimum
}