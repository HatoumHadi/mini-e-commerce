<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-md w-full mx-auto bg-white rounded-lg shadow-md overflow-hidden p-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Welcome Back</h2>
            <p class="text-gray-600 mt-2">Sign in to access your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" class="block text-sm font-medium text-gray-700" />
                <div class="mt-1">
                    <x-text-input
                        id="email"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="your@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                <div class="mt-1">
                    <x-text-input
                        id="password"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>
            </div>

{{--            <div class="flex items-center justify-between">--}}
{{--                <!-- Remember Me -->--}}
{{--                <div class="flex items-center">--}}
{{--                    <input id="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" name="remember">--}}
{{--                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">--}}
{{--                        {{ __('Remember me') }}--}}
{{--                    </label>--}}
{{--                </div>--}}

{{--                @if (Route::has('password.request'))--}}
{{--                    <div class="text-sm">--}}
{{--                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">--}}
{{--                            {{ __('Forgot password?') }}--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}

            <div>
                <x-primary-button class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Sign In') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            <p>
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    {{ __('Sign up') }}
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
