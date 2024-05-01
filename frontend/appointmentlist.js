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
                                                "<label class='form-check-label' for='appointment" + appt.id + "date" + i + "'>" + date.day + ", " + date.starttime + " - " + date.endtime + " (" + date.personCount + " prs.)" + "</label>" + 
                                            "</li>"
                                        );
                                        amtDates++; // Increment amtDates so the confirm button can receive its data attribute containing this information
                                    });

                                    // Appends input field for name, a button for confirming datees, and a button for deleting the appt to this appointment
                                    $("#appointmentLabel" + appt.id).append
                                    (
                                        "<div class='form-floating'>" + 
                                            "<input type='text' class='form-control' name='attendeeName" + appt.id + "' id='attendeeName" + appt.id + "' placeholder='Your name'>" + 
                                            "<label for='attendeeName" + appt.id + "'>Your name</label>" + 
                                        "</div>" +
                                        "<hr>" + 
                                        "<button class='btn btn-success btnConfirmDates' data-apptid='" + appt.id + "' data-amtdates='" + amtDates + "'>Confirm Dates</button> " + 
                                        "<button class='btn btn-danger btnDeleteAppt' data-apptid='" + appt.id + "'>Delete Appointment</button>"
                                    );
                                    
                                    // Appends the comment section
                                    $.ajax
                                    ({
                                        url: "../backend/api/api.php",
                                        type: "POST",
                                        data: 
                                        JSON.stringify({
                                            action: "getComments",
                                            appointmentId: appt.id
                                        }),
                                        contentType: "application/json",
                                        dataType: "json",
                                        success: function(comments) 
                                        {
                                            console.log("Comments fetched successfully", comments);

                                            // Create new list for this appointment's dates
                                            $("#appointmentLabel" + appt.id).append
                                            (
                                                "<ul class='list-group' id='comments" + appt.id + "'>" + 
                                                "<hr>" + 
                                                "<h3>Comments</h3>" + 
                                                "</ul>"
                                            );

                                            // Appending each comment
                                            comments.comments.forEach(function(comment, i)
                                            {
                                                $("#comments" + appt.id).append
                                                ( 
                                                    "<li class='list-group-item'>" + 
                                                        "<input disabled class='form-control' type='text' id='commentName" + appt.id + "no" + i + "' placeholder='#" + (i + 1) + " | " + comment.name + "'>" + 
                                                        "<input disabled class='form-control' type='text' id='commentString" + appt.id + "no" + i + "' placeholder='" + comment.commentString + "'>" + 
                                                    "</li>"
                                                );
                                            });

                                            // Appending new comment creation
                                            $("#comments" + appt.id).append
                                            (
                                                "<hr>" + 
                                                "<h3>New comment</h3>" + 
                                                "<div class='form-floating'>" + 
                                                    "<input type='text' class='form-control' name='newCommenter' id='newCommenter" + appt.id + "' placeholder='Commenter'>" + 
                                                    "<label for='newCommenter'>Commenter</label>" + 
                                                "</div>" +
                                                "<textarea id='newComment" + appt.id + "' rows='4' cols='50'></textarea>" + 
                                                "<hr>" + 
                                                "<button class='btn btn-success btnComment' data-apptid='" + appt.id + "'>Comment</button> "
                                            )
                                        },
                                        error: function(comments)
                                        {
                                            console.log("ERROR: Fetching comments failed", comments);
                                        }
                                    });
                                },
                                error: function(dates) 
                                {
                                    console.error("Error fetching appointment dates:", dates);
                                }
                            });
                        }                     
                    });

                    // If the appointment expired, it is disabled and marked as "(Expired)"
                    appointments.forEach(function(appt, i) // We use a separate forEach loop for this so expired appts are displayed at the bottom
                    {
                        let currentExpiryDate = new Date(appt.expired);
                        if(today.getTime() >= currentExpiryDate.getTime())
                        {
                            $("#appointments").append
                            (
                                "<li class='list-group-item'>" +
                                    "<p class='d-inline-flex gap-1'>" +
                                        "<button class='btn btn-secondary' type='button' data-bs-toggle='collapse' data-bs-target='#appointmentCollapse" + appt.id + "'>#" + appt.id + " | " + appt.name + " (by " + appt.author + ", expired)</button>" +  
                                    "</p>" + 
                                    "<div class='collapse' id='appointmentCollapse" + appt.id + "'>" +  
                                        "<label class='col-form-label' for='appointment" + appt.id + "' id='appointmentLabel" + appt.id + "'>#" + appt.id + " | " + appt.name + " (by " + appt.author + ", expired)</label>" + 
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
                                                "<input disabled class='form-control' type='text' id='appointment" + appt.id + "date" + i + "' placeholder='" + date.day + ", " + date.starttime + " - " + date.endtime + " (" + date.personCount + " prs.)'>" + 
                                            "</li>"
                                        );
                                        amtDates++;
                                    });

                                    // Appends a button for deleting the appt to this appointment
                                    $("#appointmentLabel" + appt.id).append
                                    (
                                        "<hr>" + 
                                        "<button class='btn btn-danger btnDeleteAppt' data-apptid='" + appt.id + "'>Delete Appointment</button>"
                                    );

                                    // Appends the comment section
                                    $.ajax
                                    ({
                                        url: "../backend/api/api.php",
                                        type: "POST",
                                        data: 
                                        JSON.stringify({
                                            action: "getComments",
                                            appointmentId: appt.id
                                        }),
                                        contentType: "application/json",
                                        dataType: "json",
                                        success: function(comments) 
                                        {
                                            console.log("Comments fetched successfully", comments);

                                            // Create new list for this appointment's dates
                                            $("#appointmentLabel" + appt.id).append
                                            (
                                                "<ul class='list-group' id='comments" + appt.id + "'>" + 
                                                "<hr>" + 
                                                "<h3>Comments</h3>" + 
                                                "</ul>"
                                            );

                                            // Appending each comment
                                            comments.comments.forEach(function(comment, i)
                                            {
                                                $("#comments" + appt.id).append
                                                ( 
                                                    "<li class='list-group-item'>" + 
                                                        "<input disabled class='form-control' type='text' id='commentName" + appt.id + "no" + i + "' placeholder='#" + (i + 1) + " | " + comment.name + "'>" + 
                                                        "<input disabled class='form-control' type='text' id='commentString" + appt.id + "no" + i + "' placeholder='" + comment.commentString + "'>" + 
                                                    "</li>"
                                                );
                                            });

                                            // Appending new comment creation
                                            $("#comments" + appt.id).append
                                            (
                                                "<hr>" + 
                                                "<h3>New comment</h3>" + 
                                                "<div class='form-floating'>" + 
                                                    "<input type='text' class='form-control' name='newCommenter' id='newCommenter" + appt.id + "' placeholder='Commenter'>" + 
                                                    "<label for='newCommenter'>Commenter</label>" + 
                                                "</div>" +
                                                "<textarea id='newComment" + appt.id + "' rows='4' cols='50'></textarea>" + 
                                                "<hr>" + 
                                                "<button class='btn btn-success btnComment' data-apptid='" + appt.id + "'>Comment</button> "
                                            )
                                        },
                                        error: function(comments)
                                        {
                                            console.log("ERROR: Fetching comments failed", comments);
                                        }
                                    });
                                },
                                error: function(dates) 
                                {
                                    console.error("Error fetching appointment dates:", dates);
                                }
                            });
                        } 
                    })
                }
                else
                {
                    // Output to website and console: No appointments found
                    console.log("No appointments found.");
                    $("#appointments").append
                    (
                        "<li class='list-group-item'>No appointments found</li>"
                    );
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
    {                                                      // $(document).on() is necessary as event binding would otherwise happen before buttons are loaded
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

    // Clicking the delete button
    $(document).on("click", ".btnDeleteAppt", function()
    {
        let apptID = $(this).data("apptid"); // The data attributes are used to get the necessary parameters for confirmDates
        deleteAppointment(apptID);
    });

    // Deleting the appointment from the DB
    function deleteAppointment(apptID)
    {
        $.ajax
        ({
            url: "../backend/api/api.php",
            type: "POST",
            data: 
            JSON.stringify({
                action: "deleteAppointmentById",
                appointmentId: apptID
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(response)
            {
                console.log("Appointment deleted", response);
                location.reload();

            },
            error: function(response)
            {
                console.log("ERROR: Appointment deletion failed", response);
            }            
        })
    }

    // Clicking the comment button
    $(document).on("click", ".btnComment", function()
    {
        let apptID = $(this).data("apptid"); // The data attributes are used to get the necessary parameters for confirmDates
        comment(apptID);
    });

    // Sending the comment to the DB
    function comment(apptID)
    {
        $.ajax
        ({
            url: "../backend/api/api.php",
            type: "POST",
            data: 
            JSON.stringify({
                action: "insertComment",
                name: $("#newCommenter" + apptID).val(),
                commentString: $("#newComment" + apptID).val(),
                appointmentId: apptID
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(response)
            {
                console.log("Comment added", response);
                location.reload();

            },
            error: function(response)
            {
                console.log("ERROR: Adding comment failed", response);
            }            
        })        
    }
});