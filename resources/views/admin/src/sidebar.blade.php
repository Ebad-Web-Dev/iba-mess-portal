  <style>
    .active-link {
        position: relative;
        text-decoration: none;
    }
    
    .active-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #801f0f;
        animation: underline 0.3s ease;
    }
    
    @keyframes underline {
        from { width: 0; }
        to { width: 100%; }
    }
    
    .active-link svg, .active-link span {
        color: #801f0f !important;
        font-weight: bold;
    }
</style>
  <div class="main-sidebar sidebar-style-3">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="index-2.html"><img src="{{ asset('asset/assets/img/iba70whitebg.png') }}" height="40" width="60" alt="logo"></a>
                </div> 
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="index-2.html"><img src="{{ asset('asset/assets/img/iba70whitebg.png') }}" height="40" width="60" alt="logo"></a>
                </div>
                <ul class="sidebar-menu">
                    <li class="menu-header">Welcome {{ Auth::guard('admin')->user()->username }}</li>
                    
                    <!-- Dashboard -->
                    <li class="dropdown {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" style="color: #0d47a1;">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#801f0f" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                                <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                            </svg>
                            <span class="mx-2" style="color: #801f0f">Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- Import Students -->
                    <li class="dropdown {{ request()->routeIs('students.import') ? 'active' : '' }}" style="color: #0d47a1;">
                        <a href="{{ route('students.import') }}" class="nav-link {{ request()->routeIs('students.import') ? 'active-link' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#801f0f" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                            </svg>
                            <span class="mx-2" style="color: #801f0f">Import Students</span>
                        </a>
                    </li>
                    
                    <!-- Students Meals -->
                    <li class="dropdown {{ request()->routeIs('admin.students.meals') ? 'active' : '' }}" style="color: #0d47a1;">
                        <a href="{{ route('admin.students.meals') }}" class="nav-link {{ request()->routeIs('admin.students.meals') ? 'active-link' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#801f0f" viewBox="0 0 16 16">
                                <path d="M2 9a2 2 0 0 0 2-2h8a2 2 0 0 0 2 2 2 2 0 0 0 2 2H0a2 2 0 0 0 2-2zm.5 3a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm2 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zM12 9a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2 2 2 0 0 0-2 2h12a2 2 0 0 0-2-2z"/>
                                <path d="M8 0a5.5 5.5 0 0 0-5.5 5.5.5.5 0 0 0 .5.5H5a1 1 0 0 0 1-1 1 1 0 0 1 2 0 1 1 0 0 0 1 1h1.5a.5.5 0 0 0 .5-.5A5.5 5.5 0 0 0 8 0z"/>
                            </svg>
                            <span class="mx-2" style="color: #801f0f">Students Meals</span>
                        </a>
                    </li>
                </ul>


            </aside>
        </div>