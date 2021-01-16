<div class="menu">
    <div class="main-menu">
        <div class="scroll">
            <ul class="list-unstyled">
                <li class="{{(request()->is('dashboard') || request()->segment(1) == 'dashboard') ? 'active' : ''}}">
                    <a href="/dashboard">
                        <i class="fa fa-th-large" aria-hidden="true"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{(request()->is('reports') || request()->segment(1) == 'reports') ? 'active' : ''}}">
                    <a href="#reports">
                        <i class="fa fa-line-chart" aria-hidden="true"></i> Reports
                    </a>
                </li>
                <li class="{{(request()->is('trakrid') || request()->segment(1) == 'trakrid') ? 'active' : ''}}">
                    <a href="/trakrid">
                        <i class="fa fa-id-card-o" aria-hidden="true"></i> trakrID
                    </a>
                </li>
                
                @if( !auth()->user()->is_admin && !auth()->user()->sub_account )
                <li class="{{(request()->is('locations') || request()->segment(1) == 'locations') ? 'active' : ''}}">
                    <a href="/locations">
                        <i class="fa fa-globe" aria-hidden="true"></i> Locations
                    </a>
                </li>
                @endif
                
                <li class="{{(request()->is('settings') || request()->segment(1) == 'settings') ? 'active' : ''}}">
                    <a href="/settings">
                        <i class="fa fa-cog" aria-hidden="true"></i> Settings
                    </a>
                </li>
                <li class="{{(request()->is('support') || request()->segment(1) == 'support') ? 'active' : ''}}">
                    <a href="/support">
                        <i class="fa fa-life-ring" aria-hidden="true"></i> Help & Support
                    </a>
                </li>
                
                @if(auth()->user()->is_admin)
                <li class="{{(request()->is('user') || request()->segment(1) == 'user') ? 'active' : ''}}">
                    <a href="/user">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i> User Accounts
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
    
    <div class="sub-menu">
        <div class="scroll">
            <ul class="list-unstyled" data-link="reports">
                <li>
                    <a href="/reports">
                        <i class=""></i> <span class="d-inline-block">Summary Report</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('summaryReport') }}">
                        <i class=""></i> <span class="d-inline-block">Screening Questions</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>