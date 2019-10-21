    <div>
      <?php
        if(isset($error))
          echo $error;

        if(isset($activation))
          echo $activation;
          
      ?>

      <form class="login_form row" action="<?=base_url('index.php/dashboard/registerprocess')?>" method="post" >
          <div class="col-lg-6 form-group">
              <input class="form-control" type="text" required="required" name="registerFirstName" placeholder="First Name">
          </div>
          <div class="col-lg-6 form-group">
              <input class="form-control" type="text" required="required" name="registerLastName"  placeholder="Last Name">
          </div>
          <div class="col-lg-6 form-group">
              <input class="form-control" type="email" required="required" name="registerEmail"  placeholder="Email Address">
          </div>
          <div class="col-lg-6 form-group">
              <input class="form-control" type="text" required="required" name="registerPhone"  placeholder="Phone">
          </div>
          <div class="col-lg-6 form-group">
              <input class="form-control" type="date" required="required" name="registerBirthday"  placeholder="Birthday">
          </div>
          <div class="col-lg-6 form-group">
              <input class="form-control" type="text" required="required" name="registerAddress"  placeholder="Address">
          </div>
          <div class="col-lg-6 form-group">
              <input class="form-control" type="password" required="required" name="registerPassword"  placeholder="Password">
          </div>
          <div class="col-lg-6 form-group">
              <input class="form-control" type="password" required="required" name="registerReenter" placeholder="Re-Password">
          </div>
          <div class="col-lg-6 form-group">
              <button type="submit" value="submit" class="btn btn-info">Register Now</button>
          </div>
      </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
