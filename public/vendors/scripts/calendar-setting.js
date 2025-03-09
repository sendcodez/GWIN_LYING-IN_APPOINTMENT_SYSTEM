jQuery(document).ready(function () {
    "use strict";

    // FullCalendar initialization
    jQuery("#calendar").fullCalendar({
        themeSystem: "bootstrap4",
        businessHours: false,
        defaultView: "month",
        editable: true,
        header: {
            left: "title",
            right: "prev,next",
        },

        // Day Render Function
        dayRender: function (date, cell) {
            var dayName = date.format("dddd").toLowerCase();
            var selectedDoctorId = jQuery("#serviceFilter").val(); // Get the selected doctor ID
            var isAvailable = false; // Assume unavailable initially
            console.log("Day Render: " + date.format("YYYY-MM-DD") + " | Doctor ID: " + selectedDoctorId);

            // Reset cell content and styles
            cell.empty(); // Remove any previously appended content
            cell.removeClass("clickable unclick past-date"); // Clear all classes
            cell.css({ backgroundColor: "", cursor: "" }); // Reset styles

            // Disable past dates
            if (date.isBefore(moment(), "day")) {
                console.log("Past date detected: " + date.format("YYYY-MM-DD"));
                cell.addClass("past-date");
                cell.css({
                    backgroundColor: "#d3d3d3", // Light grey background
                    cursor: "not-allowed", // Disable pointer interaction
                });
                cell.html(""); // Clear any residual content
                return; // Skip further processing for past dates
            }

            // Check if the date is a rest day
            var formattedDate = date.format("YYYY-MM-DD");

            // Log restDays content for debugging
            console.log("Rest days array: ", restDays);

            // Normalize the formatted date to ignore the time part
            var normalizedFormattedDate = moment(formattedDate).startOf("day");

            // Adjust the rest days to match only the date part (ignoring time)
            var isRestDay = restDays.some(function (restDayEntry) {
                // Normalize rest day entry to start of the day (ignoring time)
                var restDay = moment(restDayEntry).startOf("day");
                console.log("Checking rest day: " + restDay.format("YYYY-MM-DD"));
                return restDay.isSame(normalizedFormattedDate, "day"); // Compare only the date part
            });

            if (isRestDay) {
                console.log("Rest day detected: " + formattedDate); // Log detected rest day
                // Mark the day as unavailable
                cell.addClass("unclick");
                cell.css({
                    backgroundColor: "#f8d7da", // Red background for unavailable days
                });
                cell.append(
                    "<span class='not-available' style='color:red;font-size:.6rem;'>UNAVAILABLE</span>"
                );
                return; // Skip further processing for rest days
            }

            // Check doctor availability for the selected doctor
            doctorAvailabilities.forEach(function (availability) {
                if (
                    selectedDoctorId == availability.doctor_id &&
                    availability.day.toLowerCase() === dayName
                ) {
                    console.log("Availability found for doctor: " + selectedDoctorId + " on day: " + dayName);
                    var startTime = moment(availability.start_time, "HH:mm:ss");
                    var endTime = moment(availability.end_time, "HH:mm:ss");

                    // Assume the day is available unless all slots are booked
                    var isDayFullyBooked = true;
                    var currentTime = moment(startTime);

                    while (currentTime.isBefore(endTime)) {
                        var slotStart = currentTime.format("HH:mm:ss");
                        var slotEnd = moment(currentTime).add(30, "minutes").format("HH:mm:ss");

                        console.log("Checking slot: " + slotStart + " to " + slotEnd);

                        // Check if any appointments overlap with this slot
                        var isSlotAvailable = !allAppointments.some(function (appointment) {
                            return (
                                appointment.date === formattedDate &&
                                appointment.status !== 4 && // Ensure the appointment is not cancelled
                                moment(appointment.start_time, "HH:mm:ss").isBefore(moment(slotEnd, "HH:mm:ss")) &&
                                moment(appointment.end_time, "HH:mm:ss").isAfter(moment(slotStart, "HH:mm:ss"))
                            );
                        });

                        if (isSlotAvailable) {
                            console.log("Slot available: " + slotStart + " to " + slotEnd);
                            isAvailable = true; // Mark the day as available
                            break;
                        }

                        // Increment currentTime manually by adding 30 minutes
                        currentTime = moment(currentTime).add(30, "minutes");
                    }

                    // If all slots are booked, mark as unavailable
                    if (!isAvailable) {
                        isDayFullyBooked = true;
                    }
                }
            });

            // Mark the cell as available or unavailable
            if (isAvailable) {
                console.log("Day available: " + formattedDate);
                cell.addClass("clickable");
                cell.css({
                    cursor: "pointer",
                    backgroundColor: "#d4edda", // Light green background for available days
                });
                cell.append("<span class='available' style='color:green;font-size:.8rem;'>Click to Book</span>");
            } else {
                console.log("Day unavailable: " + formattedDate);
                cell.addClass("unclick");
                cell.css({
                    backgroundColor: "#f8d7da", // Red background for unavailable days
                });
                cell.append("<span class='not-available' style='color:red;font-size:.6rem;'>UNAVAILABLE</span>");
            }
        },

        // Handle Day Click
        dayClick: function (date, jsEvent, view) {
            console.log("Day Clicked: " + date.format("YYYY-MM-DD"));
            // Prevent clicking on unavailable days
            if (
                jQuery(this).hasClass("unclick") ||
                date.isBefore(moment(), "day")
            ) {
                return false; // Prevent click on past dates or unavailable days
            }
            $('#selected_date').val(date.format('YYYY-MM-DD'));
            $('#selected_day').val(date.format('dddd').toLowerCase());
            
            // Show the modal
            $('#modal-view-event-add').modal('show');
            
            // Add this line to populate the form fields
            populateFormFromFilter();  

            // Only allow click if the day is available
            jQuery("#selected_date").val(date.format("YYYY-MM-DD"));
            jQuery("#modal-view-event-add").modal();
            
        },
    });

    // Re-fetch events and update calendar on doctor selection change
    jQuery("#serviceFilter").change(function () {
        var selectedDoctorId = jQuery("#serviceFilter").val();
        console.log("Doctor selection changed: " + selectedDoctorId);
    
        // Clear old events but preserve the "unavailable" state for fully booked days
        jQuery("#calendar").fullCalendar("removeEvents");
    
        // Get the current date to compare with the calendar cells
        var today = moment().startOf('day'); // Today at midnight
        console.log("Current date for comparison: " + today.format("YYYY-MM-DD"));
    
        // Iterate through each calendar cell and re-render it based on new availability
        jQuery("#calendar")
            .find(".fc-day")
            .each(function () {
                var cellDate = jQuery(this).data("date"); // Get the date from the cell
                if (cellDate) {
                    var date = moment(cellDate); // Parse it into a moment object
                    var cell = jQuery(this); // Current cell
                    var dayName = date.format("dddd").toLowerCase();
                    var isAvailable = false; // Default assumption for availability
    
                    // Only apply text for future or current dates
                    if (date.isBefore(today)) {
                        return; // Skip previous dates
                    }
    
                    console.log("Checking availability for cell date: " + cellDate);
    
                    // Remove any previous status (available/not-available)
                    cell.removeClass("clickable unclick");
                    cell.find(".available, .not-available").remove();
    
                    // Check if the selected doctor has a rest day on this date
                    var normalizedFormattedDate = moment(cellDate).startOf("day");
    
                    // Filter rest days for the selected doctor
                    var isRestDay = allRestDays.some(function (restDayEntry) {
                        // Check if the doctor matches and if the rest day is on the same date
                        return restDayEntry.doctor_id == selectedDoctorId &&
                            moment(restDayEntry.rest_day).isSame(normalizedFormattedDate, "day");
                    });
    
                    if (isRestDay) {
                        console.log("Rest day detected for selected doctor: " + cellDate);
                        // Mark the day as unavailable
                        cell.addClass("unclick");
                        cell.css({
                            backgroundColor: "#f8d7da", // Red background for unavailable days
                        });
                        cell.append("<span class='not-available' style='color:red;font-size:.6rem;'>UNAVAILABLE</span>");
                        return; // Skip further processing for rest days
                    }
    
                    // Check availability for the selected doctor
                    doctorAvailabilities.forEach(function (availability) {
                        if (
                            selectedDoctorId == availability.doctor_id &&
                            availability.day.toLowerCase() === dayName
                        ) {
                            console.log("Availability found for doctor: " + selectedDoctorId + " on day: " + dayName);
                            var startTime = moment(availability.start_time, "HH:mm:ss");
                            var endTime = moment(availability.end_time, "HH:mm:ss");
    
                            // Check if the doctor has slots on this day
                            var isDayFullyBooked = true;
                            var currentTime = moment(startTime);
    
                            while (currentTime.isBefore(endTime)) {
                                var slotStart = currentTime.format("HH:mm:ss");
                                var slotEnd = moment(currentTime).add(30, "minutes").format("HH:mm:ss");
    
                                console.log("Checking slot: " + slotStart + " to " + slotEnd);
    
                                // Check for appointments that overlap with this slot
                                var isSlotAvailable = !allAppointments.some(function (appointment) {
                                    return (
                                        appointment.date === date.format("YYYY-MM-DD") &&
                                        appointment.status !== 4 && // Ensure the appointment is not cancelled
                                        (moment(appointment.start_time, "HH:mm:ss").isBefore(moment(slotEnd, "HH:mm:ss")) &&
                                        moment(appointment.end_time, "HH:mm:ss").isAfter(moment(slotStart, "HH:mm:ss"))))
                                    ;
                                });
    
                                // If any slot is available, mark the day as not fully booked
                                if (isSlotAvailable) {
                                    isAvailable = true;
                                    break; // Exit loop early if we find an available slot
                                }
    
                                // Increment currentTime manually by adding 30 minutes
                                currentTime = moment(currentTime).add(30, "minutes");
                            }
    
                            if (!isAvailable) {
                                isDayFullyBooked = true;
                            }
                        }
                    });
    
                    // If the day is available, apply the "clickable" state
                    if (isAvailable) {
                        console.log("Day available: " + cellDate);
                        cell.addClass("clickable");
                        cell.css({
                            cursor: "pointer",
                            backgroundColor: "#d4edda", // Light green for available
                        });
                        cell.append("<span class='available' style='color:green;font-size:.8rem;'>Click to Book</span>");
                    } else {
                        // Mark the day as unavailable if fully booked
                        console.log("Day unavailable: " + cellDate);
                        cell.addClass("unclick");
                        cell.css({
                            backgroundColor: "#f8d7da", // Red background for unavailable days
                        });
                        cell.append("<span class='not-available' style='color:red;font-size:.6rem;'>UNAVAILABLE</span>");
                    }
                }
            });
    
        // After updating cells, re-fetch events to make sure the calendar is in sync
        jQuery("#calendar").fullCalendar("refetchEvents");
    });
jQuery("#serviceFilter").change(function () {
    var selectedDoctorId = jQuery("#serviceFilter").val();
    console.log("Doctor selection changed: " + selectedDoctorId);

    // Clear old events but preserve the "unavailable" state for fully booked days
    jQuery("#calendar").fullCalendar("removeEvents");

    // Get the current date to compare with the calendar cells
    var today = moment().startOf('day'); // Today at midnight
    console.log("Current date for comparison: " + today.format("YYYY-MM-DD"));

    // Iterate through each calendar cell and re-render it based on new availability
    jQuery("#calendar")
        .find(".fc-day")
        .each(function () {
            var cellDate = jQuery(this).data("date"); // Get the date from the cell
            if (cellDate) {
                var date = moment(cellDate); // Parse it into a moment object
                var cell = jQuery(this); // Current cell
                var dayName = date.format("dddd").toLowerCase();
                var isAvailable = false; // Default assumption for availability

                // Only apply text for future or current dates
                if (date.isBefore(today)) {
                    return; // Skip previous dates
                }

                console.log("Checking availability for cell date: " + cellDate);

                // Remove any previous status (available/not-available)
                cell.removeClass("clickable unclick");
                cell.find(".available, .not-available").remove();

                // Check if the selected doctor has a rest day on this date
                var normalizedFormattedDate = moment(cellDate).startOf("day");

                // Filter rest days for the selected doctor
                var isRestDay = allRestDays.some(function (restDayEntry) {
                    // Check if the doctor matches and if the rest day is on the same date
                    return restDayEntry.doctor_id == selectedDoctorId &&
                        moment(restDayEntry.rest_day).isSame(normalizedFormattedDate, "day");
                });

                if (isRestDay) {
                    console.log("Rest day detected for selected doctor: " + cellDate);
                    // Mark the day as unavailable
                    cell.addClass("unclick");
                    cell.css({
                        backgroundColor: "#f8d7da", // Red background for unavailable days
                    });
                    cell.append("<span class='not-available' style='color:red;font-size:.6rem;'>UNAVAILABLE</span>");
                    return; // Skip further processing for rest days
                }

                // Check availability for the selected doctor
                doctorAvailabilities.forEach(function (availability) {
                    if (
                        selectedDoctorId == availability.doctor_id &&
                        availability.day.toLowerCase() === dayName
                    ) {
                        console.log("Availability found for doctor: " + selectedDoctorId + " on day: " + dayName);
                        var startTime = moment(availability.start_time, "HH:mm:ss");
                        var endTime = moment(availability.end_time, "HH:mm:ss");

                        // Check if the doctor has slots on this day
                        var isDayFullyBooked = true;
                        var currentTime = moment(startTime);

                        while (currentTime.isBefore(endTime)) {
                            var slotStart = currentTime.format("HH:mm:ss");
                            var slotEnd = moment(currentTime).add(30, "minutes").format("HH:mm:ss");

                            console.log("Checking slot: " + slotStart + " to " + slotEnd);

                            // Check for appointments that overlap with this slot
                            var isSlotAvailable = !allAppointments.some(function (appointment) {
                                return (
                                    appointment.date === date.format("YYYY-MM-DD") &&
                                    appointment.status !== 4 && // Ensure the appointment is not cancelled
                                    (moment(appointment.start_time, "HH:mm:ss").isBefore(moment(slotEnd, "HH:mm:ss")) &&
                                    moment(appointment.end_time, "HH:mm:ss").isAfter(moment(slotStart, "HH:mm:ss"))))
                                ;
                            });

                            // If any slot is available, mark the day as not fully booked
                            if (isSlotAvailable) {
                                isAvailable = true;
                                break; // Exit loop early if we find an available slot
                            }

                            // Increment currentTime manually by adding 30 minutes
                            currentTime = moment(currentTime).add(30, "minutes");
                        }

                        if (!isAvailable) {
                            isDayFullyBooked = true;
                        }
                    }
                });

                // If the day is available, apply the "clickable" state
                if (isAvailable) {
                    console.log("Day available: " + cellDate);
                    cell.addClass("clickable");
                    cell.css({
                        cursor: "pointer",
                        backgroundColor: "#d4edda", // Light green for available
                    });
                    cell.append("<span class='available' style='color:green;font-size:.8rem;'>Click to Book</span>");
                } else {
                    // Mark the day as unavailable if fully booked
                    console.log("Day unavailable: " + cellDate);
                    cell.addClass("unclick");
                    cell.css({
                        backgroundColor: "#f8d7da", // Red background for unavailable days
                    });
                    cell.append("<span class='not-available' style='color:red;font-size:.6rem;'>UNAVAILABLE</span>");
                }
            }
        });

    // After updating cells, re-fetch events to make sure the calendar is in sync
    jQuery("#calendar").fullCalendar("refetchEvents");
});
    
});
        