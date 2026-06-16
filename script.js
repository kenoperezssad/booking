document.getElementById('select-all').addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

// Example for button click handlers
document.getElementById('queue-btn').addEventListener('click', () => {
    alert('Queue button clicked');
});

document.getElementById('wait-list-btn').addEventListener('click', () => {
    alert('Wait List button clicked');
});

document.getElementById('completed-btn').addEventListener('click', () => {
    alert('Completed button clicked');
});
