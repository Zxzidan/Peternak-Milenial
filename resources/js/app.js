import 'flowbite';
import { initFlowbite } from 'flowbite';
/**
 * Robust Dark/Light Mode Theme Switcher
 * Supports localStorage persistence and syncs with Tailwind v4 class-based variant.
 */
const initTheme = () => {
    const isDark =
        localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') &&
            window.matchMedia('(prefers-color-scheme: dark)').matches);

    if (isDark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    const updateThemeIcons = () => {
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const currentlyDark = document.documentElement.classList.contains('dark');

        if (currentlyDark) {
            darkIcon?.classList.add('hidden');
            lightIcon?.classList.remove('hidden');
        } else {
            darkIcon?.classList.remove('hidden');
            lightIcon?.classList.add('hidden');
        }
    };

    updateThemeIcons();

    const themeToggleBtn = document.getElementById('theme-toggle');
    themeToggleBtn?.addEventListener('click', () => {
        const currentlyDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', currentlyDark ? 'dark' : 'light');
        updateThemeIcons();
    });
};
/**
 * Sidebar Behavior:
 * - Desktop: Expand (w-64) / Collapse (w-16 mini-rail) with main content auto-adjusting.
 * - Mobile: Drawer off-canvas with backdrop overlay and close trigger.
 * - Vertical scrolling: Independent scroll inside menu area.
 */
const initSidebar = () => {
    const sidebar = document.getElementById('drawer-navigation');
    const mainContent = document.getElementById('main-content');
    const desktopToggle = document.getElementById('desktop-sidebar-toggle');
    const mobileToggle = document.getElementById('mobile-sidebar-toggle');
    const backdrop = document.getElementById('sidebar-backdrop');
    const closeBtn = document.getElementById('mobile-sidebar-close');

    if (!sidebar) return;

    // Desktop Collapse State Management
    const applyDesktopState = (collapsed) => {
        if (window.innerWidth >= 768) {
            if (collapsed) {
                sidebar.classList.add('is-collapsed');
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-16');
                mainContent?.classList.remove('md:ml-64');
                mainContent?.classList.add('md:ml-16');
            } else {
                sidebar.classList.remove('is-collapsed');
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-64');
                mainContent?.classList.remove('md:ml-16');
                mainContent?.classList.add('md:ml-64');
            }
        } else {
            sidebar.classList.remove('is-collapsed', 'w-16');
            sidebar.classList.add('w-64');
            mainContent?.classList.remove('md:ml-16');
            mainContent?.classList.add('md:ml-64');
        }
    };

    // Apply saved desktop state
    const savedCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
    applyDesktopState(savedCollapsed);

    // Desktop Toggle Event
    desktopToggle?.addEventListener('click', () => {
        const nowCollapsed = !sidebar.classList.contains('is-collapsed');
        localStorage.setItem('sidebar-collapsed', nowCollapsed ? 'true' : 'false');
        applyDesktopState(nowCollapsed);
    });

    // Mobile Drawer Open/Close
    const openMobile = () => {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        backdrop?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden', 'md:overflow-auto');
    };

    const closeMobile = () => {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        backdrop?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden', 'md:overflow-auto');
    };

    mobileToggle?.addEventListener('click', () => {
        if (sidebar.classList.contains('translate-x-0')) {
            closeMobile();
        } else {
            openMobile();
        }
    });

    backdrop?.addEventListener('click', closeMobile);
    closeBtn?.addEventListener('click', closeMobile);

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            closeMobile();
            const currentSaved = localStorage.getItem('sidebar-collapsed') === 'true';
            applyDesktopState(currentSaved);
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initFlowbite();
    initTheme();
    initSidebar();
});
