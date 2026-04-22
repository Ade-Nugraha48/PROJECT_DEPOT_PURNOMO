(function() {
    const STORAGE_KEY = 'depot_purnomo_theme';
    const DARK_CLASS = 'dark-mode';
    const BUTTON_ID = 'dark-mode-toggle';

    function getStoredTheme() {
        try {
            return localStorage.getItem(STORAGE_KEY);
        } catch (err) {
            return null;
        }
    }

    function setTheme(isDark) {
        document.documentElement.classList.toggle(DARK_CLASS, isDark);
        document.body.classList.toggle(DARK_CLASS, isDark);

        const button = document.getElementById(BUTTON_ID);
        if (button) {
            const icon = isDark ? '☀️' : '🌙';
            const label = isDark ? 'Light Mode' : 'Dark Mode';
            button.innerHTML = `<span class="dark-mode-icon">${icon}</span> <span class="dark-mode-label">${label}</span>`;
        }

        try {
            localStorage.setItem(STORAGE_KEY, isDark ? 'dark' : 'light');
        } catch (err) {
            // ignore storage errors
        }
    }

    function createToggleButton(useLightOutline) {
        const button = document.createElement('button');
        button.id = BUTTON_ID;
        button.type = 'button';
        button.className = `btn btn-sm ${useLightOutline ? 'btn-outline-light' : 'btn-outline-secondary'} dark-mode-toggle-btn`;
        button.innerHTML = '<span class="dark-mode-icon">🌙</span> <span class="dark-mode-label">Dark Mode</span>';
        button.addEventListener('click', function() {
            setTheme(!document.documentElement.classList.contains(DARK_CLASS));
        });
        return button;
    }

    function attachToggleButton() {
        const navList = document.querySelector('.navbar-custom .navbar-nav');
        const authCard = document.querySelector('.auth-card');
        const button = createToggleButton(Boolean(navList));

        if (navList) {
            const listItem = document.createElement('li');
            listItem.className = 'nav-item';
            listItem.appendChild(button);
            navList.appendChild(listItem);
            return;
        }

        if (authCard) {
            const wrapper = document.createElement('div');
            wrapper.className = 'dark-mode-toggle-wrapper';
            wrapper.appendChild(button);
            authCard.style.position = 'relative';
            authCard.appendChild(wrapper);
            return;
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'dark-mode-toggle-wrapper';
        wrapper.appendChild(button);
        document.body.appendChild(wrapper);
    }

    function init() {
        attachToggleButton();
        const savedTheme = getStoredTheme();
        const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const useDark = savedTheme ? savedTheme === 'dark' : systemPrefersDark;
        setTheme(useDark);
    }

    document.addEventListener('DOMContentLoaded', init);
})();