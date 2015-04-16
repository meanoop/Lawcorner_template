$("#find-a-lawyer-button").click(function() {
        window.location.href='/finde.html';
});

$("#find-information-button").click(function() {
    window.location.href='/finde-info.html';
});

$(".mobile-menu").click(function() {
    $(".menu ul").toggle( "slow" );
    $(".sidebar-section").toggle();
    $(".topics-top_view").toggle( "slow" );
});
