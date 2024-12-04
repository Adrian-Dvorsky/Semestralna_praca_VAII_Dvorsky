document.addEventListener('DOMContentLoaded', function () {
    const logo = document.getElementById('fly');

    logo.addEventListener('mouseover', function () {
        logo.style.transform = 'translateY(-20px) rotate(-15deg)';
        logo.style.transition = 'transform 0.5s ease-in-out';
        logo.style.boxShadow = '0 0 20px rgba(255, 255, 255, 0.6)';
    });

    logo.addEventListener('mouseout', function () {
        logo.style.transform = 'translateY(0) rotate(0deg)';
        logo.style.transition = 'transform 0.5s ease-in-out';
        logo.style.boxShadow = 'none';
    });

    logo.addEventListener('click', function () {
        logo.style.transform = 'translateY(-4000px) rotate(-45deg)';
        logo.style.transition = 'transform 5s ease-in';
        setTimeout(function () {
            logo.style.transform = 'translateY(0) rotate(0deg)';
            logo.style.transition = 'transform 2.5s ease-out';
        }, 3500);
    });
});
