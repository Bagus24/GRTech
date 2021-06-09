<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Users
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('companies') }}" class="nav-link">
                        <i class="far fa-building nav-icon"></i>
                        <p>Companies</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('employees') }}" class="nav-link">
                        <i class="fas fa-user-friends nav-icon"></i>
                        <p>Employees</p>
                    </a>
                </li>
                

            </ul>
            <li class="nav-item">
            <a href="{{ url('daily-quotes') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Quotes
              </p>
            </a>
          </li>
        </li>

    </ul>
</nav>