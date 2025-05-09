document.addEventListener('DOMContentLoaded', function() {
    // Find all flip boxes with click trigger
    const flipBoxes = document.querySelectorAll('.bfa-flip-box--click');
    
    flipBoxes.forEach(box => {
        box.addEventListener('click', function() {
            // Toggle the flipped state
            this.classList.toggle('is-flipped');
        });
    });
});
