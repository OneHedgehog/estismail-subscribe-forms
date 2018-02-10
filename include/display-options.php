<?php
defined('ABSPATH') or exit;


function estis_sf_admin_menu_view()
{

    $api_key = get_option('estis_sf_api_key');

    if (isset($_POST['estis_sf_api_key']) && !empty($_POST['estis_sf_api_key'])) {
        $api_key = $_POST['estis_sf_api_key'];
        update_option('estis_sf_api_key', $api_key);
    }

    if (preg_match("/^[a-z\d]{40}$/i", $api_key)) {
        $estis_sf_opt_array['status'] = 1;

        $user_params = array('fields' => json_encode(array('login', 'email', 'name')));
        $user_url = 'https://v1.estismail.com/mailer/users?' . http_build_query($user_params);
        $user_data = estis_sf_wp_remote_get($user_url, $api_key);

        if ($user_data) {
            $estis_sf_opt_array['status'] = 2;
            $estis_sf_opt_array['user'] = $user_data['user'];
        }

        $forms_params = array('fields' => json_encode(array('id', 'title', 'list_id', 'body')));
        $forms_url = 'https://v1.estismail.com/mailer/forms?' . http_build_query($forms_params);
        $forms_data = estis_sf_wp_remote_get($forms_url, $api_key);

        if ($forms_data) {
            foreach ($forms_data['forms'] as $key => $form) {
                $forms_data['forms'][$form['id']] = $form;
                unset($forms_data['forms'][$key]);
            }
            $estis_sf_opt_array['forms'] = $forms_data['forms'];
        }

        update_option('estis_sf_user_and_forms_array', $estis_sf_opt_array);

    } elseif (!$api_key) {
        $estis_sf_opt_array['status'] = 0;
    } else {
        $estis_sf_opt_array['status'] = 1;
    }

    switch ($estis_sf_opt_array['status']) {
        case 0: {
            $message = __('Not connected', 'estis_sf_translate');
            $class = 'alert-warning';
        }
            break;
        case 1: {
            $message = __('Invalid API key', 'estis_sf_translate');
            $class = 'alert-danger';
        }
            break;
        case 2: {
            $message = __('Connected', 'estis_sf_translate');
            $class = 'alert-info';
        }
            break;
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-xs-12 col-sm-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-dark bold uppercase"><?php _e('API connection', 'estis_sf_translate'); ?></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form method="post" action="admin-post.php"
                              class="estis_sf_form estisPostApiKeyForm">
                            <div class="alert <?php echo($class) ?>"><?php echo($message) ?></div>
                            <div class="form-group">
                                <h3><?php _e('Please, enter your API key', 'estis_sf_translate'); ?></h3>
                                <input type="hidden" name="action" value="<?php echo(ESTIS_SF_PREFIX . '_api_key') ?>"/>
                                <input type="text" name="estis_sf_api_key"
                                       class="form-control estisApiKeyinput"
                                       value="<?php echo($api_key) ?>"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="<?php _e('Connect', 'estis_sf_translate'); ?>"
                                       class="btn btn-success api_key_button"/>
                                <a href="https://my.estismail.com/settings/profile#tab_1_5" target="_blank"
                                   class="btn btn-info get_api_key_href"><?php _e('Get your API key', 'estis_sf_translate'); ?></a>
                                <!-- todo: change url-->
                                <a href="https://estismail.com/"
                                   class="estis_sf_wp_readme"><?php _e('ReadMe', 'estis_sf_translate'); ?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php if ($estis_sf_opt_array['status'] == 2): ?>
                <div class="col-lg-6 col-md-12 lists">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold uppercase"><?php _e('Estismail subscribe forms', 'estis_sf_translate'); ?></span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php if (!empty($forms_data['forms'])): ?>
                                <div class="form-group form">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered estis_sf_table col-lg-12">
                                            <thead>
                                            <tr>
                                                <th class="Head"> <?php _e('Form title', 'estis_sf_translate'); ?> </th>
                                                <th class="Head"> <?php _e('Shortcode', 'estis_sf_translate'); ?> </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($forms_data['forms'] as $val_arr): ?>
                                                <tr>
                                                    <td><?php echo $val_arr['title']; ?></td>
                                                    <td>
                                                        <input class="estisSelectShortCode" type="text"
                                                               value="<?php echo('[estis id = ' . $val_arr['id'] . ']'); ?>">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-danger">
                                    <?php _e('No forms found', 'estis_sf_translate'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}