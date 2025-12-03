<x-app-layout>
    <div id="wrapper">
        @include('sidenav.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('sidenav.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1>Hands</h1>
                        <div>
                            <!-- Export Button -->
                            <a href="{{ route('hands.index', array_merge(request()->all(), ['export' => 'excel'])) }}"
                                class="btn btn-success">Export to Excel</a>
                            <!-- <a href="{{ route('hands.create') }}" class="btn btn-primary">Create Hand</a> -->
                        </div>
                    </div>

                    @php
                        $gridNames = [
                            '5 CARD POKER',
                            '3 CARD POKER',
                            'HOLDEM',
                            'ANDAR BAHAR',
                            'BLACK JACK',
                            'CUSTOM'
                        ];
                    @endphp

                    <div class="container-fluid">

                        <div class="row">
                            @foreach ($gridGroups as $index => $group)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 bg-white shadow-sm">

                                        <h5 class="text-primary fw-bold mb-3">{{ $gridNames[$index] }}</h5>

                                        <table class="table table-sm table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($group as $hand)
                                                    <tr>
                                                        <td>{{ $hand->id }}</td>
                                                        <td>{{ $hand->name }}</td>
                                                        <td>{{ $hand->deduction_type }}</td>
                                                        <td>
                                                            {{ $hand->deduction_value }}
                                                            {{ $hand->deduction_type == "percentage" ? '%' : '' }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('hands.edit', $hand->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            @include('sidenav.footer')
        </div>
    </div>
</x-app-layout>