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
            success: function(response) 
            {
                if (response) {
                    // Clear existing appointments (if there are any)
                    $("#appointments").empty();

                    // Get today's date
                    let today = new Date(); // Date() with no parameters constructs a new Date object with the current date

                    // Append each appointment to the list
                    response.forEach(function(appt, i) 
                    {
                        let currentExpiryDate = new Date(appt.expired);
                        if(today.getTime() < currentExpiryDate.getTime()) // If the appointment has not expired, it is selectable (getTime() gets epoch time in seconds)
                        {
                            $("#appointments").append
                            (
                                "<li class='list-group-item'>" +
                                    "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + appt.id + "'>" +
                                    "<label class='form-check-label' for='appointment" + appt.id + "' id='appointmentLabel" + appt.id + "'>#" + appt.id + " | Name: " + appt.name + ", Author: " + appt.author + "</label>" + 
                                "</li>"
                            );
                        }
                        else // Otherwise it is disabled and marked as "(Expired)"
                        {
                            $("#appointments").append
                            (
                                "<li class='list-group-item'>" +
                                    "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + appt.id + "' disabled>" +
                                    "<label class='form-check-label' for='appointment" + appt.id + "' id='appointmentLabel" + appt.id + "'>#" + appt.id + " | Name: " + appt.name + ", Author: " + appt.author + " (Expired)</label>" + 
                                "</li>"
                            );
                        }

                        // Appends appointment dates of this appointment
                        /* appendAppointmentDates(appt.id); */
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
                                if (dates && dates.dates) 
                                {
                                    // Update UI with fetched dates (e.g., display in a modal)
                                    console.log("Dates for appointment #" + appt.id + ":", dates.dates);
                                    
                                    // Create new list for this appointment's dates
                                    $("#appointmentLabel" + appt.id).append
                                    (
                                        "<ul class='list-group' id='appointmentDates" + appt.id + "'</ul>"
                                    );
                
                                    // Append everything to the list item
                                    dates.forEach(function(dates, i)
                                    {
                                        $("#appointmentDates" + appt.id).append
                                        (
                                            "<li class='list-group-item'>" + 
                                                "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + appt.id + "date" + i + "'>" + 
                                                "<label class='form-check-label' for='appointment" + appt.id + "date" + i + "'>" + dates[i].day + ", " + dates[i].starttime + " - " + dates[i].endtime + "</label>" + 
                                            "</li>"
                                        );
                                    });
                
                                }
                                else 
                                {
                                    console.log("No dates found for appointment #" + appt.id);
                                }
                            },
                            error: function(dates) 
                            {
                                console.error("Error fetching appointment dates:", dates);
                            }
                        });

                        /*
                        // Toggle behavior when appointment is clicked
                        $("#appointmentLabel" + appt.id).on("click", function() 
                        {
                        $("#appointment" + appt.id + "date" + ???).toggle(); // Toggle visibility
                        });
                        */
                      
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

    /*
    // Fetch appointment dates
    function appendAppointmentDates(apptID) 
    {
        $.ajax({
            url: "../backend/api/api.php",
            type: "POST",
            data: 
            JSON.stringify({
                action: "getAppointmentDates",
                appointmentId: apptID
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(dates) 
            {
                if (dates && dates.dates) 
                {
                    // Update UI with fetched dates (e.g., display in a modal)
                    console.log("Dates for appointment #" + apptID + ":", dates.dates);
                    
                    // Create new list for this appointment's dates
                    $("#appointmentLabel" + apptID).append
                    (
                        "<ul class='list-group' id='appointmentDates" + apptID + "'</ul>"
                    );

                    // Append everything to the list item
                    dates.forEach(function(dates, i)
                    {
                        $("#appointmentDates" + apptID).append
                        (
                            "<li class='list-group-item'>" + 
                                "<input class='form-check-input me-1' type='checkbox' value='' id='appointment" + apptID + "date" + i + "'>" + 
                                "<label class='form-check-label' for='appointment" + apptID + "date" + i + "'>" + dates[i].day + ", " + dates[i].starttime + " - " + dates[i].endtime + "</label>" + 
                            "</li>"
                        );
                    });

                }
                else 
                {
                    console.log("No dates found for appointment #" + apptID);
                }
            },
            error: function(dates) 
            {
                console.error("Error fetching appointment dates:", dates);
            }
        });
    }
    */
});
