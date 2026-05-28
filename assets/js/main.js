document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.querySelector('[data-theme-toggle]');
    const root = document.documentElement;
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        root.setAttribute('data-theme', 'dark');
    }
    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            const current = root.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });
    }
});
