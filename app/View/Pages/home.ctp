
<div class="providerBox">
	<div class="sign_with"><?php echo __('Sign in using your account with'); ?></div>
	<ul class="providers">
		<li id="facebook" title='<?php echo __('Facebook Connect');?>' onclick="javascript:login_popup('fb');return false;">Facebook</li>
		<li id="twitter" title='<?php echo __('Twitter Connect');?>' onclick="javascript:login_popup('twt');return false;">Twitter</li>
	</ul>
</div>
<script language="JavaScript">
var newwindow;
function login_popup(url) {
	var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
	screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
	outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
	outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
	width    = 500,
	height   = 500,
	left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
	top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
	features = (
		'width=' + width +
		',height=' + height +
		',left=' + left +
		',top=' + top+
		',scrollbars=yes'
	);
	newwindow=window.open('login/'+url,'',features);
	if (window.focus) {
		newwindow.focus()
	}
	return false;
}
</script>