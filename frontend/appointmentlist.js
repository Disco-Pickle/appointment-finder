$(function () {
    // Clicking the load button
    $("#btnLoad").click(function() 
    {
        loadAppointments();
    });

    // Loading the appointments
    function loadAppointments() 
    {
        $.ajax
        ({
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
                if(appointments) 
                {
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
                                    "<p class='d-inline-flex gap-1'>" +
                                        "<button class='btn btn-primary' type='button' data-bs-toggle='collapse' data-bs-target='#appointmentCollapse" + appt.id + "'>#" + appt.id + " | " + appt.name + " (by " + appt.author + ")</button>" +  
                                    "</p>" + 
                                    "<div class='collapse' id='appointmentCollapse" + appt.id + "'>" +  
                                        "<label class='col-form-label' for='appointment" + appt.id + "' id='appointmentLabel" + appt.id + "'>#" + appt.id + " | " + appt.name + " (by " + appt.author + ")</label>" + 
                                    "</div>" + 
                                "</li>"
                            );

                            // Appends appointment dates of this appointment
                            $.ajax
                            ({
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
                                    let amtDates = 0; // Counts amount of dates
                                    dates.forEach(function(date, i)
                                    {
                                        $("#appointmentDates" + appt.id).append
                                        (
                                            "<li class='list-group-item'>" + 
                                                "<input class='form-check-input me-1' type='checkbox' value='true' id='appointment" + appt.id + "date" + i + "' data-dateid='" + date.id + "'>" + 
                                                "<label class='form-check-label' for='appointment" + appt.id + "date" + i + "'>" + date.day + ", " + date.starttime + " - " + date.endtime + " (" + date.personCount + " confirmation(s))" + "</label>" + 
                                            "</li>"
                                        );
                                        amtDates++;
                                    });

                                    // Appends input field for name and a button for confirming datees to this appointment
                                    $("#appointmentLabel" + appt.id).append
                                    (
                                        "<div class='form-floating'>" + 
                                            "<input type='text' class='form-control' name='attendeeName" + appt.id + "' id='attendeeName" + appt.id + "' placeholder='Your name'>" + 
                                            "<label for='attendeeName" + appt.id + "'>Your name</label>" + 
                                        "</div>" +
                                        "<hr>" + 
                                        "<button class='btn btn-success btnConfirmDates' data-apptid='" + appt.id + "' data-amtdates='" + amtDates + "'>Confirm Dates</button>"
                                    ); 
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
                                    "<input class='form-check-input me-1' type='checkbox' value='1' id='appointment" + appt.id + "' disabled>" +
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
            error: function(appointments) 
            {
                console.error("Error fetching appointments:", appointments);
            }
        });
    }

    // Clicking the confirm button
    $(document).on("click", ".btnConfirmDates", function() // "btnConfirmDates" is defined as a class instead of as an id to allow attaching this function to all buttons without a loop
    {
        let apptID = $(this).data("apptid"); // The data attributes are used to get the necessary parameters for confirmDates
        let amtDates = $(this).data("amtdates");
        confirmDates(apptID, amtDates);
    });

    // Sending the dates associated with the name to the DB
    function confirmDates(apptID, amtDates)
    {
        let person = $("#attendeeName" + apptID).val();

        for(let i = 0; i < amtDates; i++)
        {
            // Get status of checkbox of current date (boolean)
            let transmitDate = $("#appointment" + apptID + "date" + i).prop('checked');
            
            // If checkbox was checked, name is appended to the date entry in the DB
            if(transmitDate && person != "")
            {
                $.ajax
                ({
                    url: "../backend/api/api.php",
                    type: "POST",
                    data: 
                    JSON.stringify({
                        action: "insertPerson",
                        dateId: $("#appointment" + apptID + "date" + i).data("dateid"),
                        persons: [person]
                    }),
                    contentType: "application/json",
                    dataType: "json",
                    success: function(response)
                    {
                        console.log("Persons added to specified dates", response);
                        location.reload();

                    },
                    error: function(response)
                    {
                        console.log("ERROR: Adding persons to specified dates failed", response);
                    }
                });
            }
        }
    }
});