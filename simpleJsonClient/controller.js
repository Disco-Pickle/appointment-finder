$(function () {

    $("#searchResult").hide();

    $("#btn_Search").click(function (e) {
        $("#searchResult").hide();
        loaddata($("#searchfield").val());
    });


    let data = null;

    function loaddata(searchterm) {

        console.log("Sending Ajax Request");
        data = null;

        // see: https://api.jquery.com/jQuery.ajax/
        $.ajax({
            type: "GET", // HTTP method to be used
            url: "../serviceHandler.php", // Target URL to which the HTTP request is sent
            cache: false, // false forces that requested pages are not cached by the browser
            data: {method: "queryPersonByName", param: searchterm}, // Data to be sent to the server
            dataType: "json", // Data type expected to be received from the server
            success: function (response) { // Function to be executed if the HTTP request is successful

                console.log("Ajax-Success", response);
                data = response;

                // EXTENSION START
                // Changes search result description
                $("#resultDescription").replaceWith("<label for='noOfentries' class='form-label' id='resultDescription'>Persons under this name:</label>"); 

                // Reads all entries for the provided search term from data
                $("#persons").replaceWith("<p type='text' readonly class='form-control-plaintext' id='persons'></p>"); // Replaces previous .append with the default <p>
                $.each(data, function(i, v) { // "For each line in data, do:"
                    $("#persons").append("<p>First Name: " + v.firstname + " | Last Name: " + v.lastname + " | E-Mail: " + v.email + " | Phone number: " + v.phone + " | Department: " + v.department + "</p>");
                });
                // EXTENSION END

                // Displays number of lines in response
                $("#noOfentries").val(response.length);

                // Displays search results with a 1 second fade-in
                $("#searchResult").show(1000);
            },
            error: function() { // Function to be executed if the HTTP request fails
                console.error("Error! Trying next search method...");

                // EXTENSION START
                $.ajax({
                    type: "GET", // HTTP method to be used
                    url: "../serviceHandler.php", // Target URL to which the HTTP request is sent
                    cache: false, // false forces that requested pages are not cached by the browser
                    data: {method: "queryPersonById", param: searchterm}, // Data to be sent to the server
                    dataType: "json", // Data type expected to be received from the server
                    success: function (response) { // Function to be executed if the HTTP request is successful

                        console.log("Ajax-Success", response);
                        data = response;

                        // Changes search result description
                        $("#resultDescription").replaceWith("<label for='noOfentries' class='form-label' id='resultDescription'>Persons under this ID:</label>");

                        // Reads all entries for the provided search term from data
                        $("#persons").replaceWith("<p type='text' readonly class='form-control-plaintext' id='persons'></p>"); // Replaces previous .append with the default <p>
                        $.each(data, function(i, v) { // "For each line in data, do:"
                            $("#persons").append("<p>First Name: " + v.firstname + " | Last Name: " + v.lastname + " | E-Mail: " + v.email + " | Phone number: " + v.phone + " | Department: " + v.department + "</p>");
                        });

                        // Displays number of lines in response
                        $("#noOfentries").val(response.length);

                        // Displays search results with a 1 second fade-in
                        $("#searchResult").show(1000);
                    },
                    error: function() { // Function to be executed if the HTTP request fails
                        console.error("Error! Trying next search method...");

                        $.ajax({
                            type: "GET", // HTTP method to be used
                            url: "../serviceHandler.php", // Target URL to which the HTTP request is sent
                            cache: false, // false forces that requested pages are not cached by the browser
                            data: {method: "queryPersonByDept", param: searchterm}, // Data to be sent to the server
                            dataType: "json", // Data type expected to be received from the server
                            success: function (response) { // Function to be executed if the HTTP request is successful

                                console.log("Ajax-Success", response);
                                data = response;

                                // Changes search result description
                                $("#resultDescription").replaceWith("<label for='noOfentries' class='form-label' id='resultDescription'>Persons in this Department:</label>");

                                // Replaces previous .append with the default <p>
                                $("#persons").replaceWith("<p type='text' readonly class='form-control-plaintext' id='persons'></p>");

                                // Reads all entries for the provided search term from data
                                $.each(data, function(i, v) { // "For each line in data, do:"
                                    $("#persons").append("<p>First Name: " + v.firstname + " | Last Name: " + v.lastname + " | E-Mail: " + v.email + " | Phone number: " + v.phone + " | Department: " + v.department + "</p>");
                                });

                                // Displays number of lines in response
                                $("#noOfentries").val(response.length);

                                // Displays search results with a 1 second fade-in
                                $("#searchResult").show(1000);
                            },
                            error: function() { // Function to be executed if the HTTP request fails
                                console.error("Error! Trying next search method...");

                                $.ajax({
                                    type: "GET", // HTTP method to be used
                                    url: "../serviceHandler.php", // Target URL to which the HTTP request is sent
                                    cache: false, // false forces that requested pages are not cached by the browser
                                    data: {method: "queryPersonByPhone", param: searchterm}, // Data to be sent to the server
                                    dataType: "json", // Data type expected to be received from the server
                                    success: function (response) { // Function to be executed if the HTTP request is successful

                                        console.log("Ajax-Success", response);
                                        data = response;

                                        // Changes search result description
                                        $("#resultDescription").replaceWith("<label for='noOfentries' class='form-label' id='resultDescription'>Persons with this Phone Number:</label>");

                                        // Replaces previous .append with the default <p>
                                        $("#persons").replaceWith("<p type='text' readonly class='form-control-plaintext' id='persons'></p>");

                                        // Reads all entries for the provided search term from data
                                        $.each(data, function(i, v) { // "For each line in data, do:"
                                            $("#persons").append("<p>First Name: " + v.firstname + " | Last Name: " + v.lastname + " | E-Mail: " + v.email + " | Phone number: " + v.phone + " | Department: " + v.department + "</p>");
                                        });

                                        // Displays number of lines in response
                                        $("#noOfentries").val(response.length);

                                        // Displays search results with a 1 second fade-in
                                        $("#searchResult").show(1000);
                                    },
                                    error: function() { // Function to be executed if the HTTP request fails
                                        console.error("Error! Giving up.");

                                        // Output if none of the search functions produce results
                                        // Changes search result description
                                        $("#resultDescription").replaceWith("<label for='noOfentries' class='form-label' id='resultDescription'>No entries found</label>");

                                        // Replaces previous .append with the default <p>
                                        $("#persons").replaceWith("<p type='text' readonly class='form-control-plaintext' id='persons'></p>");

                                        // Displays number of lines in response
                                        $("#noOfentries").val(0);

                                        // Displays search results with a 1 second fade-in
                                        $("#searchResult").show(1000);
                                    }            
                                });
                            }
                        });

                    }            
                });
                // EXTENSION END
            }            
        });

        // $.ajax is an asynchronous call ... these line are logged usually *before* "Ajax-Success"
        console.log("loaddata finished");
        console.log("Data (still null ... AJAX call not yet finished)", data);
    }

});
