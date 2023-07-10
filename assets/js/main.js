$(document).ready(function () {
  //Cargar Tablas

  $("#tableBalanceEmployee").load("./partials/tableBalanceEmployee.php");

  //Buscadores
  $("#search").load("./partials/search.php");
  $("#slotSearchEmployeePeriod").load("./partials/searchEmployeePeriod.php");
  $("#slotSearchEmployeeDiscountDay").load(
    "./partials/searchEmployeeDiscountDay.php"
  );
  $("#slotSearchEmployeeDiscountDate").load(
    "./partials/searchEmployeeDiscountDate.php"
  );
  $("#slotSearchEmployeePermissBack").load(
    "./partials/searchEmployeePermissBack.php"
  );
  $("#slotSearchEmployeeUser").load("./partials/searchEmployeeUser.php");
  $("#slotSearchDepartamentReport").load(
    "./partials/searchDepartamentReport.php"
  );
  $("#slotSearchEmployeeReport").load("./partials/searchEmployeeReport.php");

  //Ocultar botones
  $("#btnUpdateDepartament").hide();
  $("#btnUpdateReason").hide();
  $("#btnUpdateContractType").hide();
  $("#btnUpdateJobTitle").hide();

  //Configuración de Selector de hora  y minutos
  $('[name="timeSelector"]')
    .clockpicker({
      autoclose: true,
    })
    .change(function () {
      var time = $(this).val();
      var hrs = Number(time.substring(0, 2));
      var min = Number(time.substring(3, 5));
      var ampm = hrs >= 12 ? "pm" : "am";
      hrs = hrs % 12;
      hrs = hrs ? hrs : 12; // the hour '0' should be '12'
      min = min < 10 ? "0" + min : min;
      var strTime = hrs + ":" + min + " " + ampm;
      $(this).val(strTime);
    });

  //Configuracion de Selector de rango de fechas
  $(function () {
    //Funcion retorna la fecha de activacion para permisos atrasados
    getMinDate()
      .then(function (date) {
        var dateMoment = moment(date, "YYYY-MM-DD");
        // Nombre de input, fecha minima para escoger las fechas, rango de dias limite.
        initializeDateRangePicker("daterange", dateMoment, 6);
        initializeDateRangePicker("daterangeAdmin", null, null);
      })
      .catch(function (error) {
        console.log("Error:", error);
      });

    function initializeDateRangePicker(inputName, minDate, maxSelectableDays) {
      var options = {
        autoUpdateInput: false,
        timePicker: false,
        startDate: moment().startOf("hour"),
        endDate: moment().startOf("hour").add(32, "hour"),
        locale: {
          format: "DD/MM/YYYY",
          separator: " - ",
          applyLabel: "Aplicar",
          cancelLabel: "Quitar",
          fromLabel: "From",
          toLabel: "To",
          customRangeLabel: "Custom",
          daysOfWeek: ["do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
          monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
          ],
        },
      };

      if (minDate) {
        options.minDate = minDate;
      }

      var picker = $(`input[name="${inputName}"]`).daterangepicker(options);

      picker.attr("readonly", true);

      picker.on("apply.daterangepicker", function (ev, picker) {
        toastr.options.preventDuplicates = true;
        toastr.options.positionClass = "toast-bottom-right";
        toastr.options.closeButton = true;
        toastr.options.newestOnTop = false;
        toastr.options.timeOut = "5000";

        var start = picker.startDate;
        var end = picker.endDate;
        var diff = end.diff(start, "days");

        if (maxSelectableDays) {
          if (maxSelectableDays && diff > maxSelectableDays) {
            var extraDays = diff - maxSelectableDays;
            message = "Te has pasado por " + extraDays + " días.";
            toastr.error(message, "MENSAJE");
            //picker.clear();
          } else {
            picker.element.val(
              start.format("DD/MM/YYYY") + " - " + end.format("DD/MM/YYYY")
            );
            picker.updateElement();
          }
        } else {
          picker.element.val(
            start.format("DD/MM/YYYY") + " - " + end.format("DD/MM/YYYY")
          );
          picker.updateElement();
        }
      });

      picker.on("cancel.daterangepicker", function (ev, picker) {
        picker.element.val("");
        picker.updateElement();
      });
    }
  });

  //Configuración del Selector de Fecha Unica
  $(function () {
    //Funcion retorna la fecha de activacion para permisos atrasados
    getMinDate()
      .then(function (date) {
        var dateMoment = moment(date, "YYYY-MM-DD");
        // Nombre de input, fecha minima para escoger las fechas.
        initializeDateSelector("datesingle", dateMoment);
        initializeDateSelector("datesingleAdmin", null);
      })
      .catch(function (error) {
        console.log("Error:", error);
      });

    function initializeDateSelector(inputName, minDate) {
      var options = {
        singleDatePicker: true,
        autoUpdateInput: false,
        timePicker: false,
        startDate: moment(),
        drops: "auto", // Esta línea permite al plugin decidir donde mostrar el calendario.
        locale: {
          format: "DD/MM/YYYY",
          separator: " - ",
          applyLabel: "Aplicar",
          cancelLabel: "Quitar",
          fromLabel: "Desde",
          toLabel: "Hasta",
          customRangeLabel: "Personalizado",
          daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
          monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
          ],
        },
      };

      if (minDate) {
        options.minDate = minDate;
      }

      $('input[name="' + inputName + '"]').daterangepicker(options);

      $('input[name="' + inputName + '"]').prop("readonly", true);

      $('input[name="' + inputName + '"]').on(
        "apply.daterangepicker",
        function (ev, picker) {
          $(this).val(picker.startDate.format("DD/MM/YYYY"));
        }
      );

      $('input[name="' + inputName + '"]').on(
        "cancel.daterangepicker",
        function (ev, picker) {
          $(this).val("");
        }
      );
    }
  });

  //Enviar datos para Login
  $("#login").click(function () {
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var username = $("#username").val();
    var password = $("#password").val();
    if (username.trim() === "" || password.trim() === "") {
      toastr.error("Por favor, ingresa usuario y contraseña.");
    } else {
      enviarDatosLogin(username, password);
    }
  });

  $("#password").keyup(function (event) {
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    if (event.keyCode === 13) {
      var username = $("#username").val();
      var password = $("#password").val();

      if (username.trim() === "" || password.trim() === "") {
        toastr.error("Por favor, ingresa usuario y contraseña.");
      } else {
        enviarDatosLogin(username, password);
      }
    }
  });

  //Enviar datos para Gestión de Empleado/Usuario
  $("#guardarnuevo").click(function () {
    //toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idTipoCodigo = $("#idTipoCodigo").val();
    var idTipoContrato = $("#idTipoContrato").val();
    var idDepartamento = $("#idDepartamento").val();
    var idJobTitle = $("#idJobTitle").val();
    var cedulaEmpleado = $("#cedulaEmpleado").val();
    var nombreEmpleado = $("#nombreEmpleado").val();
    var apellidoEmpleado = $("#apellidoEmpleado").val();
    var fechaInicioLaboral = $("#fechaInicioLaboral").val();
    var telefonoEmpleado = $("#telefonoEmpleado").val();
    var direccionEmpleado = $("#direccionEmpleado").val();
    var emailEmpleado = $("#emailEmpleado").val();
    var salary = $("#salary").val();

    if (
      idTipoCodigo !== "" &&
      idTipoContrato !== "" &&
      idDepartamento !== "" &&
      idJobTitle !== "" &&
      cedulaEmpleado !== "" &&
      nombreEmpleado !== "" &&
      apellidoEmpleado !== "" &&
      fechaInicioLaboral !== "" &&
      telefonoEmpleado !== "" &&
      direccionEmpleado !== "" &&
      emailEmpleado !== "" &&
      salary !== ""
    ) {
      if (validateCedula(cedulaEmpleado.trim())) {
        var emailPattern = /^[^\s@]+@iniap\.gob\.ec$/;
        if (emailPattern.test(emailEmpleado)) {
          fechaInicioLaboral = moment(
            fechaInicioLaboral.trim(),
            "DD/MM/YYYY"
          ).format("YYYY-MM-DD");
          insertDataEmployee(
            idTipoCodigo,
            idTipoContrato,
            idDepartamento,
            idJobTitle,
            cedulaEmpleado,
            nombreEmpleado,
            apellidoEmpleado,
            fechaInicioLaboral,
            telefonoEmpleado,
            direccionEmpleado,
            emailEmpleado,
            salary
          );
        } else {
          toastr.error("El correo es incorrecto", "MENSAJE");
        }
      } else {
        toastr.error("El número de cédula es incorrecto", "MENSAJE");
      }
    } else {
      toastr.error("Ingrese todos los datos", "MENSAJE");
    }
  });
  $("#actualizadatos").click(function () {
    //toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idEmployee = $("#idEmployeeu").val();
    var idTipoCodigo = $("#idTipoCodigou").val();
    var idTipoContrato = $("#idTipoContratou").val();
    var idDepartamento = $("#idDepartamentou").val();
    var idJobTitle = $("#idJobTitleu").val();
    var cedulaEmpleado = $("#cedulaEmpleadou").val();
    var nombreEmpleado = $("#nombreEmpleadou").val();
    var apellidoEmpleado = $("#apellidoEmpleadou").val();
    var fechaInicioLaboral = $("#fechaInicioLaboralu").val();
    var telefonoEmpleado = $("#telefonoEmpleadou").val();
    var direccionEmpleado = $("#direccionEmpleadou").val();
    var emailEmpleado = $("#emailEmpleadou").val();
    var salary = $("#salaryu").val();

    if (
      idTipoCodigo !== "" &&
      idTipoContrato !== "" &&
      idDepartamento !== "" &&
      idJobTitle !== "" &&
      cedulaEmpleado !== "" &&
      nombreEmpleado !== "" &&
      apellidoEmpleado !== "" &&
      fechaInicioLaboral !== "" &&
      telefonoEmpleado !== "" &&
      direccionEmpleado !== "" &&
      emailEmpleado !== "" &&
      salary !== ""
    ) {
      if (validateCedula(cedulaEmpleado.trim())) {
        var emailPattern = /^[^\s@]+@iniap\.gob\.ec$/;
        if (emailPattern.test(emailEmpleado)) {
          fechaInicioLaboral = moment(
            fechaInicioLaboral.trim(),
            "DD/MM/YYYY"
          ).format("YYYY-MM-DD");
          updateDataEmployee(
            idEmployee,
            idTipoCodigo,
            idTipoContrato,
            idDepartamento,
            idJobTitle,
            cedulaEmpleado,
            nombreEmpleado,
            apellidoEmpleado,
            fechaInicioLaboral,
            telefonoEmpleado,
            direccionEmpleado,
            emailEmpleado,
            salary
          );
        } else {
          toastr.error("El correo es incorrecto", "MENSAJE");
        }
      } else {
        toastr.error("El número de cédula es incorrecto", "MENSAJE");
      }
    } else {
      toastr.error("Ingrese todos los datos", "MENSAJE");
    }
  });
  $("#btnChangePassword").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var passwordNow = $("#passwordNow").val();
    var passwordNew = $("#passwordNew").val();
    var confirmPasswordNew = $("#confirmPasswordNew").val();

    if (passwordNow !== "" && passwordNew !== "" && confirmPasswordNew !== "") {
      if (passwordNew === confirmPasswordNew) {
        changePasswordUser(passwordNow, passwordNew, confirmPasswordNew);
      } else {
        toastr.error("La clave nueva no coincide", "MENSAJE");
      }
    } else {
      toastr.error("Ingrese todos los datos", "MENSAJE");
    }
  });
  $("#btnEmployeeUser").click(function () {
    //toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idEmployee = $("#searchEmployeeUser").val();
    var cedulaEmpleado = $("#cedulaEmployeeUser").val();
    var password = $("#passwordUser").val();
    var typeUser = $("#idTypeUser").val();

    var checkboxElement = document.getElementById("chPassDefault");

    if (typeUser != null) {
      if (checkboxElement.checked) {
        password = cedulaEmpleado;
        insertUser(idEmployee, typeUser, password);
      } else {
        if (password !== "") {
          insertUser(idEmployee, typeUser, password);
        } else {
          toastr.error("Ingrese la clave", "MENSAJE");
        }
      }
    } else {
      toastr.error("Seleccione un tipo de usuario", "MENSAJE");
    }
  });
  $("#btnEmployeeUseru").click(function () {
    //toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idUser = $("#idUserSelected").val();
    var typeUser = $("#idTypeUseru").val();
    var password = $("#passwordUseru").val();

    if (password !== "") {
      updateUser(idUser, typeUser, password);
    } else {
      toastr.error("Ingrese una clave", "MENSAJE");
    }
  });

  //Enviar datos para Gestión de Departamentos
  $("#btnAddDepartament").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var name = $("#nameDepartament").val();

    if (name !== "") {
      insertDepartament(name);
    } else {
      toastr.error("Ingrese un nombre de departamento", "MENSAJE");
    }
  });
  $("#btnUpdateDepartament").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var id = $("#idDepartament").val();
    var name = $("#nameDepartament").val();

    if (name !== "") {
      updateDepartament(id, name);
      $("#btnAddDepartament").show();
      $("#btnUpdateDepartament").hide();
    } else {
      toastr.error("Ingrese un nombre de departamento", "MENSAJE");
    }
  });

  //Enviar datos para Gestión de Razon de Permiso
  $("#btnAddReason").click(function () {
    var name = $("#nameReason").val();
    insertReason(name);
  });
  $("#btnUpdateReason").click(function () {
    var id = $("#idReason").val();
    var name = $("#nameReason").val();
    updateReason(id, name);
    $("#btnAddReason").show();
    $("#btnUpdateReason").hide();
  });

  //Enviar datos para Gestión de Tipos de Contrato
  $("#btnAddContractType").click(function () {
    var name = $("#nameContractType").val();
    insertContractType(name);
  });
  $("#btnUpdateContractType").click(function () {
    var id = $("#idContractType").val();
    var name = $("#nameContractType").val();
    updateContractType(id, name);
    $("#btnAddContractType").show();
    $("#btnUpdateContractType").hide();
  });
  //Enviar datos para Gestión de Cargos
  $("#btnAddJobTitle").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var name = $("#nameJobTitle").val();

    if (name !== "") {
      insertJobTitle(name);
    } else {
      toastr.error("Ingrese un nombre de Cargo", "MENSAJE");
    }
  });
  $("#btnUpdateJobTitle").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var id = $("#idJobTitle").val();
    var name = $("#nameJobTitle").val();

    if (name !== "") {
      updateJobTitle(id, name);
      $("#btnAddJobTitle").show();
      $("#btnUpdateJobTitle").hide();
    } else {
      toastr.error("Ingrese un nombre de Cargo", "MENSAJE");
    }
  });

  //Enviar datos para Gestion de permisos - EMPLEADO
  $("#btnSendRequestPermissDate").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idEmployee = $("#idEmployee").val();
    var idReason = $("#selectReason").val();
    var rangeDate = $("#rangeDate").val();
    var observation = $("#txtObservation").val();
    if (
      idEmployee != 0 &&
      rangeDate !== "" &&
      idReason !== "" &&
      observation !== ""
    ) {
      dates = rangeDate.split("-");
      startDate = moment(dates[0].trim(), "DD/MM/YYYY").format("YYYY-MM-DD");
      endDate = moment(dates[1].trim(), "DD/MM/YYYY").format("YYYY-MM-DD");

      var datos =
        idEmployee +
        "||" +
        idReason +
        "||" +
        startDate +
        "||" +
        endDate +
        "||" +
        observation;
      yesOrNoQuestionSendPermiss(datos);
    } else {
      toastr.error("Ingrese todos los datos", "MENSAJE");
    }
  });
  $("#btnSendRequestPermissDay").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idEmployee = $("#idEmployee").val();
    var timeStart = $("#timeStart").val();
    var timeEnd = $("#timeEnd").val();
    var dateDay = $("#dateDay").val();
    var idReason = $("#selectReasonDay").val();
    var observation = $("#observationDay").val();
    if (
      idEmployee != 0 &&
      dateDay !== "" &&
      timeStart !== "" &&
      timeEnd !== "" &&
      idReason !== "" &&
      observation !== ""
    ) {
      dateDay = moment(dateDay, "DD/MM/YYYY").format("YYYY-MM-DD");
      timeStart = convertirFormatoAMPMa24Horas(timeStart);
      timeEnd = convertirFormatoAMPMa24Horas(timeEnd);

      var startDate = dateDay + " " + timeStart;
      var endDate = dateDay + " " + timeEnd;

      var datos =
        idEmployee +
        "||" +
        idReason +
        "||" +
        startDate +
        "||" +
        endDate +
        "||" +
        observation;
      yesOrNoQuestionSendPermiss(datos);
    } else {
      toastr.error("Ingrese todos los datos", "MENSAJE");
    }
  });

  //Enviar datos para Permiso de Descuento - ADMIN
  $("#btnEmployeeDiscountDate").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idEmployee = $("#idEmployee_discountDate").val();
    var idReason = $("#selectReasonDiscountDate").val();
    var rangeDate = $("#rangeDateDiscountDate").val();
    var observation = $("#txtObservationDiscountDate").val();

    if (idEmployee != 0) {
      if (rangeDate !== "" && idReason !== "" && observation !== "") {
        var dates = rangeDate.split("-");
        var startDate = moment(dates[0].trim(), "DD/MM/YYYY").format(
          "YYYY-MM-DD"
        );
        var endDate = moment(dates[1].trim(), "DD/MM/YYYY").format(
          "YYYY-MM-DD"
        );

        var datos =
          idEmployee +
          "||" +
          idReason +
          "||" +
          startDate +
          "||" +
          endDate +
          "||" +
          observation;
        yesOrNoQuestionSendPermiss(datos);
      } else {
        toastr.error("Ingrese todos los datos", "MENSAJE");
      }
    } else {
      toastr.error("Seleccione un empleado", "MENSAJE");
    }
  });
  $("#btnEmployeeDiscountDay").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idEmployee = $("#idEmployee_discountDay").val();
    var timeStart = $("#timeStartDiscountDay").val();
    var timeEnd = $("#timeEndDiscountDay").val();
    var dateDay = $("#dateDiscountDay").val();
    var idReason = $("#selectReasonDiscountDay").val();
    var observation = $("#observationDiscountDay").val();

    if (idEmployee != 0) {
      if (
        timeStart !== "" &&
        timeEnd !== "" &&
        dateDay !== "" &&
        idReason !== "" &&
        observation !== ""
      ) {
        dateDay = moment(dateDay, "DD/MM/YYYY").format("YYYY-MM-DD");
        timeStart = convertirFormatoAMPMa24Horas(timeStart);
        timeEnd = convertirFormatoAMPMa24Horas(timeEnd);

        var startDate = dateDay + " " + timeStart;
        var endDate = dateDay + " " + timeEnd;

        var datos =
          idEmployee +
          "||" +
          idReason +
          "||" +
          startDate +
          "||" +
          endDate +
          "||" +
          observation;
        yesOrNoQuestionSendPermiss(datos);
      } else {
        toastr.error("Ingrese todos los datos", "MENSAJE");
      }
    } else {
      toastr.error("Seleccione un empleado", "MENSAJE");
    }
  });

  //Enviar datos para Vacaciones - ADMIN
  $("#btnSendRequestPermissDateVacation").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idEmployee = $("#buscadorvivo").val();
    var idReason = $("#selectReasonVacation").val();
    var rangeDate = $("#rangeDateVacation").val();
    var observation = $("#observationVacation").val();

    if (
      idEmployee !== "" &&
      idReason !== "" &&
      rangeDate !== "" &&
      observation !== ""
    ) {
      dates = rangeDate.split("-");
      startDate = moment(dates[0].trim(), "DD/MM/YYYY").format("YYYY-MM-DD");
      endDate = moment(dates[1].trim(), "DD/MM/YYYY").format("YYYY-MM-DD");

      var datos =
        idEmployee +
        "||" +
        idReason +
        "||" +
        startDate +
        "||" +
        endDate +
        "||" +
        observation;

      yesOrNoQuestionSendPermiss(datos);
    } else {
      toastr.error("Ingrese todos los datos", "MENSAJE");
    }
  });

  //Enviar datos para validar permiso - ADMIN
  $("#btnConfirmPermiss").click(function () {
    //toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idPermiss = $("#idPermiss").val();
    var message = $("#observationAdmin").val();
    var validateCheckbox = $("#chStatePermissValidate").prop("checked");
    var rejectCheckbox = $("#chStatePermissReject").prop("checked");

    if (idPermiss != 0) {
      if (validateCheckbox || rejectCheckbox) {
        var state = validateCheckbox ? "V" : "R";
        if (message.trim() != "") {
          updateStatePermiss(idPermiss, state, message);
        } else {
          toastr.error("Escriba alguna observación", "MENSAJE");
        }
      } else {
        toastr.error("Seleccione una acción", "MENSAJE");
      }
    } else {
      toastr.error("No hay permiso seleccionado", "MENSAJE");
    }
  });

  //Enviar datos para Gestión de Periodos - ADMIN
  $("#btnGeneratePeriods").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    idEmployee = $("#idEmployeeSelectedPeriod").val();
    checkbox = document.getElementById("chExtraPeriod");
    isChecked = checkbox.checked;
    if (isChecked) {
      insertNextVacationPeriod(idEmployee);
    } else {
      insertVacationPeriod(idEmployee);
    }
  });
  $("#btnOptionsPeriod").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    idEmployee = $("#idEmployeeSelectedPeriod").val();
    if (idEmployee != 0) {
      var cadena = "id=" + idEmployee;
      $.ajax({
        type: "POST",
        data: cadena,
        dataType: "json",
        url: "./assets/php/getDataEmployee.php",
        success: function (response) {
          $("#cedulaEmployeePeriod").val(response.ci_employee);
          $("#nameEmployeePeriod").val(response.name_employee);
          $("#lastNameEmployeePeriod").val(response.lastName_employee);
          $("#departamentEmployeePeriod").val(response.name_departament);
          $("#startDateEmployeePeriod").val(response.startDate_employee);
        },
        error: function (xhr, status, error) {
          // Manejar errores de la solicitud Ajax
          console.log("Error en la solicitud Ajax:", error);
        },
      });
      $("#modalEmployeePeriod").modal("show");
    } else {
      toastr.error("Seleccione un empleado", "MENSAJE");
    }
  });
  $("#btnUpadatePeriod").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    idPeriod = $("#idPeriod").val();
    startDate = $("#startDatePeriod").val();
    endDate = $("#endDatePeriod").val();
    earndDays = $("#earnDaysPeriod").val();
    workingDays = $("#workingDaysPeriod").val();
    weekendDays = $("#weekendDaysPeriod").val();
    balanceDays = $("#balanceDaysPeriod").val();
    statePeriod = $("#selectStatePeriod").val();

    if (
      idPeriod !== "" &&
      startDate !== "" &&
      endDate !== "" &&
      earndDays !== "" &&
      balanceDays !== "" &&
      workingDays !== "" &&
      weekendDays !== ""
    ) {
      startDate = moment(startDate.trim(), "DD/MM/YYYY").format("YYYY-MM-DD");
      endDate = moment(endDate.trim(), "DD/MM/YYYY").format("YYYY-MM-DD");
      // Validar fecha de inicio anterior a la fecha final
      startDateObj = new Date(startDate);
      endDateObj = new Date(endDate);

      if (startDateObj < endDateObj) {
        // Validar duración del rango de fechas de 1 año menos 1 día
        oneYearMs = 365 * 24 * 60 * 60 * 1000; // Un año en milisegundos
        oneDayMs = 24 * 60 * 60 * 1000; // Un día en milisegundos
        dateDifference = endDateObj.getTime() - startDateObj.getTime();

        if (dateDifference >= oneYearMs - oneDayMs) {
          updatePeriodVacation(
            idPeriod,
            startDate,
            endDate,
            earndDays,
            balanceDays,
            workingDays,
            weekendDays,
            statePeriod
          );
        } else {
          toastr.error(
            "El rango de fechas debe ser de 1 año menos 1 día",
            "MENSAJE"
          );
        }
      } else {
        toastr.error(
          "La fecha de inicio debe ser anterior a la fecha final",
          "MENSAJE"
        );
      }
    } else {
      toastr.error("Ingrese todos los datos", "MENSAJE");
    }
  });

  //Enviar datos para habilitar fecha de permiso atrasado - ADMIN
  $("#btnEmployeePermissBack").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idEmployee = $("#searchEmployeePermissBack").val();
    var datePermissBack = $("#datePermissBack").val();
    var statePermissBack = $("#selectStatePermissBack").val();
    if (datePermissBack !== "") {
      datePermissBack = moment(datePermissBack, "DD/MM/YYYY").format(
        "YYYY-MM-DD"
      );
      insertPermissBack(idEmployee, datePermissBack, statePermissBack);
    } else {
      toastr.error("Ingrese la fecha", "MENSAJE");
    }
  });
  $("#btnEmployeePermissBacku").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idPermissBack = $("#idPermissBack").val();
    var datePermissBack = $("#datePermissBacku").val();
    var statePermissBack = $("#selectStatePermissBacku").val();
    alert(datePermissBack);
    if (datePermissBack !== "") {
      datePermissBack = moment(datePermissBack, "DD/MM/YYYY").format(
        "YYYY-MM-DD"
      );
      updatePermissBack(idPermissBack, datePermissBack, statePermissBack);
    } else {
      toastr.error("Ingrese la fecha", "MENSAJE");
    }
  });

  //Enviar datos para subir logos
  $("#btnUploadMainLogo").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var file = $("#fileMainLogo").prop("files")[0]; // Obtenemos el primer archivo seleccionado
    var nameFile = "Logo";

    if (file) {
      uploadImage(file, nameFile);
    } else {
      toastr.error("Seleccione una imagen", "MENSAJE");
    }
  });
  $("#btnUploadLogoHeader").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var file = $("#fileLogoHeader").prop("files")[0]; // Obtenemos el primer archivo seleccionado
    var nameFile = "Logo_header";

    if (file) {
      uploadImage(file, nameFile);
    } else {
      toastr.error("Seleccione una imagen", "MENSAJE");
    }
  });
  $("#btnUploadLogoFooter").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var file = $("#fileLogoFooter").prop("files")[0]; // Obtenemos el primer archivo seleccionado
    var nameFile = "Logo_footer";

    if (file) {
      uploadImage(file, nameFile);
    } else {
      toastr.error("Seleccione una imagen", "MENSAJE");
    }
  });

  //Enviar parametros para Reporte PDF
  $("#btnReportGeneral").click(function () {
    var search = $("#campo").val();
    var numRows = $("#num_registros").val();
    generatePDFReportGeneral(search, numRows);
  });
  $("#btnReportPermiss").click(function () {
    var search = $("#campo").val();
    var numRows = $("#num_registros").val();
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();
    generatePDFReportPermiss(search, numRows, startDate, endDate);
  });
  $("#btnReportDepartament").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var search = $("#searchDepartamentReport").val();
    var numRows = $("#num_registros").val();

    if (search != 0) {
      generatePDFReportDepartament(search, numRows);
    } else {
      toastr.error("Seleccione un Departamento", "MENSAJE");
    }
  });
  $("#btnReportEmployee").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var search = $("#searchEmployeeReport").val();
    var numRows = $("#num_registros").val();
    if (search != 0) {
      generatePDFReportEmployee(search, numRows);
    } else {
      toastr.error("Seleccione un Empleado", "MENSAJE");
    }
  });
  $("#btnGenerateCertificate").click(function () {
    toastr.options.preventDuplicates = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.closeButton = true;

    var idEmployee = $("#idEmployeeSelectedRow").val();
    var rmu = $("#chRMU").prop("checked");
    
    if (idEmployee != 0) {
      generatePDFCertificate(idEmployee, rmu);
    } else {
      toastr.error("Seleccione un Empleado", "MENSAJE");
    }
  });

});
