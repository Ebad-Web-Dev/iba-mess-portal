@include('admin.src.header')


<!-- Start main left sidebar menu -->
@include('admin.src.sidebar')
<!-- Start app main Content -->
<div class="main-content">
    <hr>
    <section class="section mt-5">

<div class="container-fluid py-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header text-white" style="background-color: #801f0f">
                    <h3 class="mb-0">Import Students</h3>
                </div>
                
                <div class="card-body">
                    {{-- Flash messages --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('warning'))
                        <div class="alert alert-warning">{{ session('warning') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {!! session('error') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('import_errors'))
                        <ul class="alert alert-danger">
                            @foreach(session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Import Instructions --}}
                    <div class="alert alert-info" style="background-color: #63776b; margin-top: 80px;">
                        <h5>⚠️ File Requirements:</h5>
                        <ul class="mb-1">
                            <li>The first row must contain these exact headers:</li>
                        </ul>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>s_no</th>
                                        <th>room_no</th>
                                        <th>name_of_students</th>
                                        <th>class</th>
                                        <th>batch</th>
                                        <th>erp_id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>101</td>
                                        <td>John Doe</td>
                                        <td>BSAF-V</td>
                                        <td>2023-27</td>
                                        <td>12345</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="mb-0">Avoid extra spaces, symbols, or empty columns.</p>
                        <a href="{{ asset('storage/samples/sample file.xlsx') }}" class="btn btn-sm btn-outline-primary mt-2" download>
                            <i class="fas fa-download"></i> Download Sample File
                        </a>
                    </div>

                    {{-- Upload Form --}}
                    <form action="{{ route('students.import.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group" style="margin-top: 100px">
                            <label for="file">Select Excel/CSV File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file" required>
                                <label class="custom-file-label" for="file">Choose file...</label>
                            </div>
                            <small class="form-text text-muted">
                                Supported formats: .xlsx, .xls, .csv (Max: 5MB)
                            </small>
                        </div>

                        <button type="submit" class="btn btn-warning mt-3">
                            <i class="fas fa-upload"></i> Import Students
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Show filename when file is selected
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        e.target.nextElementSibling.textContent = fileName;
    });
</script>



    </section>
</div>
<!-- Start app Footer part -->
@include('admin.src.footer')
