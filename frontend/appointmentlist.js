$(function () {
    // Clicking the load button
    $("#btnLoad").click(function() {
        loadAppointments();
    });

    // Loading the appointments
    function loadAppointments() {
        $.ajax({
            url: "../backend/api/api.php",
            type: "POST",
            data: JSON.stringify({
                action: "getAllAppointments"
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(response) {
                if (response) {
                    // Clear existing appointments (if any)
                    $("#appointments").empty();

                    // Append each appointment to the list
                    response.forEach(function(appointment) {
                        const listItem = $("<li>").addClass("list-group-item").text(`${appointment.name}, ${appointment.author}`);
                        $("#appointments").append(listItem);
                    });
                } else {
                    console.log("No appointments found.");
                }
            },
            error: function(response) {
                console.error("Error fetching appointments:", response);
            }
        });
    }
});
