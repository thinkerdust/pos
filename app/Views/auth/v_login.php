<?php echo view('auth/v_header') ?>
<!-- content -->
  <div class="card card-success">
    <div class="card-header"><h4>Login</h4></div>

    <div class="card-body">
      <?php if(!empty(session()->getFlashdata('error'))): ?>
        <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <button class="close" data-dismiss="alert">
              <span>&times;</span>
            </button>
            <?php echo session()->getFlashdata('error'); ?>
          </div>
        </div>
      <?php endif; ?>
      <form method="POST" action="/authenticate" class="needs-validation" novalidate="">
        <div class="form-group">
          <label for="email">Username</label>
          <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
          <div class="invalid-feedback">
            Please fill in your username
          </div>
        </div>

        <div class="form-group">
          <div class="d-block">
              <label for="password" class="control-label">Password</label>
            <div class="float-right">
              <a href="auth-forgot-password.html" class="text-small">
                Forgot Password?
              </a>
            </div>
          </div>
          <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
          <div class="invalid-feedback">
            please fill in your password
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
            Login
          </button>
        </div>
      </form>

    </div>
  </div>
  <div class="mt-5 text-muted text-center">
    Don't have an account? <a href="/register">Create One</a>
  </div>
<!-- end-content -->
<?php echo view('auth/v_footer') ?>