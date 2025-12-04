$(document).ready(() => {
    // HANDLE UPVOTE BUTTON CLICK
    $(document).on('click', '.vote-count', function() {
        
        const el = $(this);

        el.prop('disabled', true); // DISABLE BUTTON TO PREVENT MULTIPLE CLICKS

        const commentId = el.data('id');

        // AJAX REQUEST TO UPVOTE THE COMMENT
        $.post('/index.php?page=upvote', { comment_id: commentId }, function(response) {
            el.text("👍 " + response.newVotes);
        }, "json");
    });
});