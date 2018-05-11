<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'UpStream_Options_Extensions' ) ) :

/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class UpStream_Options_Extensions {

    /**
     * Array of metaboxes/fields
     * @var array
     */
    public $id = 'upstream_extensions';

    /**
     * Page title
     * @var string
     */
    protected $title = '';

    /**
     * Menu Title
     * @var string
     */
    protected $menu_title = '';

    /**
     * Menu Title
     * @var string
     */
    protected $description = '';

    /**
     * Holds an instance of the object
     *
     * @var Myprefix_Admin
     **/
    public static $instance = null;

    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct() {
        // Set our title
        $this->title = __( 'Extensions', 'upstream' );
        $this->menu_title = $this->title;
        $this->description = __( 'These extensions add extra functionality to the UpStream Project Management plugin.', 'upstream' );

        add_action('cmb2_render_upstream_extensions_wrapper', array('UpStream_Options_Extensions', 'renderExtensionsWrapper'), 10, 5 );
        add_action('wp_ajax_upstream:extensions:license.validate', array('UpStream_Options_Extensions', 'validateLicenseKey'));
        add_action('wp_ajax_upstream:extensions:license.deactivate', array('UpStream_Options_Extensions', 'deactivateLicenseKey'));
    }

    /**
     * Retrieve an array containing all available UpStream extensions.
     *
     * @since   1.11.0
     * @access  private
     * @static
     *
     * @param   bool    $installedOnly  If true, only installed extensions (regardless of their activated status).
     * @param   bool    $missingOnly    If true, it will ignore $installedOnly param and will return only non installed extensions.
     *
     * @return  array
     */
    private static function getExtensionsPool($installedOnly = false, $missingOnly = false)
    {
        if (!function_exists('is_plugin_active')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $pool = array(
            array(
                'id'               => 'customizer',
                'title'            => 'Customizer',
                'description'      => __('Adds controls to easily customize the appearance of your projects.', 'upstream'),
                'product_id'       => 4051,
                'options_key_slug' => 'upstream_customizer'
            ),
            array(
                'id'               => 'email-notifications',
                'title'            => 'Email Notifications',
                'description'      => __('Allow you to email project updates to people working on your projects.', 'upstream'),
                'product_id'       => 4996,
                'options_key_slug' => 'email-notifications'
            ),
            array(
                'id'               => 'frontend-edit',
                'title'            => 'Frontend Edit',
                'description'      => __('Allow users to add and edit items on the frontend.', 'upstream'),
                'product_id'       => 3925,
                'options_key_slug' => 'upstream_frontend_edit'
            ),
            array(
                'id'               => 'project-timeline',
                'title'            => 'Project Timeline',
                'description'      => __('Add a Gantt style chart to visualize your projects.', 'upstream'),
                'product_id'       => 3920,
                'options_key_slug' => 'project-timeline'
            ),
            array(
                'id'               => 'copy-project',
                'title'            => 'Copy Project',
                'description'      => __('Allow you to duplicate an UpStream project including all the content and options.', 'upstream'),
                'product_id'       => 5471,
                'options_key_slug' => 'copy-project'
            ),
            array(
                'id'               => 'calendar-view',
                'title'            => 'Calendar View',
                'description'      => __('This calendar display will allow you to easily see everything that’s happening in a project. You’ll be able to see due dates for all the milestones, tasks, and bugs.', 'upstream'),
                'product_id'       => 6798,
                'options_key_slug' => 'calendar-view'
            ),
            array(
                'id'               => 'custom-fields',
                'title'            => 'Custom Fields',
                'description'      => __('This extension will allow you to add more information to tasks and bugs. For example, in a web design project, the bugs could have fields for the browser type, PHP version, and screen size.', 'upstream'),
                'product_id'       => 8409,
                'options_key_slug' => 'custom-fields'
            )
        );

        $licenses = (array)get_option('upstream:extensions');
        $legacyLicensesMeta = (array)get_option('upstream_extensions');
        $legacyLicensesMeta = !empty($legacyLicensesMeta) ? $legacyLicensesMeta : array();
        $rowset = array();

        $assetsCoversURLPrefix = get_site_url() . '/wp-content/plugins/upstream/includes/admin/assets/img/banner-';

        foreach ($pool as $extension) {
            $extensionFullname = 'upstream-' . $extension['id'];
            $extensionSlug = str_replace('-', '_', $extensionFullname);
            $extensionDispatcher = $extensionFullname . '/' . $extensionFullname . '.php';

            $extension['isActive'] = (bool) is_plugin_active($extensionDispatcher);
            $extension['isInstalled'] = file_exists(ABSPATH . 'wp-content/plugins/' . $extensionDispatcher);
            $extension['license'] = array(
                'status' => 'inactive',
                'key'    => ""
            );
            $extension['url'] = 'https://upstreamplugin.com/extensions/' . $extension['id'] . '?utm_source=extensions&utm_campaign=plugin&utm_medium=settings_extensions&utm_content='. $extension['id'];
            $extension['cover'] = $assetsCoversURLPrefix . $extension['id'] . '.jpg';

            $license = isset($licenses[$extension['id']]) ? $licenses[$extension['id']] : null;
            if (!empty($license)) {
                $licenseKey = $licenses[$extension['id']]['key'];
                $extension['license']['status'] = $licenses[$extension['id']]['status'];
            } else {
                $licenseKey = isset($legacyLicensesMeta[$extension['options_key_slug']]) ? $legacyLicensesMeta[$extension['options_key_slug']] : "";
                if (!empty($licenseKey)) {
                    $extensions[$extension['id']] = array(
                        'status' => $extension['license']['status'],
                        'key'    => $licenseKey
                    );
                }

                $licenseStatus = get_option(str_replace('-', '_', $extension['options_key_slug']) . '_license_active');
                if (!empty($licenseStatus)) {
                    $extension['license']['status'] = $licenseStatus;

                    delete_option(str_replace('-', '_', $extension['options_key_slug']) . '_license_active');
                }
            }

            unset($legacyLicensesMeta[$extension['options_key_slug']], $legacyLicensesMeta[$extensionSlug], $legacyLicensesMeta[$extension['id']]);

            $extension['license']['key'] = $licenseKey;

            if (!$missingOnly) {
                if ($installedOnly) {
                    if ($extension['isInstalled']) {
                        array_push($rowset, $extension);
                    }
                } else {
                    array_push($rowset, $extension);
                }
            } else {
                if (!$extension['isInstalled']) {
                    array_push($rowset, $extension);
                }
            }
        }

        if (!empty($licenses)) {
            update_option('upstream:extensions', $licenses);
            update_option('upstream_extensions', $legacyLicensesMeta);
        }

        return json_decode(json_encode($rowset));
    }

    /**
     * Renders all Extensions Page's HTML.
     *
     * @since   1.11.0
     * @static
     *
     * @param   \CMB2_Field     $field          The current CMB2_Field object.
     * @param   string          $value          The field value passed through the escaping filter.
     * @param   mixed           $object_id      The object id.
     * @param   string          $objectType     The type of object being handled.
     * @param   \CMB2_Types     $fieldType      Instance of the correspondent CMB2_Types object.
     */
    public static function renderExtensionsWrapper($field, $value, $object_id, $objectType, $fieldType)
    {
        wp_enqueue_script('upstream-extensions', UPSTREAM_PLUGIN_URL . 'includes/admin/assets/js/extensions.js', array('jquery'), UPSTREAM_VERSION, true);
        wp_localize_script('upstream-extensions', 'upstreamExtensionsLang', array(
            'LB_ACTIVATE'          => __('Activate', 'upstream'),
            'LB_CHANGE'            => __('Change', 'upstream'),
            'LB_DEACTIVATE'        => __('Deactivate', 'upstream'),
            'LB_DEACTIVATING'      => __('Deactivating...', 'upstream'),
            'MSG_ENTER_LICENSE'    => __('Enter your License Key', 'upstream'),
            'MSG_INACTIVE_LICENSE' => __('Your license is not activated yet.', 'upstream')
        ));

        $rowsetInstalled = self::getExtensionsPool(true);
        $rowsetInstalledCount = count($rowsetInstalled);
        $rowsetMissing = self::getExtensionsPool(false, true);
        ?>

        <section id="extensions-wrapper">
            <h2 class="nav-tab-wrapper">
                <a href="#" class="nav-tab<?php echo $rowsetInstalledCount > 0 ? ' nav-tab-active' : ''; ?>"><?php _e('Installed Extensions', 'upstream'); ?></a>
                <a href="#" class="nav-tab<?php echo $rowsetInstalledCount === 0 ? ' nav-tab-active' : ''; ?>"><?php _e('Browse More Extensions', 'upstream'); ?></a>
            </h2>
            <div id="installed-extensions-list" style="display: <?php echo $rowsetInstalledCount > 0 ? 'flex' : 'none'; ?>;">
                <?php if ($rowsetInstalledCount === 0): ?>
                    <p><?php _e("No installed extensions yet.", 'upstream'); ?></p>
                <?php else: ?>
                <?php foreach ($rowsetInstalled as $row): ?>
                <article class="license-<?php echo $row->license->status; ?>" data-id="<?php echo $row->id; ?>">
                    <div>
                        <a href="<?php echo $row->url; ?>" target="_blank" rel="noopener noreferer">
                            <img src="<?php echo $row->cover; ?>" alt="<?php echo $row->title; ?>" />
                        </a>
                    </div>
                    <div>
                        <header>
                            <h3 class="u-title"><?php echo $row->title;?></h3>
                            <p class="u-description"><?php echo $row->description; ?></p>
                        </header>
                        <div class="u-license">
                            <?php if ($row->license->status !== 'valid'): ?>
                            <input type="text" size="40" placeholder="<?php echo __('Enter your License Key', 'upstream'); ?>" maxlength="32" autocomplete="false" value="<?php echo $row->license->key; ?>" />
                            <button type="button" class="button button-primary" data-action="upstream:extension:activate"><?php echo __('Activate', 'upstream'); ?></button>
                            <?php else: ?>
                            <strong><?php _e('License Key', 'upstream'); ?>:</strong>&nbsp;<code><?php echo $row->license->key; ?></code> - <a href="#" data-action="upstream:extension:change"><?php _e('Change', 'upstream'); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="u-license-status">
                            <?php if ($row->license->status === 'valid'): ?>
                            <?php _e('Active license key.', 'upstream'); ?> - <a href="#" data-action="upstream:extension:deactivate"><?php _e('Deactivate', 'upstream'); ?></a>
                            <?php elseif ($row->license->status === 'invalid'): ?>
                            <?php _e('Invalid license key.', 'upstream'); ?>
                            <?php elseif ($row->license->status === 'inactive'): ?>
                            <?php _e('Your license is not activated yet.', 'upstream'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                <input type="hidden" id="upstream-extensions-nonce" value="<?php echo wp_create_nonce('upstream:extensions'); ?>" />
                <?php endif; ?>
            </div>
            <div id="non-installed-extensions-list" style="display: <?php echo $rowsetInstalledCount === 0 ? 'flex' : 'none'; ?>;">
                <?php if (count($rowsetMissing) === 0): ?>
                <p>
                    <?php _e('Looks like you have acquired all of our currently available extensions.', 'upstream'); ?> <br />
                    <?php _e('<strong>Thank you</strong> for your support, and stay tunned for more.', 'upstream'); ?>
                </p>
                <?php else: ?>
                    <?php foreach ($rowsetMissing as $row): ?>
                    <article class="u-card">
                        <header>
                            <h3><?php echo $row->title; ?></h3>
                            <img src="<?php echo $row->cover; ?>" alt="<?php echo $row->title; ?>" />
                        </header>
                        <p><?php echo $row->description; ?></p>
                        <a href="<?php echo $row->url; ?>" target="_blank" rel="noopener noreferer" class="button button-primary"><?php _e('Get This Extension', 'upstream'); ?></a>
                    </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }

    /**
     * AJAX endpoint that validates a given license key for an extension.
     *
     * @since   1.11.0
     * @static
     */
    public static function validateLicenseKey()
    {
        header('Content-Type: application/json');

        $response = array(
            'success'        => false,
            'message'        => "",
            'license_status' => "",
            'err'            => null
        );

        try {
            if (!current_user_can('activate_plugins')) {
                throw new \Exception(__("You're not allowed to do this.", 'upstream'));
            }

            if (empty($_POST) || !isset($_POST['key']) || !isset($_POST['extension']) || !isset($_POST['nonce'])) {
                throw new \Exception(__('Invalid request.', 'upstream'));
            }

            if (!check_ajax_referer('upstream:extensions', 'nonce', false)) {
                throw new \Exception(__("You're not allowed to do this.", 'upstream'));
            }

            $extension_id = sanitize_text_field(trim($_POST['extension']));
            if (empty($extension_id)) {
                throw new \Exception(__('Invalid extension.', 'upstream'));
            }

            $licenseKey = sanitize_text_field(trim($_POST['key']));
            if (empty($licenseKey)) {
                throw new \Exception(__('Invalid license key.', 'upstream'));
            }

            $extensionsList = self::getExtensionsPool(true);
            if (empty($extensionsList)) {
                throw new \Exception(__("Invalid extension.", 'upstream'));
            }

            foreach ($extensionsList as $extension) {
                if ($extension->id === $extension_id) {
                    $apiData = array(
                        'edd_action' => 'activate_license',
                        'license'    => $licenseKey,
                        'item_id'    => $extension->product_id
                    );

                    $apiResponse = wp_remote_get(
                        esc_url_raw(add_query_arg($apiData, 'https://upstreamplugin.com')),
                        array(
                            'timeout'   => 15,
                            'body'      => $apiData,
                            'sslverify' => false
                        )
                    );

                    if (is_wp_error($apiResponse)) {
                        throw new \Exception($apiResponse->get_error_message());
                    }

                    $apiResponseData = json_decode(wp_remote_retrieve_body($apiResponse));

                    $response['license_key'] = $licenseKey;

                    $extensions = get_option('upstream:extensions');
                    $extensions[$extension_id] = array(
                        'key'    => $licenseKey,
                        'status' => $apiResponseData->license
                    );
                    update_option('upstream:extensions', $extensions);

                    $response['license_status'] = $apiResponseData->license;
                    if ($apiResponseData->license === 'invalid') {
                        if ($apiResponseData->error === 'expired') {
                            $response['message'] = __('This key is expired and could not be activated.', 'upstream');
                        } else {
                            $response['message'] = __('Invalid license key.', 'upstream');
                        }
                    } else if ($apiResponseData->license === 'valid') {
                        $response['message'] = __('Active license key.', 'upstream');
                    }

                    $response['success'] = true;

                    break;
                }
            }
        } catch (\Exception $e) {
            $response['err'] = $e->getMessage();
        }

        echo wp_json_encode($response);

        wp_die();
    }

    /**
     * AJAX endpoint that deactivates a given license key for an extension.
     *
     * @since   1.11.0
     * @static
     */
    public static function deactivateLicenseKey()
    {
        header('Content-Type: application/json');

        $response = array(
            'success' => false,
            'err'     => null
        );

        try {
            if (!current_user_can('activate_plugins')) {
                throw new \Exception(__("You're not allowed to do this.", 'upstream'));
            }

            if (empty($_POST) || !isset($_POST['extension']) || !isset($_POST['nonce'])) {
                throw new \Exception(__('Invalid request.', 'upstream'));
            }

            if (!check_ajax_referer('upstream:extensions', 'nonce', false)) {
                throw new \Exception(__("You're not allowed to do this.", 'upstream'));
            }

            $extension_id = sanitize_text_field(trim($_POST['extension']));
            if (empty($extension_id)) {
                throw new \Exception(__('Invalid extension.', 'upstream'));
            }

            $extensionSlug = str_replace('-', '_', $extension_id);

            $extensionsLicenses = get_option('upstream:extensions');
            if (isset($extensionsLicenses[$extension_id])) {
                unset($extensionsLicenses[$extension_id]);

                update_option('upstream:extensions', $extensionsLicenses);
            }

            delete_option('upstream_' . $extensionSlug . '_license_active');
            delete_option($extensionSlug . '_license_active');

            $legacyMeta = get_option('upstream_extensions');
            if (empty($legacyMeta)) {
                delete_option('upstream_extensions');
            } else {
                if (isset($legacyMeta[$extensionSlug])) {
                    unset($legacyMeta[$extensionSlug]);
                }

                if (isset($legacyMeta['upstream_' . $extensionSlug])) {
                    unset($legacyMeta['upstream_' . $extensionSlug]);
                }

                if (isset($legacyMeta[$extension_id])) {
                    unset($legacyMeta[$extension_id]);
                }

                if (empty($legacyMeta)) {
                    delete_option('upstream_extensions');
                } else {
                    update_option('upstream_extensions', $legacyMeta);
                }
            }

            $response['success'] = true;
        } catch (\Exception $e) {
            $response['err'] = $e->getMessage();
        }

        echo wp_json_encode($response);

        wp_die();
    }

    /**
     * Add the options metabox to the array of metaboxes.
     *
     * @since   0.1.0
     *
     * @return  array
     */
    public function getOptions()
    {
        $options = array(
            'id'         => $this->id,
            'title'      => $this->title,
            'menu_title' => $this->menu_title,
            'desc'       => $this->description,
            'show_on'    => array(
                'key'   => 'options-page',
                'value' => array($this->id)
            ),
            'fields'     => array(
                array(
                    'id'   => 'upstream_extensions_wrapper',
                    'type' => 'upstream_extensions_wrapper'
                )
            )
        );

        return $options;
    }

    /**
     * Returns the running object
     *
     * @return Myprefix_Admin
     **/
    public static function get_instance() {
        if( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
endif;
