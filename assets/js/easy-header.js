/**
 * Easy Header JavaScript
 */
(function($) {
    'use strict';

    // Expose the initialization function for Bricks
    window.bfaEasyHeader = function(element) {
        return new EasyHeader(element);
    };

    class EasyHeader {
        constructor(element) {
            this.element = element;
            this.mobileMenu = element.querySelector('.bfa-easy-header-mobile-menu');
            this.mobileToggle = element.querySelector('.bfa-easy-header-mobile-toggle');
            this.mobileBackdrop = element.querySelector('.bfa-easy-header-mobile-backdrop');
            this.isMobile = window.innerWidth <= 991;
            this.isBuilder = window.bfaEasyHeaderData?.isBuilder;

            this.init();
        }

        init() {
            if (this.isBuilder) {
                // In builder, we need to force render
                if (window.bfaEasyHeaderData?.forceRender) {
                    this.forceRender();
                }
            } else {
                // In frontend, bind events
                this.bindEvents();
            }

            // Always setup mobile menu
            this.setupMobileMenu();
        }

        bindEvents() {
            if (this.mobileToggle) {
                this.mobileToggle.addEventListener('click', () => this.toggleMobileMenu());
            }

            if (this.mobileBackdrop) {
                this.mobileBackdrop.addEventListener('click', () => this.handleOutsideClick());
            }

            window.addEventListener('resize', () => this.handleResize());
        }

        toggleMobileMenu() {
            if (!this.mobileMenu) return;

            // Don't toggle if we're in the builder and the menu is forced open
            if (this.isBuilder && this.mobileMenu.classList.contains('show')) {
                return;
            }

            const isOpen = this.mobileMenu.classList.contains('show');
            
            if (isOpen) {
                this.mobileMenu.classList.remove('show');
            } else {
                this.mobileMenu.classList.add('show');
            }
        }

        handleOutsideClick() {
            if (!this.mobileMenu) return;

            // Don't close if we're in the builder and the menu is forced open
            if (this.isBuilder && this.mobileMenu.classList.contains('show')) {
                return;
            }

            this.mobileMenu.classList.remove('show');
        }

        handleResize() {
            const wasMobile = this.isMobile;
            this.isMobile = window.innerWidth <= 991;

            if (wasMobile !== this.isMobile) {
                this.setupMobileMenu();
            }
        }

        setupMobileMenu() {
            if (!this.mobileMenu) return;

            if (this.isMobile) {
                this.mobileMenu.style.display = 'block';
                // Only remove show class when switching to mobile if not in builder
                if (!this.isBuilder) {
                    this.mobileMenu.classList.remove('show');
                }
            } else {
                this.mobileMenu.style.display = 'none';
                // Only remove show class when switching to desktop if not in builder
                if (!this.isBuilder) {
                    this.mobileMenu.classList.remove('show');
                }
            }
        }

        forceRender() {
            if (!this.isBuilder || !this.mobileMenu) return;

            // Force re-render of mobile menu
            this.mobileMenu.style.display = 'none';
            setTimeout(() => {
                this.mobileMenu.style.display = 'block';
                this.setupMobileMenu();
            }, 0);
        }
    }

    // Initialize all Easy Headers on the page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded - Initializing Easy Headers');
        const headers = document.querySelectorAll('.bfa-easy-header');
        console.log('Found headers:', headers.length);
        headers.forEach(header => window.bfaEasyHeader(header));
    });

    // Initialize new Easy Headers when added to the page (for Bricks Builder)
    if (window.bricksData && window.bricksData.builder) {
        console.log('Bricks builder detected - setting up observer');
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.classList && node.classList.contains('bfa-easy-header')) {
                            console.log('New header added in builder');
                            window.bfaEasyHeader(node);
                        }
                    });
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

})(jQuery); 