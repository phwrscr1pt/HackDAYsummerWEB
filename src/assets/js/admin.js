/**
 * PTPetho - Admin Dashboard JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle for mobile
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.admin-sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }

    // Search functionality
    const searchInputs = document.querySelectorAll('.header-search input, .search-box input');
    searchInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && this.form) {
                this.form.submit();
            }
        });
    });

    // Notification dropdown
    const notificationBtn = document.querySelector('.header-notifications');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            // For now, redirect to feedback inbox
            window.location.href = '/ptpetho-admin/feedback-inbox.php';
        });
    }

    // Table row hover effects
    const tableRows = document.querySelectorAll('.admin-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            // If clicking on a link or button, don't do anything
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') {
                return;
            }

            // Check for a link in the row
            const link = this.querySelector('a');
            if (link) {
                window.location.href = link.href;
            }
        });
    });

    // Alert auto-dismiss
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        // Add close button
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.cssText = 'float: right; background: none; border: none; font-size: 1.5rem; cursor: pointer; line-height: 1;';
        closeBtn.onclick = function() {
            alert.style.display = 'none';
        };
        alert.insertBefore(closeBtn, alert.firstChild);
    });

    // Form confirmation for dangerous actions
    const dangerForms = document.querySelectorAll('form[data-confirm]');
    dangerForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const message = this.dataset.confirm || 'Are you sure?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Stat card counter animation
    const animateStats = () => {
        const statCards = document.querySelectorAll('.stat-info h3');
        statCards.forEach(stat => {
            const text = stat.innerText;
            // Check if it's a number
            if (/^\d/.test(text)) {
                const num = parseFloat(text.replace(/[^0-9.]/g, ''));
                const suffix = text.replace(/[0-9.,]/g, '');

                if (!isNaN(num)) {
                    let current = 0;
                    const increment = num / 30;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= num) {
                            current = num;
                            clearInterval(timer);
                        }

                        if (Number.isInteger(num)) {
                            stat.innerText = Math.floor(current).toLocaleString() + suffix;
                        } else {
                            stat.innerText = current.toFixed(1) + suffix;
                        }
                    }, 30);
                }
            }
        });
    };

    // Run animations on load
    animateStats();

    // Real-time clock in header (if element exists)
    const clockElement = document.querySelector('.header-clock');
    if (clockElement) {
        const updateClock = () => {
            const now = new Date();
            clockElement.textContent = now.toLocaleTimeString('th-TH');
        };
        updateClock();
        setInterval(updateClock, 1000);
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+K for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('.header-search input');
            if (searchInput) {
                searchInput.focus();
            }
        }

        // Escape to close modals/alerts
        if (e.key === 'Escape') {
            const openAlerts = document.querySelectorAll('.alert:not([style*="display: none"])');
            openAlerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }
    });

    // Session timeout warning
    let sessionTimeout;
    const resetSessionTimer = () => {
        clearTimeout(sessionTimeout);
        sessionTimeout = setTimeout(() => {
            if (confirm('Your session is about to expire. Click OK to stay logged in.')) {
                // Make a request to refresh session
                fetch('/ptpetho-admin/dashboard.php', { credentials: 'same-origin' });
                resetSessionTimer();
            } else {
                window.location.href = '/ptpetho-admin/logout.php';
            }
        }, 55 * 60 * 1000); // 55 minutes
    };

    // Reset timer on any activity
    ['click', 'keypress', 'scroll', 'mousemove'].forEach(event => {
        document.addEventListener(event, resetSessionTimer, { passive: true });
    });

    resetSessionTimer();

    console.log('PTPetho Admin Dashboard Loaded');
    console.log('Session Cookie (for debugging):', document.cookie);
});
