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
                    var medications = data.medications;
                    var medicationTable = $("#medication tbody");
                    var delivery = data.delivery;
                    var deliveryTable1 = $("#delivery1 tbody");
                    var delivery2 = data.delivery;
                    var deliveryTable2 = $("#delivery2 tbody");
                    var delivery3 = data.delivery;
                    var deliveryTable3 = $("#delivery3 tbody");
                    var newborn = data.newborn;
                    var newbornTable1 = $("#newborn1 tbody");
                    var newborn2 = data.newborn;
                    var newbornTable2 = $("#newborn2 tbody");
                    var newborn3 = data.newborn;
                    var newbornTable3 = $("#newborn3 tbody");
                    var postpartum = data.postpartum;
                    var postpartumTable = $("#postpartum tbody");
                    var labor = data.labor;
                    var laborTable = $("#labor tbody");
                    var staffnotes = data.staffnotes;
                    var staffnotesTable = $("#staffnotes tbody");
                    var physician = data.physician;
                    var physicianTable = $("#physician tbody");
                    var records = data.records;
                    var recordsTable1 = $("#records1 tbody");
                    var records2 = data.records;
                    var recordsTable2 = $("#records2 tbody");
                    var attachmentData = data.attachment; // Get the array of attachment records
                    var attachmentTable = $("#attachment tbody");
                    // Clear existing rows
                    ultrasoundTable.empty();
                    labTable.empty();
                    appointmentTable.empty();
                    pregnancyTable.empty();
                    medicationTable.empty();
                    deliveryTable1.empty();
                    deliveryTable2.empty();
                    deliveryTable3.empty();
                    newbornTable1.empty();
                    newbornTable2.empty();
                    newbornTable3.empty();
                    postpartumTable.empty();
                    laborTable.empty();
                    staffnotesTable.empty();
                    physicianTable.empty();
                    recordsTable1.empty();
                    recordsTable2.empty();
                    attachmentTable.empty();
                    
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
                    $("#address").text(
                        "Barangay " +
                            data.barangay +
                            "," +
                            data.city +
                            "," +
                            data.province
                    );

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
                    $("#husband_address").text(
                        "Barangay " +
                            data.husband_barangay +
                            "," +
                            data.husband_city +
                            "," +
                            data.husband_province
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
                            .css("max-width", "100px");
                    
                        // Create a link element for the file
                        var link = $("<a>")
                            .attr("href", record.attachment)
                            .attr("target", "_blank")
                            .text("View File");
                    
                        // Create a div to contain both the image and the link
                        var attachmentDiv = $("<div>")
                            .append(img)
                            .append("<br>") // Line break between the image and the link
                            .append(link);
                    
                        var attachmentCell = $("<td>")
                            .addClass("text-center")
                            .append(attachmentDiv);
                    
                        row.append(attachmentCell);
                        ultrasoundTable.append(row);
                    });

                    //ATTACHMENT
                    attachmentData.forEach(function (attachment) {
                        var row = $("<tr>");
                        row.append($("<td>").text(attachment.attachment_date));
                        row.append($("<td>").text(attachment.attachment_name));
                        row.append($("<td>").text(attachment.attachment_description));
                    
                        // Create an image element for the attachment
                        var img = $("<img>")
                            .attr("src", attachment.attachment_file)
                            .css("max-width", "100px");
                    
                        // Create a link element for the file
                        var link = $("<a>")
                            .attr("href", attachment.attachment_file)
                            .attr("target", "_blank")
                            .text("View File");
                    
                        // Create a div to contain both the image and the link
                        var attachmentDiv = $("<div>")
                            .append(img)
                            .append("<br>") // Line break between the image and the link
                            .append(link);
                    
                        var attachmentCell = $("<td>")
                            .addClass("text-center")
                            .append(attachmentDiv);
                    
                        row.append(attachmentCell);
                        attachmentTable.append(row);
                    });

                    //DELIVERY DATA
                    delivery.forEach(function (delivery) {
                        var row = $("<tr>");
                        row.append($("<td>").text(delivery.name));
                        row.append($("<td>").text(delivery.birthday));
                        row.append($("<td>").text(delivery.birthtime));
                        row.append($("<td>").text(delivery.sex));
                        row.append($("<td>").text(delivery.weight));
                        row.append($("<td>").text(delivery.birth_order));
                        row.append($("<td>").text(delivery.aog));
                        deliveryTable1.append(row);
                    });

                    delivery.forEach(function (delivery) {
                        var row = $("<tr>");
                        row.append($("<td>").text(delivery.hc));
                        row.append($("<td>").text(delivery.cc));
                        row.append($("<td>").text(delivery.ac));
                        row.append($("<td>").text(delivery.bl));
                        row.append($("<td>").text(delivery.hepa));
                        row.append($("<td>").text(delivery.bcg));
                        row.append($("<td>").text(delivery.nbs));
                        deliveryTable2.append(row);
                    });
                    delivery.forEach(function (delivery) {
                        var row = $("<tr>");
                        row.append($("<td>").text(delivery.hearing));
                        row.append($("<td>").text(delivery.handle));
                        row.append($("<td>").text(delivery.assist));
                        row.append($("<td>").text(delivery.referral));
                        deliveryTable3.append(row);
                    });

                     //nEWBORN DATA
                    newborn.forEach(function (newborn) {
                        var row = $("<tr>");
                        row.append($("<td>").text(newborn.card));
                        row.append($("<td>").text(newborn.bln));
                        row.append($("<td>").text(newborn.mln));
                        row.append($("<td>").text(newborn.mfn));
                        row.append($("<td>").text(newborn.dob));
                        row.append($("<td>").text(newborn.dot));
                        row.append($("<td>").text(newborn.doc));
                        row.append($("<td>").text(newborn.toc));
                        newbornTable1.append(row);
                    });

                    newborn.forEach(function (newborn) {
                        var row = $("<tr>");
                        row.append($("<td>").text(newborn.baby_weight));
                        row.append($("<td>").text(newborn.baby_sex));
                        row.append($("<td>").text(newborn.baby_aog));
                        row.append($("<td>").text(newborn.baby_feeding));
                        row.append($("<td>").text(newborn.baby_status));
                        row.append($("<td>").text(newborn.baby_birthplace));
                        row.append($("<td>").text(newborn.baby_address));
                        newbornTable2.append(row);
                    });
                    newborn.forEach(function (newborn) {
                        var row = $("<tr>");
                        row.append($("<td>").text(newborn.baby_contact));
                        row.append($("<td>").text(newborn.baby_blood));
                        row.append($("<td>").text(newborn.baby_staff));
                        row.append($("<td>").text(newborn.drr));
                        row.append($("<td>").text(newborn.baby_result));
                        row.append($("<td>").text(newborn.dc));
                        row.append($("<td>").text(newborn.cb));
                        newbornTable3.append(row);
                    });

                        //PNCU
                    records.forEach(function (records) {
                        var row = $("<tr>");
                        row.append($("<td>").text(records.records_date));
                        row.append($("<td>").text(records.records_aog));
                        row.append($("<td>").text(records.records_chief));
                        row.append($("<td>").text(records.records_blood_pressure));
                        row.append($("<td>").text(records.records_weight));
                        row.append($("<td>").text(records.records_temperature));
                        row.append($("<td>").text(records.records_cardiac));
                        recordsTable1.append(row);
                    });
    
                    records.forEach(function (records) {
                        var row = $("<tr>");
                        row.append($("<td>").text(records.records_respiratory));
                        row.append($("<td>").text(records.records_fundic));
                        row.append($("<td>").text(records.records_fht));
                        row.append($("<td>").text(records.records_ie));
                        row.append($("<td>").text(records.records_diagnosis));
                        row.append($("<td>").text(records.records_plan));
                        row.append($("<td>").text(records.records_follow_up));
                        recordsTable2.append(row);
                    });

                    //POSTPARTUM
                    postpartum.forEach(function (postpartum) {
                        var row = $("<tr>");
                        row.append($("<td>").text(postpartum.post_date));
                        row.append($("<td>").text(postpartum.post_time));
                        row.append($("<td>").text(postpartum.post_temp));
                        row.append($("<td>").text(postpartum.pr));
                        row.append($("<td>").text(postpartum.rr));
                        row.append($("<td>").text(postpartum.bp));
                        row.append($("<td>").text(postpartum.u));
                        row.append($("<td>").text(postpartum.s));
                        postpartumTable.append(row);
                    });

                      //LABOR
                    labor.forEach(function (labor) {
                        var row = $("<tr>");
                        row.append($("<td>").text(labor.labor_date));
                        row.append($("<td>").text(labor.labor_time));
                        row.append($("<td>").text(labor.labor_temp));
                        row.append($("<td>").text(labor.labor_pr));
                        row.append($("<td>").text(labor.labor_rr));
                        row.append($("<td>").text(labor.labor_bp));
                        row.append($("<td>").text(labor.fmt));
                        row.append($("<td>").text(labor.intensity));
                        row.append($("<td>").text(labor.interval));
                        row.append($("<td>").text(labor.frequency));
                        laborTable.append(row);
                    });

                    //STAFF NOTES
                    staffnotes.forEach(function (staffnotes) {
                        var row = $("<tr>");
                        row.append($("<td>").text(staffnotes.staff_date));
                        row.append($("<td>").text(staffnotes.staff_time));
                        row.append($("<td>").text(staffnotes.staff_bed));
                        row.append($("<td>").text(staffnotes.staff_remarks));
                        staffnotesTable.append(row);
                    });
                    
                    //PHYSICIAN ORDER
                    physician.forEach(function (physician) {
                        var row = $("<tr>");
                        row.append($("<td>").text(physician.physician_date));
                        row.append($("<td>").text(physician.physician_time));
                        row.append($("<td>").text(physician.physician_bed));
                        row.append($("<td>").text(physician.physician_physician));
                        row.append($("<td>").text(physician.physician_order));
                        row.append($("<td>").text(physician.physician_time_noted));
                        physicianTable.append(row);
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
                    console.log("Today's date:", today.toLocaleDateString());
                    var hasAppointmentToday = appointments.some(function (
                        appointment
                    ) {
                        // Convert the appointment date to a Date object for comparison
                        var appointmentDate = new Date(appointment.app_date);

                        // Compare only the date part (not time)
                        var appointmentDateString =
                            appointmentDate.toLocaleDateString();
                        var todayDateString = today.toLocaleDateString();
                        console.log(
                            "Comparing dates:",
                            appointmentDateString,
                            "and",
                            todayDateString
                        ); // Log the comparison of dates
                        if (appointmentDateString === todayDateString) {
                            // Extract the time part of the appointment
                            var appointmentStartTime = appointment.start_time;

                            // Show SweetAlert with appointment time
                            Swal.fire({
                                icon: "success",
                                title: "Appointment Today",
                                text:
                                    "You have an appointment scheduled for today at " +
                                    appointmentStartTime,
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        } else {
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

                    //MEDICATION
                    medications.forEach(function (medication) {
                        var row = $("<tr>");
                        row.append($("<td>").text(medication.med_date));
                        row.append($("<td>").text(medication.medications));
                        medicationTable.append(row);
                    });
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
                    var medications = data.medications;
                    var medicationTable = $("#medication tbody");
                    var delivery = data.delivery;
                    var deliveryTable1 = $("#delivery1 tbody");
                    var delivery2 = data.delivery;
                    var deliveryTable2 = $("#delivery2 tbody");
                    var delivery3 = data.delivery;
                    var deliveryTable3 = $("#delivery3 tbody");
                    var newborn = data.newborn;
                    var newbornTable1 = $("#newborn1 tbody");
                    var newborn2 = data.newborn;
                    var newbornTable2 = $("#newborn2 tbody");
                    var newborn3 = data.newborn;
                    var newbornTable3 = $("#newborn3 tbody");
                    var postpartum = data.postpartum;
                    var postpartumTable = $("#postpartum tbody");
                    var labor = data.labor;
                    var laborTable = $("#labor tbody");
                    var staffnotes = data.staffnotes;
                    var staffnotesTable = $("#staffnotes tbody");
                    var physician = data.physician;
                    var physicianTable = $("#physician tbody");
                    var records = data.records;
                    var recordsTable1 = $("#records1 tbody");
                    var records2 = data.records;
                    var recordsTable2 = $("#records2 tbody");
                    var attachmentData = data.attachment; // Get the array of attachment records
                    var attachmentTable = $("#attachment tbody");
                    // Clear existing rows
                    ultrasoundTable.empty();
                    labTable.empty();
                    appointmentTable.empty();
                    pregnancyTable.empty();
                    medicationTable.empty();
                    deliveryTable1.empty();
                    deliveryTable2.empty();
                    deliveryTable3.empty();
                    newbornTable1.empty();
                    newbornTable2.empty();
                    newbornTable3.empty();
                    postpartumTable.empty();
                    laborTable.empty();
                    staffnotesTable.empty();
                    physicianTable.empty();
                    recordsTable1.empty();
                    recordsTable2.empty();
                    attachmentTable.empty();

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
                            .css("max-width", "100px");
                    
                        // Create a link element for the file
                        var link = $("<a>")
                            .attr("href", record.attachment)
                            .attr("target", "_blank")
                            .text("View File");
                    
                        // Create a div to contain both the image and the link
                        var attachmentDiv = $("<div>")
                            .append(img)
                            .append("<br>") // Line break between the image and the link
                            .append(link);
                    
                        var attachmentCell = $("<td>")
                            .addClass("text-center")
                            .append(attachmentDiv);
                    
                        row.append(attachmentCell);
                        ultrasoundTable.append(row);
                    });

                     //ATTACHMENT
                     attachmentData.forEach(function (attachment) {
                        var row = $("<tr>");
                        row.append($("<td>").text(attachment.attachment_date));
                        row.append($("<td>").text(attachment.attachment_name));
                        row.append($("<td>").text(attachment.attachment_description));
                    
                        // Create an image element for the attachment
                        var img = $("<img>")
                            .attr("src", attachment.attachment_file)
                            .css("max-width", "100px");
                    
                        // Create a link element for the file
                        var link = $("<a>")
                            .attr("href", attachment.attachment_file)
                            .attr("target", "_blank")
                            .text("View File");
                    
                        // Create a div to contain both the image and the link
                        var attachmentDiv = $("<div>")
                            .append(img)
                            .append("<br>") // Line break between the image and the link
                            .append(link);
                    
                        var attachmentCell = $("<td>")
                            .addClass("text-center")
                            .append(attachmentDiv);
                    
                        row.append(attachmentCell);
                        attachmentTable.append(row);
                    });

                     //DELIVERY DATA
                    delivery.forEach(function (delivery) {
                        var row = $("<tr>");
                        row.append($("<td>").text(delivery.name));
                        row.append($("<td>").text(delivery.birthday));
                        row.append($("<td>").text(delivery.birthtime));
                        row.append($("<td>").text(delivery.sex));
                        row.append($("<td>").text(delivery.weight));
                        row.append($("<td>").text(delivery.birth_order));
                        row.append($("<td>").text(delivery.aog));
                        deliveryTable1.append(row);
                    });

                    delivery.forEach(function (delivery) {
                        var row = $("<tr>");
                        row.append($("<td>").text(delivery.hc));
                        row.append($("<td>").text(delivery.cc));
                        row.append($("<td>").text(delivery.ac));
                        row.append($("<td>").text(delivery.bl));
                        row.append($("<td>").text(delivery.hepa));
                        row.append($("<td>").text(delivery.bcg));
                        row.append($("<td>").text(delivery.nbs));
                        deliveryTable2.append(row);
                    });
                    delivery.forEach(function (delivery) {
                        var row = $("<tr>");
                        row.append($("<td>").text(delivery.hearing));
                        row.append($("<td>").text(delivery.handle));
                        row.append($("<td>").text(delivery.assist));
                        row.append($("<td>").text(delivery.referral));
                        deliveryTable3.append(row);
                    });

                       //nEWBORN DATA
                       newborn.forEach(function (newborn) {
                        var row = $("<tr>");
                        row.append($("<td>").text(newborn.card));
                        row.append($("<td>").text(newborn.bln));
                        row.append($("<td>").text(newborn.mln));
                        row.append($("<td>").text(newborn.mfn));
                        row.append($("<td>").text(newborn.dob));
                        row.append($("<td>").text(newborn.dot));
                        row.append($("<td>").text(newborn.doc));
                        row.append($("<td>").text(newborn.toc));
                        newbornTable1.append(row);
                    });

                    newborn.forEach(function (newborn) {
                        var row = $("<tr>");
                        row.append($("<td>").text(newborn.baby_weight));
                        row.append($("<td>").text(newborn.baby_sex));
                        row.append($("<td>").text(newborn.baby_aog));
                        row.append($("<td>").text(newborn.baby_feeding));
                        row.append($("<td>").text(newborn.baby_status));
                        row.append($("<td>").text(newborn.baby_birthplace));
                        row.append($("<td>").text(newborn.baby_address));
                        newbornTable2.append(row);
                    });
                    newborn.forEach(function (newborn) {
                        var row = $("<tr>");
                        row.append($("<td>").text(newborn.baby_contact));
                        row.append($("<td>").text(newborn.baby_blood));
                        row.append($("<td>").text(newborn.baby_staff));
                        row.append($("<td>").text(newborn.drr));
                        row.append($("<td>").text(newborn.baby_result));
                        row.append($("<td>").text(newborn.dc));
                        row.append($("<td>").text(newborn.cb));
                        newbornTable3.append(row);
                    }); 

                          //PNCU
                          records.forEach(function (records) {
                            var row = $("<tr>");
                            row.append($("<td>").text(records.records_date));
                            row.append($("<td>").text(records.records_aog));
                            row.append($("<td>").text(records.records_chief));
                            row.append($("<td>").text(records.records_blood_pressure));
                            row.append($("<td>").text(records.records_weight));
                            row.append($("<td>").text(records.records_temperature));
                            row.append($("<td>").text(records.records_cardiac));
                            recordsTable1.append(row);
                        });
        
                        records.forEach(function (records) {
                            var row = $("<tr>");
                            row.append($("<td>").text(records.records_respiratory));
                            row.append($("<td>").text(records.records_fundic));
                            row.append($("<td>").text(records.records_fht));
                            row.append($("<td>").text(records.records_ie));
                            row.append($("<td>").text(records.records_diagnosis));
                            row.append($("<td>").text(records.records_plan));
                            row.append($("<td>").text(records.records_follow_up));
                            recordsTable2.append(row);
                        });
    


                    //POSTPARTUM
                    postpartum.forEach(function (postpartum) {
                        var row = $("<tr>");
                        row.append($("<td>").text(postpartum.post_date));
                        row.append($("<td>").text(postpartum.post_time));
                        row.append($("<td>").text(postpartum.post_temp));
                        row.append($("<td>").text(postpartum.pr));
                        row.append($("<td>").text(postpartum.rr));
                        row.append($("<td>").text(postpartum.bp));
                        row.append($("<td>").text(postpartum.u));
                        row.append($("<td>").text(postpartum.s));
                        postpartumTable.append(row);
                    });

                      //POSTPARTUM
                    labor.forEach(function (labor) {
                        var row = $("<tr>");
                        row.append($("<td>").text(labor.labor_date));
                        row.append($("<td>").text(labor.labor_time));
                        row.append($("<td>").text(labor.labor_temp));
                        row.append($("<td>").text(labor.labor_pr));
                        row.append($("<td>").text(labor.labor_rr));
                        row.append($("<td>").text(labor.labor_bp));
                        row.append($("<td>").text(labor.fmt));
                        row.append($("<td>").text(labor.intensity));
                        row.append($("<td>").text(labor.interval));
                        row.append($("<td>").text(labor.frequency));
                        laborTable.append(row);
                    });

                    //STAFF NOTES
                    staffnotes.forEach(function (staffnotes) {
                        var row = $("<tr>");
                        row.append($("<td>").text(staffnotes.staff_date));
                        row.append($("<td>").text(staffnotes.staff_time));
                        row.append($("<td>").text(staffnotes.staff_bed));
                        row.append($("<td>").text(staffnotes.staff_remarks));
                        staffnotesTable.append(row);
                    });
                    
                    //PHYSICIAN ORDER
                    physician.forEach(function (physician) {
                        var row = $("<tr>");
                        row.append($("<td>").text(physician.physician_date));
                        row.append($("<td>").text(physician.physician_time));
                        row.append($("<td>").text(physician.physician_bed));
                        row.append($("<td>").text(physician.physician_physician));
                        row.append($("<td>").text(physician.physician_order));
                        row.append($("<td>").text(physician.physician_time_noted));
                        physicianTable.append(row);
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
                    var hasAppointmentToday = appointments.some(function (
                        appointment
                    ) {
                        // Convert the appointment date to a Date object for comparison
                        var appointmentDate = new Date(appointment.app_date);

                        // Compare only the date part (not time)
                        var appointmentDateString =
                            appointmentDate.toLocaleDateString();
                        var todayDateString = today.toLocaleDateString();

                        if (appointmentDateString === todayDateString) {
                            // Extract the time part of the appointment
                            var appointmentStartTime = appointment.start_time;

                            // Show SweetAlert with appointment time
                            Swal.fire({
                                icon: "success",
                                title: "Appointment Today",
                                text:
                                    "You have an appointment scheduled for today at " +
                                    appointmentStartTime,
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        } else {
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

                    medications.forEach(function (medication) {
                        var row = $("<tr>");
                        row.append($("<td>").text(medication.med_date));
                        row.append($("<td>").text(medication.medications));
                        medicationTable.append(row);
                    });
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
