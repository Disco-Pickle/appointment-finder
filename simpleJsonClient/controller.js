$(function () 
{
    let data = null;
    
    function loaddata(searchterm) 
    {
        console.log("Sending Ajax Request");
        data = null;
    
        // see: https://api.jquery.com/jQuery.ajax/
        $.ajax
        ({
            // \/\/ This all needs to be changed \/\/
            type: "GET", // HTTP method to be used
            url: "../serviceHandler.php", // Target URL to which the HTTP request is sent
            cache: false, // false forces that requested pages are not cached by the browser
            data: {method: "", param: searchterm}, // Data to be sent to the server
            dataType: "", // Data type expected to be received from the server
            // /\/\ This all needs to be changed /\/\
            success: function (response) // Function to be executed if the HTTP request is successful
            {
                
            },
            error: function() 
            { // Function to be executed if the HTTP request fails
                console.error("ERROR");
            }            
        });
    }
});

