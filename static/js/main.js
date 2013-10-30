$(function() {
    // expand/collapse header search field
    $("[for='search']").on("click", function() {
        $('#search').toggleClass('open');
    });
});