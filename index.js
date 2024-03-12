document.addEventListener('DOMContentLoaded', function() {
    var menuIcon = document.getElementById('menu-icon');
    var navBar = document.querySelector('.navbar');

    menuIcon.addEventListener('click', function() {
        navBar.classList.toggle('active');
    });

    // Close the menu when a link is clicked
    var navLinks = document.querySelectorAll('.navbar a');
    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            navBar.classList.remove('active');
        });
    });

    // Close the menu when clicking outside of it
    document.addEventListener('click', function(event) {
        if (!event.target.matches('.navbar, #menu-icon')) {
            navBar.classList.remove('active');
        }
    });
});