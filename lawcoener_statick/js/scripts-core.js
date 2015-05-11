$("#find-a-lawyer-button").click(function() {
        window.location.href='/finde.html';
});

$("#find-information-button").click(function() {
    window.location.href='/finde-info.html';
});

$(".contact-button").click(function() {
    $(".shadow-gen").toggle();
    $(".sidebar-section.mobile-popup").toggle();
});

$(".side-bar-profile .sidebar-section.mobile-popup .closer").click(function() {
    $(".shadow-gen").toggle();
    $(".sidebar-section.mobile-popup").toggle();
});

$(".mobile-menu").click(function() {
    $(".menu ul").toggle( "slow" );
    $(".topics-top_view").toggle( "slow" );
});

$(".selector-item").click(function() {
    $(".taber-selector").toggleClass("hide-skills");
    $(".selector-item").toggleClass("active");
    $(".save-lawyer-review, .reviews-toggle").toggle();
});

$(".mobile-menu-search").click(function() {
    $(".slide-toogle").slideToggle("slow")
});