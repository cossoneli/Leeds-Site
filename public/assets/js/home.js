$(document).ready(() => {

    // IF A PANEL IS CLICKED, GO TO THREAD PAGE
    $(".my-panel").click(function() {
        const topic = $(this).data('topic'); // get data-topic
        window.open('/index.php?page=thread&topic=' + topic, '_blank'); 
    })

    $(document).on('click', '.reply-button', function() {
        const commentDiv = $(this).closest('.comment');

        const parentDiv = commentDiv.parent();

        // Avoid adding multiple reply forms
        if (commentDiv.find('.reply-form').length === 0) {
            const replyForm = `
                <div class="reply-form d-flex my-3">
                    <div class="comment-body flex-grow-1">
                        <textarea class="form-control mb-2" placeholder="Write your reply..."></textarea>
                        <div class="text-end">
                            <button class="btn btn-primary btn-sm submit-reply">Reply</button>
                            <button class="btn btn-secondary btn-sm cancel-reply">Cancel</button>
                        </div>
                    </div>
                </div>
            `;
            parentDiv.append(replyForm);
        }
    });

    // Optional: Cancel button
    $(document).on('click', '.cancel-reply', function() {
        $(this).closest('.reply-form').remove();
    });


    // live match countdown
    const matchTime = window.fixtureDate;

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

