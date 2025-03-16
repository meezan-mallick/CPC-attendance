$(document).ready(function () {
  // Mobile-first approach - handle sidebar toggle
  $("#sidebarToggle").on("click", function () {
    // Toggle sidebar visibility
    $("#sidebar").toggleClass("active");

    // Toggle overlay on mobile
    $(".overlay").toggleClass("active");

    // Toggle content width on desktop
    if ($(window).width() >= 768) {
      $("#sidebar").toggleClass("hidden");
      $("#content").toggleClass("full");
    }

    // Close navbar collapse if open on mobile
    if ($(window).width() < 992) {
      if ($(".navbar-collapse").hasClass("show")) {
        $(".navbar-collapse").removeClass("show");
      }
    }
  });

  // When clicking overlay, close sidebar (mobile only)
  $(".overlay").on("click", function () {
    $("#sidebar").removeClass("active");
    $(".overlay").removeClass("active");
  });

  // Set initial state based on screen size
  function handleScreenSize() {
    if ($(window).width() < 768) {
      // Mobile view - hide sidebar initially
      $("#sidebar").removeClass("active");
      $("#content").addClass("full");
    } else {
      // Desktop view - show sidebar initially
      $("#sidebar").addClass("active").removeClass("hidden");
      $("#content").removeClass("full");
    }
  }

  // Run on page load
  handleScreenSize();

  // Run on window resize
  $(window).resize(handleScreenSize);

  // Close sidebar when clicking a link on mobile
  $("#sidebar a").on("click", function () {
    if ($(window).width() < 768) {
      $("#sidebar").removeClass("active");
      $(".overlay").removeClass("active");
    }
  });

  // Handle navbar collapse state changes
  $(".navbar-collapse").on("show.bs.collapse", function () {
    // When opening navbar menu on mobile, close sidebar if open
    if ($(window).width() < 768 && $("#sidebar").hasClass("active")) {
      $("#sidebar").removeClass("active");
      $(".overlay").removeClass("active");
    }
  });
});
