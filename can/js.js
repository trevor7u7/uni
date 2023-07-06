(function (document, window) {

    let bottonDelete = '<botton id="btnBorrarHora" class="btn btn-danger btnBorrarHora" onclick="borrar()">Eliminar</botton>'
    
    var buttons = document.querySelectorAll('.hour-button');
    let i = 1
    buttons.forEach(function (button) {
        var coleccion = JSON.parse(button.dataset.coleccion);
        if ($(coleccion).empty()) {

            coleccion.posicion = i;
            button.dataset.coleccion = JSON.stringify(coleccion);
            button.innerHTML = button.innerHTML + ' <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Hora Libre: ' + i + '</span>'
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
            var arrastradaData = JSON.parse(dragSrcElement.dataset.coleccion);
            var soltadaData = JSON.parse(this.dataset.coleccion);

            if (soltadaData.profesor && soltadaData.aula) {

                let dataModal = '<table class="table"><tr><td><h3>Datos nuevos:</h3><span class="text-start">Hora:' + 
                                soltadaData.posicion + 
                                '</span></br>' +
                                '<span class="text-start">Profesor: '+
                                soltadaData.profesor +
                                '</span></br>'+
                                '<span class="text-start">Aula: '+
                                soltadaData.aula + '</span></td>'+
                                '<td><h3>Datos a Cambiar</h3>'+
                                '<span class="text-start">Hora:' + 
                                arrastradaData.posicion + 
                                '</span></br>' +
                                '<span class="text-start">Profesor: '+
                                arrastradaData.profesor +
                                '</span></br>'+
                                '<span class="text-start">Aula: '+
                                arrastradaData.aula + '</span>'
                                '</td></tr></table>'


                Swal.fire({
                    icon: 'warning',
                    title: '¿Estas seguro de cambiar esta Hora?',
                    html: dataModal,
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    focusConfirm: false,
                    preConfirm: () => {
                        dragSrcElement.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Hora Libre: ' + JSON.stringify(soltadaData.posicion) + '<br> Profesor: ' + JSON.stringify(soltadaData.profesor) + '<br> Aula:' + JSON.stringify(soltadaData.aula) + '</span>' +bottonDelete
                        if (arrastradaData.profesor && arrastradaData.aula) {
                            this.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Hora Libre: ' + JSON.stringify(arrastradaData.posicion) + ' <br> Profesor: ' + JSON.stringify(arrastradaData.profesor) + '<br> Aula: ' + JSON.stringify(arrastradaData.aula) + '</span>' +bottonDelete
                        }
                        dragSrcElement.dataset.coleccion = JSON.stringify(soltadaData);

                        this.dataset.coleccion = JSON.stringify(arrastradaData);


                        return console.log('confirmado');
                    }
                })
                
            }else {

                if (arrastradaData.profesor && arrastradaData.aula) {
                    this.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Hora Libre: ' + JSON.stringify(arrastradaData.posicion) + ' <br> Profesor: ' + JSON.stringify(arrastradaData.profesor) + '<br> Aula: ' + JSON.stringify(arrastradaData.aula) + '</span>' +bottonDelete
                }

                dragSrcElement.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Hora Libre: ' + JSON.stringify(soltadaData.posicion) + '</span>'
                dragSrcElement.dataset.coleccion = JSON.stringify(soltadaData);

                this.dataset.coleccion = JSON.stringify(arrastradaData);

                 return console.log('otro modo');
            }

        }
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





})(document, window);

let bottonDelete = '<botton id="btnBorrarHora" class="btn btn-danger btnBorrarHora" onclick="borrar()">Eliminar</botton>'


function borrar() {
    // btnBorrarHora
    var btnBorrarHora = document.querySelectorAll('.btnBorrarHora')
    btnBorrarHora.forEach(function (button) {
        button.addEventListener('click', function (event) {
            var container = this.parentNode;
            var coleccion = JSON.parse(container.dataset.coleccion);
       
            delete coleccion.profesor
            delete coleccion.aula

            container.dataset.coleccion = JSON.stringify(coleccion);
            container.innerHTML = 'Arrastrar <a href="#" onclick="verdad()" class="edit-button btn">Editar</a><span class="btn btn-primary text-start">Hora Libre: ' + JSON.stringify(coleccion.posicion) + '</span>'
            
        });
    });
}

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
                        
                        // let comprobarBoton = container.childNodes

                        // container.childNodes.forEach(
                            // function (b) {
                        span.innerHTML = 'Posicion: ' + coleccion.posicion + ' <br> Profesor: ' + nuevoProfesor + ' <br> Aula: ' + nuevaAula;
                                
                        let btnArr = Array.from(container.childNodes)
                        if (!btnArr[3]) {
                            container.innerHTML = container.innerHTML + bottonDelete
                            
                        }

                        // container.innerHTML = container.innerHTML + bottonDelete
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