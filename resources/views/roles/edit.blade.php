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
                    <h2>Edit Role</h2>

                    <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}"
                                required>
                        </div>

                        <!-- Button to select all checkboxes -->
                        <button type="button" id="select-all" class="btn btn-primary mb-3">Select All</button>
                        <button type="button" id="deselect-all" class="btn btn-secondary mb-3">Deselect All</button>

                        <div class="form-group row">
                            <label for="permissions">Assign Permissions</label>
                            @foreach ($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input data-permission class="form-check-input" type="checkbox"
                                            name="permissions[]" value="{{ $permission->id }}"
                                            {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Update Role</button>
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

    <script>
        // Get the select and deselect buttons
        const selectAllBtn = document.getElementById('select-all');
        const deselectAllBtn = document.getElementById('deselect-all');

        // Get all checkboxes with the name 'permissions[]'
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');

        // Event listener for selecting all checkboxes
        selectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        });

        // Event listener for deselecting all checkboxes
        deselectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        });
    </script>


</x-app-layout>
