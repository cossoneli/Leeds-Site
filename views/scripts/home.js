$(document).ready(() => {

    // IF A PANEL IS CLICKED, GO TO THREAD PAGE
    $(".my-panel").click(function() {
        const topic = $(this).data('topic'); // get data-topic
        window.open('thread.php?topic=' + topic, '_blank'); 
    })


});
