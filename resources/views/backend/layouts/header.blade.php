<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="text-capitalize {{ isset($active) ? ($active == "dashboard" ? "active" : "" ) : ''  }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="menu-icon ti-home"></i>Dashboard </a>
                </li>
                <li class="text-capitalize {{ isset($active) ? ($active == "categories" ? "active" : "" ) : ''  }}">
                    <a href="{{ route('admin.categories.index') }}"><i class="menu-icon ti-menu"></i>Danh mục</a>
                </li>
                <li class="text-capitalize {{ isset($active) ? ($active == "products" ? "active" : "" ) : ''  }}">
                    <a href="{{ route('admin.product') }}"><i class="menu-icon ti-bag"></i>Sản phẩm</a>
                </li>
                <li class="text-capitalize {{ isset($active) ? ($active == "orders" ? "active" : "" ) : ''  }}">
                    <a href="{{ route('admin.orders.index') }}"><i class="menu-icon ti-truck"></i>Đơn hàng</a>
                </li>
                <li class="text-capitalize {{ isset($active) ? ($active == "users" ? "active" : "" ) : ''  }}">
                    <a href="{{ route('admin.users.index') }}"><i class="menu-icon ti-user"></i>Khách hàng</a>
                </li>
                <li class="{{ isset($active) ? ($active == "contacts" ? "active" : "" ) : ''  }}">
                    <a href="{{ route('admin.contacts.index') }}"><i class="menu-icon ti-info-alt"></i>
                    Thông tin</a>
                </li>
                <li class="{{ isset($active) ? ($active == "slides" ? "active" : "" ) : ''  }} text-capitalize">
                    <a href="{{ route('admin.slides.index') }}"><i class="menu-icon ti-image"></i>
                    Trình chiếu</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->
<!-- Right Panel -->
<div id="right-panel" class="right-panel">
    <!-- Header-->
    <header id="header" class="header">
        <div class="top-left">
            <div class="navbar-header">
                <a class="navbar-brand" href="./"><img src="{{ asset('backend/images/logo.png') }}" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="{{ asset('backend/images/logo.png') }}" alt="Logo"></a>
                <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
        </div>
        <div class="top-right">
            <div class="header-menu">
                <div class="header-left">
                    <div class="dropdown for-notification">
                        @php
                            $is_not_reads = App\Models\Order::where('is_read', false)->orderBy('created_at','desc')->get();
                        @endphp

                        <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="count bg-danger notification-count" @if($is_not_reads->count() == 0) style="display: none" @endif>{{count($is_not_reads)}}</span>
                        </button>
                        
                        <div class="dropdown-menu" aria-labelledby="notification" id="dropdownNotification">
                            @forelse ($is_not_reads as $item)
                                {{-- @php
                                    if ($item->user->avatar) {
                                        $path = Storage::url($item->user->avatar);
                                    } else {
                                        $path = asset('images/shop/no-avatar.png');
                                    }
                                @endphp --}}
                                <a class="dropdown-item media" href="{{ route('admin.orders.index', ['search' => $item->order_id]) }}">
                                    {{-- <span class="photo media-left"><img alt="avatar" src="{{$path}}"></span> --}}
                                    <div class="message media-body">
                                        {{-- <span class="name float-left">Đơn hàng mới từ {{$item->user->name}}</span> --}}
                                        <span class="time float-right">
                                            @php 
                                                Carbon\Carbon::setLocale('vi');
                                                echo $item->created_at->diffForHumans(Carbon\Carbon::now());
                                            @endphp
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <a class="dropdown-item media" href="#">
                                    <div class="message media-body">
                                        <p>Bạn hiện không có thông báo nào </p>
                                    </div>
                                </a>
                            @endforelse
                            
                        </div>
                    </div>

                    <div class="user-area dropdown">
                        <a href="#" class="dropdown-toggle active" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="{{ asset('backend/images/admin.jpg') }}" alt="User Avatar">
                        </a>
                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="{{ route('admin.logout') }}"><i class="fa fa-power -off"></i>Đăng Xuất</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>