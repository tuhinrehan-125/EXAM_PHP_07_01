@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>My Colleagues</h1>

        <form id="save-colleague-form" action="{{ route('colleagues.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="colleagues-container">
                <div class="colleague-section mb-3 p-3 border rounded bg-light">
                    <label>Name:</label>
                    <input type="text" name="colleagues[][name]" class="form-control mb-2" required>
                    
                    <label>Email:</label>
                    <input type="email" name="colleagues[][email]" class="form-control mb-2" required>
                    <label>Phone:</label>
                    <input type="text" name="colleagues[][phone]" class="form-control mb-2" required>           
                    <label>Position:</label>
                    <input type="text" name="colleagues[][position]" class="form-control mb-2" required>
                    <label>PDF File:</label>
                    <input type="file" name="colleagues[][pdf_file]" accept="application/pdf" class="form-control mb-2">
                    <button type="button" class="btn btn-danger remove-colleague">Remove</button>
                </div>
            </div>
            <button type="button" id="add-colleague" class="btn btn-primary mb-3">Add</button>
            <button type="submit" class="btn btn-success">Save</button>
        </form>

        <table id="colleagues-table" class="table table-striped table-bordered mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated by AJAX -->
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('add-colleague').addEventListener('click', function() {
            const colleagueContainer = document.getElementById('colleagues-container');
            const newColleagueSection = document.createElement('div');
            newColleagueSection.classList.add('colleague-section', 'mb-3', 'p-3', 'border', 'rounded', 'bg-light');
            newColleagueSection.innerHTML = `
                <label>Name:</label>
                <input type="text" name="colleagues[][name]" class="form-control mb-2" required>
                <label>Email:</label>
                <input type="email" name="colleagues[][email]" class="form-control mb-2" required>
                <label>Phone:</label>
                <input type="text" name="colleagues[][phone]" class="form-control mb-2" required>
                <label>Position:</label>
                <input type="text" name="colleagues[][position]" class="form-control mb-2" required>
                <label>PDF File:</label>
                <input type="file" name="colleagues[][pdf_file]" accept="application/pdf" class="form-control mb-2">
                <button type="button" class="btn btn-danger remove-colleague">Remove</button>
            `;
            colleagueContainer.appendChild(newColleagueSection);

            // Add event listener for the "Remove" button
            newColleagueSection.querySelector('.remove-colleague').addEventListener('click', function() {
                newColleagueSection.remove();
            });
        });
    </script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Ensure the CSRF token is sent with every AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Create an empty array to store the colleagues data
        var colleaguesData = [];

        // Loop through all colleague sections and collect the data
        $('#colleagues-container .colleague-section').each(function() {
            var colleague = {
                name: $(this).find('[name*="name"]').val(),
                email: $(this).find('[name*="email"]').val(),
                phone: $(this).find('[name*="phone"]').val(),
                position: $(this).find('[name*="position"]').val(),
                pdf_file: $(this).find('[name*="pdf_file"]')[0].files[0]  // File input for PDF
            };

            // Add the colleague data to the colleaguesData array
            colleaguesData.push(colleague);
        });

        // Now send the correctly structured data
        var formData = new FormData();
        formData.append('colleagues', JSON.stringify(colleaguesData));  // Append the array as a JSON string
        formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRF token

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Success:', response);
                alert(response.message);

                // Clear the form fields after submission
                $('#save-colleague-form')[0].reset();

                // Refresh the DataTable to show the new data
                $('#colleagues-table').DataTable().ajax.reload();
            },
            error: function (error) {
                console.error('Error:', error);
                alert('An error occurred. Please check the console for details.');
            }
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
                        // Reload DataTable after deleting a colleague
                        table.ajax.reload();
                    },
                    error: function(error) {
                        console.error(error);
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        };
    });
</script>

@endpush
