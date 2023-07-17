//Acceso a Login
function enviarDatosLogin(username, password) {
    //Configuraciones de alerta
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        username: username,
        password: password,
    };

    $.ajax({
        type: "POST",
        url: "assets/php/validateLogin.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            var url = response.url;
            if (success == true) {
                toastr.success(message, "MENSAJE");
                setTimeout(function () {
                    window.location.href = url;
                }, 1000);
            } else {
                toastr.error(message, "MENSAJE");
            }

        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });

}

//Gestión de Empleado
function insertDataEmployee(idTipoCodigo, idTipoContrato, idDepartamento, idJobTitle, idAbbrJob, cedulaEmpleado, nombreEmpleado,
    apellidoEmpleado, dateInicioLaboral, telefonoEmpleado, direccionEmpleado, emailEmpleado, salary) {

    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        idTipoCodigo: idTipoCodigo,
        idTipoContrato: idTipoContrato,
        idDepartamento: idDepartamento,
        idJobTitle: idJobTitle,
        idAbbrJob: idAbbrJob,
        cedulaEmpleado: cedulaEmpleado,
        nombreEmpleado: nombreEmpleado,
        apellidoEmpleado: apellidoEmpleado,
        dateInicioLaboral: dateInicioLaboral,
        telefonoEmpleado: telefonoEmpleado,
        direccionEmpleado: direccionEmpleado,
        emailEmpleado: emailEmpleado,
        salary: salary
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "assets/php/insertEmployee.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData();
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.success(message, "MENSAJE");
            } else {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });

}
function updateDataEmployee(idEmployee, idTipoCodigo, idTipoContrato, idDepartamento, idJobTitle, idAbbrJob, cedulaEmpleado, nombreEmpleado,
    apellidoEmpleado, dateInicioLaboral, telefonoEmpleado, direccionEmpleado, emailEmpleado, salary) {

    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        idEmployee: idEmployee,
        idTipoCodigo: idTipoCodigo,
        idTipoContrato: idTipoContrato,
        idDepartamento: idDepartamento,
        idJobTitle: idJobTitle,
        idAbbrJob: idAbbrJob,
        cedulaEmpleado: cedulaEmpleado,
        nombreEmpleado: nombreEmpleado,
        apellidoEmpleado: apellidoEmpleado,
        dateInicioLaboral: dateInicioLaboral,
        telefonoEmpleado: telefonoEmpleado,
        direccionEmpleado: direccionEmpleado,
        emailEmpleado: emailEmpleado,
        salary: salary
    };

    $.ajax({
        type: "POST",
        url: "assets/php/updateEmployee.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData();
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });

}

//Agregar datos a Modales/Inputs
//Modales
function agregaform(datos) {
    d = datos.split('||');
    $('#idEmployeeu').val(d[0]);
    $('#idTipoCodigou').val(d[1]);
    $('#idTipoContratou').val(d[2]);
    $('#idDepartamentou').val(d[3]);
    $('#idJobTitleu').val(d[4]);
    $('#idAbbrJobu').val(d[5]);
    $('#cedulaEmpleadou').val(d[6]);
    $('#nombreEmpleadou').val(d[7]);
    $('#apellidoEmpleadou').val(d[8]);
    $('#fechaInicioLaboralu').val(d[9]);
    $('#telefonoEmpleadou').val(d[10]);
    $('#direccionEmpleadou').val(d[11]);
    $('#emailEmpleadou').val(d[12]);
    $('#salaryu').val(d[13]);

}
function addToModalPermiss(datos) {
    d = datos.split('||');

    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();

    const h5Element = document.getElementById("modalDetailLabel");

    //h5Element.style.fontWeight = "bold";
    $('#idPermiss').val(d[0]);
    h5Element.innerText = 'Permiso Nº ' + d[1] + '-' + currentYear;
    $('#fullnameEmployee').val(d[3]);
    $('#nameReason').val(d[4]);
    $('#issueDate').val(d[5]);
    $('#startDate').val(d[7]);
    $('#endDate').val(d[8]);
    $('#workingDays').val(d[9]);
    $('#weekendDays').val(d[10]);
    $('#total').val(d[11]);
    $('#observation').val(d[12]);


}
function addToModalPeriod(datos) {
    d = datos.split('||');
    $('#idPeriod').val(d[0]);
    $('#startDatePeriod').val(d[3]);
    $('#endDatePeriod').val(d[4]);
    var earnedDays = parseFloat(d[5]) + parseFloat(d[6]);
    $('#earnDaysPeriod').val(earnedDays.toFixed(2));
    $('#workingDaysPeriod').val(d[7]);
    $('#weekendDaysPeriod').val(d[8]);
    $('#selectStatePeriod').val(d[9]);
    var balanceDays = parseFloat(d[7]) + parseFloat(d[8]);
    $('#balanceDaysPeriod').val(balanceDays.toFixed(2));
    

    idPeriod = $('#idPeriod').val();

    var cadena = "id=" + idPeriod;

    $.ajax({
        type: "POST",
        data: cadena,
        dataType: "json",
        url: './assets/php/getDataEmployeeForPeriod.php',
        success: function (response) {
            $('#cedulaEmployeePeriodu').val(response.ci_employee);
            $('#nameEmployeePeriodu').val(response.name_employee);
            $('#lastNameEmployeePeriodu').val(response.lastName_employee);
            $('#departamentEmployeePeriodu').val(response.name_departament);

        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function addToModalUser(datos) {
    d = datos.split('||');

    var cadena = "id=" + d[1];
    $('#idUserSelected').val(d[0]);
    $('#idTypeUseru').val(d[3]);
    $('#passwordUseru').val(d[6]);

    $.ajax({
        type: "POST",
        data: cadena,
        dataType: "json",
        url: './assets/php/getDataEmployee.php',
        success: function (response) {
            $('#cedulaEmployeeUseru').val(response.ci_employee);
            $('#nameEmployeeUseru').val(response.name_employee);
            $('#lastNameEmployeeUseru').val(response.lastName_employee);
            $('#departamentEmployeeUseru').val(response.name_departament);

        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function addToModalPermissBack(datos) {
    d = datos.split('||');

    var cadena = "id=" + d[1];

    let date = d[4];
    let newDate = date.replace(/-/g, "/");

    $('#idPermissBack').val(d[0]);
    $('#datePermissBacku').val(newDate);
    $('#selectStatePermissBacku').val(d[5]);


    $.ajax({
        type: "POST",
        data: cadena,
        dataType: "json",
        url: './assets/php/getDataEmployee.php',
        success: function (response) {
            $('#cedulaEmployeePermissBacku').val(response.ci_employee);
            $('#nameEmployeePermissBacku').val(response.name_employee);
            $('#lastNameEmployeePermissBacku').val(response.lastName_employee);
            $('#departamentEmployeePermissBacku').val(response.name_departament);

        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function addToModalEmployeeCertificate(datos) {
    d = datos.split('||');

    var cadena = "id=" + d[0];
    $('#idEmployeeSelectedRow').val(d[0]);

    $.ajax({
        type: "POST",
        data: cadena,
        dataType: "json",
        url: './assets/php/getDataEmployee.php',
        success: function (response) {
            $('#cedulaEmployeeCertificate').val(response.ci_employee);
            $('#nameEmployeeCertificate').val(response.name_employee);
            $('#lastNameEmployeeCertificate').val(response.lastName_employee);
            $('#departamentEmployeeCertificate').val(response.name_departament);
            $('#startDateEmployeeCertificate').val(response.startDate_employee);

        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
//Inputs
function addToInputDepartament(datos) {
    d = datos.split('||');
    $('#idDepartament').val(d[0]);
    $('#nameDepartament').val(d[1]);
    $('#btnAddDepartament').hide();
    $('#btnUpdateDepartament').show();
}
function addToInputReason(datos) {
    d = datos.split('||');
    $('#idReason').val(d[0]);
    $('#nameReason').val(d[1]);
    $('#btnAddReason').hide();
    $('#btnUpdateReason').show();
}
function addToInputContractType(datos) {
    d = datos.split('||');
    $('#idContractType').val(d[0]);
    $('#nameContractType').val(d[1]);
    $('#btnAddContractType').hide();
    $('#btnUpdateContractType').show();
}
function addToInputJobTitle(datos) {
    d = datos.split('||');
    $('#idJobTitle').val(d[0]);
    $('#nameJobTitle').val(d[1]);
    $('#btnAddJobTitle').hide();
    $('#btnUpdateJobTitle').show();
}
function addToInputAbbrJob(datos) {
    d = datos.split('||');
    $('#idAbbrJob').val(d[0]);
    $('#nameAbbrJob').val(d[1]);
    $('#btnAddAbbrJob').hide();
    $('#btnUpdateAbbrJob').show();
}


//Alertas de Si o No
//Eliminar
function yesOrNoQuestionDepartament(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    alertify.confirm('Eliminar Departamento', '¿Esta seguro de eliminar este departamento?',
        function () {
            deleteDepartament(id);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}
function yesOrNoQuestionReason(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;
    alertify.confirm('Eliminar Razón de Permiso', '¿Esta seguro de eliminar esta Razón de Permiso?',
        function () {
            deleteReason(id);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}
function yesOrNoQuestionContractType(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    alertify.confirm('Eliminar Tipo de Contrato', '¿Esta seguro de eliminar este Tipo de Contrato?',
        function () {
            deleteContractType(id);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}
function yesOrNoQuestionJobTitle(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    alertify.confirm('Eliminar Cargo', '¿Esta seguro de eliminar este Cargo?',
        function () {
            deleteJobTitle(id);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}
function yesOrNoQuestionAbbrJob(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    alertify.confirm('Eliminar Abreviatura de Título', '¿Esta seguro de eliminar esta abreviatura?',
        function () {
            deleteAbbrJob(id);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}
//Opciones Usuario
function preguntarSiNo(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    alertify.confirm('Bloquear Acceso', '¿Esta seguro de bloquear el acceso a este usuario?',
        function () {
            disableUser(id);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}
function yesOrNoQuestionEnableUser(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;
    
    alertify.confirm('Habilitar Acceso', '¿Esta seguro de habilitar el acceso a este usuario?',
        function () {
            enableUser(id);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}
function preguntarSiNoReset(id, password) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    alertify.confirm('Resetear clave', '¿Esta seguro de resetear la clave?',
        function () {
            resetPassword(id, password);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}
function yesOrNoQuestionDisableEmployee(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    alertify.confirm('Desactivar Empleado', '¿Esta seguro borrar todos los valores de periodos del Empleado?',
        function () {
            disableEmployee(id);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}
//Permisos
function yesOrNoQuestionSendPermiss(datos) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    alertify.confirm('Enviar Solicitud', '¿Esta seguro de enviar esta solicitud?',
        function () {
            sendRequestPermiss(datos);
        },
        function () {
            toastr.error('Se canceló', "MENSAJE");
        });
}

//Opciones de Usuario
function insertUser(idEmployee, typeUser, password) {

    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        idEmployee: idEmployee,
        typeUser: typeUser,
        password: password
    };

    $.ajax({
        type: "POST",
        url: "assets/php/insertUser.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getDataUsers();
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.success(message, "MENSAJE");
            } else {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });

}
function updateUser(idUser, typeUser, password) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        idUser: idUser,
        typeUser: typeUser,
        password: password
    };


    $.ajax({
        type: "POST",
        url: "assets/php/updateUser.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getDataUsers();
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.success(message, "MENSAJE");
            } else {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });

}
function enableUser(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    cadena = "id=" + id;
    $.ajax({
        type: "POST",
        url: "assets/php/enableUser.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getDataUsers();
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function disableUser(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    cadena = "id=" + id;

    $.ajax({
        type: "POST",
        url: "assets/php/disableUser.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                //$('#tabla').load('./partials/tableEmployees.php');
                getDataUsers();
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function resetPassword(id, password) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var cadena = "id=" + id +
        "&password=" + password;

    $.ajax({
        type: "POST",
        url: "assets/php/resetPassword.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getDataUsers();
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function changePasswordUser(passwordNow, passwordNew, confirmPasswordNew) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        passwordNow: passwordNow,
        passwordNew: passwordNew,
        confirmPasswordNew: confirmPasswordNew
    };


    $.ajax({
        type: "POST",
        url: "assets/php/changePasswordUser.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function disableEmployee(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    cadena = "id=" + id;

    $.ajax({
        type: "POST",
        url: "assets/php/disableEmployee.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}


//Gestión de Departamentos
function insertDepartament(name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'INSERT';
    cadena = "id=" +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageDepartament.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("departament");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function updateDepartament(id, name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'UPDATE';
    cadena = "id=" + id +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageDepartament.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("departament");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function deleteDepartament(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'DELETE';
    cadena = "id=" + id +
        "&name=" +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageDepartament.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("departament");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}

//Gestión de Razones de Permiso
function insertReason(name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'INSERT';
    cadena = "id=" +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageReason.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("reason");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function updateReason(id, name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;
    
    operation = 'UPDATE';
    cadena = "id=" + id +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageReason.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("reason");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function deleteReason(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'DELETE';
    cadena = "id=" + id +
        "&name=" +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageReason.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("reason");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}

//Gestión de Tipos de Contratación
function insertContractType(name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'INSERT';
    cadena = "id=" +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageContractType.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("contractType");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function updateContractType(id, name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;
    
    operation = 'UPDATE';
    cadena = "id=" + id +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageContractType.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("contractType");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function deleteContractType(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'DELETE';
    cadena = "id=" + id +
        "&name=" +
        "&operation=" + operation;
    $.ajax({
        type: "POST",
        url: "assets/php/manageContractType.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("contractType");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}

//Gestión de Cargos
function insertJobTitle(name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'INSERT';
    cadena = "id=" +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageJobTitle.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("jobTitle");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function updateJobTitle(id, name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'UPDATE';
    cadena = "id=" + id +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageJobTitle.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("jobTitle");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function deleteJobTitle(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'DELETE';
    cadena = "id=" + id +
        "&name=" +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageJobTitle.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("jobTitle");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
//Gestión de Abreviaturas de Titulos
function insertAbbrJob(name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'INSERT';
    cadena = "id=" +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageAbbrJob.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("abbrJob");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function updateAbbrJob(id, name) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'UPDATE';
    cadena = "id=" + id +
        "&name=" + name +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageAbbrJob.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("abbrJob");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function deleteAbbrJob(id) {
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    operation = 'DELETE';
    cadena = "id=" + id +
        "&name=" +
        "&operation=" + operation;

    $.ajax({
        type: "POST",
        url: "assets/php/manageAbbrJob.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getData("abbrJob");
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}

//Permisos
function sendRequestPermiss(datos) {
    //Configuraciones de alerta
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;
    toastr.options.newestOnTop = false;

    d = datos.split('||');

    cadena = "idEmployee=" + d[0] +
        "&idReason=" + d[1] +
        "&startDate=" + d[2] +
        "&endDate=" + d[3] +
        "&observation=" + d[4];

    $.ajax({
        type: "POST",
        url: "assets/php/insertPermiss.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                var pageUrl = window.location.pathname;
                if (pageUrl.includes("employee_permise")) {
                    getData("permissDate");
                    getData("permissDay");
                } else if (pageUrl.includes("admin_vacation")) {
                    getDataVacation();
                } else if (pageUrl.includes("admin_discount")) {
                    getData("discountDate");
                    getData("discountDay");
                }
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}

function updateStatePermiss(idPermiss, state, message) {
    //Configuraciones de alerta
    toastr.options.preventDuplicates = false;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;
    toastr.options.newestOnTop = false;

    var cadena = "idPermiss=" + idPermiss +
        "&state=" + state +
        "&message=" + message;

    $.ajax({
        type: "POST",
        url: "assets/php/updateStatePermiss.php",
        data: cadena,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getDataPermisses();
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}

//Gestión de Periodos de Vacaciones
function insertVacationPeriod(idEmployee) {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        id: idEmployee
    };
    //console.log(data);

    $.ajax({
        type: "POST",
        url: "assets/php/insertVacationPeriod.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getDataPeriods();
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function insertNextVacationPeriod(idEmployee) {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        id: idEmployee
    };
    console.log(data);

    $.ajax({
        type: "POST",
        url: "assets/php/insertNextVacationPeriod.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getDataPeriods();
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function updatePeriodVacation(idPeriod, startDate, endDate, workingDays, weekendDays, statePeriod) {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        idPeriod: idPeriod,
        startDate: startDate,
        endDate: endDate,
        workingDays: workingDays,
        weekendDays: weekendDays,
        statePeriod: statePeriod
    };
    //console.log(data);

    $.ajax({
        type: "POST",
        url: "assets/php/updateVacationPeriod.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getDataPeriods();
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}

//Habilitar fecha para permiso atrasado
function insertPermissBack(idEmployee, datePermissBack, statePermissBack) {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        idEmployee: idEmployee,
        minDate: datePermissBack,
        state: statePermissBack
    };
    //console.log(data);

    $.ajax({
        type: "POST",
        url: "assets/php/insertPermissBack.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                $('#tablePermissBack').load('./partials/tablePermissBack.php');
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}
function getMinDate() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: "POST",
            url: "assets/php/getDatePermissBack.php",
            dataType: "json",
            success: function (response) {
                var date = response.date;
                resolve(date);
            },
            error: function (xhr, status, error) {
                // Manejar errores de la solicitud Ajax
                console.log("Error en la solicitud Ajax:", error);
                reject(error);
            }
        });
    });
}
function updatePermissBack(idPermissBack, datePermissBack, statePermissBack) {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var data = {
        idPermissBack: idPermissBack,
        minDate: datePermissBack,
        state: statePermissBack
    };
    //console.log(data);

    $.ajax({
        type: "POST",
        url: "assets/php/updatePermissBack.php",
        data: data,
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                getDataPermissBack();
                toastr.success(message, "MENSAJE");
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}

//Otras Funciones
function convertirFormatoAMPMa24Horas(time) {
    var tiempoAMPM = time.split(" ");
    var tiempo = tiempoAMPM[0];
    var periodo = tiempoAMPM[1];

    var horasMinutos = tiempo.split(":");
    var horas = parseInt(horasMinutos[0]);
    var minutos = parseInt(horasMinutos[1]);

    if (periodo === "pm" && horas < 12) {
        horas += 12;
    } else if (periodo === "am" && horas === 12) {
        horas = 0;
    }

    var horasStr = horas.toString().padStart(2, "0");
    var minutosStr = minutos.toString().padStart(2, "0");

    return horasStr + ":" + minutosStr + ":00";
}
function validateCedula(cedula) {
    if (cedula.length == 10) {
        var digito_region = cedula.substring(0, 2);
        if (digito_region >= 1 && digito_region <= 24) {
            var ultimo_digito = cedula.substring(9);
            var pares = parseInt(cedula.substring(1, 2)) + parseInt(cedula.substring(3, 4)) + parseInt(cedula.substring(5, 6)) + parseInt(cedula.substring(7, 8));
            var numero1 = cedula.substring(0, 1);
            numero1 = (numero1 * 2);
            if (numero1 > 9) numero1 -= 9;
            var numero3 = cedula.substring(2, 3);
            numero3 = (numero3 * 2);
            if (numero3 > 9) numero3 -= 9;
            var numero5 = cedula.substring(4, 5);
            numero5 = (numero5 * 2);
            if (numero5 > 9) numero5 -= 9;
            var numero7 = cedula.substring(6, 7);
            numero7 = (numero7 * 2);
            if (numero7 > 9) numero7 -= 9;
            var numero9 = cedula.substring(8, 9);
            numero9 = (numero9 * 2);
            if (numero9 > 9) numero9 -= 9;
            var impares = numero1 + numero3 + numero5 + numero7 + numero9;
            var suma_total = (pares + impares);
            var primer_digito_suma = String(suma_total).substring(0, 1);
            var decena = (parseInt(primer_digito_suma) + 1) * 10;
            var digito_validador = decena - suma_total;
            if (suma_total % 10 == 0) {
                digito_validador = 0;
            } else {
                digito_validador = 10 - (suma_total % 10);
            }
            if (digito_validador == ultimo_digito) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function uploadImage(file, nameFile) {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.closeButton = true;

    var url = 'index.php';

    var data = new FormData();
    data.append('file', file);
    data.append('nameFile', nameFile);

    $.ajax({
        type: "POST",
        url: "assets/php/uploadImage.php",
        data: data,
        processData: false,  // Impide que jQuery transforme la data en string
        contentType: false,  // Impide que jQuery establezca el contentType
        dataType: "json",
        success: function (response) {
            var success = response.success;
            var message = response.message;
            if (success == true) {
                toastr.success(message, "MENSAJE");
                setTimeout(function () {
                    window.location.href = url;
                }, 1000);    
            } else {
                toastr.error(message, "MENSAJE");
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud Ajax
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}


//PDF Reportes
function generatePDFPermiss(idPermiss) {
    // Definir la URL del script PHP
    var url = "report_permissEmployee.php";
    // Crear la URL completa con el parámetro
    var fullUrl = url + "?idPermiss=" + idPermiss;
    // Actualizar la URL del iframe
    $('#pdfFrame').attr('src', fullUrl);
    // Mostrar el modal
    $('#modalPDFPermiss').modal('show');

}
function generatePDFReportGeneral(search, numRows) {
    // Definir la URL del script PHP
    var url = "report_general.php";
    // Crear la URL completa con el parámetro
    var fullUrl = url + "?search=" + encodeURIComponent(search.trim()) + "&numRows=" + encodeURIComponent(numRows);
    
    // Actualizar la URL del iframe
    $('#pdfFrameGeneral').attr('src', fullUrl);
    // Mostrar el modal
    $('#modalReportGeneral').modal('show');

}
function generatePDFReportPermiss(search, numRows, startDate, endDate) {
    // Definir la URL del script PHP
    var url = "report_permiss.php";
    // Crear la URL completa con el parámetro
    var fullUrl = url + "?search=" + encodeURIComponent(search.trim()) + "&numRows=" + encodeURIComponent(numRows) + 
    "&startDate=" + encodeURIComponent(startDate) + "&endDate=" + encodeURIComponent(endDate);
    
    // Actualizar la URL del iframe
    $('#pdfFramePermiss').attr('src', fullUrl);
    // Mostrar el modal
    $('#modalReportPermiss').modal('show');

}
function generatePDFReportDepartament(search, numRows) {
    // Definir la URL del script PHP
    var url = "report_departament.php";
    // Crear la URL completa con el parámetro
    var fullUrl = url + "?search=" + encodeURIComponent(search.trim()) + "&numRows=" + encodeURIComponent(numRows);
    
    // Actualizar la URL del iframe
    $('#pdfFrameDepartament').attr('src', fullUrl);
    // Mostrar el modal
    $('#modalReportDepartament').modal('show');

}
function generatePDFReportEmployee(search, numRows) {
    // Definir la URL del script PHP
    var url = "report_employee.php";
    // Crear la URL completa con el parámetro
    var fullUrl = url + "?search=" + encodeURIComponent(search.trim()) + "&numRows=" + encodeURIComponent(numRows);
    
    // Actualizar la URL del iframe
    $('#pdfFrameEmployee').attr('src', fullUrl);
    // Mostrar el modal
    $('#modalReportEmployee').modal('show');

}
function generatePDFCertificate(idEmployee, rmu) {
    // Definir la URL del script PHP
    var url = "report_certificate.php";
    // Crear la URL completa con el parámetro
    var fullUrl = url + "?idEmployee=" + encodeURIComponent(idEmployee) + "&rmu=" + encodeURIComponent(rmu);
    // Abrir una nueva ventana o pestaña del navegador con la URL completa
    window.open(fullUrl, "_blank");

}





