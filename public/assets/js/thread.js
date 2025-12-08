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

    $(document).on('click', '.reply-button', function() {
        const commentDiv = $(this).closest('.comment');

        const parentDiv = commentDiv.parent();

        const parentId = commentDiv.data('parent-comment');
        
        // Avoid adding multiple reply forms
        if (parentDiv.find('.reply-form').length === 0) {
            const replyForm = `
                <form class="reply-form" action="" method="POST">
                    <div class="d-flex my-3">
                        <div class="comment-body flex-grow-1">
                            <textarea id="comment" name="comment" class="form-control mb-2" placeholder="Write your reply..."></textarea>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-sm submit-reply">Reply</button>
                                <button class="btn btn-secondary btn-sm cancel-reply">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            `;
            const $replyForm = $(replyForm);

            $replyForm.attr('action', `${baseUrl}/index.php?page=insert_reply&parent_id=${parentId}`);
            parentDiv.append($replyForm);
        }
    });

    $(document).on('click', '.cancel-reply', function() {
        $(this).closest('.reply-form').remove();
    });
});