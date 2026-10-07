<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-minimize">
          <button id="minimizeSidebar" class="btn btn-icon btn-round">
            <i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini"></i>
            <i class="nc-icon nc-minimal-left text-center visible-on-sidebar-regular"></i>
          </button>
        </div>
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <a class="navbar-brand" href="#">
            @if (!empty($breadcrumb))
                @foreach ($breadcrumb as $index => $item)
                    {{ $item['name'] }}
                @endforeach
            @endif
        </a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link btn-magnify" href="{{ route('fronend.home') }}" target="_bank">
                <i class="nc-icon nc-world-2"></i> เยี่ยมชมหน้าเว็บ
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-rotate"  href="{{ route('LogoutAdmin') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <i class="nc-icon nc-button-power"></i> ออกจากระบบ
                </a>

                <form id="logout-form" action="{{ route('LogoutAdmin') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
      </div>
    </div>
</nav>
