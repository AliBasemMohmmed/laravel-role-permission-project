import './bootstrap';
document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('nav a');

    for (const link of links) {
        link.addEventListener('click', smoothScroll);
    }
});

function smoothScroll(event) {
    event.preventDefault();
    const targetId = event.currentTarget.getAttribute('href').substring(1);
    const targetSection = document.getElementById(targetId);

    window.scrollTo({
        top: targetSection.offsetTop - 50,
        behavior: 'smooth'
    });
}
