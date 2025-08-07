@include('admin.src.header')


<!-- Start main left sidebar menu -->
@include('admin.src.sidebar')
<!-- Start app main Content -->
<div class="main-content">
    <section class="section mt-5">
        <div class="container-fluid py-2">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header text-white" style="background-color: #801f0f;">
                            <h3 class="mb-0">Change Password</h3>
                        </div>
                        
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.change') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="username">Admin Username</label>
                                    <input type="text" class="form-control" id="username" 
                                           value="{{ Auth::guard('admin')->user()->username }}" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" 
                                               name="password" required placeholder="Enter new password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" 
                                           name="password_confirmation" required placeholder="Confirm new password">
                                </div>
                                
                                <button type="submit" class="btn btn-primary" style="background-color: #801f0f; border-color: #801f0f;">
                                    Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>



<!-- Start app Footer part -->
@include('admin.src.footer')
