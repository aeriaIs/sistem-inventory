<section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="menu-sidebar"><a href="{{ url('/home') }}"><span class="fa fa-calendar-minus-o"></span> Beranda Dashboard</span></a></li>

        <li class="menu-sidebar"><a href="{{ route('supplier.index') }}"><span class="fa fa-calendar-minus-o"></span> Supplier </span></a></li>

        <li class="menu-sidebar"><a href="{{ route('product.index') }}"><span class="fa fa-calendar-minus-o"></span> Produk </span></a></li>

        <li class="menu-sidebar"><a href="{{ route('purchase-order.index') }}"><span class="fa fa-calendar-minus-o"></span> Orders </span></a></li>

        <li class="menu-sidebar">
          <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="glyphicon glyphicon-log-out">
            </span> Logout</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
             @csrf
          </form>
        </li>

      </ul>
    </section>