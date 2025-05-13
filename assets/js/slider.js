class FlexSlider {
    constructor(element) {
        this.element = element;
        this.container = element.querySelector('.flex-slider-container');
        this.handle = element.querySelector('.flex-slider-handle');
        this.after = element.querySelector('.flex-slider-after');
        this.isVertical = element.classList.contains('flex-slider-vertical');
        this.isDragging = false;
        this.startPosition = 0;
        this.startX = 0;
        this.startY = 0;
        this.defaultPosition = parseInt(element.getAttribute('data-default-position')) || 50;

        this.init();
    }

    init() {
        // Always use the latest default position
        this.defaultPosition = parseInt(this.element.getAttribute('data-default-position')) || 50;
        this.setPosition(this.defaultPosition, true);

        // Add event listeners
        this.handle.addEventListener('mousedown', this.startDragging.bind(this));
        this.container.addEventListener('mousedown', this.handleContainerClick.bind(this));
        document.addEventListener('mousemove', this.drag.bind(this));
        document.addEventListener('mouseup', this.stopDragging.bind(this));

        // Touch events
        this.handle.addEventListener('touchstart', this.startDragging.bind(this), { passive: false });
        this.container.addEventListener('touchstart', this.handleContainerClick.bind(this), { passive: false });
        document.addEventListener('touchmove', this.drag.bind(this), { passive: false });
        document.addEventListener('touchend', this.stopDragging.bind(this));

        // Keyboard navigation
        this.handle.addEventListener('keydown', this.handleKeyboard.bind(this));
        this.handle.setAttribute('tabindex', '0');
        this.handle.setAttribute('role', 'slider');
        this.handle.setAttribute('aria-valuemin', '0');
        this.handle.setAttribute('aria-valuemax', '100');
        this.handle.setAttribute('aria-valuenow', this.defaultPosition);
    }

    startDragging(e) {
        e.preventDefault();
        this.isDragging = true;
        
        const rect = this.container.getBoundingClientRect();
        const handleRect = this.handle.getBoundingClientRect();
        
        this.startPosition = this.isVertical ? 
            handleRect.top - rect.top : 
            handleRect.left - rect.left;
            
        this.startX = e.clientX || e.touches[0].clientX;
        this.startY = e.clientY || e.touches[0].clientY;
        this.handle.classList.add('dragging');
    }

    stopDragging() {
        if (!this.isDragging) return;
        this.isDragging = false;
        this.handle.classList.remove('dragging');
    }

    drag(e) {
        if (!this.isDragging) return;
        e.preventDefault();

        const currentX = e.clientX || e.touches[0].clientX;
        const currentY = e.clientY || e.touches[0].clientY;
        const deltaX = currentX - this.startX;
        const deltaY = currentY - this.startY;

        const containerRect = this.container.getBoundingClientRect();
        const containerSize = this.isVertical ? containerRect.height : containerRect.width;
        const delta = this.isVertical ? deltaY : deltaX;
        const position = this.startPosition + delta;
        const percentage = (position / containerSize) * 100;

        this.setPosition(percentage);
    }

    handleContainerClick(e) {
        if (e.target === this.handle) return;

        const containerRect = this.container.getBoundingClientRect();
        const clickPosition = this.isVertical ? 
            e.clientY - containerRect.top : 
            e.clientX - containerRect.left;
        const percentage = (clickPosition / (this.isVertical ? containerRect.height : containerRect.width)) * 100;

        this.setPosition(percentage);
    }

    handleKeyboard(e) {
        const step = 1;
        let newPosition;

        switch (e.key) {
            case 'ArrowLeft':
            case 'ArrowDown':
                newPosition = this.getCurrentPosition() - step;
                break;
            case 'ArrowRight':
            case 'ArrowUp':
                newPosition = this.getCurrentPosition() + step;
                break;
            case 'Home':
                newPosition = 0;
                break;
            case 'End':
                newPosition = 100;
                break;
            default:
                return;
        }

        e.preventDefault();
        this.setPosition(newPosition);
    }

    setPosition(percentage, isInit = false) {
        // Clamp percentage between 0 and 100
        percentage = Math.max(0, Math.min(100, percentage));

        // Update handle position and after image mask
        if (this.isVertical) {
            this.handle.style.left = '';
            this.handle.style.top = `${percentage}%`;
            this.handle.style.transform = 'translateY(-50%)';
            this.after.style.clipPath = `inset(${percentage}% 0 0 0)`;
        } else {
            this.handle.style.top = '';
            this.handle.style.left = `${percentage}%`;
            this.handle.style.transform = 'translateX(-50%)';
            this.after.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
        }

        // Update ARIA attributes
        this.handle.setAttribute('aria-valuenow', Math.round(percentage));

        // Dispatch custom event
        const event = new CustomEvent('flexSliderChange', {
            detail: { position: percentage }
        });
        this.element.dispatchEvent(event);
    }

    getCurrentPosition() {
        const position = this.isVertical ? 
            parseFloat(this.handle.style.top) : 
            parseFloat(this.handle.style.left);
        return isNaN(position) ? this.defaultPosition : position;
    }
}

// Initialize all sliders on the page
document.addEventListener('DOMContentLoaded', () => {
    const sliders = document.querySelectorAll('.flex-slider');
    sliders.forEach(slider => new FlexSlider(slider));
});

// Initialize sliders added dynamically
const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => {
        mutation.addedNodes.forEach(node => {
            if (node.nodeType === 1) { // Element node
                const sliders = node.classList?.contains('flex-slider') ? 
                    [node] : 
                    node.querySelectorAll('.flex-slider');
                sliders.forEach(slider => new FlexSlider(slider));
            }
        });
    });
});

observer.observe(document.body, {
    childList: true,
    subtree: true
}); 