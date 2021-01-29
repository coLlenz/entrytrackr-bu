<div class="menu">
    <div class="main-menu">
        <div class="scroll">
            <ul class="list-unstyled">
                <li class="{{(request()->segment(2) == 'dashboard') ? 'active' : ''}}">
                    <a href="/dashboard">
                        <i class="fa fa-th-large" aria-hidden="true"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="{{(request()->segment(2) == 'reports') ? 'active' : ''}}">
                    <a href="#">
                        <i class="fa fa-line-chart" aria-hidden="true"></i> Reports
                    </a>
                </li>
                <li class="{{(request()->segment(2) == 'trakrid') ? 'active' : ''}}">
                    <a href="#">
                        <i class="fa fa-id-card-o" aria-hidden="true"></i> trakrID
                    </a>
                </li>
                
                <li class="{{(request()->segment(2) == 'templates') ? 'active' : ''}}">
                    <a href="#">
                        <i class="fa fa-list-ul" aria-hidden="true"></i> Templates
                    </a>
                </li>
                
                <li class="{{(request()->segment(2) == 'settings') ? 'active' : ''}}">
                    <a href="#">
                        <i class="fa fa-cog" aria-hidden="true"></i> Settings
                    </a>
                </li>
                <li class="{{(request()->segment(2) == 'support') ? 'active' : ''}}">   
                    <a href="#">
                        <i class="fa fa-life-ring" aria-hidden="true"></i> Help & Support
                    </a>
                </li>
                
                <li class="{{(request()->segment(2) == 'clients') ? 'active' : ''}}">
                    <a href="{{route('admin-clients')}}">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i> User Accounts
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="sub-menu">
        <div class="scroll">
            <ul class="list-unstyled" data-link="reports">
                <li>
                    <a href="/reports">
                        <i class=""></i> <span class="d-inline-block font-weight-bold">Summary Report</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('summaryReport') }}">
                        <i class=""></i> <span class="d-inline-block font-weight-bold">Screening Questions</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>