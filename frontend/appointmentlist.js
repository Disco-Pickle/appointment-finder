$(function () {
    // Clicking the load button
    $("#btnLoad").click(function() 
    {
        loadAppointments();
    });

    // Loading the appointments
    function loadAppointments() 
    {
        $.ajax({
            url: "../backend/api/api.php",
            type: "POST",
            data: 
            JSON.stringify({
                action: "getAllAppointments"
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(response) 
            {
                if (response) {
                    // Clear existing appointments (if there are any)
                    $("#appointments").empty();

                    // Append each appointment to the list
                    response.forEach(function(appt, i) 
                    {
                        if(appt.expired === 0) // If the appointment has not expired, it is selectable
                        {
                            $("#appointments").append
                            (
                                "<li class='list-group-item'>" +
                                    "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + appt.id + "'>" +
                                    "<label class='form-check-label' for='appointment" + appt.id + "'>#" + appt.id + " | Name: " + appt.name + ", Author: " + appt.author + "</label>" + 
                                "</li>"
                            );
                        }
                        else // Otherwise it is disabled and marked as "(Expired)"
                        {
                            $("#appointments").append
                            (
                                "<li class='list-group-item'>" +
                                    "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + appt.id + "' disabled>" +
                                    "<label class='form-check-label' for='appointment" + appt.id + "'>#" + appt.id + " | Name: " + appt.name + ", Author: " + appt.author + " (Expired)</label>" + 
                                "</li>"
                            );
                        }
                    });
                }
                else 
                {
                    console.log("No appointments found.");
                }
            },
            error: function(response) {
                console.error("Error fetching appointments:", response);
            }
        });
    }

    // Loading the dates of an appointment
    function loadDates()
    {
        
    }
});
