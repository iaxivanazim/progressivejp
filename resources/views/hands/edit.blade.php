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
                    <h1>Edit Hand</h1>

                    <form action="{{ route('hands.update', $hand->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Hand Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ old('name', $hand->name) }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deduction Type -->
                        <div class="form-group">
                            <label for="deduction_type">Deduction Type</label>
                            <select class="form-control" id="deduction_type" name="deduction_type">
                                <option value="percentage" {{ $hand->deduction_type ? 'selected' : '' }}>Percentage
                                </option>
                                <option value="fixed" {{ $hand->deduction_type ? 'selected' : '' }}>Fixed Amount
                                </option>
                            </select>
                        </div>

                        <!-- Deduction Value -->
                        <div class="form-group">
                            <label for="deduction_value">Deduction Value</label>
                            <input type="number" class="form-control" id="deduction_value" name="deduction_value"
                                step="0.01" required value="{{ old('deduction_value', $hand->deduction_value) }}">
                        </div>

                        <div class="form-group">
                            <label for="float">Float</label>
                            <input type="checkbox" class="sensor-checkbox" name="float" id="float" value="1"
                                {{ $hand->float ? 'checked' : '' }}>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
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
