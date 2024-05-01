$(function ()
{
    // Adding more proposed dates
    let amountDates = 1;
   $("#btnAddDate").click(function()
    {
        // Adds new date to form and increments amountDates
        amountDates++;
        $("#options").append(
            "<div class='row'>" +
                "<div class='col-3'>" +
                    "<input type='date' class='form-control' name='day" + amountDates + "' id='day" + amountDates + "'>" +
                "</div>" + 
                "<div class='col-2'>" +
                    "<input type='time' class='form-control' name='starttime" + amountDates + "' id='starttime" + amountDates + "'>" +
                "</div>" +
                "<div class='col-2'>" +
                    "<input type='time' class='form-control' name='endtime" + amountDates + "' id='endtime" + amountDates +"'>" +
                "</div>" +
            "</div>"
        )
    });

    // Submitting the new appointment (saving it in the DB)
    let name;
    let author;
    let expired;
    let dates = [];
    $("#btnSubmit").click(function()
    {
        // Get appointment name
        name = $("#name").val();
        console.log("Name: ", name);

        // Get author
        author = $("#author").val();
        console.log("Author: ", author);

        // Get date after which the date is expired
        expired = $("#expired").val();
        console.log("Expired: ", expired);

        // Get proposed dates
        for(let i = 1; i <= amountDates; i++)
        {
            dates.push
            ({
                day: $("#day" + i).val(),
                starttime: $("#starttime" + i).val(),
                endtime: $("#endtime" + i).val()
            });
        }
        console.log("Dates: ", dates);

        // Construct the JSON payload
        const payload = {
            action: "addAppointment",
            author: author,
            name: name,
            expired: expired,
            dates: dates
        };

        // Send data to DB
        $.ajax
        ({
            type: "POST",
            url: "../backend/api/api.php",
            cache: false,
            data: JSON.stringify(payload), // Convert to JSON string
            contentType: "application/json", // Set content type
            success: function()
            {
                console.log("Appointment data successfully sent to database");

                // Clearing all fields and reloading site
                $("#name").val("");
                $("#author").val("");
                $("#expired").val("");
                $("#day1").val("");
                $("#starttime1").val("");
                $("#endtime1").val("");
                location.reload();
            },
            error: function()
            {
                console.log("ERROR: Sending appointment data to database failed");
            }
        })
    });
});