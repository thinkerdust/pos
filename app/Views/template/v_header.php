<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Point Of Sales</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/fontawesome/css/all.min.css')?>">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap4.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/datatables/button/css/buttons.bootstrap4.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/sweetalert2/dist/sweetalert2.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/select2/css/select2.min.css')?>">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/components.css') ?>">
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <ul class="navbar-nav mr-auto">
          <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block" style="text-transform:uppercase">Hi, <?php echo session()->get('username');?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="/logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>