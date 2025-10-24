$(document).ready(() => {

    // IF A PANEL IS CLICKED, GO TO THREAD PAGE
    $(".my-panel").click(function() {
        const topic = $(this).data('topic'); // get data-topic
        window.open('thread.php?topic=' + topic, '_blank'); 
    })


    // live match countdown
    const matchTime = window.fixtureDate;
    console.log(matchTime);

    updateCountdown();

    setInterval(updateCountdown, 1000);

    // ---------------------------------------SOME HELPER FUNCTIONS

    function updateCountdown() {
        const now = new Date().getTime();
        const diff = matchTime - now;

        if (diff <= 0) {
            $(".countdown").html("<span>Kickoff!</span>");
            return;
        }

        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);

        $(".countdown").html(
            `
            <span class="mx-2 countdown-days">${hours} H</span>
            <span class="mx-2 countdown-hours">${minutes} M</span>
            <span class="mx-2 countdown-minutes">${seconds} S</span>
            `
        );
    }
});

