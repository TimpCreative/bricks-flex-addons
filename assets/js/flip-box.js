/* Flex Flip Box JS – uses CSS var for duration */

document.addEventListener('click', (e) => {
    if (e.target.closest('.bfa-flip-box--click')) {
        const box = e.target.closest('.bfa-flip-box--click');
        if (box) {
            box.classList.toggle('is-flipped');
        }
    }
});

// Brute force builder preview handling
if (document.body.classList.contains('bricks-is-builder')) {
    // Watch for changes in the builder panel
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'data-settings') {
                const element = mutation.target;
                if (element.classList.contains('bfa-flip-box')) {
                    try {
                        const settings = JSON.parse(element.getAttribute('data-settings'));
                        if (settings.preview_flipped) {
                            element.setAttribute('data-preview-flipped', 'true');
                        } else {
                            element.removeAttribute('data-preview-flipped');
                        }
                    } catch (e) {
                        console.error('Error parsing settings:', e);
                    }
                }
            }
        });
    });

    // Start observing the document for changes
    observer.observe(document.body, {
        childList: true,
        subtree: true,
        attributes: true,
        attributeFilter: ['data-settings']
    });

    // Also watch for the checkbox directly
    document.addEventListener('change', (e) => {
        if (e.target.matches('input[type="checkbox"][name="preview_flipped"]')) {
            const box = e.target.closest('.bfa-flip-box');
            if (box) {
                if (e.target.checked) {
                    box.setAttribute('data-preview-flipped', 'true');
                } else {
                    box.removeAttribute('data-preview-flipped');
                }
            }
        }
    });
}

// Reset flipped state when page loses focus
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        document.querySelectorAll(`.bfa-flip-box.is-flipped`).forEach(box => {
            if (!box.hasAttribute('data-preview-flipped')) {
                box.classList.remove('is-flipped');
            }
        });
    }
});

// Reset flipped state when window loses focus
window.addEventListener('blur', () => {
    document.querySelectorAll(`.bfa-flip-box.is-flipped`).forEach(box => {
        if (!box.hasAttribute('data-preview-flipped')) {
            box.classList.remove('is-flipped');
        }
    });
});
