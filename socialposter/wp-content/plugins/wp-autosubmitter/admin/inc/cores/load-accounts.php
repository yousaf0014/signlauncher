<?php 
defined('ABSPATH') or die('No script kiddies please!');
$redirect_url = admin_url() . 'admin.php?page=sbw_accounts';
wp_redirect($redirect_url);
exit();