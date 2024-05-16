$(document).ready(function () {
    // Function to perform ID search
    $("#searchButton").on("click", function () {
        var userId = $("#user_id").val();
        if (userId) {
            $.ajax({
                url: "/get-patient-details/" + userId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    var appointments = data.appointments; // Get the array of appointments
                    var appointmentTable = $("#appointment tbody");
                    var pregnancyHistories = data.pregnancyHistories; // Get the array of pregnancy histories
                    var pregnancyTable = $("#pregnancy_histories tbody");
                    var labData = data.laboratories; // Get the array of laboratory records
                    var labTable = $("#laboratory tbody");
                    var ultrasoundData = data.ultrasounds; // Get the array of ultrasound records
                    var ultrasoundTable = $("#ultrasound tbody");

                    // Clear existing rows
                    ultrasoundTable.empty();
                    labTable.empty();
                    appointmentTable.empty();
                    pregnancyTable.empty();

                    $("#fullname").text(
                        data.firstname +
                            " " +
                            data.middlename +
                            " " +
                            data.lastname
                    );
                    $("#middlename").text(data.middlename);
                    $("#lastname").text(data.lastname);
                    //PATIENT
                    $("#contact_number").text(data.contact_number);
                    $("#birthday").text(data.birthday);
                    $("#birthplace").text(data.birthplace);
                    $("#age").text(data.age);
                    $("#civil").text(data.civil);
                    $("#religion").text(data.religion);
                    $("#occupation").text(data.occupation);
                    $("#nationality").text(data.nationality);
                    $("#husband_fullname").text(
                        data.husband_firstname +
                            " " +
                            data.husband_middlename +
                            " " +
                            data.husband_lastname
                    );
                    $("#husband_contact_number").text(
                        data.husband_contact_number
                    );
                    $("#husband_religion").text(data.husband_religion);
                    $("#husband_age").text(data.husband_age);
                    $("#husband_occupation").text(data.husband_occupation);
                    $("#husband_birthday").text(data.husband_birthday);
                    $("#address").text(
                        "Barangay " +
                            data.barangay +
                            "," +
                            data.city +
                            "," +
                            data.province
                    );
                    //TERMS
                    $("#gravida").text(data.gravida);
                    $("#para").text(data.para);
                    $("#t").text(data.t);
                    $("#p").text(data.p);
                    $("#a").text(data.a);
                    $("#l").text(data.l);
                    //PREG HISTORY

                    pregnancyHistories.forEach(function (history) {
                        var row = $("<tr>");
                        row.append($("<td>").text(history.pregnancy));
                        row.append($("<td>").text(history.pregnancy_date));
                        row.append($("<td>").text(history.aog));
                        row.append($("<td>").text(history.manner));
                        row.append($("<td>").text(history.bw));
                        row.append($("<td>").text(history.sex));
                        row.append($("<td>").text(history.present_status));
                        row.append($("<td>").text(history.complications));
                        pregnancyTable.append(row);
                    });

                    //LABORATORY
                    labData.forEach(function (record) {
                        var row = $("<tr>");
                        row.append($("<td>").text(record.date));
                        row.append($("<td>").text(record.urinalysis));
                        row.append($("<td>").text(record.cbc));
                        row.append($("<td>").text(record.blood_type));
                        row.append($("<td>").text(record.hbsag));
                        row.append($("<td>").text(record.vdrl));
                        row.append($("<td>").text(record.fbs));
                        labTable.append(row);
                    });

                    //ULTRASOUND
                    ultrasoundData.forEach(function (record) {
                        var row = $("<tr>");
                        row.append($("<td>").text(record.ultra_date));
                        row.append($("<td>").text(record.result));

                        // Create an image element for the attachment
                        var img = $("<img>")
                            .attr("src", record.attachment)
                            .attr("alt", "ultrasound")
                            .css("max-width", "100px");
                        var attachmentCell = $("<td>")
                            .addClass("text-center")
                            .append(img);

                        row.append(attachmentCell);
                        ultrasoundTable.append(row);
                    });

                    //APPOINTMENT
                    appointments.forEach(function (appointment) {
                        var row = $("<tr>");
                        row.append($("<td>").text(appointment.app_date));
                        row.append($("<td>").text(appointment.doctor));
                        row.append($("<td>").text(appointment.service));
                        row.append($("<td>").text(appointment.start_time));
                        row.append($("<td>").text(appointment.status));
                        appointmentTable.append(row);
                    });

                   
                    var today = new Date(); // Current date
                    console.log('Today\'s date:', today.toLocaleDateString());
                    var hasAppointmentToday = appointments.some(function (appointment) {
                        // Convert the appointment date to a Date object for comparison
                        var appointmentDate = new Date(appointment.app_date);
                        
                        // Compare only the date part (not time)
                        var appointmentDateString = appointmentDate.toLocaleDateString();
                        var todayDateString = today.toLocaleDateString();
                        console.log('Comparing dates:', appointmentDateString, 'and', todayDateString); // Log the comparison of dates
                        if (appointmentDateString === todayDateString) {
                            // Extract the time part of the appointment
                            var appointmentStartTime = appointment.start_time;
                            
                            // Show SweetAlert with appointment time
                            Swal.fire({
                                icon: "success",
                                title: "Appointment Today",
                                text: "You have an appointment scheduled for today at " + appointmentStartTime,
                                showConfirmButton: false,
                                timer: 3000,
                            });
                            

                        }
                    else{
                        Swal.fire({
                            icon: "error",
                            title: "No Appointment for Today",
                            text: "You have no appointment scheduled for today!",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                });
                
                    //MEDICAL HISTORY
                    $("#hypertension").text(data.hypertension);
                    $("#asthma").text(data.asthma);
                    $("#heartdisease").text(data.heartdisease);
                    $("#tuberculosis").text(data.tuberculosis);
                    $("#diabetes").text(data.diabetes);
                    $("#goiter").text(data.goiter);
                    $("#epilepsy").text(data.epilepsy);
                    $("#allergy").text(data.allergy);
                    $("#hepatitis").text(data.hepatitis);
                    $("#medical_vdrl").text(data.medical_vdrl);
                    $("#bleeding").text(data.bleeding);
                    $("#operation").text(data.operation);
                    $("#others").text(data.others);
                },
                error: function (xhr, textStatus, errorThrown) {
                    // Handle error if user details retrieval fails
                    console.log(errorThrown);
                    // Show SweetAlert for invalid QR code
                    Swal.fire({
                        icon: "error",
                        title: "Invalid QR Code",
                        text: "The scanned QR code is invalid.",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                },
            });
        }
    });

    $(document).ready(function () {
        // Initialize the scanner
        let scanner = new Instascan.Scanner({
            video: document.getElementById("scanner"),
        });

        // Add listener for scan event
        scanner.addListener("scan", function (content) {
            // Display the scanned content in the user_id input field
            $("#user_id").val(content);

            // Call a function to fetch user details based on the scanned ID
            getUserDetails(content);
        });

        // Get available cameras and start the scanner
        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]); // Use the first available camera
                } else {
                    console.error("No cameras found.");
                }
            })
            .catch(function (e) {
                console.error(e);
            });

        // Function to fetch user details based on the scanned ID
        function getUserDetails(userId) {
            // Perform AJAX request to fetch user details using the scanned ID
            $.ajax({
                url: "/get-patient-details/" + userId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    var appointments = data.appointments; // Get the array of appointments
                    var appointmentTable = $("#appointment tbody");
                    var pregnancyHistories = data.pregnancyHistories; // Get the array of pregnancy histories
                    var pregnancyTable = $("#pregnancy_histories tbody");
                    var labData = data.laboratories; // Get the array of laboratory records
                    var labTable = $("#laboratory tbody");
                    var ultrasoundData = data.ultrasounds; // Get the array of ultrasound records
                    var ultrasoundTable = $("#ultrasound tbody");

                    // Clear existing rows
                    ultrasoundTable.empty();
                    labTable.empty();
                    appointmentTable.empty();
                    pregnancyTable.empty();

                    $("#fullname").text(
                        data.firstname +
                            " " +
                            data.middlename +
                            " " +
                            data.lastname
                    );
                    $("#middlename").text(data.middlename);
                    $("#lastname").text(data.lastname);
                    //PATIENT
                    $("#contact_number").text(data.contact_number);
                    $("#birthday").text(data.birthday);
                    $("#birthplace").text(data.birthplace);
                    $("#age").text(data.age);
                    $("#civil").text(data.civil);
                    $("#religion").text(data.religion);
                    $("#occupation").text(data.occupation);
                    $("#nationality").text(data.nationality);
                    $("#husband_fullname").text(
                        data.husband_firstname +
                            " " +
                            data.husband_middlename +
                            " " +
                            data.husband_lastname
                    );
                    $("#husband_contact_number").text(
                        data.husband_contact_number
                    );
                    $("#husband_religion").text(data.husband_religion);
                    $("#husband_age").text(data.husband_age);
                    $("#husband_occupation").text(data.husband_occupation);
                    $("#husband_birthday").text(data.husband_birthday);
                    $("#address").text(
                        "Barangay " +
                            data.barangay +
                            "," +
                            data.city +
                            "," +
                            data.province
                    );
                    //TERMS
                    $("#gravida").text(data.gravida);
                    $("#para").text(data.para);
                    $("#t").text(data.t);
                    $("#p").text(data.p);
                    $("#a").text(data.a);
                    $("#l").text(data.l);
                    //PREG HISTORY

                    pregnancyHistories.forEach(function (history) {
                        var row = $("<tr>");
                        row.append($("<td>").text(history.pregnancy));
                        row.append($("<td>").text(history.pregnancy_date));
                        row.append($("<td>").text(history.aog));
                        row.append($("<td>").text(history.manner));
                        row.append($("<td>").text(history.bw));
                        row.append($("<td>").text(history.sex));
                        row.append($("<td>").text(history.present_status));
                        row.append($("<td>").text(history.complications));
                        pregnancyTable.append(row);
                    });

                    //LABORATORY
                    labData.forEach(function (record) {
                        var row = $("<tr>");
                        row.append($("<td>").text(record.date));
                        row.append($("<td>").text(record.urinalysis));
                        row.append($("<td>").text(record.cbc));
                        row.append($("<td>").text(record.blood_type));
                        row.append($("<td>").text(record.hbsag));
                        row.append($("<td>").text(record.vdrl));
                        row.append($("<td>").text(record.fbs));
                        labTable.append(row);
                    });

                    //ULTRASOUND
                    ultrasoundData.forEach(function (record) {
                        var row = $("<tr>");
                        row.append($("<td>").text(record.ultra_date));
                        row.append($("<td>").text(record.result));

                        // Create an image element for the attachment
                        var img = $("<img>")
                            .attr("src", record.attachment)
                            .attr("alt", "ultrasound")
                            .css("max-width", "100px");
                        var attachmentCell = $("<td>")
                            .addClass("text-center")
                            .append(img);

                        row.append(attachmentCell);
                        ultrasoundTable.append(row);
                    });

                    //APPOINTMENT
                    appointments.forEach(function (appointment) {
                        var row = $("<tr>");
                        row.append($("<td>").text(appointment.app_date));
                        row.append($("<td>").text(appointment.doctor));
                        row.append($("<td>").text(appointment.service));
                        row.append($("<td>").text(appointment.start_time));
                        row.append($("<td>").text(appointment.status));
                        appointmentTable.append(row);
                    });
                    
                    var today = new Date(); // Current date
                    var hasAppointmentToday = appointments.some(function (appointment) {
                        // Convert the appointment date to a Date object for comparison
                        var appointmentDate = new Date(appointment.app_date);
                        
                        // Compare only the date part (not time)
                        var appointmentDateString = appointmentDate.toLocaleDateString();
                        var todayDateString = today.toLocaleDateString();
                        
                        if (appointmentDateString === todayDateString) {
                            // Extract the time part of the appointment
                            var appointmentStartTime = appointment.start_time;
                            
                            // Show SweetAlert with appointment time
                            Swal.fire({
                                icon: "success",
                                title: "Appointment Today",
                                text: "You have an appointment scheduled for today at " + appointmentStartTime,
                                showConfirmButton: false,
                                timer: 3000,
                            });
                            

                        }
                    else{
                        Swal.fire({
                            icon: "error",
                            title: "No Appointment for Today",
                            text: "You have no appointment scheduled for today!",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                });
                

                    //MEDICAL HISTORY
                    $("#hypertension").text(data.hypertension);
                    $("#asthma").text(data.asthma);
                    $("#heartdisease").text(data.heartdisease);
                    $("#tuberculosis").text(data.tuberculosis);
                    $("#diabetes").text(data.diabetes);
                    $("#goiter").text(data.goiter);
                    $("#epilepsy").text(data.epilepsy);
                    $("#allergy").text(data.allergy);
                    $("#hepatitis").text(data.hepatitis);
                    $("#medical_vdrl").text(data.medical_vdrl);
                    $("#bleeding").text(data.bleeding);
                    $("#operation").text(data.operation);
                    $("#others").text(data.others);
                },
                error: function (xhr, textStatus, errorThrown) {
                    // Handle error if user details retrieval fails
                    console.log(errorThrown);
                    // Show SweetAlert for invalid QR code
                    Swal.fire({
                        icon: "error",
                        title: "Invalid QR Code",
                        text: "The scanned QR code is invalid.",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                },
            });
        }
    });
});
