var inputs = document.querySelectorAll('input[name="email"]');

inputs.forEach(function(input) {
  input.addEventListener("input", function(event) {
    var inputValue = event.target.value;
    var emailPattern = /^[^\s@]+@iniap\.gob\.ec$/;

    if (emailPattern.test(inputValue)) {
      input.classList.remove("is-invalid");
    } else {
      input.classList.add("is-invalid");
    }
  });

  input.addEventListener("blur", function(event) {
    if (event.target.value === "") {
      event.target.classList.remove("is-invalid");
    }
  });
});



var inputs = document.querySelectorAll('input[name="numeric"]');

inputs.forEach(function(input) {
  input.addEventListener("input", function(event) {
    var inputValue = event.target.value;
    var numericPattern = /^[0-9]+$/;
    var maxLength = parseInt(input.getAttribute("maxlength"));

    if (!numericPattern.test(inputValue)) {
      input.value = inputValue.replace(/\D/g, '');
    }

    if (inputValue.length > maxLength) {
      input.value = inputValue.slice(0, maxLength);
    }
  });
});
var inputs = document.querySelectorAll('input[name="decimal"]');

inputs.forEach(function(input) {
  input.addEventListener("input", function(event) {
    var inputValue = event.target.value;
    var numericPattern = /^[0-9]*(\.[0-9]*)?$/; // Patrón para números enteros o decimales
    var maxLength = parseInt(input.getAttribute("maxlength"));

    if (!numericPattern.test(inputValue)) {
      input.value = inputValue.replace(/[^\d.]/g, ''); // Remueve cualquier caracter no numérico ni punto decimal
    }

    if (inputValue.length > maxLength) {
      input.value = inputValue.slice(0, maxLength);
    }
  });
});



var inputs = document.querySelectorAll('input[name="cedulaInput"]');

inputs.forEach(function(input) {
  input.addEventListener("input", function(event) {
    var inputValue = event.target.value;
    var numericPattern = /^[0-9]+$/;
    var maxLength = parseInt(input.getAttribute("maxlength"));

    if (!numericPattern.test(inputValue)) {
      input.value = inputValue.replace(/\D/g, '');
    }

    if (inputValue.length > maxLength) {
      input.value = inputValue.slice(0, maxLength);
    }

    if (!validateCedula(inputValue)) {
      input.classList.add("is-invalid");
    } else {
      input.classList.remove("is-invalid");
    }
  });

  input.addEventListener("blur", function(event) {
    if (event.target.value === "") {
      event.target.classList.remove("is-invalid");
    }
  });
});



var inputs = document.querySelectorAll('input[name="single-text"]');

inputs.forEach(function(input) {
  input.addEventListener("input", function(event) {
    var inputValue = event.target.value;
    var lettersAndSpacesPattern = /^[A-Za-z\sñáéíóúÁÉÍÓÚ]+$/;

    if (!lettersAndSpacesPattern.test(inputValue)) {
      input.value = inputValue.replace(/[^A-Za-z\sñáéíóúÁÉÍÓÚ]/g, '');
    }
  });
});

