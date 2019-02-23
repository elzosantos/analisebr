function legend(parent, data) {
    parent.className = 'legend';
    var datas = data.hasOwnProperty('datasets') ? data.datasets : data;

    // remove possible children of the parent
    while (parent.hasChildNodes()) {
        parent.removeChild(parent.lastChild);
    }

    datas.forEach(function(d) {
        var title = document.createElement('div');
        title.className = 'col-md-4 center';
        title.style.borderColor = d.hasOwnProperty('strokeColor') ? d.strokeColor : d.color;
        title.style.borderStyle = 'solid';
        title.style.padding = '3px';
        title.style.margin = '3px';

        parent.appendChild(title);
      
        var qtd = document.createElement('div');
        qtd.className = 'col-md-4 center';
        qtd.style.borderColor = d.hasOwnProperty('strokeColor') ? d.strokeColor : d.color;
        qtd.style.borderStyle = 'solid';
        qtd.style.padding = '3px';
        qtd.style.margin = '3px';
        parent.appendChild(qtd);

        var text = document.createTextNode(d.title);
        title.appendChild(text);
        var qtdv = document.createTextNode(d.qtd);
        qtd.appendChild(qtdv);

    });
}