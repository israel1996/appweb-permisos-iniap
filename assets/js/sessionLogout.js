// Initialize the timeout variable
var tiempoInactivo;

// Set the timeout, in milliseconds
var tiempoLimite = 30 * 60 * 1000;  // 30 minutes

// List of events that are considered as activity
var events = ['load', 'mousemove', 'mousedown', 'click', 'scroll', 'keypress', 'touchstart'];

// This function will be called when the user has been active
function resetTimer() {
    // Clear the previous set timeout
    clearTimeout(tiempoInactivo);

    // Set a new timeout
    tiempoInactivo = setTimeout(redireccionar, tiempoLimite);
}

// This function will be called when the user has been inactive
function redireccionar() {
    // Use fetch API to logout
    fetch('assets/php/logout.php')
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        // Redirect to login page
        window.location.href = 'login.php';
    })
    .catch(function(error) {
        console.error('There has been a problem with your fetch operation: ', error);
    });
}

// Add the event listeners
for (var i in events) {
    window.addEventListener(events[i], resetTimer);
}
