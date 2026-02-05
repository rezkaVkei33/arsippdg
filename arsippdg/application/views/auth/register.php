<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Register' ?></title>
    
   <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    
    <!-- Bootstrap 5 CSS -->
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/img/LogoPoltek.png'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/custom/style_login.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

</head>
<body>
    <div class="main-container">
        <!-- Left Panel: Logo and System Info -->
        <div class="left-panel">
            <div class="logo-container">
                <img src="<?= base_url('assets/img/LogoPoltek.png') ?>" alt="Logo PDG" onerror="this.style.display='none'">
                <h1 class="system-title">SISTEM INFORMASI</h1>
                <p class="system-subtitle">Arsip Surat PDG</p>
                
                <div class="divider-section">
                    <hr class="divider-gold">
                    <hr class="divider-black">
                </div>
                
                <p style="font-size: 14px; opacity: 0.8; position: relative; z-index: 1;">
                    Bergabunglah dengan sistem arsip digital terdepan
                </p>
                
                <div class="features-list">
                    <div class="feature-item">
                        <i class="bi bi-person-plus"></i>
                        <span>Daftar dengan mudah dan cepat</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Keamanan data terjamin</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-folder-check"></i>
                        <span>Kelola arsip secara digital</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-clock-history"></i>
                        <span>Akses 24/7 kapan saja</span>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                &copy; 2024 Arsip Surat PDG. All rights reserved.
            </div>
        </div>
        
        <!-- Right Panel: Register Form -->
        <div class="right-panel">
            <div class="register-form-container">
                <h2 class="form-title">
                    <i class="bi bi-person-plus me-2"></i>BUAT AKUN BARU
                </h2>

                <!-- Error Alert -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- Success Alert -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Register Form -->
                <?= form_open('auth/do_register', ['method' => 'POST', 'id' => 'registerForm']) ?>

                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class="bi bi-at me-2"></i>Username
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="username" 
                               name="username" 
                               placeholder="Masukkan username (minimal 5 karakter)"
                               required
                               minlength="5"
                               autocomplete="username"
                               value="<?= set_value('username') ?>">
                        <?php if (form_error('username')): ?>
                            <div class="form-text text-danger">
                                <?= form_error('username') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Masukkan password (minimal 8 karakter)"
                                   required
                                   minlength="8"
                                   autocomplete="new-password">
                            <button type="button" 
                                    class="toggle-password" 
                                    id="togglePassword"
                                    title="Tampilkan/Sembunyikan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="passwordStrengthBar"></div>
                        </div>
                        <div class="strength-text" id="strengthText"></div>
                        <?php if (form_error('password')): ?>
                            <div class="form-text text-danger">
                                <?= form_error('password') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">
                            <i class="bi bi-lock-check me-2"></i>Konfirmasi Password
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   placeholder="Ulangi password Anda"
                                   required
                                   autocomplete="new-password">
                            <button type="button" 
                                    class="toggle-password" 
                                    id="toggleConfirmPassword"
                                    title="Tampilkan/Sembunyikan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <?php if (form_error('confirm_password')): ?>
                            <div class="form-text text-danger">
                                <?= form_error('confirm_password') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms" style="font-size: 13px; color: #4a5568;">
                            Saya setuju dengan <a href="#" style="color: #3498db;">Syarat dan Ketentuan</a> serta <a href="#" style="color: #3498db;">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-login text-light fw-bold">
                        <i class="bi bi-person-plus me-2"></i>DAFTAR SEKARANG
                    </button>

                <?= form_close() ?>

                <!-- Login Link -->
                <div class="login-link">
                    <p class="mb-0">
                        Sudah punya akun? 
                        <a href="<?= base_url('auth/login') ?>">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

      <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <script>
        // Toggle password visibility
        function setupPasswordToggle(toggleId, inputId) {
            const btn = document.getElementById(toggleId);
            const input = document.getElementById(inputId);

            btn.addEventListener('click', function() {
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        }

        setupPasswordToggle('togglePassword', 'password');
        setupPasswordToggle('toggleConfirmPassword', 'confirm_password');

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const bar = document.getElementById('passwordStrengthBar');
            const text = document.getElementById('strengthText');
            
            let strength = 0;
            let strengthText = '';
            
            // Length check
            if (password.length >= 8) strength++;
            
            // Lowercase and uppercase check
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            
            // Number check
            if (/[0-9]/.test(password)) strength++;
            
            // Special character check
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            // Reset classes
            bar.className = 'password-strength-bar';
            
            // Determine strength level
            if (password.length === 0) {
                strengthText = '';
            } else if (password.length < 8) {
                bar.classList.add('weak');
                strengthText = 'Password terlalu pendek';
            } else if (strength < 3) {
                bar.classList.add('weak');
                strengthText = 'Lemah';
            } else if (strength < 4) {
                bar.classList.add('fair');
                strengthText = 'Cukup';
            } else {
                bar.classList.add('strong');
                strengthText = 'Kuat';
            }
            
            text.textContent = strengthText;
        });

        // Confirm password validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = '#e53e3e';
                this.style.boxShadow = '0 0 0 3px rgba(229, 62, 62, 0.1)';
            } else {
                this.style.borderColor = '#38a169';
                this.style.boxShadow = '0 0 0 3px rgba(56, 161, 105, 0.1)';
            }
        });

        // Form submit handler
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password tidak cocok. Harap pastikan password dan konfirmasi password sama.');
                return false;
            }
            
            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                alert('Harap setujui Syarat dan Ketentuan serta Kebijakan Privasi.');
                return false;
            }
            
            btn.classList.add('loading');
            btn.disabled = true;
        });

        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                alert.style.transition = 'all 0.3s ease';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });

        // Auto-focus username field
        document.getElementById('username').focus();
    </script>
</body>
</html>