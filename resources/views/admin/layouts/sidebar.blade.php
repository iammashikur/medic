<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mb-4">
            <a href="index.html"> <img style="
                width: 155px;
                height: 75px;
            " alt="image" src="{{url('/')}}/assets/admin/img/logo.png" class="header-logo" />
            </a>
        </div>


        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ MenuActive('', 1) }}">
                <a href="{{ url('/') }}" class="nav-link"><i
                        data-feather="monitor"></i><span>Dashboard</span></a>
            </li>

            @hasanyrole('admin')
            <li class="dropdown {{ MenuActive('doctor', 1) }}">
                <a href="{{ route('doctor.index') }}" class="nav-link"><i
                        data-feather="feather"></i><span>Doctors</span></a>
            </li>
            @endhasanyrole

            <li class="dropdown {{ MenuActive('specializations', 1) }}">
                <a href="{{ route('doctor.index') }}" class="nav-link">
                    <i data-feather="grid"></i>
                    <span>Specializations</span></a>
            </li>

            <li class="dropdown {{ MenuActive('doctor', 1) }}">
                <a href="{{ route('doctor.index') }}" class="nav-link">
                    <i class="fa fa-stethoscope"></i>
                    <span>Doctors</span></a>
            </li>



            <li class="dropdown {{ MenuActive('patient', 1) }}">
                <a href="{{ route('doctor.index') }}" class="nav-link">
                    <i class="fa fa-diagnoses"></i>
                    <span>Patients</span></a>
            </li>


            <li class="dropdown {{ MenuActive('test', 1) }} {{ MenuActive('test-category', 1) }} {{ MenuActive('test-subcategory', 1) }}">
                <a href="#" class=" nav-link has-dropdown "><i
                    data-feather="list"></i><span>Tests</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link {{ MenuActive('test', 1) }}" href="{{ route('test-category.index') }}">Test Category</a></li>

                    <li><a class="nav-link" href="{{ route('test-subcategory.index') }}">Test Subcategory</a></li>
                    <li><a class="nav-link" href="{{ route('test.index') }}">Test</a></li>

                </ul>
            </li>

            <li class="dropdown {{ MenuActive('tests', 1) }}">
                <a href="{{ route('doctor.index') }}" class="nav-link">
                    <i
                    data-feather="check-square"></i>
                    <span>Patient Tests</span></a>
            </li>


            <li class="dropdown {{ MenuActive('appointment', 1) }}">
                <a href="{{ route('appointment.index') }}" class="nav-link">
                    <i
                    data-feather="calendar"></i>
                    <span>Appointments</span></a>
            </li>



            <li class="dropdown {{ MenuActive('tests', 1) }}">
                <a href="{{ route('hospital.index') }}" class="nav-link">
                    <i
                    data-feather="hexagon"></i>
                    <span>Hospitals</span></a>
            </li>


            <li class="dropdown {{ MenuActive('tests', 1) }}">
                <a href="{{ route('doctor.index') }}" class="nav-link">
                    <i
                    data-feather="dollar-sign"></i>
                    <span>Transactions</span></a>
            </li>

            <li class="dropdown {{ MenuActive('tests', 1) }}">
                <a href="{{ route('doctor.index') }}" class="nav-link">
                    <i
                    data-feather="bar-chart-2"></i>
                    <span>Report</span></a>
            </li>

            <li class="dropdown {{ MenuActive('tests', 1) }}">
                <a href="{{ route('doctor.index') }}" class="nav-link">
                    <i
                    data-feather="settings"></i>
                    <span>Settings</span></a>
            </li>


            {{-- <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Apps</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="chat.html">Chat</a></li>
                    <li><a class="nav-link" href="portfolio.html">Portfolio</a></li>
                    <li><a class="nav-link" href="blog.html">Blog</a></li>
                    <li><a class="nav-link" href="calendar.html">Calendar</a></li>
                </ul>
            </li> --}}

        </ul>
    </aside>
</div>
