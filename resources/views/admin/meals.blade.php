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
                    <h3 class="mb-0">Students Ordered Meals</h3>
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
                   <table id="meals-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ERP ID</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Meal Types</th>
                            <th>Meal Rates</th>
                            <th>Total Price</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Room No</th>
                            <th>Payment Status</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
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
