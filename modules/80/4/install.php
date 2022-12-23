<?php
$return = true;
if(!rex_addon::get('yform')->isAvailable()) {
	print rex_view::error(rex_i18n::msg('d2u_helper_modules_error_yform'));
	$return = $return ? false : $return;
}
else if (rex_version::compare(rex_addon::get('yform')->getVersion(), '3.0', '<')) {
	print rex_view::error(rex_i18n::msg('multinewsletter_config_install_yform3_required'));
	$return = $return ? false : $return;
}
return $return;