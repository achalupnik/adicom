<style>
    #container {
        margin: 20vh auto;
        width: 350px;
    }
    #b_form_submit {
        margin-top: 10px;
    }
    #d_label_login {
        margin-bottom: 15px;
    }
    #infoMessage{
      color: whitesmoke;
      font-size: h4;
    }
    .pdd {
      padding: 10px 0;
    }
    #infoMessage h3 p {
      margin: 0 !important;
    }
</style>

<div id="infoMessage" class="bg-danger text-center <?php echo (isset($message)&&$message!='')?'pdd':'';?>"><h3><?php echo isset($message)?$message:'';?></h3></div>

<div id="container">
  <?php echo form_open("auth/login");?>
    <div id="d_label_login" class="text-center"><h3>Zaloguj się</h3></div>
    <input type="text" id="identity" name="identity" placeholder="login" class="form-control">
    <input type="password" id="password" name="password" placeholder="hasło" class="form-control">
    <!-- <input type="checkbox" name="remember" value="1" id="remember" class="mt-3"> 
    <label for="remember">Zapamiętaj</label> -->
    <button type="submit" id="b_form_submit" class="btn btn-lg btn-primary btn-block">Zaloguj</button>
  <?php echo form_close();?>
  <!-- <p class="text-right mt-2 "><a href="forgot_password"><?php echo 'Nie pamiętam hasła';?></a></p> -->
</div>



