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
        $.ajax
        ({
            type: "GET", // HTTP method to be used
            url: "../backend/api/api.php", // Target URL to which the HTTP request is sent
            cache: false, // false forces that requested pages are not cached by the browser
            data: {"action": "getAppointment"}, // Data to be sent to the server
            dataType: "json", // Data type expected to be received from the server
            success: function(response) // Function to be executed if the HTTP request is successful
            {
                console.log("Ajax succeded", response);
                data = response;

                // The fetched appointments are appended to the appointments element
                $.each(data, function(i, appt) // For each appointment fetched, a checkbox item is appended to the list
                {
                    if(appt.expired === 0) // If the appointment has not expired, it is selectable
                    {
                        $("#appointments").append
                        (
                            "<li class='list-group-item'>" +
                                "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + i + "'>" +
                                "<label class='form-check-label' for='appointment" + i + "'>" + appt.day + "." + appt.month + "." + appt.year + ", " + appt.startTime + " - " + appt.endTime + "</label>" + 
                            "</li>"
                        );
                    }
                    else // Otherwise it is disabled and marked as "(Expired)"
                    {
                        $("#appointments").append
                        (
                            "<li class='list-group-item'>" +
                                "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + i + "' disabled>" +
                                "<label class='form-check-label' for='appointment" + i + "'>" + appt.day + "." + appt.month + "." + appt.year + ", " + appt.startTime + " - " + appt.endTime + "(Expired)</label>" + 
                            "</li>"
                        );
                    }
                    i++;
                });
            },
            error: function(response) // Function to be executed if the HTTP request fails
            { 
                console.error("ERROR", response);
            }            
        });
    }
});

