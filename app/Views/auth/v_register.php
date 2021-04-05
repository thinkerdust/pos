<?php echo view('auth/v_header') ?>
<!-- content -->
    <div class="card card-primary">
        <div class="card-header"><h4>Register</h4></div>

        <div class="card-body">
            <?php if(isset($validation)): ?>
                <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                    <div class="alert-icon"><i class="far fa-times-circle"></i></div>
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                        </button>
                        <?php echo $validation->listErrors(); ?>
                    </div>
                </div>
            <?php endif; ?>
            <form method="POST" action="/proses_register" class="needs-validation" novalidate="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" name="username" autofocus required>
                    <div class="invalid-feedback">
                        Please fill in your username
                    </div>
                </div>

                <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email" required>
                    <div class="invalid-feedback">
                        Please fill in your email
                    </div>
                </div>

                <div class="row">
                <div class="form-group col-6">
                    <label for="password" class="d-block">Password</label>
                    <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                    <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                    </div>
                </div>
                <div class="form-group col-6">
                    <label for="password2" class="d-block">Password Confirmation</label>
                    <input id="password2" type="password" class="form-control" name="confirm_password" required>
                </div>
                </div>

                <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Register
                </button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        Already have an account ? <a href="/login">login</a>
    </div>
<!-- end-content -->
<?php echo view('auth/v_footer') ?>