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
                    <h1>House Commissions</h1>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Bet ID</th>
                                <th>Commission Amount</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $commission)
                                <tr>
                                    <td>{{ $commission->id }}</td>
                                    <td>{{ $commission->bet_id }}</td>
                                    <td>{{ $commission->commission_amount }}</td>
                                    <td>{{ $commission->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $commissions->links() }}
                    </div>
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
