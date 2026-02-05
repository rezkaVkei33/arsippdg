<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login' ?></title>

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
                <img src="<?= base_url('assets/img/LogoPoltek.png') ?>" alt="Logo PDG">
                <h1 class="system-title">SISTEM INFORMASI</h1>
                <p class="system-subtitle">Arsip Surat PDG</p>
                
                <div class="divider-section">
                    <hr class="divider-gold">
                    <hr class="divider-black">
                </div>
                
                <p style="font-size: 14px; opacity: 0.8; position: relative; z-index: 1;">
                    Sistem terintegrasi untuk pengelolaan arsip surat digital
                </p>
                
                <div class="features-list">
                    <div class="feature-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Keamanan data terjamin</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-folder-check"></i>
                        <span>Arsip terorganisir rapi</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-clock-history"></i>
                        <span>24/7 Akses fleksibel</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-search"></i>
                        <span>Pencarian cepat dan mudah</span>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                &copy; 2024 Arsip Surat PDG. All rights reserved.
            </div>
        </div>
        
        <!-- Right Panel: Login Form -->
        <div class="right-panel">
            <div class="login-form-container">
                <h2 class="form-title">
                    <i class="bi bi-box-arrow-in-right me-2"></i>LOGIN KE SISTEM
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

                <!-- Login Form -->
                <?= form_open('auth/do_login', ['method' => 'POST', 'id' => 'loginForm']) ?>

                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class="bi bi-person me-2"></i>Username
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="username" 
                               name="username" 
                               placeholder="Masukkan username"
                               required
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
                                   placeholder="Masukkan password"
                                   required
                                   autocomplete="current-password">
                            <button type="button" 
                                    class="toggle-password" 
                                    id="togglePassword"
                                    title="Tampilkan/Sembunyikan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <?php if (form_error('password')): ?>
                            <div class="form-text text-danger">
                                <?= form_error('password') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember_me">
                        <label class="form-check-label" for="rememberMe">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-login text-light fw-bold">
                        <i class="bi bi-box-arrow-in-right me-2"></i>MASUK SEKARANG
                    </button>

                <?= form_close() ?>

                <!-- Register Link -->
                <div class="register-link">
                    <p class="mb-0">
                        Belum punya akun? 
                        <a href="<?= base_url('auth/register') ?>">Daftar di sini</a>
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
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Form submit handler
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
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
    </script>
</body>
</html>