<footer class="footer footer-visible mt-5" id="footer">
    <div class="container text-center">
        <span>
            &copy; <?= date('Y'); ?> Arsip Surat PDG —
            <strong>Rezka Apriyandi</strong>
        </span>
    </div>
</footer>

<script>
let hideTimer;
const footer = document.getElementById('footer');

function resetTimer() {
    clearTimeout(hideTimer);
    footer.classList.add('show');
    
    hideTimer = setTimeout(() => {
        footer.classList.remove('show');
    }, 3000);
}

document.addEventListener('scroll', resetTimer);
document.addEventListener('mousemove', resetTimer);

// Initial hide
resetTimer();
</script>

<style>
.footer {
    transition: opacity 0.3s ease;
}
.footer.show {
    opacity: 1;
}
.footer:not(.show) {
    opacity: 0;
    pointer-events: none;
}
</style>
