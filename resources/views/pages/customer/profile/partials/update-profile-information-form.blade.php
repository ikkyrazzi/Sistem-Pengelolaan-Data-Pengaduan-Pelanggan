<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('patch')
        <div class="card-body">
            <!-- Name -->
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input id="name" name="name" type="text"
                    class="form-control @error('name') is-invalid @enderror" required autocomplete="name"
                    placeholder="Enter full name" value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" name="email" type="email"
                    class="form-control @error('email') is-invalid @enderror" required autocomplete="email"
                    placeholder="Enter email address" value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="card-action mt-4">
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ route('customer.dashboard') }}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</section>
