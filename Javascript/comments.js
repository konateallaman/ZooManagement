$(function() {
    // Handle the form submission
    $('#add-comment-form').submit(function(event) {
        event.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var comment = $('#comment').val();
        $.ajax({
            url: 'add-comment.php',
            method: 'POST',
            data: {
                name: name,
                email: email,
                comment: comment
            },
            success: function(response) {
                // Refresh the comments section
                $('.comments').html(response);
                // Clear the form
                $('#name').val('');
                $('#email').val('');
                $('#comment').val('');
            }
        });
    });

    // Handle the like button clicks
    $('.like-button').click(function() {
        var commentId = $(this).data('comment-id');
        $.ajax({
            url: 'like-comment.php',
            method: 'POST',
            data: {
                commentId: commentId
            },
            success: function(response) {
                // Update the like count
                var count = parseInt($('.count').html());
                $('.count').html(count + 1);
            }
        });
    });
});
