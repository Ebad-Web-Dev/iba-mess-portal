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
                <div class="card-header text-white" style="background-color: #801f0f; !important">
                    <h3 class="mb-0">Students List</h3>
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
                    <table id="student-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room No</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Batch</th>
                                <th>ERP ID</th>
                                <th>Status</th> <!-- New status column -->
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    </section>
</div>



<!-- Start app Footer part -->
@include('admin.src.footer')
