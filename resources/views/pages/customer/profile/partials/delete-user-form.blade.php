<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')

        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" name="password" type="password"
                class="form-control @error('password') is-invalid @enderror" required
                placeholder="{{ __('Enter your password') }}">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-danger">
                {{ __('Delete Account') }}
            </button>
            <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</section>
