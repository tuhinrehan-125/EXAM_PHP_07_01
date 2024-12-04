@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">My Colleagues</h1>

    <!-- Save Colleague Form -->
    <form id="save-colleague-form" class="mb-5 p-4 border rounded bg-light shadow">
        @csrf
        <div id="colleagues-container">
            <div class="colleague-section row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="position" class="form-label">Position:</label>
                    <input type="text" name="position" class="form-control" required>
                </div>
                <div class="col-md-12">
                    <label for="pdf_file" class="form-label">PDF File:</label>
                    <input type="file" name="pdf_file" class="form-control" accept="application/pdf">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <!-- Colleagues Table -->
    <div class="table-responsive">
        <table id="colleagues-table" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded via AJAX -->
            </tbody>
        </table>
    </div>
</div>
@endsection


@push('scripts')
<!-- <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#colleagues-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/colleagues',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'position', name: 'position' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        // Save Colleague
        $('#save-colleague-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '/colleagues',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response.message);
                    $('#colleagues-table').DataTable().ajax.reload();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        // Delete Colleague
        window.deleteColleague = function(id) {
            if (confirm('Are you sure you want to delete this colleague?')) {
                $.ajax({
                    url: `/colleagues/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#colleagues-table').DataTable().ajax.reload();
                    }
                });
            }
        };
    });
</script> -->
@endpush
