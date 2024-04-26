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
        console.log("Date added");
    });

    // Submitting the new appointment (saving it in the DB)
    let name;
    let author;
    let dates = [];
    $("#btnSubmit").click(function()
    {
        // Get appointment name
        name = $("#name").val();
        console.log("name = " + name);

        // Get author
        author = $("#author").val();
        console.log("author = " + author);

        $.ajax
        ({
            type: "POST",
            urls: "../backend/api/api.php",
            cache: false,
            data: {addAppointment: author, name, dates},
            dataType: "json",
            success: function()
            {
                console.log("Appointment data successfully sent to database");
            },
            error: function()
            {
                console.log("ERROR: Sending appointment data to database failed");
            }
        })

        // Get proposed dates
        for(let i = 1; i <= amountDates; i++)
        {
            dates.push([
                $("#day" + i).val(),
                $("#starttime" + i).val(),
                $("#endtime" + i).val()
            ]);
            console.log("dates[" + (i - 1) + "] =" + dates[i - 1]);
        }
    });
});