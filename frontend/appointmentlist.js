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

                        // Append everything to the list item
                        appointmentItem.append(appointmentLabel, datesContainer);
                        $("#appointments").append(appointmentItem);

                        // Toggle behavior when appointment is clicked
                        appointmentLabel.on("click", function() {
                            datesContainer.toggle(); // Toggle visibility

                            // Fetch appointment dates if not already loaded
                            if (datesContainer.is(":visible")) {
                                const appointmentId = appt.id;
                                getAppointmentDates(appointmentId);
                            }
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

    // Fetch appointment dates
    function getAppointmentDates(appointmentId) {
        $.ajax({
            url: "../backend/api/api.php",
            type: "POST",
            data: JSON.stringify({
                action: "getAppointmentDates",
                appointmentId: appointmentId
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(response) {
                if (response && response.dates) {
                    // Update UI with fetched dates (e.g., display in a modal)
                    console.log("Dates for appointment #" + appointmentId + ":", response.dates);
                } else {
                    console.log("No dates found for appointment #" + appointmentId);
                }
            },
            error: function(response) {
                console.error("Error fetching appointment dates:", response);
            }
        });
    }
});
