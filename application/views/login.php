    <div>
      <?php
        if(isset($message))
          echo $message;

        if(isset($activation))
          echo $activation;

      ?>
      <form class="login_form row" action="<?=base_url('index.php/dashboard/login')?>" method="post" >
          <div class="col-lg-12 form-group">
              <input class="form-control" type="text" name="identity" placeholder="User Name">
          </div>
          <div class="col-lg-12 form-group">
              <input class="form-control" type="password" name="password" placeholder="Password">
          </div>

          <div class="col-lg-12 form-group">
              <div class="creat_account">
                  <input type="checkbox" id="f-option" name="selector">
                  <label for="f-option">Keep me logged in</label>
                  <div class="check"></div>
              </div>
          </div>
          <div class="col-lg-12 form-group">
              <button type="submit" value="submit" class="btn btn-info">Login</button>
          </div>
      </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
