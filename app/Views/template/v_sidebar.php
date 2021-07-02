<div class="main-sidebar">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="dashboard">Point Of Sales</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="dashboard">POS</a>
      </div>
      <ul class="sidebar-menu">
          <li class="<?php echo ($sidebar == 'dashboard') ? 'active':'' ;?>">
            <a href="dashboard" class="nav-link"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
          </li>
          <li class="<?php echo ($sidebar == 'category') ? 'active':'' ;?>">
            <a class="nav-link" href="category"><i class="fas fa-tags"></i><span>Management Category</span></a>
          </li>
          <li class="<?php echo ($sidebar == 'product') ? 'active':'' ;?>">
            <a class="nav-link" href="product"><i class="fas fa-shopping-cart"></i><span>Management Product</span></a>
          </li>
          <li class="<?php echo ($sidebar == 'transaction') ? 'active':'' ;?>">
            <a class="nav-link" href="transaction"><i class="fas fa-hand-holding-usd"></i><span>Transaction</span></a>
          </li>
        </ul>

    </aside>
  </div>