<?php
  session_start();
  if(isset($_SESSION['UserID']))
    unset($_SESSION['UserID']); 
  if(isset($_SESSION['UserPaswd']))
    unset($_SESSION['UserPaswd']); 	
?> 

<p align="center"><big><strong>Science Olympiad</strong></p></big>
<p align="center"><big><strong>Solon Div B File Download</strong></p></big>

<h3 align="center"><b>Enter the user ID and password.</b></h3>
<br>

<form ACTION="filelist.php" name="saveform" METHOD="POST" align="center">
  <div align="center"><center><table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right"><table border="0" height="59" width="226"
      bgcolor="#FFFFFF" cellspacing="1" cellpadding="0">
        <tr>
          <td width="154" height="19" bgcolor="#000080" align="right"><p><font color="#FFFFFF"><small>User ID:</small></font></td>
          <td width="133" height="19" bgcolor="#000080" align="left"><p><input NAME="username"
          VALUE SIZE="8" MAXLENGTH="12" tabindex="1"></td>
          <td width="64" height="19" bgcolor="#C0C0C0" align="center"><div align="center"><center><p><a
          href="javascript:alert('The User ID.')"><small><small>Help</small></small></a></td>
        </tr>
        <tr align="center">
          <td width="154" height="17" bgcolor="#000080" align="right"><p><font color="#FFFFFF"><small>Password:</small></font></td>
          <td height="17" width="133" bgcolor="#000080" align="left"><p><input type="password"
          name="password" size="12" tabindex="2" maxlength="15"></td>
          <td height="17" bgcolor="#C0C0C0" align="center"><a
          href="javascript:alert('The password for this user ID (case sensitive).')"><small><small>Help</small></small></a></td>
        </tr>
        <tr align="center">
          <td width="154" height="1" bgcolor="#000080"></td>
          <td width="133" height="1" bgcolor="#000080" align="left"><p><input TYPE="submit"
          VALUE="Login" tabindex="3"
          style="font-family: Verdana; font-size: 8pt"></td>
          <td width="64" height="1" bgcolor="#C0C0C0" align="center"><a
          href="javascript:alert('Click to login')"><small><small>Help</small></small></a></td>
        </tr>
      </table>
      </div></td>
    </tr>
  </table>
  </center></div>
</form>

<p align="center">&nbsp;</p>
