/**
 * Hiranya Dark Mode Controller
 * Handles client-side theme toggling with a protection guard against double-initialization.
 */

// 1. Immediate theme execution to prevent page flash
(function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark-mode');
        document.body && document.body.classList.add('dark-mode');
    } else if (savedTheme === 'light') {
        document.documentElement.classList.remove('dark-mode');
        document.body && document.body.classList.remove('dark-mode');
    }
})();

// Guard against double registration of event listeners (due to multiple imports)
if (!window.ThemeToggleInitialized) {
    window.ThemeToggleInitialized = true;

    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById("theme-toggle-btn");
        const toggleIcon = document.getElementById("theme-toggle-icon");
        
        // Double check body class state matches root html class
        if (document.documentElement.classList.contains('dark-mode')) {
            document.body.classList.add('dark-mode');
        }

        const updateIcon = () => {
            if (!toggleIcon) return;
            if (document.body.classList.contains("dark-mode")) {
                toggleIcon.className = "fa fa-sun";
                toggleIcon.style.color = "#FBBF24";
                if (toggleBtn) toggleBtn.title = "Switch to Light Mode (Mode Terang)";
            } else {
                toggleIcon.className = "fa fa-moon";
                toggleIcon.style.color = "#FBBF24";
                if (toggleBtn) toggleBtn.title = "Switch to Dark Mode (Mode Gelap)";
            }
        };

        // Initial icon update
        updateIcon();

        if (toggleBtn) {
            toggleBtn.addEventListener("click", function() {
                document.body.classList.toggle("dark-mode");
                document.documentElement.classList.toggle("dark-mode");
                
                const isDark = document.body.classList.contains("dark-mode");
                const activeTheme = isDark ? "dark" : "light";
                
                // Persist theme selection
                localStorage.setItem("theme", activeTheme);
                document.cookie = `theme=${activeTheme}; path=/; max-age=31536000; SameSite=Lax`;
                
                // Update toggle icon representation
                updateIcon();
            });
        }
    });
}
