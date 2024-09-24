<x-app-layout>
    <div id="wrapper">
        @include('sidenav.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('sidenav.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h2>Audit Log Files</h2>

                    @if ($paginatedFiles)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paginatedFiles as $file)
                                    <tr>
                                        <td>{{ basename($file) }}</td>
                                        <td>
                                            <a href="{{ route('audit_logs.files.download', basename($file)) }}"
                                                class="btn btn-primary">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center">
                            {{ $paginatedFiles->links() }}
                        </div>
                    @else
                        <p>No log files available.</p>
                    @endif
                </div>
                <!-- /.container-fluid -->

            </div>
            @include('sidenav.footer')
        </div>
    </div>
</x-app-layout>
