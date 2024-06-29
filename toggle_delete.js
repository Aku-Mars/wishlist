function toggleDeleteButtons() {
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(button => {
        if (button.style.display === 'none' || button.style.display === '') {
            button.style.display = 'block';
        } else {
            button.style.display = 'none';
        }
    });
}
