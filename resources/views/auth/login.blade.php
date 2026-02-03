<x-guest-layout>
    <style>
        body,
        html {
            overflow-x: hidden !important;
            max-width: 100vw !important;
            width: 100%;
        }

        .min-h-screen {
            overflow: hidden;
        }

        /* Smooth Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes gentlePulse {

            0%,
            100% {
                opacity: 0.6;
            }

            50% {
                opacity: 0.8;
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .animate-gentle-pulse {
            animation: gentlePulse 4s ease-in-out infinite;
        }

        .animate-gradient-shift {
            background-size: 200% 200%;
            animation: gradientShift 10s ease infinite;
        }

        /* Blue Pastel Color Palette */
        .blue-pastel-bg {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%);
        }

        .blue-pastel-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow:
                0 8px 32px rgba(59, 130, 246, 0.12),
                0 2px 8px rgba(59, 130, 246, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }

        .blue-pastel-input {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .blue-pastel-input:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.2);
            background: white;
        }

        .blue-pastel-button {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .blue-pastel-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.25);
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        }

        .blue-pastel-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .blue-pastel-button:hover::before {
            left: 100%;
        }

        .blue-pastel-checkbox:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        /* Decorative Elements - Blue Theme */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.5;
        }

        .blob-1 {
            background: linear-gradient(135deg, #93c5fd, #dbeafe);
            width: 400px;
            height: 400px;
            top: -200px;
            right: -200px;
            animation-delay: 0s;
        }

        .blob-2 {
            background: linear-gradient(135deg, #60a5fa, #a5f3fc);
            width: 300px;
            height: 300px;
            bottom: -150px;
            left: -150px;
            animation-delay: -2s;
        }

        .blob-3 {
            background: linear-gradient(135deg, #3b82f6, #818cf8);
            width: 250px;
            height: 250px;
            top: 50%;
            right: 20%;
            animation-delay: -4s;
        }

        /* Floating Waves */
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            z-index: -1;
        }

        .wave svg {
            position: relative;
            display: block;
            width: calc(130% + 1.3px);
            height: 120px;
            transform: rotateY(180deg);
        }

        .wave .shape-fill {
            fill: rgba(59, 130, 246, 0.08);
        }

        /* Smooth Transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #eff6ff;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3b82f6, #60a5fa);
            border-radius: 3px;
        }

        /* Typography */
        .blue-pastel-text {
            color: #1e40af;
        }

        .blue-pastel-text-secondary {
            color: #2563eb;
        }

        .blue-pastel-text-muted {
            color: #4f46e5;
        }

        /* Glow Effect */
        .glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.15);
        }

        /* Card Hover Effect */
        .blue-pastel-card:hover {
            box-shadow:
                0 12px 40px rgba(59, 130, 246, 0.15),
                0 4px 12px rgba(59, 130, 246, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
        }

        /* Input Icons */
        .input-icon {
            color: #60a5fa;
        }

        /* Link Styling */
        .blue-link {
            color: #3b82f6;
            position: relative;
        }

        .blue-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: #3b82f6;
            transition: width 0.3s ease;
        }

        .blue-link:hover::after {
            width: 100%;
        }

        /* Demo Box */
        .demo-box {
            background: linear-gradient(135deg, rgba(219, 234, 254, 0.6), rgba(191, 219, 254, 0.4));
            border: 1px solid rgba(147, 197, 253, 0.3);
            backdrop-filter: blur(4px);
        }
    </style>

    <!-- Background Blobs -->
    <div class="blob blob-1 animate-float"></div>
    <div class="blob blob-2 animate-float"></div>
    <div class="blob blob-3 animate-float"></div>

    <!-- Floating Waves -->
    <div class="wave">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                opacity=".25" class="shape-fill"></path>
            <path
                d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                opacity=".5" class="shape-fill"></path>
            <path
                d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                class="shape-fill"></path>
        </svg>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 blue-pastel-bg relative overflow-hidden">
        <div class="w-full max-w-md mx-auto relative z-10">
            <!-- Logo Section -->
            <div class="text-center mb-8 animate-fade-in">
                <div class="inline-block mb-4 relative">
                    <div
                        class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-400 flex items-center justify-center shadow-lg glow">
                        <img width="50" height="50"
                            src="https://img.icons8.com/isometric-line/50/report-card.png" alt="report-card" />
                    </div>
                    <div class="absolute -inset-4 bg-blue-500 rounded-full opacity-10 blur-xl"></div>
                </div>
                <h1 class="text-4xl font-bold blue-pastel-text mb-2">Aspirasi<span class="text-blue-600">Siswa</span>
                </h1>
                <p class="blue-pastel-text-secondary">Portal Aspirasi Modern</p>
            </div>

            <!-- Session Status -->
            <div class="animate-fade-in" style="animation-delay: 0.1s;">
                <x-auth-session-status class="mb-4" :status="session('status')" />
            </div>

            <!-- Login Card -->
            <div class="blue-pastel-card rounded-3xl p-8 animate-fade-in" style="animation-delay: 0.2s;">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-semibold blue-pastel-text mb-2">Selamat Datang Kembali</h2>
                    <p class="blue-pastel-text-muted text-sm">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium blue-pastel-text flex items-center">
                            <svg class="w-4 h-4 mr-2 input-icon" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Alamat Email
                        </label>
                        <div class="relative">
                            <input id="email" class="blue-pastel-input w-full pl-10 pr-4 py-3 rounded-xl"
                                type="email" name="email" :value="old('email')" required autofocus
                                autocomplete="username" placeholder="email@sekolah.id">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="text-red-400 text-sm" />
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-medium blue-pastel-text flex items-center">
                            <svg class="w-4 h-4 mr-2 input-icon" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input id="password" class="blue-pastel-input w-full pl-10 pr-10 py-3 rounded-xl"
                                type="password" name="password" required autocomplete="current-password"
                                placeholder="••••••••">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 input-icon hover:text-blue-600">
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="text-red-400 text-sm" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center cursor-pointer group">
                            <div class="relative">
                                <input id="remember_me" type="checkbox" class="sr-only" name="remember">
                                <div
                                    class="w-5 h-5 bg-blue-100 rounded border border-blue-200 group-hover:border-blue-300">
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center hidden">
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <span class="ml-2 text-sm blue-pastel-text-muted group-hover:text-blue-600">
                                Ingat Saya
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm blue-link hover:no-underline transition-all"
                                href="{{ route('password.request') }}">
                                Lupa Kata Sandi?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="blue-pastel-button w-full py-3 rounded-xl font-medium relative overflow-hidden group">
                        <span class="relative z-10 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Masuk ke Akun
                        </span>
                    </button>

                    <!-- Divider -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-blue-100"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white blue-pastel-text-muted">Atau</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-sm blue-pastel-text-muted">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-medium blue-link ml-1">
                                Daftar Sekarang
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6 animate-fade-in" style="animation-delay: 0.3s;">
                <p class="text-sm blue-pastel-text-muted">
                    &copy; {{ date('Y') }} Aspirasi Siswa. Portal Aspirasi Digital.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            window.togglePassword = function() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eye-icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    `;
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    `;
                }
            };

            // Checkbox animation
            const checkbox = document.getElementById('remember_me');
            const checkboxDiv = checkbox.parentElement;

            checkbox.addEventListener('change', function() {
                const checkIcon = checkboxDiv.querySelector('.absolute');
                if (this.checked) {
                    checkIcon.classList.remove('hidden');
                    checkIcon.classList.add('flex');
                    checkboxDiv.querySelector('.bg-blue-100').classList.add('bg-blue-200');
                } else {
                    checkIcon.classList.remove('flex');
                    checkIcon.classList.add('hidden');
                    checkboxDiv.querySelector('.bg-blue-200').classList.remove('bg-blue-200');
                }
            });

            // Form submission animation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                const originalContent = button.innerHTML;

                button.innerHTML = `
                    <svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;
                button.disabled = true;

                // Reset after 3 seconds (in case of error)
                setTimeout(() => {
                    if (button.disabled) {
                        button.innerHTML = originalContent;
                        button.disabled = false;
                    }
                }, 3000);
            });

            // Input focus effects
            const inputs = document.querySelectorAll('.blue-pastel-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-1', 'ring-blue-200', 'rounded-xl');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-1', 'ring-blue-200', 'rounded-xl');
                });
            });

            // Add gentle hover effect to demo box
            const demoBox = document.querySelector('.demo-box');
            if (demoBox) {
                demoBox.addEventListener('mouseenter', function() {
                    this.classList.add('ring-1', 'ring-blue-200', 'transform', 'scale-[1.02]');
                });

                demoBox.addEventListener('mouseleave', function() {
                    this.classList.remove('ring-1', 'ring-blue-200', 'transform', 'scale-[1.02]');
                });
            }

            // Card hover effect
            const card = document.querySelector('.blue-pastel-card');
            if (card) {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            }
        });

        // Mouse move effect for blobs
        document.addEventListener('mousemove', function(e) {
            const blobs = document.querySelectorAll('.blob');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            blobs.forEach((blob, index) => {
                const speed = 0.015 * (index + 1);
                const moveX = (x - 0.5) * 30 * speed;
                const moveY = (y - 0.5) * 30 * speed;

                blob.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });
    </script>
</x-guest-layout>
