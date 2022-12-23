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

wp_enqueue_media();

$accounts = 0;
global $wpdb;
$tbl_name = $wpdb->prefix.'sbwaccounts';
$results = $wpdb->get_results("SELECT * FROM $tbl_name");
foreach($results as $row){ 
    $accounts++;
  if ($row->account_type === 'Facebook') {
    $fb_authorized = empty($row->access_token)? false : true;
  }
  else if ($row->account_type === 'Linkedin') {
    $li_authorized = empty($row->access_token)? false : true;
  }
}

$tbl_name1 = $wpdb->prefix.'sbwposts';
$last_post = $wpdb->get_row("SELECT * FROM $tbl_name1 ORDER BY id DESC LIMIT 1");
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <?php if ($accounts == 0) : ?>

        <div class="wp-clearfix">
            <div class="widget-title ui-sortable-handle">
                <h2>No Accounts Added - Setup Accounts <span class="in-widget-title"></span></h2>
            </div>
            <div id="content" class="widget">
                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                    <input type="hidden" name="action" value="sbw_setup_account" />
                    <input class="button button-primary" type="submit" name="sbw_setup_account" value="Setup Accounts"/>
                </form>
            </div>
        </div>


    <?php else : ?>

    
    <?php 

        echo '<div class="article-content" style="line-height: 3em;">';

        echo '<div class="updated">Make sure you post with atleast 4 hours difference to avoid your accounts getting banned.</div>';

        if(!$fb_authorized) {
            echo '<div class="update-message notice inline notice-warning notice-alt">Can not post on Facebook, you must authorize first.</div>';
        }
        if(!$li_authorized) {
            echo '<div class="update-message notice inline notice-warning notice-alt">Can not post on Linkedin, you must authorize first.</div>';
        }

        if (isset($_SESSION['sbw_post_response'])) {
            foreach ($_SESSION['sbw_post_response'] as $key => $value) {
                echo '<div class="updated">'.$key.': '.$value.'</div>';
            }
            unset($_SESSION['sbw_post_response']);
        }
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
            echo '<div class="error notice is-dismissible"> <ul class="errors">';
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

    <div class="wp-clearfix">
        <div class="widget-title ui-sortable-handle">
            <h2>Auto Post to Social Accounts <span class="in-widget-title"></span></h2>
        </div>
        <div id="content" class="widget">
            <form id="fbSettings" name="fbSettings" action="<?php echo admin_url('admin-post.php'); ?>" method="post">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="post_title">Post Title <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="post_title" type="text" id="post_title" aria-describedby="post_title-description" value="" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="post_link">Post Link <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="post_link" type="text" id="post_link" aria-describedby="post_link-description" value="" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="post_description">Desription <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="post_description" type="text" id="post_description" aria-describedby="post-description" value="" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="image_attachment_url">Image URL <strong>*</strong></label>
                            </th>
                            <td>
                                <input name="image_attachment_url" type="text" id="image_attachment_url" aria-describedby="post_image-description" value="" class="regular-text ltr">
                                <label for="upload_image_button"><strong> - OR -</strong></label>
                                <input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <input type="hidden" name="action" value="sbw_post_action" />
                    <input class="button button-primary" type="submit" name="submit" value="Post"/>
                </p>
            </form>
        </div>
    </div>

<?php endif; ?>

</div>
