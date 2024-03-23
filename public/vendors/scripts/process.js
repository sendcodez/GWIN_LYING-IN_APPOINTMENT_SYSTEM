var width = 100,
    perfData = window.performance.timing,
    EstimatedTime = -(perfData.loadEventEnd - perfData.navigationStart),
    time = parseInt((EstimatedTime / 1000) % 60) * 100;

// Percentage Increment Animation
var PercentageID = $("#percent1"),
    start = 0,
    end = 100,
    duration = 2000; // Set duration to 2000 milliseconds (2 seconds)
animateValue(PercentageID, start, end, duration);

function animateValue(id, start, end, duration) {
    var range = end - start,
        current = start,
        increment = end > start ? 1 : -1,
        stepTime = Math.abs(Math.floor(duration / range)), // Adjust this value for faster animation
        obj = $(id);

    var timer = setInterval(function() {
        current += increment;
        $(obj).text(current + "%");
        $("#bar1").css("width", current + "%");

        if (current == end) {
            clearInterval(timer);
        }
    }, 1); // Decreased stepTime to make animation faster
}

// Fading Out Loadbar on Finished
setTimeout(function() {
    $(".pre-loader").fadeOut(100);
}, 1000); // Set fadeOut to 2000 milliseconds (2 seconds)
