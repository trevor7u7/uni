function mostrarFormulario() {
    Swal.fire({
        title: 'Crear Profesor',
        html:
            '<input id="txtNombre" class="swal2-input" placeholder="Nombre">' +
            '<input id="txtApellido" class="swal2-input" placeholder="Apellido">' +
            '<input id="txtPerfil" class="swal2-input" placeholder="Perfil">',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Crear',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const nombre = Swal.getPopup().querySelector('#txtNombre').value;
            const apellido = Swal.getPopup().querySelector('#txtApellido').value;
            const perfil = Swal.getPopup().querySelector('#txtPerfil').value;

            if (!nombre || !apellido || !perfil) {
                Swal.showValidationMessage('Por favor, completa todos los campos');
                return false;
            }

            // Llamar a la función AJAX para crear el profesor
            crearProfesor(nombre, apellido, perfil);
        }
    });
}

function crearProfesor(nombre, apellido, perfil) {
    $.ajax({
        url: 'crud_profesor.php',
        type: 'POST',
        data: {
            tipo: 'crear',
            name: nombre,
            last_name: apellido,
            perfil: perfil
        },
        success: function (response) {
            if (response.success) {
                Swal.fire('¡Profesor ' + nombre + ' ' + apellido + ' creado!', '', 'success');
                cargarProfesores();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Ha ocurrido un error al procesar la solicitud', 'error');
        }
    });
}



$(document).ready(function () {
    cargarProfesores(); // Cargar los profesores al cargar la página
});

function cargarProfesores() {
    // Realizar una solicitud AJAX para obtener los datos de los profesores
    $.ajax({
        url: 'crud_profesor.php',
        type: 'POST',
        data: { 'tipo': 'listar' },
        success: function (response) {
            if (response.success) {
                var profesores = response.profesores;

                // Limpiar la tabla antes de agregar los datos
                $('#tablaProfesores').empty();

                // Agregar los datos de los profesores a la tabla
                $.each(profesores, function (index, profesor) {
                    var row = '<tr>' +
                        '<td>' + profesor.name + '</td>' +
                        '<td>' + profesor.last_name + '</td>' +
                        '<td>' + profesor.perfil + '</td>' +
                        '<td><a class="btn btn-secondary" href="disponibilidad.html?id=' + profesor.id + '">Ver</a></td>' +
                        '<td><button class="btn btn-primary" onclick="actualizarProfesor(' + profesor.id + ')">Actualizar</button></td>' +
                        '<td><button class="btn btn-danger" onclick="eliminarProfesor(' + profesor.id + ')">Eliminar</button></td>' +
                        '</tr>';

                    $('#tablaProfesores').append(row);
                });
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Ha ocurrido un error al cargar los profesores', 'error');
        }
    });
}

function actualizarProfesor(id) {
    // Mostrar el formulario desplegable de actualización utilizando SweetAlert2

    $.ajax({
        url: 'crud_profesor.php',
        type: 'POST',
        data: {
            'tipo': 'listar_uno',
            id: id
        },
        success: function (response) {
            Swal.fire({
                title: 'Actualizar Profesor',
                html:
                    '<input id="txtNombre" value="' + response.profesor.name + '" class="swal2-input" placeholder="Nombre">' +
                    '<input id="txtApellido" value="' + response.profesor.last_name + '" class="swal2-input" placeholder="Apellido">' +
                    '<input id="txtPerfil" value="' + response.profesor.perfil + '" class="swal2-input" placeholder="Perfil">',
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Actualizar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const nombre = Swal.getPopup().querySelector('#txtNombre').value;
                    const apellido = Swal.getPopup().querySelector('#txtApellido').value;
                    const perfil = Swal.getPopup().querySelector('#txtPerfil').value;

                    if (!nombre || !apellido || !perfil) {
                        Swal.showValidationMessage('Por favor, completa todos los campos');
                        return false;
                    }

                    // Llamar a la función AJAX para actualizar el profesor
                    actualizarProfesorAjax(id, nombre, apellido, perfil);

                }
            });
        }
    })


}

function actualizarProfesorAjax(id, nombre, apellido, perfil) {
    // Realizar una solicitud AJAX para actualizar el profesor en la base de datos
    $.ajax({
        url: 'crud_profesor.php',
        type: 'POST',
        data: {
            tipo: 'actualizar',
            id: id,
            name: nombre,
            last_name: apellido,
            perfil: perfil
        },
        success: function (response) {
            if (response.success) {
                Swal.fire('¡Profesor ' + nombre + ' ' + apellido + ' actualizado!', '', 'success');

                // Recargar la tabla de profesores para reflejar los cambios
                cargarProfesores();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Ha ocurrido un error al procesar la solicitud', 'error');
        }
    });
}

function eliminarProfesor(id) {
    // Mostrar la confirmación de eliminación utilizando SweetAlert2
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Llamar a la función AJAX para eliminar el profesor
            eliminarProfesorAjax(id);
        }
    });
}

function eliminarProfesorAjax(id) {
    // Realizar una solicitud AJAX para eliminar el profesor de la base de datos
    $.ajax({
        url: 'crud_profesor.php',
        type: 'POST',
        data: {
            id: id,
            tipo: 'eliminar'
        },
        success: function (response) {
            if (response.success) {
                Swal.fire('¡Profesor eliminado!', '', 'success');

                // Recargar la tabla de profesores para reflejar los cambios
                cargarProfesores();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Ha ocurrido un error al procesar la solicitud', 'error');
        }
    });
}