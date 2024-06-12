<?php session_start();?>
<body bgcolor="lightgray">
	<h1>Login</h1>
	<a href="index.php">Zum Fahrschulquiz</a>

	<form method="post" action="../index.php?id=100"
		enctype="multipart/form-data">
		<table style="border: hidden;">
			<tr>
				<td>Benutzername:</td>
				<td><input type="text" name="loginUsername"></td>
				<td style="color: red;"><?php
		
    if ($_SESSION["login_error"]==true)
        echo "Benutzername oder Passwort wurden falsch eingegeben!"?></td>
			</tr>
			<tr>
				<td>Passwort:</td>
				<td><input type="password" name="loginPassword"></td>
				<td></td>
			</tr>
			<tr>
				<td><input type="submit" value="Anmelden"></td>
				<td><input type="reset" value="Zurücksetzen"></td>
				<td></td>
			</tr>
		</table>
	</form>
</body>
