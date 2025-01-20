<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="form-group">
            <label for="current_password">{{ __('Current Password') }}</label>
            <input id="current_password" name="current_password" type="password"
                class="form-control @error('current_password') is-invalid @enderror" required
                autocomplete="current-password" placeholder="Enter your current password">
            @error('current_password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="form-group">
            <label for="password">{{ __('New Password') }}</label>
            <input id="password" name="password" type="password"
                class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password"
                placeholder="Enter a new password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm New Password -->
        <div class="form-group">
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required
                autocomplete="new-password" placeholder="Confirm your new password">
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="card-action">
            <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
            <a href="{{ route('technician.dashboard') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
        </div>
    </form>
</section>
