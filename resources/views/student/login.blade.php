<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login | Institute of Business Administration</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('asset/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('asset/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('asset/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/assets/css/components.min.css') }}">

    <!-- Font Awesome 6 Free (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #801f0f;
            --secondary-color: #0d47a1;
            --accent-color: #ff6b6b;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
            --light-text: #7f8c8d;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: var(--dark-text);
        }
        
        .login-brand {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-align: center;
            letter-spacing: 1px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }
        
        .card-header h4 {
            font-weight: 600;
            margin: 0;
        }
        
        .card-body {
            padding: 2rem;
            background-color: white;
        }
        
        .form-group label {
            font-weight: 500;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(128, 31, 15, 0.25);
        }
        
        .input-group-text {
            background-color: white;
            border-right: none;
        }
        
        .input-group .form-control {
            border-left: none;
        }
        
        .input-group:focus-within .input-group-text {
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 500;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #6e1a0d;
            transform: translateY(-2px);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-text);
            z-index: 5;
        }
        
        .toggle-password:hover {
            color: var(--primary-color);
        }
        
        .login-image {
            height: 100%;
            background: linear-gradient(rgba(128, 31, 15, 0.7), rgba(13, 71, 161, 0.7)), 
                        url('asset/assets/img/iba.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            padding: 2rem;
        }
        
        .login-image h3 {
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .login-image p {
            text-align: center;
            opacity: 0.9;
        }
        
        .institution-logo {
            max-width: 200px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 2px 5px rgba(0,0,0,0.2));
        }
        
        .error-message {
            color: #e74c3c;
            background-color: #fadbd8;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 10px;
        }
        
        .note-text {
            font-size: 0.9rem;
            color: var(--light-text);
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: white;
            padding: 1rem 0;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        }
        
        .footer a {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animated {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .delay-1 {
            animation-delay: 0.2s;
        }
        
        .delay-2 {
            animation-delay: 0.4s;
        }
        
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .login-image {
                padding: 4rem 2rem;
            }
            
            body {
                padding-top: 2rem;
                padding-bottom: 4rem;
            }
        }
        
        /* Select2 customization */
        .select2-container--default .select2-selection--single {
            height: auto;
            /* padding: 10px 15px; */
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }
        .select2-container.select2-container--open .select2-selection--single{
            background-color: #ffff;
            /* color: #ffff; */
        }
        .select2-container.select2-container--focus .select2-selection--multiple, .select2-container.select2-container--focus .select2-selection--single{
            background-color: #ffff;

        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <span class="loader"><span class="loader-inner"></span></span>
        </div>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="login-brand animated">
                        <img src="{{ url('asset/assets/img/iba70whitebg.png') }}" alt="Logo" class="institution-logo">
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="card animated delay-1">
                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="card-body">
                                    <div class="card-header text-center">
                                        <h4>Welcome Back!</h4>
                                    </div>
                                    
                                    @if ($errors->any())
                                        <div class="error-message animated delay-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <div>
                                                @foreach ($errors->all() as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- @php
                                           if (session()->has('student_erp_id')) {
                                            // Session 'user' exists
                                                $user = session('student_erp_id');
                                                print_r($user);
                                            } else {
                                                // Session 'user' does not exist
                                                echo 'No user session';
                                            }
                                    @endphp          --}}

                                    <form method="POST" action="{{ route('student.login') }}">
                                         @csrf                             
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                                </div>
                                                <input id="username" style="background: white" type="text" class="form-control" required 
                                                       name="erp_id" value="{{ old('username') }}" autofocus
                                                       placeholder="Enter your ERP ID">
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter your ERPID
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                </div>
                                                <input id="password" style="background: white" type="password" class="form-control" 
                                                       name="password" required placeholder="Enter your password">
                                                <span toggle="#password" class="far fa-eye field-icon toggle-password"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter your password
                                            </div>
                                        </div>
                                        
                                        <div class="form-group text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block" id="submitBTN">
                                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                                            </button>
                                        </div>
                                        
                                        <p class="note-text animated delay-2">
                                            <i class="fas fa-info-circle mr-2"></i> 
                                            Note: Login with your ERP Portal (Oracle) Credentials.
                                        </p>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="login-image animated delay-2">
                                    <h3>Welcome to Institute of Business Administration</h3>
                                    <h4>Mess Portal</h4>
                                    <div class="mt-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="footer animated delay-2">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="bullet"></div> 
                        <a href="#">Institute of Business Administration</a> 
                        <div class="bullet"></div> 
                        <span>© {{ date('Y') }} All Rights Reserved</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('asset/assets/bundles/lib.vendor.bundle.js') }}"></script>
    <script src="{{ asset('asset/js/CodiePie.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('asset/assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('asset/assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('asset/assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('asset/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('asset/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('asset/js/scripts.js') }}"></script>
    <script src="{{ asset('asset/js/custom.js') }}"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            
            // Toggle password visibility
            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
            
            // Form validation
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
            
            // Add animation to form elements on focus
            $('.form-control').focus(function() {
                $(this).parent().addClass('animated pulse');
            }).blur(function() {
                $(this).parent().removeClass('animated pulse');
            });
        });
    </script>
</body>
</html>