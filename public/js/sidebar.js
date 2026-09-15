document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    // Restore user state preference on load
    if (localStorage.getItem('sidebar-collapsed') === 'true') {
        sidebar.classList.add('collapsed');
        document.body.classList.add('sidebar-collapsed');
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            if (sidebar) sidebar.classList.toggle('collapsed');
            document.body.classList.toggle('sidebar-collapsed');

            const isCollapsed = sidebar ? sidebar.classList.contains('collapsed') : false;
            localStorage.setItem('sidebar-collapsed', isCollapsed);
        });
    }
});