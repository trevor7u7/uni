
var buttons = document.querySelectorAll('.hour-button');
let i = 1
buttons.forEach(function (button) {
    var coleccion = JSON.parse(button.dataset.coleccion);
    if ($(coleccion).empty()) {

        coleccion.posicion = i;
        button.dataset.coleccion = JSON.stringify(coleccion);
        button.innerHTML = button.innerHTML + ' <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Posición: ' + i + '</span>'
        i++
    }
    // else {
    //     button.innerHTML = button.textContent + ' ' + coleccion.dia + '<span class="text-primary"> ' + i + '</span> ' + coleccion.hora;
    //     i++
    // }

});

var dragSrcElement = null;

function handleDragStart(event) {
    dragSrcElement = this;
    event.dataTransfer.effectAllowed = 'move';
    event.dataTransfer.setData('text/html', this.innerHTML);
    this.classList.add('dragging');
}

function handleDragOver(event) {
    if (event.preventDefault) {
        event.preventDefault();
    }
    event.dataTransfer.dropEffect = 'move';
    return false;
}

function handleDrop(event) {
    if (event.stopPropagation) {
        event.stopPropagation();
    }
    if (dragSrcElement !== this) {
        var dragData = JSON.parse(dragSrcElement.dataset.coleccion);
        var dropData = JSON.parse(this.dataset.coleccion);

        // dragSrcElement.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span></span> ' + JSON.stringify(dropData)
        // this.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span></span> ' + JSON.stringify(dragData)

        // Boton donde (origen) se arrastra 

        if (dropData.profesor != undefined && dropData.aula != undefined) {
            dragSrcElement.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Posición: ' + JSON.stringify(dropData.posicion) + '<br> Profesor: ' + JSON.stringify(dropData.profesor) + '<br> Aula:' + JSON.stringify(dropData.aula) + '</span>'
        } else {
            dragSrcElement.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Posición: ' + JSON.stringify(dropData.posicion) + '</span>'
        }



        // Boton a donde (destino) se arrastra 

        if (dragData.profesor != undefined && dragData.aula !== undefined) {
            this.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Posición: ' + JSON.stringify(dragData.posicion) + ' <br> Profesor: ' + JSON.stringify(dragData.profesor) + '<br> Aula: ' + JSON.stringify(dragData.aula) + '</span>'
        } else {
            this.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Posición: ' + JSON.stringify(dragData.posicion) + '</span>'
        }

        dragSrcElement.dataset.coleccion = JSON.stringify(dropData);
        this.dataset.coleccion = JSON.stringify(dragData);
    }
    return false;
}

var buttons = document.querySelectorAll('.hour-button');
buttons.forEach(function (button) {
    button.addEventListener('dragstart', handleDragStart, false);
    button.addEventListener('dragover', handleDragOver, false);
    button.addEventListener('drop', handleDrop, false);
    button.addEventListener('dragend', function () {
        this.classList.remove('dragging');
    });
});

// -----------------------------------------------


function verdad() {
    var editButtons = document.querySelectorAll('.edit-button');
    var datos = {
        profesor: ['Juan', 'Luis', 'Miguel'],
        aula: ['1', 'Laboratorio', '6']
    };

    editButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            var container = this.parentNode;
            var span = container.querySelector('span');
            var coleccion = JSON.parse(container.dataset.coleccion);

            Swal.fire({
                title: 'Editar Datos',
                html:
                    '<label>Profesor:</label>' +
                    '<select id="profesor-select" class="swal2-select">' +
                    generateOptions(datos.profesor, coleccion.profesor) +
                    '</select><br>' +
                    '<label>Aula:</label>' +
                    '<select id="aula-select" class="swal2-select">' +
                    generateOptions(datos.aula, coleccion.aula) +
                    '</select>',
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                    var profesorSelect = document.getElementById('profesor-select');
                    var aulaSelect = document.getElementById('aula-select');
                    var nuevoProfesor = profesorSelect.value;
                    var nuevaAula = aulaSelect.value;

                    if (nuevoProfesor && nuevaAula) {
                        coleccion.profesor = nuevoProfesor;
                        coleccion.aula = nuevaAula;
                        container.dataset.coleccion = JSON.stringify(coleccion);
                        span.innerHTML = 'Posicion: ' + coleccion.posicion + ' <br> Profesor: ' + nuevoProfesor + ' <br> Aula: ' + nuevaAula;
                    }
                }
            });
        });
    });

    function generateOptions(options, selectedValue) {
        var html = '';
        for (var i = 0; i < options.length; i++) {
            var option = options[i];
            var isSelected = option === selectedValue ? 'selected' : '';
            html += '<option value="' + option + '" ' + isSelected + '>' + option + '</option>';
        }
        return html;
    }

}