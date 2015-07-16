<h2><?php echo(lang::getText("newmail")); ?></h2>
<form action="admin_mail_createnew" method="POST">
<table>
<tr>
	<th><p><?php echo(lang::getText("mailfrom")); ?></p></th>
	<td><select name="from"><?php
		$sendable = true;
		$froms = sql::get("SELECT * FROM ".dbPrefix."mail_accounts");
		if($froms === false) {
			$sendable = false;
			echo("<option value='false'>".lang::getText("none")."</option>");
		} else {
			if(isset($froms["name"])) {
				$froms = [$froms];
			}
			foreach($froms as $v) {
				echo("<option value='".$v["address"]."'>".$v["name"]."</option>");
			}
		}
	?></select></td>
</tr><tr>
	<th><p><?php echo(lang::getText("mailto")); ?></p></th>
	<td><select name="to"><?php
		$sendable = true;
		$list = sql::get("SELECT * FROM ".dbPrefix."mail_lists");
		if($list === false) {
			$sendable = false;
			echo("<option value='false'>".lang::getText("none")."</option>");
		} else {
			if(isset($list["name"])) {
				$list = [$list];
			}
			foreach($list as $v) {
				echo("<option value='".$v["name"]."'>".$v["name"]."</option>");
			}
		}
	?></select></td>
</tr><tr>
	<th><p><?php echo(lang::getText("mailsendtype")); ?></p></th>
	<td>
		<select name="type" onchange="{
			if(this.value === 'ONCE') {
				obj('typeonce').style.display = 'block';
				obj('typerepeat').style.display = 'none';
			} else {
				obj('typeonce').style.display = 'none';
				obj('typerepeat').style.display = 'block';
			}
		}">
			<option value="ONCE"><?php echo(lang::getText("mailsendtypeonce")); ?></option>
			<option value="REPEAT"><?php echo(lang::getText("mailsendtyperepeat")); ?></option>
		</select>
	</td>
</tr><tr>
	<th>&nbsp;</th>
	<td>
		<style>
		#typeonce > .calendar {
			position: absolute;
			background: #fff;
			min-height: 0px;
			max-height: 0px;
			opacity: 0;
			overflow: hidden;
			display: none;
			transition: opacity 500ms, max-height 500ms;
		}
		#typerepeat > .calendar {
			position: absolute;
			background: #fff;
			min-height: 0px;
			max-height: 0px;
			opacity: 0;
			overflow: hidden;
			display: none;
			transition: opacity 500ms, max-height 500ms;
		}
		</style>
		<div id="typeonce">
			<p id="dateElement" onclick="{
				if((this.parentNode.children[1].style.overflow == 'hidden') || (this.parentNode.children[1].style.overflow == '')) {
					this.parentNode.children[1].style.display = 'block';
					setTimeout((function(o) {
						return function() {
							o.parentNode.children[1].style.overflow = 'visible';
							o.parentNode.children[1].style.maxHeight = '300px';
							o.parentNode.children[1].style.opacity = 1;
						}
					}(this)), 1);
				} else {
					this.parentNode.children[1].style.overflow = 'hidden';
					this.parentNode.children[1].style.maxHeight = '0px';
					this.parentNode.children[1].style.opacity = 0;
					setTimeout((function(o) {
						return function() {
							o.parentNode.children[1].style.display = 'none';
						}
					}(this)), 205);
				}
			}" style="display: block; text-align: left;"><?php echo(lang::getText("pickdate")); ?></p>
			<?php
				echo(dates::calendar("updDate", true, true));
			?>
			<script>
			function updDate(date) {
				var d = new Date(parseInt(date.substr(0, 4)), parseInt(date.substr(5, 2))-1, parseInt(date.substr(8, 2)));
				if(date.substr(-5) !== "ERROR") {
					var now = new Date();
					if(d.getTime() < now.getTime()) {
						obj("dateElement").innerHTML = '<?php echo(lang::getText("send")." ".strtolower(lang::getText("immediatly"))); ?> ('+date+')';
					} else {
						obj("dateElement").innerHTML = date;
					}
					obj("typeonce").children[3].value = date;
				} else {
					obj("typeonce").children[3].value = "false";
					obj("dateElement").innerHTML = "<?php echo(lang::getText("error")); ?>";
				}
			}
			</script>
			<input type="hidden" name="oncestartdate" value="false">
			
		</div><div id="typerepeat" style="display: none;">
			<p id="dateElement2" onclick="{
				var childnr = 1;
				if((this.parentNode.children[childnr].style.overflow == 'hidden') || (this.parentNode.children[childnr].style.overflow == '')) {
					this.parentNode.children[childnr].style.display = 'block';
					setTimeout((function(o) {
						return function() {
							o.parentNode.children[childnr].style.overflow = 'visible';
							o.parentNode.children[childnr].style.maxHeight = '300px';
							o.parentNode.children[childnr].style.opacity = 1;
						}
					}(this)), 1);
					if((this.parentNode.children[3].style.overflow !== 'hidden') && (this.parentNode.children[3].style.overflow !== '')) {
						this.parentNode.children[3].style.overflow = 'hidden';
						this.parentNode.children[3].style.maxHeight = '0px';
						this.parentNode.children[3].style.opacity = 0;
					}
				} else {
					this.parentNode.children[childnr].style.overflow = 'hidden';
					this.parentNode.children[childnr].style.maxHeight = '0px';
					this.parentNode.children[childnr].style.opacity = 0;
					setTimeout((function(o) {
						return function() {
							o.parentNode.children[childnr].style.display = 'none';
						}
					}(this)), 205);
				}
			}" style="display: block; text-align: left;"><?php echo(lang::getText("pickstartdate")); ?></p>
			<?php
				echo(dates::calendar("updDate2", true, true));
			?>
			<p id="dateElement3" onclick="{
				var childnr = 3;
				if((this.parentNode.children[childnr].style.overflow == 'hidden') || (this.parentNode.children[childnr].style.overflow == '')) {
					this.parentNode.children[childnr].style.display = 'block';
					setTimeout((function(o) {
						return function() {
							o.parentNode.children[childnr].style.overflow = 'visible';
							o.parentNode.children[childnr].style.maxHeight = '300px';
							o.parentNode.children[childnr].style.opacity = 1;
						}
					}(this)), 1);
					if((this.parentNode.children[1].style.overflow !== 'hidden') && (this.parentNode.children[1].style.overflow !== '')) {
						this.parentNode.children[1].style.overflow = 'hidden';
						this.parentNode.children[1].style.maxHeight = '0px';
						this.parentNode.children[1].style.opacity = 0;
					}
				} else {
					this.parentNode.children[childnr].style.overflow = 'hidden';
					this.parentNode.children[childnr].style.maxHeight = '0px';
					this.parentNode.children[childnr].style.opacity = 0;
					setTimeout((function(o) {
						return function() {
							o.parentNode.children[childnr].style.display = 'none';
						}
					}(this)), 205);
				}
			}" style="display: block; text-align: left;"><?php echo(lang::getText("pickenddate")); ?></p>
			<?php
				echo(dates::calendar("updDate3", true, true));
			?>
			<script>
			function updDate2(date) {
				if(date.substr(-5) !== "ERROR") {
					var d = new Date(parseInt(date.substr(0, 4)), parseInt(date.substr(5, 2))-1, parseInt(date.substr(8, 2)));
					var now = new Date();
					if(d.getTime() < now.getTime()) {
						obj("dateElement2").innerHTML = '<?php echo(lang::getText("send")." ".strtolower(lang::getText("immediatly"))); ?> ('+date+')';
					} else {
						obj("dateElement2").innerHTML = '<?php echo(lang::getText("startdate")); ?>: '+date;
					}
					
					obj("typerepeat").children[5].value = date;
					var weekdays = [];
					weekdays[0] = "<?php echo(lang::getText("monday")); ?>";
					weekdays[1] = "<?php echo(lang::getText("tuesday")); ?>";
					weekdays[2] = "<?php echo(lang::getText("wednesday")); ?>";
					weekdays[3] = "<?php echo(lang::getText("thursday")); ?>";
					weekdays[4] = "<?php echo(lang::getText("friday")); ?>";
					weekdays[5] = "<?php echo(lang::getText("saturday")); ?>";
					weekdays[6] = "<?php echo(lang::getText("sunday")); ?>";
					obj("repeatRule").innerHTML = "";
					var everyweek = document.createElement("OPTION");
					everyweek.value = "+1 week";
					everyweek.innerHTML = "<?php echo(lang::getText("every")); ?> "+weekdays[dates_dayToWeekday(d.getDay())];
					
					var everymonth = document.createElement("OPTION");
					everymonth.value = "+1 month";
					everymonth.innerHTML = d.getDate()+" <?php echo(strtolower(lang::getText("every"))." ".strtolower(lang::getText("month"))); ?>";
					
					var everyday = document.createElement("OPTION");
					everyday.value = "+1 day";
					everyday.innerHTML = "<?php echo(lang::getText("every")." ".strtolower(lang::getText("day"))); ?>";
					
					var months = [];
					<?php
					$m = ["january", "february", "march", "april", "may", "june", "july", "august", "september", "oktober", "november", "december"];
					foreach($m as $k => $v) {
						echo("months[".$k."] = \"".lang::getText($v)."\";");
					}
					?>
					var everyyear = document.createElement("OPTION");
					everyyear.value = "+1 year";
					everyyear.innerHTML = d.getDate()+" "+months[d.getMonth()]+" <?php echo(strtolower(lang::getText("every"))." ".strtolower(lang::getText("year"))); ?>";
					
					obj("repeatRule").appendChild(everyday);
					obj("repeatRule").appendChild(everyweek);
					obj("repeatRule").appendChild(everymonth);
					obj("repeatRule").appendChild(everyyear);
				} else {
					obj("typerepeat").children[5].value = "false";
					obj("dateElement2").innerHTML = "<?php echo(lang::getText("error")); ?>";
				}
			}
			function updDate3(date) {
				if(date.substr(-5) !== "ERROR") {
					obj("dateElement3").innerHTML = '<?php echo(lang::getText("enddate")); ?>: '+date;
					obj("typerepeat").children[6].value = date;
				} else {
					obj("dateElement3").innerHTML = "<?php echo(lang::getText("error")); ?>";
					obj("typerepeat").children[6].value = "FALSE";
				}
			}
			</script>
			<input type="hidden" name="repeatstartdate" value="false">
			<input type="hidden" name="repeatenddate" value="false">
			<select name="rule" id="repeatRule">
				<option><?php echo(lang::getText("none")); ?></option>
			</select>
			<?php
			//button($img, $link, $class = "", $attr = "", $attr2 = "")
			echo(elements::button("help_20.png", ["js", "{
					if((obj('repeathint').style.display === 'none') || (obj('repeathint').style.display === '')) {
						obj('repeathint').style.display = 'inline';
						setTimeout(function() {
							obj('repeathint').style.opacity = 1;
						}, 1);
					} else {
						obj('repeathint').style.opacity = 0;
						setTimeout(function() {
							obj('repeathint').style.display = 'none';
						}, 200);
					}
				}"], "", "onmouseover=\"popup('".lang::getText("hint")."')\""));
			?><div id="repeathint" style="position: absolute; width: 30%; background: #fff; border: 1px solid #bbb; border-radius: 10px; padding: 10px; transition: opacity 200ms; display: none;"><h3><?php echo(lang::getText("hint")); ?></h3><p><?php echo(lang::getText("admin_main_new_repeat_hint")); ?></p></div>
		</div>
	</td>
</tr><tr>
	<th><p><?php echo(lang::getText("mailsubject")); ?></p></th>
	<td>
		<input type="text" name="subject" placeholder="<?php echo(lang::getText("mailsubject")) ?>">
	</td>
</tr><tr>
	<th><p><?php echo(lang::getText("mailpage")); ?></p></th>
	<td>
		<select name="page" onchange="{
			if(this.value === 'text') {
				obj('txtarea').style.display = 'block';
			} else {
				obj('txtarea').style.display = 'none';
			}
		}">
		<option value="text" selected><?php echo(lang::getText("mailnewtxttype")); ?></option>
		<?php
		$sendable = true;
		$list = sql::get("SELECT * FROM ".dbPrefix."pages WHERE type = 'mail'");
		if($list === false) {
			$sendable = false;
			echo("<option value='false'>".lang::getText("none")."</option>");
		} else {
			if(isset($list["name"])) {
				$list = [$list];
			}
			foreach($list as $v) {
				echo("<option value='".$v["name"]."'>".$v["name"]."</option>");
			}
		}
	?></select>
	<a href="admin_mail_new_newpage"><?php echo(lang::getText("mailnewmsg")); ?></a>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
		<textarea name="mail" id="txtarea" cols=40 rows=6 placeholder="<?php echo(lang::getText("mailmessage")); ?>"></textarea>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" value="<?php echo(lang::getText("mailcreate")); ?>"></td>
</tr>
</table>
</form>