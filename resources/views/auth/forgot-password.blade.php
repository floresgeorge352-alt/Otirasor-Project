<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-[#023e8a]">Forgot Password?</h2>
        <p class="text-sm text-gray-500 mt-2">
            No problem. Just enter your email address and we'll send you a link to reset your password.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-[#0077b6] focus:border-[#0077b6] transition-colors"
                placeholder="Enter your registered email">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div class="pt-2">
            <button type="submit" 
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#0077b6] hover:bg-[#005f8f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0077b6] transition-all duration-300">
                Email Password Reset Link
            </button>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm font-medium text-[#0077b6] hover:text-[#005f8f] hover:underline transition">
                ← Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>