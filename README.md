# Simple REST Application

## Backend
http://localhost/*PATH-TO-REPLACE*/serviceHandler.php?method=queryPersonByName&param=Doe


## Frontend
http://localhost/*PATH-TO-REPLACE*/simpleJsonClient/simplePersonHandle.html


# Database

## Login
http://192.168.0.22:8080
- root
- ourpassword

# Issue Tracker
## Issues
- When adding dates, but not entering any data, this either results in no data being parsed or data entered further up being parsed again: This needs a fix. As long as all added dates are also filled in correctly, there is no issue
- addPersons() is needed to add persons to specific dates of an appointment
- appointmentlist.js overhaul: Needs to fetch all appointments in appointment table from DB, then needs to match all dates in date table from DB to their respective appointment (connection is identified by fk_idappointment) => Make the current AJAX call for appointments call another function that fetches all dates for the current appointment (via getAppointmentDates) and appends them to this appointment. Also make the appointment a retractable dropdown menu