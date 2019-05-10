<div class="card card-login mx-auto mt-5">
        <div class="card-header">Reset Password</div>
        <div class="card-body">
          <div class="text-center mb-4">
            <h4>Forgot your password?</h4>
            <p>Enter your email address and we will send you instructions on how to reset your password.</p>
          </div>

            <?php $this->addModal('form', $form); ?>
            <!--<form action="" method="post">
                <div class="form-group">
                    <div class="form-label-group">
                        <input name="email"type="email" id="inputEmail" class="form-control" placeholder="Enter email address" required="required" autofocus="autofocus">
                        <label for="inputEmail">Enter email address</label>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary btn-block" value="Reset Password"></input>
            </form>-->
          <div class="text-center">
            <a class="d-block small mt-3" href="<?php echo \Core\Routing::getSlug('Users', 'add'); ?>">Register an Account</a>
            <a class="d-block small" href="<?php echo \Core\Routing::getSlug('Users', 'login'); ?>">Login Page</a>
          </div>
        </div>
      </div>