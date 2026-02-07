document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       FOOTER AUTO HIDE
    ========================= */
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

    ['mousemove','mousedown','keypress','scroll','touchstart','click']
        .forEach(evt => document.addEventListener(evt, showFooter));

    resetInactivityTimer();


    /* =========================
       NAVBAR SCROLL EFFECT
       DESKTOP ONLY !!!
    ========================= */
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;

    function isDesktop() {
        return window.innerWidth >= 992;
    }

    window.addEventListener('scroll', function () {
        if (!isDesktop()) {
            navbar.style.transform = 'translateY(0)';
            return;
        }

        const currentScroll = window.pageYOffset;

        if (currentScroll > 100) {
            navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,.15)';
            navbar.style.padding = '0.5rem 0';

            if (currentScroll > lastScroll && currentScroll > 200) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
        } else {
            navbar.style.boxShadow = '0 4px 6px rgba(0,0,0,.1)';
            navbar.style.padding = '0.8rem 0';
            navbar.style.transform = 'translateY(0)';
        }

        lastScroll = currentScroll;
    });


    /* =========================
       AUTO CLOSE NAVBAR MOBILE
    ========================= */
    document.querySelectorAll('.navbar-nav a:not(.dropdown-toggle)').forEach(el => {
        el.addEventListener('click', () => {
            const nav = document.querySelector('.navbar-collapse');
            if (nav.classList.contains('show')) {
                bootstrap.Collapse.getOrCreateInstance(nav).hide();
            }
        });
    });

});
