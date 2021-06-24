<aside class="main-sidebar open">
      <div class="sidebar-heading d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="#">مرحبا {{Auth::guard('dashboard')->user()->name}}  </a>
        <i class="fas fa-bars fa-lg icon toggle-sidebar-icon d-none d-xl-block"></i>
        <i class="fas fa-times fa-lg icon toggle-sidebar-icon d-block d-xl-none"></i>
      </div>
      <ul class="nav d-block sidebar-links-container">
        <li class="nav-item  statistics">
          <a class="nav-link {{ Request::is('*statistics*') ? 'active ' : '' }}" href="{{route('dashboard.statistics.index')}}"><i class="fas fa-chart-line mr-2"></i> <span>التقارير</span></a>
        </li>
        {{-- <li class="nav-item  users">
          <a class="nav-link {{ Request::is('*users*') ? 'active ' : '' }}" href="{{route('dashboard.users.index')}}"><i class="fas fa-users mr-2"></i> <span>العملاء</span></a>
        </li> --}}
        <li class="nav-item notifications">
          <a class="nav-link {{ Request::is('*notifications*') ? 'active ' : '' }}" href="{{route('dashboard.notifications.index')}}"><i class="far fa-bell  mr-2"></i><span>الإشعارات</span></a>
        </li>
        <li class="nav-item horoscopes">
          <a class="nav-link {{ Request::is('*horoscopes*') ? 'active ' : '' }}" href="{{route('dashboard.horoscopes.index')}}"><i class="fas fa-broadcast-tower mr-2"></i><span>الابراج</span></a>
        </li>
        <li class="nav-item news">
            <a class="nav-link {{ Request::is('*news*') ? 'active ' : '' }}" href="{{route('dashboard.news.index')}}"><i class="far fa-newspaper fa-1x mr-2"></i><span>الاخبار</span></a>
        </li>
        <li class="nav-item warnings">
            <a class="nav-link {{ Request::is('*warnings*') ? 'active ' : '' }}" href="{{route('dashboard.warnings.index')}}"><i class="fas fa-exclamation-triangle fa-1x mr-2"></i><span>التحذيرات</span></a>
        </li>
            @if(Auth::guard('dashboard')->user()->isSuperAdmin)
          <li class="nav-item admins">
            <a class="nav-link {{ Request::is('*admins*') ? 'active ' : '' }}" href="{{route('dashboard.admins.index')}}"><i class="fas fa-user fa-1x mr-2"></i><span>المسؤولين</span></a>
          </li>
        @endif
        <li class="nav-item appInfo">
          <a class="nav-link {{ Request::is('*appInfo*') ? 'active ' : '' }}" href="{{route('dashboard.appInfo.index')}}"><i class="fas fa-cogs  mr-2"></i><span>إعدادات التطبيق </span></a>
        </li>
        </li>
      </ul>
</aside>
