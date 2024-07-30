jQuery(document).ready(function () {
    jQuery("#add-event").submit(function () {
        var values = {};
        $.each($("#add-event").serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });
        console.log(values);
    });
});

(function () {
    "use strict";
    // ------------------------------------------------------- //
    // Calendar
    // ------------------------------------------------------ //
    jQuery(function () {
        // page is ready
        jQuery("#calendar").fullCalendar({
            themeSystem: "bootstrap4",
            // emphasizes business hours
            businessHours: false,
            defaultView: "month",
            // event dragging & resizing
            editable: true,
            // header
            header: {
                left: "title",
                center: "month,agendaWeek,agendaDay",
                right: "today prev,next",
            },
            events: function (start, end, timezone, callback) {
                var events = [];
                appointments.forEach(function (appointment) {
                    if (appointment.status !== 4) {
                        // Fetch appointments only if status is not cancelled
                        var startTime = appointment.start_time;
            
                        // Check if startTime is valid
                        if (startTime) {
                            console.log("Start Time:", startTime);
            
                            // Split and format time if startTime is not null or empty
                            var timeParts = startTime.split(":");
                            var hour = parseInt(timeParts[0], 10);
                            var minute = parseInt(timeParts[1], 10);
                            var period = "AM";
            
                            if (hour >= 12) {
                                period = "PM";
                                if (hour > 12) {
                                    hour -= 12;
                                }
                            }
            
                            var timeString =
                                hour +
                                ":" +
                                ("0" + minute).slice(-2) +
                                " " +
                                period;
            
                            var title = timeString; // Construct the event title
            
                            var event = {
                                title: title,
                                start: appointment.date,
                                service_id: appointment.service_id,
                            };
                            events.push(event);
                        } else {
                            console.error("Invalid start time:", startTime);
                        }
                    }
                });
                callback(events);
            },
            

            /*
            eventClick: function (event, jsEvent, view) {
                jQuery(".event-title").text(event.title);
                jQuery(".doctor-name").text(event.doctorName);
                jQuery(".service").text(event.service);
                jQuery(".date").text(event.date);
                jQuery(".time").text(event.time);
                jQuery("#modal-view-event").modal();
            },
            */

            dayClick: function (date, jsEvent, view) {
                if (jQuery(this).hasClass("unclick")) {
                    return false;
                }
                if (date.isBefore(moment(), "day")) {
                    return false; // Prevent default action for past dates
                }
                jQuery('input[name="selected_date"]').val(
                    date.format("YYYY-MM-DD")
                );
                jQuery('input[name="selected_day"]').val(date.format("dddd"));
                var selectedDay = jQuery('input[name="selected_day"]').val();
                console.log("Selected Day:", selectedDay);
                jQuery("#modal-view-event-add").modal();
            },

            // Callback to customize day rendering
            dayRender: function(date, cell) {
                var dayName = date.format("dddd").toLowerCase();
                var isAvailable = false;
            
                doctorAvailabilities.forEach(function(availability) {
                    if (availability.day === dayName && availability.status !== 4) {
                        var startTime = moment(availability.start_time, "HH:mm:ss");
                        var endTime = moment(availability.end_time, "HH:mm:ss");
            
                        // Create a copy of startTime to avoid modifying the original variable
                        var currentTime = moment(startTime);
            
                        while (currentTime.isBefore(endTime)) {
                            var slotStart = currentTime.format("HH:mm:ss");
                            var slotEnd = moment(currentTime).add(30, "minutes").format("HH:mm:ss"); // Add 30 minutes to currentTime
            
                            var isSlotAvailable = !allAppointments.some(function(appointment) {
                                // Check if the appointment is not cancelled
                                return appointment.date === date.format("YYYY-MM-DD") &&
                               
                                (
                                    appointment.status !== 4 &&
                                  // Check if appointment overlaps with the current slot
                                  (moment(appointment.start_time, "HH:mm:ss") < moment(slotEnd, "HH:mm:ss") && 
                                   moment(appointment.end_time, "HH:mm:ss") > moment(slotEnd, "HH:mm:ss"))
                                );
                            });
            
                            if (isSlotAvailable) {
                                isAvailable = true;
                                break; // Exit the loop if any available slot is found
                            }
            
                            // Increment currentTime manually by adding 30 minutes
                            currentTime = moment(currentTime).add(30, "minutes");
                        }
                    }
                });
            
                if (!isAvailable) {
                    cell.addClass("red-day");
                    cell.addClass("unclick");
                    cell.append("<span class='not-available'>Not Available</span>");
                }
            
            },
        });
    });
})(jQuery);
