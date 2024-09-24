<section>
    <header>
        <h2 class="h4 font-weight-medium text-dark">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="form-group">
            <x-input-label for="name" :value="__('Name')" class="form-label" />
            <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
        </div>

        <div class="form-group">
            <x-input-label for="username" :value="__('Username')" class="form-label" />
            <x-text-input id="username" name="username" type="text" class="form-control" :value="old('username', $user->username)" required autocomplete="username" />
            <x-input-error class="mt-2 text-danger" :messages="$errors->get('username')" />

            {{-- @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0 text-decoration-none text-muted">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif --}}
        </div>

        <!-- Role -->
        <div class="form-group">
            <x-input-label for="role_id" :value="__('Select Role')" class="form-label" />
            <select id="role_id" name="role_id" class="form-select" required>
                <option value="" disabled>{{ __('Select Role') }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $role->id == old('role_id', $user->role_id) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2 text-danger" />
        </div>

        <!-- Status (Optional) -->
        <div class="form-group mt-4">
            <x-input-label for="status" :value="__('Status')" />
            
            <select id="status" class="form-control mt-1" name="status" required autocomplete="status">
                <option value="Active" {{ old('status', $user->status) == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('status', $user->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <!-- PIN (Optional) -->
        <div class="form-group">
            <x-input-label for="pin" :value="__('PIN')" class="form-label" />
            <x-text-input id="pin" class="form-control" type="text" name="pin" :value="old('pin', $user->pin)" required autocomplete="pin" />
            <x-input-error :messages="$errors->get('pin')" class="mt-2 text-danger" />
        </div>

        <div class="d-flex align-items-center gap-2">
            <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>