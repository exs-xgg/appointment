    <div>
      <?php
        if(isset($error))
          echo $error;

        if(isset($activation))
          echo $activation;
      ?>

      <form class="login_form row" action="<?=base_url('index.php/dashboard/registerConfirm')?>" method="post" >
          <div class="col-lg-4 form-group">
              <input class="form-control" type="email" name="registerEmail"  placeholder="Email Address">
          </div>
          <div class="col-lg-3 form-group">
              <input class="form-control" type="text" name="registerCode" placeholder="Confirmation Code">
          </div>
          <div class="col-lg-3 form-group">
              <button type="submit" value="submit" class="btn btn-info">Activate Account</button>
          </div>
      </form>
    </div>
