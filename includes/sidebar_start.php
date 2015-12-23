<div class="sidebar">
 <div class="sidebar_1">
 <form name="loginform" id="loginform" action="/sign-in/index.php" method="post"><center>
  <table>
   <tbody>
    <tr>
     <h1>Email</h1>
	</tr>
	<tr>
     <input type='text' name='email' class="input" value='<? echo $_POST["email"]; ?>'>
	</tr>
	<tr>
     <h1>Password</h1>
	</tr>
	<tr>
     <input type='password' name='password' class="input">
	</tr>
	<tr>
     <input name="submit" type="submit" class="button margintop" value="Sign in">
	 <br>
	</tr>
	<tr>
     <input type="button" name="register" class="button margintop" value="Sign up" onclick="location.href = '/sign-up';">
	 <br>
	</tr>
	<tr>
     <a href="/forgot-pass" class="passrecovery margintop">Forgot password?</a>
	</tr>  
   </tbody>
  </table>
  </center></form>
 </div>
</div>