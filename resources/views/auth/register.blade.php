<x-guest-layout>
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- DISABLE BROWSER PASSWORD TOGGLE -->
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

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="text-2xl font-bold text-indigo-200 mb-4">
            Buat Akun Baru!
        </h2>

        <div class="pl-4 space-y-6">

            <!-- NAME -->
            <div>
                <x-input-label for="name" value="Name" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fa-solid fa-user"></i>
                    </span>

                    <x-text-input
                        id="name"
                        type="text"
                        name="name"
                        class="block w-full rounded-xl pl-10 text-sm"
                        :value="old('name')"
                        required autofocus />
                </div>
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <!-- EMAIL -->
            <div>
                <x-input-label for="email" value="Email" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fa-solid fa-envelope"></i>
                    </span>

                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        class="block w-full rounded-xl pl-10 text-sm"
                        :value="old('email')"
                        required />
                </div>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <!-- PASSWORD -->
            <div>
                <x-input-label for="password" value="Password" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fa-solid fa-lock"></i>
                    </span>

                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        class="block w-full rounded-xl pl-10 pr-10 text-sm"
                        required />

                    <!-- SINGLE TOGGLE -->
                    <span id="togglePassword"
                          class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <x-input-label for="password_confirmation" value="Confirm Password" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fa-solid fa-lock"></i>
                    </span>

                    <x-text-input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="block w-full rounded-xl pl-10 pr-10 text-sm"
                        required />

                    <!-- SINGLE TOGGLE -->
                    <span id="toggleConfirmPassword"
                          class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <!-- ACTION -->
            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('login') }}"
                   class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" >
                    Sudah punya akun? Masuk Sekarang!
                </a>
                <x-primary-button class="ms-4">
                    Daftar Akun
                </x-primary-button>
            </div>
        </div>
    </form>

    <!-- TOGGLE SCRIPT -->
    <script>
        function setupToggle(toggleId, inputId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            const icon = toggle.querySelector("i");

            toggle.addEventListener("click", () => {
                const isPassword = input.type === "password";
                input.type = isPassword ? "text" : "password";

                icon.classList.toggle("fa-eye", !isPassword);
                icon.classList.toggle("fa-eye-slash", isPassword);
            });
        }

        setupToggle("togglePassword", "password");
        setupToggle("toggleConfirmPassword", "password_confirmation");
    </script>
</x-guest-layout>
