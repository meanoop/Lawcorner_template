
$("#find-a-lawyer-button").click(function() {
        window.location.href='/finde.html';
});

$("#find-information-button").click(function() {
    window.location.href='/finde-info.html';
});

$(".border-menu").click(function() {
    $(".menu ul").toggle( "slow" );
    $(".sidebar-section").toggle();
    $(".find-information #carousel-widen").toggle();
});
