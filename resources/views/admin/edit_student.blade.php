<!-- Add this section to your blade file where you want the edit form -->

@include('admin.src.header')
@include('admin.src.sidebar')

<div class="main-content">
    <hr>
<section class="section mt-5">
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header text-white" style="background-color: #801f0f;">
                        <h3 class="mb-0">Edit Student</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.students.update', ['id' => $student_detail->id]) }}">
                            @csrf
                            <input id="serial_no" type="hidden" class="form-control" name="student_id" value="{{ $student_detail->id }}" required>

                            <div class="form-group row">
                                <label for="room_no" class="col-md-4 col-form-label text-md-right">Room No</label>
                                <div class="col-md-6">
                                    <input id="room_no" type="text" class="form-control" name="room_no" value="{{ $student_detail->room_no }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Full Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $student_detail->name }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="class" class="col-md-4 col-form-label text-md-right">Class</label>
                                <div class="col-md-6">
                                    <input id="class" type="text" class="form-control" name="class" value="{{ $student_detail->class }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="batch" class="col-md-4 col-form-label text-md-right">Batch</label>
                                <div class="col-md-6">
                                    <input id="batch" type="text" class="form-control" name="batch" value="{{ $student_detail->batch }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="erp_id" class="col-md-4 col-form-label text-md-right">ERP ID</label>
                                <div class="col-md-6">
                                    <input id="erp_id" type="text" class="form-control" name="erp_id" value="{{ $student_detail->erp_id }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="enabled" class="col-md-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-6">
                                    <select id="enabled" class="form-control" name="enabled" required>
                                        <option value="1" {{ $student_detail->enabled ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$student_detail->enabled ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" style="background-color: #801f0f; border-color: #801f0f;">
                                        Update Student
                                    </button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@include('admin.src.footer')