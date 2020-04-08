<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img src="{{url('public/images/logo/logo-anterin-2.png')}}" style="width:75%;">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
    </a>

    <hr class="sidebar-divider my-0">

    <div class="sidebar-heading">
        Main Menu
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{url('dashboard/product')}}">
            <i class="fas fa-fw fa-cubes"></i>
            <span>Products</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{url('dashboard/order')}}">
            <i class="fas fa-fw fa-file"></i>
            <span>Order</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{url('dashboard/banner')}}">
            <i class="fas fa-fw fa-clone"></i>
            <span>Banner</span>
        </a>
    </li>
</ul>