$(function ()
{
    // Adding more proposed dates
    let dates = 1;
    $("#btnAddDate").click(function()
    {
        dates++;
        $("#options").append(
            "<div class='row'>" +
                "<div class='col-3'>" +
                    "<input type='date' class='form-control' name='date" + dates + "' id='date" + dates + "'>" +
                "</div>" + 
                "<div class='col-2'>" +
                    "<input type='time' class='form-control' name='starttime" + dates + "' id='starttime" + dates + "'>" +
                "</div>" +
                "<div class='col-2'>" +
                    "<input type='time' class='form-control' name='endtime" + dates + "' id='endtime" + dates +"'>" +
                "</div>" +
            "</div>"
        )
    })

    
})