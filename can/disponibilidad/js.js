(function (document, window) {

    var buttons = document.querySelectorAll('.hour-button');
    let i = 1
    buttons.forEach(function (button) {
        var coleccion = JSON.parse(button.dataset.coleccion);
        if ($(coleccion).empty()) {

            coleccion.posicion = i;
            // "disponibilidad": 0
            coleccion.disponibilidad= 0
            button.classList.add('bg-secondary')
            button.classList.add('text-white')
            button.dataset.coleccion = JSON.stringify(coleccion);
            button.innerText = 'Ocupado'
            i++
        }
        // else {
        //     button.innerHTML = button.textContent + ' ' + coleccion.dia + '<span class="text-primary"> ' + i + '</span> ' + coleccion.hora;
        //     i++
        // }

    });



})(document, window);

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("tipoHorario").value=''
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
      removeDisplayN()
      mostrarContenido()
    } else if (selectedValue === "nocturno") {
      titulo.innerHTML = "Nocturno";
      removeDisplayN()
      ocultarContenido()
    } else {
      titulo.innerHTML = "";
    }
  }

  function cambiarEstado(td) {
    var data = JSON.parse(td.getAttribute("data-coleccion"));
    let tipoHorario = document.getElementById("tipoHorario").value
    
    if (data.disponibilidad === 0) {
      td.textContent = "Disponible";
      data.disponibilidad = 1;
      data.tipoh = tipoHorario
      td.classList.remove('bg-secondary')
      td.classList.add('bg-primary')

    } else {
      td.textContent = "Ocupado";
      data.disponibilidad = 0;
      delete data.tipoh
      td.classList.remove('bg-primary')
      td.classList.add('bg-secondary')

    }

    td.setAttribute("data-coleccion", JSON.stringify(data));
  }

 function guardarDatos() {
    var tdList = document.querySelectorAll(".hour-button");
    var jsonData = [];

    tdList.forEach(function(td) {
      var data = JSON.parse(td.getAttribute("data-coleccion"));
      if (data.disponibilidad === 1) {
        jsonData.push(data);
      }
    });
    // Aquí puedes enviar jsonData a través de una solicitud HTTP
    // o utilizarlo según tus necesidades.
    console.log(jsonData);
  }

  var contenidoGuardado = null;

  function ocultarContenido() {
    var tdDiurno = document.querySelectorAll(".tdDiurno");

    tdDiurno.forEach(function(td) {
      td.classList.add('d-none')
    });

  }

  function mostrarContenido() {
    var tdDiurno = document.querySelectorAll(".tdDiurno");

    tdDiurno.forEach(function(td) {
      td.classList.remove('d-none')
    });
  }