 // Footer auto-hide functionality
        let inactivityTimer;
        const footer = document.getElementById('mainFooter');
        let isFooterVisible = true;

        function hideFooter() {
            if (isFooterVisible) {
                footer.classList.remove('footer-visible');
                footer.classList.add('footer-hidden');
                isFooterVisible = false;
            }
        }

        function showFooter() {
            if (!isFooterVisible) {
                footer.classList.remove('footer-hidden');
                footer.classList.add('footer-visible');
                isFooterVisible = true;
            }
            resetInactivityTimer();
        }

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(hideFooter, 3000);
        }

        // Event listeners for user activity
        ['mousemove', 'mousedown', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, showFooter);
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Start inactivity timer
            resetInactivityTimer();
            
            // Scroll to dashboard content when clicking scroll indicator
            document.querySelector('.scroll-indicator').addEventListener('click', function() {
                document.querySelector('.dashboard-content').scrollIntoView({ 
                    behavior: 'smooth' 
                });
            });
            
            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'slideUp 0.6s ease forwards';
                    }
                });
            }, observerOptions);

            // Observe elements to animate
            document.querySelectorAll('.stat-card, .quick-action-btn').forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                observer.observe(element);
            });

            // Keyboard shortcut to show footer
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'f') {
                    showFooter();
                    e.preventDefault();
                }
            });

            // Add scroll effect to navbar
            let lastScroll = 0;
            window.addEventListener('scroll', function() {
                const currentScroll = window.pageYOffset;
                const navbar = document.querySelector('.navbar');
                
                if (currentScroll > 100) {
                    navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.15)';
                    navbar.style.padding = '0.5rem 0';
                    
                    // Hide navbar on scroll down, show on scroll up
                    if (currentScroll > lastScroll && currentScroll > 200) {
                        navbar.style.transform = 'translateY(-100%)';
                    } else {
                        navbar.style.transform = 'translateY(0)';
                    }
                } else {
                    navbar.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                    navbar.style.padding = '0.8rem 0';
                    navbar.style.transform = 'translateY(0)';
                }
                
                lastScroll = currentScroll;
            });

            // Force dropdowns to have proper z-index
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.zIndex = '1060';
            });
        });

        // Ensure dropdowns work on window resize
        window.addEventListener('resize', function() {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.zIndex = '1060';
            });
        });
