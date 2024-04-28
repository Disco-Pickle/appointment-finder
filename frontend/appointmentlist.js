$(function () {
    // Clicking the load button
    $("#btnLoad").click(function() {
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
            success: function(appointments) 
            {
                if (appointments) {
                    // Clear existing appointments (if there are any)
                    $("#appointments").empty();

                    // Get today's date
                    let today = new Date(); // Date() with no parameters constructs a new Date object with the current date

                    // If the appointment has not expired, it is selectable 
                    appointments.forEach(function(appt, i) 
                    {
                        let currentExpiryDate = new Date(appt.expired);
                        if(today.getTime() < currentExpiryDate.getTime()) // getTime() gets epoch time in seconds
                        {
                            $("#appointments").append
                            (
                                "<li class='list-group-item'>" +
                                    "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + appt.id + "'>" +
                                    "<label class='form-check-label' for='appointment" + appt.id + "' id='appointmentLabel" + appt.id + "'>#" + appt.id + " | " + appt.name + " (by " + appt.author + ")</label>" + 
                                "</li>"
                            );

                            // Appends appointment dates of this appointment
                            $.ajax({
                                url: "../backend/api/api.php",
                                type: "POST",
                                data: 
                                JSON.stringify({
                                    action: "getAppointmentDates",
                                    appointmentId: appt.id
                                }),
                                contentType: "application/json",
                                dataType: "json",
                                success: function(dates) 
                                {
                                    console.log("Dates for appointment #" + appt.id + ":", dates);
                                    
                                    // Create new list for this appointment's dates
                                    $("#appointmentLabel" + appt.id).append
                                    (
                                        "<ul class='list-group' id='appointmentDates" + appt.id + "'</ul>"
                                    );
                
                                    // Append everything to the list item
                                    dates.forEach(function(date, i)
                                    {
                                        $("#appointmentDates" + appt.id).append
                                        (
                                            "<li class='list-group-item'>" + 
                                                "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + appt.id + "date" + i + "'>" + 
                                                "<label class='form-check-label' for='appointment" + appt.id + "date" + i + "'>" + date.day + ", " + date.starttime + " - " + date.endtime + "</label>" + 
                                            "</li>"
                                        );
                                    });
                                },
                                error: function(dates) 
                                {
                                    console.error("Error fetching appointment dates:", dates);
                                }
                            });
                        }                     
                    });

                    // // If the appointment expired, it is disabled and marked as "(Expired)"
                    appointments.forEach(function(appt, i)
                    {
                        let currentExpiryDate = new Date(appt.expired);
                        if(today.getTime() >= currentExpiryDate.getTime())
                        {
                            $("#appointments").append
                            (
                                "<li class='list-group-item'>" +
                                    "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + appt.id + "' disabled>" +
                                    "<label class='form-check-label' for='appointment" + appt.id + "' id='appointmentLabel" + appt.id + "'>#" + appt.id + " | " + appt.name + " (by " + appt.author + ", expired)</label>" + 
                                "</li>"
                            );
                        } 
                    })
                }
                else 
                {
                    console.log("No appointments found.");
                }
            },
            error: function(appointments) {
                console.error("Error fetching appointments:", appointments);
            }
        });
    }
});

