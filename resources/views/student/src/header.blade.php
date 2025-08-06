<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title : 'IBA Mess Portal' }}</title>
    <link rel="shortcut icon" href="{{ asset('asset\assets\img\iba70whitebg.png') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Flatpickr for date selection -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #801f0f;
            --secondary-color: #801f0f;
            --accent-color: #e74c3c;
            --light-bg: #f9f5f4;
            --card-shadow: 0 4px 20px rgba(128, 31, 15, 0.08);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            padding-top: 70px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 5px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--secondary-color);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .navbar.scrolled .navbar-brand img {
            height: 35px;
        }

        .nav-center {
            display: flex;
            justify-content: center;
            flex-grow: 1;
        }

        .nav-link {
            color: var(--secondary-color);
            font-weight: 500;
            margin: 0 15px;
            padding: 5px 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link:hover:after,
        .nav-link.active:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-color);
            animation: underline 0.3s ease;
        }

        @keyframes underline {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        .logout-btn {
            background-color: var(--accent-color);
            color: white;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
        }

        /* User dropdown styles */
        .user-dropdown {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .navbar.scrolled .user-avatar {
            width: 28px;
            height: 28px;
            font-size: 0.9rem;
        }

        .user-name {
            font-weight: 500;
            color: var(--secondary-color);
            margin-right: 5px;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 0;
            overflow: hidden;
        }

        .dropdown-item {
            padding: 10px 15px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            margin: 0;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding-bottom: 60px;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(128, 31, 15, 0.15);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }

        /* DataTable Styles */
        #subscriptions-table_wrapper {
            padding: 0;
        }

        #subscriptions-table {
            width: 100% !important;
        }

        #subscriptions-table thead th {
            background-color: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 12px 15px;
        }

        #subscriptions-table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        #subscriptions-table tbody tr:nth-child(even) {
            background-color: rgba(128, 31, 15, 0.03);
        }

        #subscriptions-table tbody tr:hover {
            background-color: rgba(128, 31, 15, 0.08);
        }

        .dataTables_length,
        .dataTables_filter {
            margin-bottom: 15px;
        }

        .dataTables_info {
            padding-top: 15px !important;
        }

        .dataTables_paginate .paginate_button {
            padding: 5px 12px;
            margin: 0 3px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .dataTables_paginate .paginate_button.current {
            background: var(--primary-color);
            color: white !important;
            border-color: var(--primary-color);
        }

        /* Buttons */
        .dt-buttons .btn {
            border-radius: 6px;
            padding: 6px 12px;
            margin-right: 8px;
            transition: all 0.3s ease;
        }

        .dt-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #6e1a0d;
            border-color: #6e1a0d;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Badges */
        .badge {
            padding: 6px 10px;
            font-weight: 500;
            font-size: 0.85rem;
            border-radius: 4px;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        /* Footer */
        footer.main-footer {
            background-color: white;
            padding: 20px 0;
            color: var(--primary-color);
            font-size: 0.9rem;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
            margin-top: auto;
        }

        footer.main-footer a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }

        footer.main-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .nav-center {
                display: none;
            }

            .navbar-brand {
                margin-right: auto;
            }
            
            #subscriptions-table thead {
                display: none;
            }
            
            #subscriptions-table tbody td {
                display: block;
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            
            #subscriptions-table tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                padding-right: 10px;
                font-weight: bold;
                text-align: left;
                color: var(--primary-color);
            }
            
            #subscriptions-table tbody tr {
                margin-bottom: 15px;
                display: block;
                border: 1px solid #ddd;
                border-radius: 8px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .navbar-brand img {
                height: 30px;
            }
            
            .card-header h3 {
                font-size: 1.2rem;
            }
            
            .dataTables_length,
            .dataTables_filter {
                margin-bottom: 10px;
            }
            
            .dt-buttons {
                margin-bottom: 10px;
            }
            
            .dt-buttons .btn {
                margin-bottom: 5px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card, #subscriptions-table {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body>
    <!-- Eye-catching Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo on the left -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('asset\assets\img\iba70whitebg.png') }}" alt="Logo">
            </a>

            <!-- Centered navigation links -->
            <div class="nav-center d-none d-lg-flex">
                <a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('student.subscription') }}" class="nav-link {{ request()->routeIs('student.subscription') ? 'active' : '' }}">Subscriptions</a>
            </div>

            <!-- User dropdown on the right -->
            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown">
                    <a class="user-dropdown dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ isset($student->name) ?  substr($student->name, 0, 1) : '' }}
                        </div>
                        <span class="user-name d-none d-sm-inline">{{ isset($student->name) ? $student->name : '-' }}</span>
                        {{-- <i class="fas fa-chevron-down"></i> --}}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        {{-- <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li> --}}
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('student.logout') }}">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Mobile menu button -->
            <button class="navbar-toggler d-lg-none ms-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#mobileMenu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>
    
    <!-- Mobile Menu (hidden on larger screens) -->
    <div class="collapse d-lg-none" id="mobileMenu">
        <div class="container py-3">
            <a href="{{ route('student.dashboard') }}" class="d-block py-2 nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('student.subscription') }}" class="d-block py-2 nav-link {{ request()->routeIs('student.subscription') ? 'active' : '' }}">Subscriptions</a>
        </div>
    </div>