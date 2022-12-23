<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://logicso.tech
 * @since      1.0.0
 *
 * @package    Wp_Autosubmitter
 * @subpackage Wp_Autosubmitter/admin/partials
 */

$account_details = array();
global $wpdb;
$tbl_name = $wpdb->prefix.'sbwaccounts';
$results = $wpdb->get_results("SELECT * FROM $tbl_name");
foreach($results as $row){ 
  if ($row->account_type === 'Facebook') {
    $account_details['fb_app_id'] = $row->app_id;
    $account_details['fb_app_secret'] = $row->app_secret;
    $account_details['fb_authorized'] = empty($row->access_token)? false : true;
  }
  else if ($row->account_type === 'Twitter') {
    $account_details['tw_app_id'] = $row->app_id;
    $account_details['tw_app_secret'] = $row->app_secret;
    $account_details['tw_access_token'] = $row->access_token;
    $account_details['tw_access_token_secret'] = $row->access_token_secret;
  }
  else if ($row->account_type === 'Linkedin') {
    $account_details['li_app_id'] = $row->app_id;
    $account_details['li_app_secret'] = $row->app_secret;
    $account_details['li_authorized'] = empty($row->access_token)? false : true;
  }
  else if ($row->account_type === 'Instagram') {
    $account_details['ig_app_id'] = $row->app_id;
    $account_details['ig_app_secret'] = $row->app_secret;
  }
}


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <div style="padding-top: 20px;"></div>

    <?php 
        echo '<div class="article-content" style="line-height: 3em;">';

        if (isset($_SESSION['sbw_auth_message'])) {
            echo '<div class="updated">'.$_SESSION['sbw_auth_message'].'</div>';
            unset($_SESSION['sbw_auth_message']);
        }
        if (isset($_SESSION['sbw_success']) && $_SESSION['sbw_success'] == true) { 
            if (isset($_SESSION['sbw_message'])) {
                echo '<div class="updated">'.$_SESSION['sbw_message'].'</div>';
                unset($_SESSION['sbw_message']);
                unset($_SESSION['sbw_success']);
            }
        }
        else {
            if (isset($_SESSION['sbw_errors']) && sizeof($_SESSION['sbw_errors'])>0 && $_SESSION['sbw_errors']->get_error_code()) :
            echo '<div class="error notice is-dismissible"><ul class="errors">';
            foreach ($_SESSION['sbw_errors']->errors as $error) {
                echo '<li>'.$error[0].'</li>';
            }
            echo '</ul></div>';
            unset($_SESSION['sbw_errors']);
            unset($_SESSION['sbw_success']);
            endif;
        }
          
        echo '</div>';

    ?>
    
                                        
    <div id="tabs">
        <ul>
            <li><a href="#tabs-fb"><img width="35px" height="35px" src="<?php echo plugin_dir_url(__FILE__) . '../images/facebook.png'; ?>"></a></li>
            <li><a href="#tabs-tw"><img width="35px" height="35px" src="<?php echo plugin_dir_url(__FILE__) . '../images/twitter.png'; ?>"></a></li>
            <li><a href="#tabs-li"><img width="35px" height="35px" src="<?php echo plugin_dir_url(__FILE__) . '../images/linkedin.png'; ?>"></a></li>
            <li><a href="#tabs-ig"><img width="35px" height="35px" src="<?php echo plugin_dir_url(__FILE__) . '../images/instagram.png'; ?>"></a></li>
        </ul>
        <div id="tabs-fb" class="widget-inside">
            <form id="fbSettings" name="fbSettings" action="<?php echo admin_url('admin-post.php'); ?>" method="post">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th></th>
                            <td>
                                <p>Please visit <a href='https://developers.facebook.com/apps' target='_blank'><strong>here</strong></a> and create new Facebook Application to get Application ID and Application Secret.<br/><br/> Also please make sure you follow below steps after creating app.<br/><br/>Navigate to Apps > Settings > Edit settings > Website > Site URL. Set the site url as : <?php echo home_url(); ?> </p>
                                <p>
                                Please add below url in the Valid OAuth redirect URIs.                            
                                <textarea readonly="readonly" onfocus="this.select();" style="width: 100%;height:50px;margin-top:10px;"><?php echo admin_url('admin-post.php?action=sbw_callback_authorize'); ?></textarea>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/TL7rHKCGUCI?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="fb_api_key">Application Id <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="fb_api_key" type="text" id="fb_api_key" aria-describedby="fb_api_key-description" value="<?php echo isset($account_details['fb_app_id']) ? esc_attr($account_details['fb_app_id']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="fb_app_secret">Application Secret <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="fb_app_secret" type="text" id="fb_app_secret" aria-describedby="fb_app_secret-description" value="<?php echo isset($account_details['fb_app_secret']) ? esc_attr($account_details['fb_app_secret']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php if(isset($account_details['fb_authorized']) && $account_details['fb_authorized'] == false) { ?>
                        <div class="update-message notice inline notice-warning notice-alt">You must authorize first for posting on Facebook.</div>
                <?php } ?>
                
                <p class="submit" style="display:  inline-block;">
                    <input type="hidden" name="action" value="sbw_save_action" />
                    <input type="hidden" name="method" value="submit-fb-details" />
                    <input class="button button-primary" type="submit" name="submit" value="Save Changes"/>
                </p>
            </form>
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="sbw_fb_authorize_action"/>
                <input type="submit" name="sbw_fb_authorize" value="Authorize" class="button" style="display:  inline-block;position:  relative;top: -53px;left: 125px;"/>
            </form>
        </div>
        <div id="tabs-tw" class="widget-inside">
            <form id="twSettings" name="twSettings" action="<?php echo admin_url('admin-post.php'); ?>" method="post">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th></th>
                            <td>
                                <p>Please visit <a href='https://apps.twitter.com/' target='_blank'><strong>here</strong></a> and create new Twitter Application to get Consumer Key, Consumer Secret, Access Token and Access Token Secret.<br/><br/> Also please make sure you follow below steps after creating app.<br/><br/>Navigate to App (Your App Name) > Settings > Website. Set the site url as : <?php echo home_url(); ?> <br/>Navigate to App (Your App Name) > Permissions > Access > Read and Write <br/>Navigate to App (Your App Name) > Keys and Access Tokens > Application Settings > Get Consumer Key and Consumer Secret <br/>Navigate to App (Your App Name) > Keys and Access Tokens > Token Actions > "Create my access token" for Access Token and Access Token Secret </p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/nSQHm0zfNTs?rel=0&amp;start=89" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="tw_api_key"> Consumer Key <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="tw_api_key" type="text" id="tw_api_key" aria-describedby="tw_api_key-description" value="<?php echo isset($account_details['tw_app_id']) ? esc_attr($account_details['tw_app_id']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="tw_app_secret"> Consumer Secret <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="tw_app_secret" type="text" id="tw_app_secret" aria-describedby="tw_app_secret-description" value="<?php echo isset($account_details['tw_app_secret']) ? esc_attr($account_details['tw_app_secret']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="tw_access_token"> Access Token <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="tw_access_token" type="text" id="tw_app_secret" aria-describedby="tw_access_token-description" value="<?php echo isset($account_details['tw_access_token']) ? esc_attr($account_details['tw_access_token']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="tw_access_token_secret"> Access Token Secret <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="tw_access_token_secret" type="text" id="tw_access_token_secret" aria-describedby="tw_access_token_secret-description" value="<?php echo isset($account_details['tw_access_token_secret']) ? esc_attr($account_details['tw_access_token_secret']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <input type="hidden" name="action" value="sbw_save_action" />
                    <input type="hidden" name="method" value="submit-tw-details" />
                    <input class="button button-primary" type="submit" name="submit" value="Save Changes"/>
                </p>
            </form>
        </div>
        <div id="tabs-li" class="widget-inside">
            <form id="liSettings" name="liSettings" method="post" action="<?php echo admin_url('admin-post.php'); ?>">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th></th>
                            <td>
                                <p>Please visit <a href='https://www.linkedin.com/developer/apps' target='_blank'><strong>here</strong></a> and create new Linkedin Application to get Client ID and Client Secret.<br/><br/> Also please make sure you follow below steps after creating app.<br/><br/>Navigate to Application Settings > Settings > Website URL. Set the site url as : <?php echo home_url(); ?> <br/> Navigate to Application Settings > Authentication > Default Application Permissions > Check "w_share"</p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/HflngRdMxIQ?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="li_api_key">Client Id <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="li_api_key" type="text" id="li_api_key" aria-describedby="li_api_key-description" value="<?php echo isset($account_details['li_app_id']) ? esc_attr($account_details['li_app_id']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="li_app_secret">Client Secret <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="li_app_secret" type="text" id="li_app_secret" aria-describedby="li_app_secret-description" value="<?php echo isset($account_details['li_app_secret']) ? esc_attr($account_details['li_app_secret']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php if(isset($account_details['li_authorized']) && $account_details['li_authorized'] == false) { ?>
                        <div class="update-message notice inline notice-warning notice-alt">You must authorize first for posting on Linkedin.</div>
                <?php } ?>
                <p class="submit" style="display:  inline-block;">
                    <input type="hidden" name="action" value="sbw_save_action" />
                    <input type="hidden" name="method" value="submit-li-details" />
                    <input class="button button-primary" type="submit" name="submit" value="Save Changes"/>
                </p>
            </form>
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="sbw_li_authorize_action"/>
                <input type="submit" name="sbw_li_authorize" value="Authorize" class="button" style="display:  inline-block;position:  relative;top: -53px;left: 125px;"/>
            </form>
        </div>
        <div id="tabs-ig" class="widget-inside">
            <form id="igSettings" name="igSettings" method="post" action="<?php echo admin_url('admin-post.php'); ?>">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th></th>
                            <td>
                                <p><strong>Note:</strong> We take no responsibility if your account gets banned by Instagram as there is no public API available for posting to Instagram.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="ig_api_key">Username <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="ig_api_key" type="text" id="ig_api_key" aria-describedby="ig_api_key-description" value="<?php echo isset($account_details['ig_app_id']) ? esc_attr($account_details['ig_app_id']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="ig_app_secret">Password <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="ig_app_secret" type="text" id="ig_app_secret" aria-describedby="ig_app_secret-description" value="<?php echo isset($account_details['ig_app_secret']) ? esc_attr($account_details['ig_app_secret']) : ''; ?>" class="regular-text ltr">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <input type="hidden" name="action" value="sbw_save_action" />
                    <input type="hidden" name="method" value="submit-ig-details" />
                    <input class="button button-primary" type="submit" name="submit" value="Save Changes"/>
                </p>
            </form>
        </div>
    </div>


</div>

<script>
$( "#tabs" ).tabs();
</script>





