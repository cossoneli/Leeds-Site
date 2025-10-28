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

        const days = Math.floor((diff / (1000 * 60 * 60 * 24)));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);

        $(".countdown").html(
            `
            <span class="px-2 border-bottom countdown-days">${days} D</span>
            <span class="px-2 border-bottom countdown-hours">${hours} H</span>
            <span class="px-2 border-bottom countdown-minutes">${minutes} M</span>
            <span class="px-2 border-bottom countdown-seconds">${seconds} S</span>
            `
        );
    }
});

