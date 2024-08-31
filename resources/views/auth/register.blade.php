<x-app-layout>
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('sidenav.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('sidenav.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="form-control mt-1" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Username -->
                        <div class="form-group mt-4">
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" class="form-control mt-1" type="text" name="username"
                                :value="old('username')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="form-group mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="form-control mt-1" type="password" name="password"
                                required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="form-control mt-1" type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div class="form-group mt-4">
                            <x-input-label for="role_id" :value="__('Select Role')" />
                            <select id="role_id" name="role_id" class="form-control mt-1" required>
                                <option value="" disabled selected>{{ __('Select Role') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                        </div>

                        <!-- Status (Optional) -->
                        <div class="form-group mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <x-text-input id="status" class="form-control mt-1" type="text" name="status"
                                :value="old('status')" required autocomplete="status" />
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- PIN (Optional) -->
                        <div class="form-group mt-4">
                            <x-input-label for="pin" :value="__('PIN')" />
                            <x-text-input id="pin" class="form-control mt-1" type="text" name="pin"
                                :value="old('pin')" required autocomplete="pin" />
                            <x-input-error :messages="$errors->get('pin')" class="mt-2" />
                        </div>

                        <!-- Register Button and Already Registered Link -->
                        <div class="d-flex justify-content-end mt-4">
                            {{-- <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                                href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a> --}}
                            <x-primary-button class="ms-4">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('sidenav.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->




</x-app-layout>
