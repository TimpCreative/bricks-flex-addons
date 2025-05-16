document.addEventListener('DOMContentLoaded', function() {
    // Initialize all content toggles
    initContentSwitchers();

    // Re-init when Bricks triggers a rerender
    if (typeof bricksIsFrontend !== 'undefined') {
        document.addEventListener('bricks/ajax/load_page/completed', initContentSwitchers);
    }
    if (window.bricksFrontend && typeof window.bricksFrontend.on === 'function') {
        window.bricksFrontend.on('init', initContentSwitchers);
    }
    if (window.bricks && typeof window.bricks.on === 'function') {
        window.bricks.on('elementsRendered', function() {
            setTimeout(initContentSwitchers, 50);
        });
    }
});

function initContentSwitchers() {
    document.querySelectorAll('.brxe-flex-content-switcher').forEach(function(switcher) {
        if (!switcher) return;

        const buttons = switcher.querySelectorAll('.bfa-toggle-button');
        const switchInput = switcher.querySelector('.bfa-toggle-input');
        const contentWrapper = switcher.querySelector('.bfa-content-wrapper');
        const toggleButtons = switcher.querySelector('.bfa-toggle-buttons');
        const slider = switcher.querySelector('.bfa-toggle-slider');
        
        if (!contentWrapper) return;
        
        const contentItems = contentWrapper.children;

        // Get color and border settings from data attributes on the switcher
        const activeBg = switcher.getAttribute('data-buttonactivebg') || '#ffc940';
        const activeBorder = switcher.getAttribute('data-buttonactiveborder') || '#e6a800';
        const inactiveBg = switcher.getAttribute('data-buttoninactivebg') || '#fff';
        const inactiveBorder = switcher.getAttribute('data-buttoninactiveborder') || '#ffc940';
        let borderWidth = switcher.getAttribute('data-buttonborderwidth');
        // Strip 'px' if present and ensure it's a valid number
        borderWidth = borderWidth ? borderWidth.replace('px', '') : '1.5';
        borderWidth = !isNaN(borderWidth) ? borderWidth : '1.5';
        const transitionDuration = switcher.getAttribute('data-transitionduration') || '300ms';

        // Add .bfa-content-item class and set initial visibility
        Array.from(contentItems).forEach((child, idx) => {
            child.classList.add('bfa-content-item');
            child.style.transitionDuration = transitionDuration;
            if (idx === 0) {
                child.classList.add('active');
                child.classList.add('no-transition');
                child.removeAttribute('hidden');
                child.style.opacity = '1';
                child.style.transform = 'translateY(0)';
            } else {
                child.classList.remove('active');
                child.setAttribute('hidden', '');
                child.style.opacity = '0';
                child.style.transform = 'translateY(10px)';
            }
        });
        // Remove no-transition after a short delay
        setTimeout(() => {
            if (contentItems[0]) {
                contentItems[0].classList.remove('no-transition');
            }
        }, 50);

        // Set initial button styles and alignment
        function updateButtonStyles(activeIndex) {
            buttons.forEach((btn, idx) => {
                if (idx === activeIndex) {
                    btn.classList.add('active');
                    btn.style.background = activeBg;
                    btn.style.borderColor = activeBorder;
                    btn.style.borderWidth = borderWidth + 'px';
                    btn.style.borderStyle = 'solid';
                } else {
                    btn.classList.remove('active');
                    btn.style.background = inactiveBg;
                    btn.style.borderColor = inactiveBorder;
                    btn.style.borderWidth = borderWidth + 'px';
                    btn.style.borderStyle = 'solid';
                }
            });
        }
        // Set initial button styles
        updateButtonStyles(0);

        // Alignment fix for both buttons and switch
        const alignContainers = [];
        if (toggleButtons) alignContainers.push(toggleButtons);
        const toggleWrapper = switcher.querySelector('.bfa-toggle-wrapper');
        if (toggleWrapper) alignContainers.push(toggleWrapper);
        const justify = switcher.getAttribute('data-buttonalignment') || 'flex-start';
        alignContainers.forEach(container => {
            container.style.justifyContent = justify;
            if (justify === 'center') {
                container.style.marginLeft = 'auto';
                container.style.marginRight = 'auto';
            } else if (justify === 'flex-end') {
                container.style.marginLeft = 'auto';
                container.style.marginRight = '';
            } else {
                container.style.marginLeft = '';
                container.style.marginRight = '';
            }
        });

        // Switch toggle color logic
        if (slider) {
            // Set initial switch color to inactive
            slider.style.background = inactiveBg;
        }

        // Handle button toggles
        buttons.forEach((button, index) => {
            if (!button) return;
            
            button.addEventListener('click', function() {
                // Update button states
                buttons.forEach(btn => {
                    if (btn) {
                        btn.classList.remove('active');
                        btn.setAttribute('aria-selected', 'false');
                    }
                });
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');

                // Update content visibility with animation
                updateContentVisibility(index);
                updateButtonStyles(index);
            });
        });

        // Handle switch toggle
        if (switchInput) {
            switchInput.addEventListener('change', function() {
                const index = this.checked ? 1 : 0;
                updateContentVisibility(index);
                updateButtonStyles(index);
                // Update switch color
                if (slider) {
                    slider.style.background = this.checked ? activeBg : inactiveBg;
                }
            });
            // Set initial switch color
            if (slider) {
                slider.style.background = inactiveBg;
            }
        }

        // Helper function to update content visibility with animation
        function updateContentVisibility(activeIndex) {
            Array.from(contentItems).forEach((content, contentIndex) => {
                if (content) {
                    const isActive = contentIndex === activeIndex;
                    
                    if (isActive) {
                        content.classList.add('active');
                        content.removeAttribute('hidden');
                        // Force reflow to ensure animation plays
                        content.offsetHeight;
                        content.style.opacity = '1';
                        content.style.transform = 'translateY(0)';
                    } else {
                        content.style.opacity = '0';
                        content.style.transform = 'translateY(10px)';
                        // Wait for animation to complete before hiding
                        setTimeout(() => {
                            if (!content.classList.contains('active')) {
                                content.setAttribute('hidden', '');
                            }
                        }, 300);
                        content.classList.remove('active');
                    }
                }
            });
        }
    });
} 