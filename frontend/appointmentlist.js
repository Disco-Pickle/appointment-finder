$(function () 
{
    // Clicking the load button
    $("#btnLoad").click(function() 
    {
        loadAppointments();
    });

    // Loading the appointments
    let data = null;
    let amountAppointments;
    function loadAppointments() 
    {    
        // Data is fetched via AJAX calls
// Function to fetch appointment data for a given ID
function fetchAppointmentData(appointmentId) {
    $.ajax({
        url: "../backend/api/api.php",
        type: "POST",
        data: JSON.stringify({
            action: "getAppointment",
            appointmentId: appointmentId
        }),
        contentType: "application/json", // Set the content type to JSON
        dataType: "json",
        success: function(response) {
            if (response) {
                // Handle the response (e.g., append to the list of appointments)
                console.log("Appointment data for ID " + appointmentId, response);
                // Append the data to your list of appointments
                // ...
                // Continue fetching next appointment
                fetchAppointmentData(appointmentId + 1);
            } else {
                // No valid response, stop fetching
                console.log("No more appointments found.");
            }
        },
        error: function(response) {
            console.error("Error fetching appointment data for ID " + appointmentId, response);
        }
    });
}


// Start fetching appointments from ID 1
fetchAppointmentData(1);

    }
});

