document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggle = document.getElementById('userDropdown');
    const dropdownMenu = document.querySelector('.dropdown-menu[aria-labelledby="userDropdown"]');

    if (dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener('shown.bs.dropdown', function() {
            // Position the dropdown menu below the toggle button
            const rect = dropdownToggle.getBoundingClientRect();
            dropdownMenu.style.top = `${rect.bottom + window.scrollY}px`;
            dropdownMenu.style.right = `${window.innerWidth - rect.right}px`;
        });
    }
});
