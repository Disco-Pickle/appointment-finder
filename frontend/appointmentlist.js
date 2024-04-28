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
            data: JSON.stringify({
                action: "getAllAppointments"
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(response) {
                if (response) {
                    // Clear existing appointments (if there are any)
                    $("#appointments").empty();

                    // Append each appointment to the list
                    response.forEach(function(appt, i) {
                        const appointmentItem = $("<li class='list-group-item'></li>");
                        const appointmentLabel = $("<label class='form-check-label'></label>");

                        if (appt.expired === 0) {
                            appointmentLabel.text("#" + appt.id + " | Name: " + appt.name + ", Author: " + appt.author);
                        } else {
                            appointmentLabel.text("#" + appt.id + " | Name: " + appt.name + ", Author: " + appt.author + " (Expired)");
                        }

                        // Create a container for dates (initially hidden)
                        const datesContainer = $("<div class='dates-container'></div>");

                        // Add dates to the container
                        appt.dates.forEach(function(date) {
                            datesContainer.append("<p>Date: " + date.day + ", Start: " + date.starttime + ", End: " + date.endtime + "</p>");
                        });

                        // Append everything to the list item
                        appointmentItem.append(appointmentLabel, datesContainer);
                        $("#appointments").append(appointmentItem);

                        // Toggle behavior when appointment is clicked
                        appointmentLabel.on("click", function() {
                            datesContainer.toggle(); // Toggle visibility
                        });
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


    }
});
