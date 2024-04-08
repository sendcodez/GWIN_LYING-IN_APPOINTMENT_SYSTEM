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
                $.ajax({
                    url: '/getAllAppointments',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var events = [];
                        response.forEach(function(appointment) {
                            var startTime = appointment.start_time;
                            var timeParts = startTime.split(':');
                            var hour = parseInt(timeParts[0], 10);
                            var minute = parseInt(timeParts[1], 10);
                            var period = 'AM';
                            if (hour >= 12) {
                                period = 'PM';
                                if (hour > 12) {
                                    hour -= 12;
                                }
                            }
                            var timeString = hour + ':' + ('0' + minute).slice(-2) + ' ' + period;
                            
                            var title = timeString + ' - Dr. ' + appointment.doctor_name;

                            var event = {
                                title: title,
                                start: appointment.date,
                                service_id: appointment.service_id,
                            };
                            events.push(event);
                        });
                        callback(events);
                    },
                    
                    
                });
                
            },
            
            
        });
    });
    
})(jQuery);
