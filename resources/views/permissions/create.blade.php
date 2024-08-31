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
                    <h2>Create Permission</h2>

                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Permission Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Permission</button>
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
