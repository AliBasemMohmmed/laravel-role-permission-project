// public/assets/js/color-modes.js
document.addEventListener('DOMContentLoaded', function () {
    const toggleSwitch = document.querySelector('.color-mode-switch input[type="checkbox"]');
    const currentMode = localStorage.getItem('colorMode') || 'light';

    if (currentMode) {
        document.documentElement.setAttribute('data-color-mode', currentMode);
        if (currentMode === 'dark') {
            toggleSwitch.checked = true;
        }
    }

    function switchColorMode(e) {
        if (e.target.checked) {
            document.documentElement.setAttribute('data-color-mode', 'dark');
            localStorage.setItem('colorMode', 'dark');
        } else {
            document.documentElement.setAttribute('data-color-mode', 'light');
            localStorage.setItem('colorMode', 'light');
        }
    }

    toggleSwitch.addEventListener('change', switchColorMode, false);
});
