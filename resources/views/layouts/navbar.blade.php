<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-info navbar-navy">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" style="color: white" role="button"><i class="fas fa-bars"></i></a>
        </li>
      {{-- @can('jv_create')
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plus"></i> Create Voucher
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach(App\Helpers\CommonHelper::VoucherType() as $key => $value)
                <a class="dropdown-item show-modal float-right" href="javascript:void(0);" data-size="xl" data-title="Create {{$value}}"
                data-action="{{ route('vouchers.create',["vt"=>$key]) }}">{{$value}}</a>
                @endforeach
            </div>
          </div>
          @endcan --}}
        {{--<li class="nav-item d-none d-sm-inline-block">--}}
            {{--<a href="#" class="nav-link">Contact</a>--}}
        {{--</li>--}}
    </ul>

    <!-- SEARCH FORM -->
    {{--<form class="form-inline ml-3">--}}
        {{--<div class="input-group input-group-sm">--}}
            {{--<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
            {{--<div class="input-group-append">--}}
                {{--<button class="btn btn-navbar" type="submit">--}}
                    {{--<i class="fas fa-search"></i>--}}
                {{--</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</form>--}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments" style="color: white;"></i>
                <span class="badge badge-danger navbar-badge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                {{-- <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ URL::asset('public/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>


                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a> --}}
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell" style="color: white;"></i>
                <span class="badge badge-warning navbar-badge">{{ auth()->user()->unreadNotifications()->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ auth()->user()->unreadNotifications()->count() }} Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach(auth()->user()->unreadNotifications as $notification)
                <a href="{{url('redirect_url?id='.$notification->id.'&url='.$notification->data['url'])}}" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> {{ $notification->data['name'] }}
                    <span class="float-right text-muted text-sm">{{ \App\Helpers\CommonHelper::count_minutes($notification->created_at) }}</span>
                </a>
                <div class="dropdown-divider"></div>
                @endforeach
                {{--<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt" style="color: white;"></i></a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li> --}}
    </ul>
</nav>
<!-- /.navbar -->
