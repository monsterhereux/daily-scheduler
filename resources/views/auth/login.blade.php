<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

     <style>
        /* Chrome, Edge, Safari */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        /* Chrome autofill eye */
        input[type="password"]::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            display: none !important;
        }
    </style>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Heading -->
        <h2 class="text-2xl font-bold text-left text-indigo-200 mb-2">
            Selamat Datang!
        </h2>

        <!-- Container dengan spacing konsisten -->
        <div class="pl-4 space-y-6">

            <!-- Email -->
            <div class="space-y-1">
                <x-input-label for="email" :value="__('Email')" />

                <div class="relative">
                    <!-- Email icon -->
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fas fa-envelope text-base"></i>
                    </span>

                    <x-text-input 
                        id="email"
                        class="block w-full rounded-xl pl-10 bg-white shadow-none text-sm" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" 
                    />
                </div>

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <x-input-label for="password" :value="__('Kata Sandi')" />

                <div class="relative">
                    <!-- Lock icon -->
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fas fa-lock text-base"></i>
                    </span>

                    <x-text-input 
                        id="password" 
                        class="block w-full rounded-xl pl-10 pr-10 bg-white shadow-none text-sm" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password" 
                    />

                    <!-- Eye toggle -->
                    <span id="togglePassword" 
                          class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Script toggle -->
            <script>
                const togglePassword = document.querySelector("#togglePassword");
                const password = document.querySelector("#password");
                const icon = togglePassword.querySelector("i");

                togglePassword.addEventListener("click", function () {
                    const type = password.getAttribute("type") === "password" ? "text" : "password";
                    password.setAttribute("type", type);

                    if (type === "password") {
                        icon.classList.remove("fa-eye-slash");
                        icon.classList.add("fa-eye");
                    } else {
                        icon.classList.remove("fa-eye");
                        icon.classList.add("fa-eye-slash");
                    }
                });
            </script>

            <!-- Remember Me + Forgot Password -->
            <div class="pl-2 flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Ingat Saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" 
                       href="{{ route('password.request') }}">
                        {{ __('Lupa Password Anda?') }}
                    </a>
                @endif
            </div>

            <!-- Tombol Login -->
            <div class="flex justify-end space-x-2 mt-3">
                <x-primary-button>
                    {{ __('Masuk') }}
                </x-primary-button>

                <x-primary-button>
                    <a href="{{ route('register') }}">
                        {{ __('Daftar Akun') }}
                    </a>
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
