$(document).ready(() => {
    $('#expand-icon').on("click", () => {
        console.log("clicked");
        $('.my-panel').css('display','none !important');
    });
});
