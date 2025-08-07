<!DOCTYPE html>
<html lang="en">

<!-- index.html  Tue, 07 Jan 2020 03:35:33 GMT -->
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>IBA Hostel Mess</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="{{ asset('asset/assets/modules/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/assets/modules/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('asset/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/assets/modules/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('asset/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

{{-- datables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- Template CSS -->
<link rel="stylesheet" href="{{ asset('asset/assets/css/style.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/assets/css/components.min.css') }}">

<!-- Font Awesome 6 Free (CDN) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .pricing-highlight{
        border: 1px solid #0d47a1;
    }
    .pricing-title{
        background-color: #810f0f !important;
        padding: 15px !important;
        font-size: 15px !important;
    }

  .row.card-row {
    display: flex;
    flex-wrap: wrap;
  }
  .pricing-item-label{
    font-weight: 900px;
    font-size: 15px;
    padding-top: 3px;
    justify-content: flex-start;
  }
.pricing-details{
    display: flex;
    justify-content: flex-start !important;
}
  .card-row > .col-12 {
    display: flex;
  }

  .pricing-item:hover{
    cursor: pointer;
    text-decoration: underline;
    color: darkblue;
    
  }

  #card-container {
  max-height: 600px;
  overflow-y: auto;
}
.pricing {
  flex: 1;
  display: flex;
  flex-direction: column;
  height: 280px; /* Fixed height for all cards */
  overflow: hidden;
}

.pricing-padding {
  flex-grow: 1;
  overflow-y: auto; /* Enables vertical scrollbar if content overflows */
  padding-right: 5px; /* Add spacing to avoid hidden scrollbar content */
}

/* Optional: add consistent scrollbar style */
.pricing-padding::-webkit-scrollbar {
  width: 6px;
}

.pricing-padding::-webkit-scrollbar-thumb {
  background-color: #ccc;
  border-radius: 3px;
}

.pricing-padding::-webkit-scrollbar-track {
  background-color: #f1f1f1;
}

.prevBtn, .nextBtn, .page-indicator{
    margin: 0 30px;
}
.badge-success { background-color: #28a745; color: white; padding: 3px 8px; border-radius: 5px; }
.badge-danger { background-color: #dc3545; color: white; padding: 3px 8px; border-radius: 5px; }
.main-content{
    padding-top: 10px;
}
    #meals-table td {
    white-space: normal !important;
    word-wrap: break-word;
}

.badge-success {
    background-color: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
}



</style>
</head>
<body class="layout-4">
<!-- Page Loader -->
{{-- <div class="page-loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div> --}}

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg" style="background-color: #ffff" ></div>
        
        <!-- Start app top navbar -->
        <nav class="navbar navbar-expand-lg main-navbar" style="background-color: #ffff" >
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3" >
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg" style="color: #801f0f" ><i class="fas fa-bars"></i></a></li>
                    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                </ul>
                
            </form>
            <ul class="navbar-nav navbar-right">
                @if(Auth::guard('admin')->check())
                <li class="nav-item dropdown">
                    
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-sm-none d-lg-inline-block" style="color: #801f0f">
                            Hi, {{ Auth::guard('admin')->user()->username }}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        {{-- <li><div class="dropdown-item-text">Logged in {{ Auth::guard('admin')->user()->updated_at->diffForHumans() }}</div></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="features-profile.html" class="dropdown-item"><i class="far fa-user me-2"></i> Profile</a></li>
                        <li><a href="features-activities.html" class="dropdown-item"><i class="fas fa-bolt me-2"></i> Activities</a></li> --}}
                        {{-- <li><a href="{{ route('password.settings') }}" class="dropdown-item"><i class="fas fa-cog me-2"></i> Settings</a></li> --}}
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
        
