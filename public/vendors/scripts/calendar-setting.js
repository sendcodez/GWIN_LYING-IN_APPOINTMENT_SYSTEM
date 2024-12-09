jQuery(document).ready(function () {
    (function () {
        "use strict";

        // Initialize FullCalendar
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

                // Reset cell content and styles
                cell.empty(); // Remove any previously appended content
                cell.removeClass("clickable unclick past-date"); // Clear all classes
                cell.css({ backgroundColor: "", cursor: "" }); // Reset styles

                // Disable past dates
                if (date.isBefore(moment(), "day")) {
                    cell.addClass("past-date");
                    cell.css({
                        backgroundColor: "#d3d3d3", // Light grey background
                        cursor: "not-allowed", // Disable pointer interaction
                    });
                    cell.html(""); // Clear any residual content
                    return; // Skip further processing for past dates
                }

                // Iterate through all availabilities
                doctorAvailabilities.forEach(function (availability) {
                    // If doctor is available on this day
                    if (
                        selectedDoctorId == availability.doctor_id &&
                        availability.day.toLowerCase() === dayName
                    ) {
                        var startTime = moment(availability.start_time, "HH:mm:ss");
                        var endTime = moment(availability.end_time, "HH:mm:ss");

                        // Create a copy of startTime to avoid modifying the original variable
                        var currentTime = moment(startTime);

                        // Assume the day is available, change if fully booked
                        var isDayFullyBooked = true;

                        while (currentTime.isBefore(endTime)) {
                            var slotStart = currentTime.format("HH:mm:ss");
                            var slotEnd = moment(currentTime).add(30, "minutes").format("HH:mm:ss");

                            // Check for any appointments that overlap with this slot
                            var isSlotAvailable = !allAppointments.some(function (appointment) {
                                return (
                                    appointment.date === date.format("YYYY-MM-DD") &&
                                    appointment.status !== 4 && // Ensure the appointment is not cancelled
                                    (moment(appointment.start_time, "HH:mm:ss").isBefore(moment(slotEnd, "HH:mm:ss")) &&
                                     moment(appointment.end_time, "HH:mm:ss").isAfter(moment(slotStart, "HH:mm:ss")))
                                );
                            });

                            // If any slot is available, the day is not fully booked
                            if (isSlotAvailable) {
                                isDayFullyBooked = false;
                                break; // Exit loop early if we find an available slot
                            }

                            // Increment currentTime manually by adding 30 minutes
                            currentTime = moment(currentTime).add(30, "minutes");
                        }

                        // If the day is fully booked, mark it as unavailable
                        if (isDayFullyBooked) {
                            isAvailable = false;
                        } else {
                            isAvailable = true;
                        }
                    }
                });

                // Apply styles and behavior based on availability
                if (isAvailable) {
                    // Clear unavailable styles if available
                    cell.removeClass("unclick");
                    cell.css({
                        cursor: "pointer",
                        backgroundColor: "#d4edda", // Light green background for available days
                    });
                    cell.append(
                        "<span class='available' style='color:green;font-size:.8rem;'>Click to Book</span>"
                    );
                } else {
                    // Mark the day as unavailable if fully booked
                    cell.addClass("unclick");
                    cell.css({
                        backgroundColor: "#f8d7da", // Red background for unavailable days
                    });
                    cell.append(
                        "<span class='not-available' style='color:red;font-size:.8rem;'>UNAVAILABLE</span>"
                    );
                }

                // Debugging: Log the availability status for each date
                console.log("Date:", date.format("YYYY-MM-DD"), "Available:", isAvailable);
            },

            // Handle Day Click
            dayClick: function (date, jsEvent, view) {
                // Prevent clicking on unavailable days
                if (
                    jQuery(this).hasClass("unclick") ||
                    date.isBefore(moment(), "day")
                ) {
                    return false; // Prevent click on past dates or unavailable days
                }

                // Only allow click if the day is available
                jQuery("#selected_date").val(date.format("YYYY-MM-DD"));
                jQuery("#modal-view-event-add").modal();
            },
        });

        // Re-fetch events and update calendar on doctor selection change
        jQuery("#serviceFilter").change(function () {
            var selectedDoctorId = jQuery("#serviceFilter").val();

            // Clear old availability and events
            jQuery("#calendar").fullCalendar("removeEvents");

            // Update the dayRender logic for the new selected doctor
            jQuery("#calendar")
                .find(".fc-day")
                .each(function () {
                    var cellDate = jQuery(this).data("date"); // Get the date from the cell
                    if (cellDate) {
                        var date = moment(cellDate); // Parse it into a moment object
                        var cell = jQuery(this); // Current cell

                        // Call the dayRender logic manually
                        var dayName = date.format("dddd").toLowerCase();
                        var isAvailable = false;

                        cell.removeClass("clickable unclick");
                        cell.find(".available, .not-available").remove();

                        doctorAvailabilities.forEach(function (availability) {
                            if (
                                selectedDoctorId == availability.doctor_id &&
                                availability.day.toLowerCase() === dayName
                            ) {
                                isAvailable = true;
                            }
                        });
                        // Exclude past dates from availability logic
                        if (date.isBefore(moment(), "day")) {
                            return; // Skip the availability logic for past dates
                        }

                        if (isAvailable) {
                            cell.addClass("clickable");
                            cell.css({
                                cursor: "pointer",
                                backgroundColor: "#d4edda",
                            });
                            cell.append(
                                "<span class='available' style='color:green;font-size:.8rem;'>Click to Book</span>"
                            );
                        } else {
                            cell.addClass("unclick");
                            cell.css({
                                backgroundColor: "#f8d7da",
                            });
                            cell.append(
                                "<span class='not-available' style='color:red;font-size:.8rem;'>UNAVAILABLE</span>"
                            );
                        }
                    }
                });

            // Re-fetch events for the new selected doctor
            jQuery("#calendar").fullCalendar("refetchEvents");
        });
    })(jQuery);
});
