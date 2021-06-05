request('../php/fetchQuestionnaires.php').then(result => {
    if (result != undefined && result != null && result.length > 0) {
        var questTable = document.getElementById('questionnaires-table'); // Prendo la tabella per i questionari
        var dataString = '';
        var ids = [];
        result.forEach(exam => {
            var id = `${exam.id_corso},${exam.id_attdid},${exam.ord_attdid},${exam.id_docente}`; // Costruisco l'id per l'esame di cui compilare il questionario
            var rowClass = !exam.questionario ? '-selectable' : ''; // Indico se è selezionabile
            dataString += `<tr class='row${rowClass}' id='row-${id}'><td>${exam.anno}</td><td>${exam.id_attdid} - ${exam.nome_attdid}</td><td>${exam.cfu}</td><td>${exam.cognome_doc} ${exam.nome_doc}</td><td><img width=15 alt='icona di compilazione' src='../assets/icons/${exam.questionario ? 'green' : 'red'}.svg'/></td></tr>`;
            if (!exam.questionario) ids.push(id); // Inserisco l'id nella lista per assegnargli l'event listener in seguito
        });
        questTable.innerHTML += dataString; // Mostro la tabella
        // Assegno gli event listener
        ids.forEach(id => {
            var href = `../pages/questions.php?id=${id}`;
            var button = document.getElementById('row-' + id);
            button.addEventListener('click', () => { location.href = href; })
        });
    } else {
        document.getElementById('questionnaires-div').innerHTML = '<p>Non ci sono questionari da compilare</p>';
    }
}).catch(error => {
    document.getElementById('questionnaires-div').innerHTML = '<p>Non ci sono questionari da compilare</p>';
    alert('Non è stato possibile recuperare i dati dei questionari da compilare, riprova più tardi');
});