import 'flowbite';
import { initFlowbite } from 'flowbite';

/**
 * Robust Dark/Light Mode Theme Switcher
 * Supports localStorage persistence and syncs with Tailwind v4 class-based variant.
 */
const initTheme = () => {
    try {
        localStorage.removeItem('theme');
        localStorage.setItem('theme', 'light');
    } catch (e) {}
    document.documentElement.classList.remove('dark');
};

/**
 * Flowbite Collapsible Sidebar & Mobile Drawer Behavior:
 * - Desktop (sm and up): Collapsible (w-64 open vs w-16 closed mini-rail) with main content auto-adjusting (sm:ml-64 vs sm:ml-16).
 * - Mobile (< sm): Off-canvas drawer (-translate-x-full vs translate-x-0) with backdrop overlay.
 */
const initSidebar = () => {
    const sidebar = document.getElementById('top-bar-sidebar');
    const mainContent = document.getElementById('main-content');
    const desktopToggle = document.getElementById('desktop-sidebar-toggle');
    const drawerToggle = document.querySelector('[data-drawer-toggle="top-bar-sidebar"]');
    const drawerHides = document.querySelectorAll('[data-drawer-hide="top-bar-sidebar"]');
    const backdrop = document.getElementById('sidebar-backdrop');

    if (!sidebar) return;

    // Apply desktop collapsed/expanded state
    const setDesktopCollapsed = (collapsed) => {
        if (window.innerWidth >= 640) {
            if (collapsed) {
                sidebar.classList.add('is-collapsed', 'w-16');
                sidebar.classList.remove('w-64');
                mainContent?.classList.add('sm:ml-16');
                mainContent?.classList.remove('sm:ml-64');
            } else {
                sidebar.classList.remove('is-collapsed', 'w-16');
                sidebar.classList.add('w-64');
                mainContent?.classList.add('sm:ml-64');
                mainContent?.classList.remove('sm:ml-16');
            }
        } else {
            // Reset desktop classes on mobile
            sidebar.classList.remove('w-16');
            sidebar.classList.add('w-64');
        }
    };

    // Load saved collapsed state (default: false / open)
    const savedCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
    setDesktopCollapsed(savedCollapsed);

    // Toggle desktop collapse
    const toggleDesktop = () => {
        const nowCollapsed = !sidebar.classList.contains('is-collapsed');
        localStorage.setItem('sidebar-collapsed', nowCollapsed ? 'true' : 'false');
        setDesktopCollapsed(nowCollapsed);
        // Trigger window resize event so ApexCharts redraws with new container width smoothly
        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 320);
    };

    desktopToggle?.addEventListener('click', (e) => {
        e.preventDefault();
        toggleDesktop();
    });

    // Mobile Drawer Open & Close
    const openMobileDrawer = () => {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        backdrop?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden', 'sm:overflow-auto');
    };

    const closeMobileDrawer = () => {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        backdrop?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden', 'sm:overflow-auto');
    };

    drawerToggle?.addEventListener('click', (e) => {
        e.preventDefault();
        if (sidebar.classList.contains('translate-x-0')) {
            closeMobileDrawer();
        } else {
            openMobileDrawer();
        }
    });

    drawerHides.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            closeMobileDrawer();
        });
    });

    backdrop?.addEventListener('click', closeMobileDrawer);

    // Auto close drawer when clicking any navigation link inside sidebar on mobile
    sidebar.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 640) {
                closeMobileDrawer();
            }
        });
    });

    // Handle screen resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 640) {
            closeMobileDrawer();
            const currentSaved = localStorage.getItem('sidebar-collapsed') === 'true';
            setDesktopCollapsed(currentSaved);
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initFlowbite();
    initTheme();
    initSidebar();
});
