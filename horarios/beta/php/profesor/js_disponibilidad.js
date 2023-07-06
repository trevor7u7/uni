$(document).ready(function () {
    // Obtener la URL actual
    var urlActual = window.location.href;

    // Crear un objeto URLSearchParams con la URL de la página obtenida
    var params = new URLSearchParams(new URL(urlActual).search);

    // Obtener el valor del parámetro 'id'
    var id = params.get('id');

    $.ajax({
        url: '../profesor_disponibilidad/crud_profesor_disponibilidad.php',
        method: "POST",
        data: { 'id': id, 'tipo': 'mostrar_name' },
        success: function (res) {
            $('#nombreProfesor').text('Disponibilidad: ' + res.profesor.name + ' ' + res.profesor.last_name);
        },
        error: function (error) {
            console.error(error);
        }
    });
});


function cargarTabla(horario) {
    // Obtener la URL actual
    var urlActual = window.location.href;

    // Crear un objeto URLSearchParams con la URL de la página obtenida
    var params = new URLSearchParams(new URL(urlActual).search);

    // Obtener el valor del parámetro 'id'
    var id = params.get('id');
    $.ajax({
        url: '../profesor_disponibilidad/crud_profesor_disponibilidad.php',
        method: "POST",
        data: { 'id': id, 'tipo': 'cargar_tabla', 'horario': horario },
        success: function (res) {
            var buttons = document.querySelectorAll('.hour-button');
            let i = 1
            buttons.forEach(function (button) {
                button.classList.remove('bg-primary')
                button.classList.remove('bg-secondary')
                var coleccion = JSON.parse(button.dataset.coleccion);
                var matchingData = res.data.find(function (item) {
                    return item.hour === i;
                });
                if (matchingData) {
                    coleccion.posicion = matchingData.hour
                    if (matchingData.disponibilidad) {
                        button.classList.add('bg-primary');
                        button.classList.add('text-white')
                        button.dataset.coleccion = JSON.stringify(coleccion);
                        button.innerText = 'Disponible'
                        coleccion.disponibilidad = 1
                    } else {
                        coleccion.disponibilidad = 0
                        button.classList.add('bg-secondary')
                        button.classList.add('text-white')
                        button.dataset.coleccion = JSON.stringify(coleccion);
                        button.innerText = 'Ocupado'
                    }



                } else {
                    coleccion.posicion = i
                    coleccion.disponibilidad = 0
                    button.classList.add('bg-secondary')
                    button.classList.add('text-white')
                    button.dataset.coleccion = JSON.stringify(coleccion);
                    button.innerText = 'Ocupado'
                }
                i++
            });
        },
        error: function (error) {
            console.error(error);
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("tipoHorario").value = ''
});

function removeDisplayN() {
    let tabla = document.getElementById('tableMain')
    let botonGrd = document.getElementById('btnGuardar')

    tabla.classList.remove("d-none");
    botonGrd.classList.remove("d-none");

}

function mostrarTitulo() {
    var select = document.getElementById("tipoHorario");
    var selectedValue = select.options[select.selectedIndex].value;
    var titulo = document.getElementById("titleTable");

    if (selectedValue === "diurno") {
        titulo.innerHTML = "Diurno";
        cargarTabla('diurno')
        removeDisplayN()
        mostrarContenido()
    } else if (selectedValue === "nocturno") {
        titulo.innerHTML = "Nocturno";
        cargarTabla('nocturno')
        removeDisplayN()
        ocultarContenido()
    } else {
        titulo.innerHTML = "";
    }
}

function cambiarEstado(td) {
    var datos = JSON.parse(td.getAttribute("data-coleccion"));
    let tipoHorario = document.getElementById("tipoHorario").value

    if (datos.disponibilidad === 0) {
        td.textContent = "Disponible";
        datos.disponibilidad = 1;
        datos.tipoh = tipoHorario
        td.classList.remove('bg-secondary')
        td.classList.add('bg-primary')

    } else {
        td.textContent = "Ocupado";
        datos.disponibilidad = 0;
        datos.tipoh = tipoHorario
        td.classList.remove('bg-primary')
        td.classList.add('bg-secondary')

    }
    // Obtener la URL actual
    var urlActual = window.location.href;

    // Crear un objeto URLSearchParams con la URL de la página obtenida
    var params = new URLSearchParams(new URL(urlActual).search);

    // Obtener el valor del parámetro 'id'
    var id = params.get('id');

    $.ajax({
        url: '../profesor_disponibilidad/crud_profesor_disponibilidad.php',
        method: "POST",
        data: { 'id': id, 'tipo': 'verificar', 'datos': datos },
        success: function (res) {
            console.log(res);

        },
        error: function (error) {
            console.error(error);
        }
    });
    td.setAttribute("data-coleccion", JSON.stringify(datos));
}

var contenidoGuardado = null;

function ocultarContenido() {
    var tdDiurno = document.querySelectorAll(".tdDiurno");

    tdDiurno.forEach(function (td) {
        td.classList.add('d-none')
    });

}

function mostrarContenido() {
    var tdDiurno = document.querySelectorAll(".tdDiurno");

    tdDiurno.forEach(function (td) {
        td.classList.remove('d-none')
    });
}


