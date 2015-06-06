<div style="padding: 10px 10px;">
<?php
if(!isset($_SESSION["user"])) {
?>
<div class="tabWindow" style="background: #fff;">
<div>
	<div onclick="openTab(this);" class="tabHeader"><a>Login</a></div>
	<div>
		<form action="functions/login.php" method="POST">
			<input type="hidden" name="page" value="<?php echo(PAGE); ?>">
			<p style="text-indent: 0px;"><input type="text" name="username" size=12 placeholder="<?php echo(lang::getText("username")); ?>"></p>
			<p style="text-indent: 0px;"><input type="password" name="password" size=12 placeholder="<?php echo(lang::getText("password")); ?>"></p>
			<input type="submit" value="<?php echo(lang::getText("login")); ?>" style="width: 100%;">
		</form>
		<div style="text-align: right;">
			<a href="userregister"><?php echo(lang::getText("register")); ?></a>
		</div>
	</div>
</div></div>
<?php
} else {
?>

<div class="tabWindow" style="background: #fff;">
<div>
	<div onclick="openTab(this);" class="tabHeader"><a><?php echo($_SESSION["user"]["base"]["username"]); ?></a></div>
	<div>
	<a href="userpage"><?php echo(lang::getText("mypage")); ?></a><br>
	<?php echo("<a href=\"functions/logout.php?redir=".PAGE."\">".lang::getText("logout")."</a>"); ?>
	</div>
</div></div>
<?php
}
?>
</div>