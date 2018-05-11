<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'UpStream_Options_General' ) ) :

/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class UpStream_Options_General {

    /**
     * Array of metaboxes/fields
     * @var array
     */
    public $id = 'upstream_general';

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
        $this->title = __( 'General', 'upstream' );
        $this->menu_title = $this->title;
        $this->description = '';
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



    /**
     * Add the options metabox to the array of metaboxes
     * @since  0.1.0
     */
    public function options() {

        $project_url = '<a target="_blank" href="' . home_url( 'projects' ) . '">' . home_url( 'projects' ) . '</a>';

        $options = apply_filters( $this->id . '_option_fields', array(
            'id'         => $this->id, // upstream_tasks
            'title'      => $this->title,
            'menu_title' => $this->menu_title,
            'desc'       => $this->description,
            'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->id ), ),
            'show_names' => true,
            'fields'     => array(

                array(
                    'name' => __( 'Labels', 'upstream' ),
                    'id'   => 'labels_title',
                    'type' => 'title',
                    'desc' => __( 'Here you can change the labels of various items. You could change Client to Customer or Bugs to Issues for example.<br>These labels will change on the frontend as well as in the admin area.', 'upstream' ),
                ),
                array(
                    'name' => __( 'Project Label', 'upstream' ),
                    'id'   => 'project',
                    'type' => 'labels',
                ),
                array(
                    'name' => __( 'Client Label', 'upstream' ),
                    'id'   => 'client',
                    'type' => 'labels',
                ),
                array(
                    'name' => __( 'Milestone Label', 'upstream' ),
                    'id'   => 'milestone',
                    'type' => 'labels',
                ),
                array(
                    'name' => __( 'Task Label', 'upstream' ),
                    'id'   => 'task',
                    'type' => 'labels',
                ),
                array(
                    'name' => __( 'Bug Label', 'upstream' ),
                    'id'   => 'bug',
                    'type' => 'labels',
                ),
                array(
                    'name' => __( 'File Label', 'upstream' ),
                    'id'   => 'file',
                    'type' => 'labels',
                ),

                array(
                    'name' => sprintf( __( '%s Area', 'upstream' ), upstream_client_label() ),
                    'id'   => 'client_area_title',
                    'type' => 'title',
                    'desc' => sprintf( __( 'Various options for the %1s login page and the frontend view. <br>%2s can view their projects by visiting %3s (URL is available after adding a %s).', 'upstream' ), upstream_client_label(), upstream_client_label_plural(), $project_url, upstream_project_label() ),
                    'before_row' => '<hr>'
                ),
                array(
                    'name' => __( 'Login Page Heading', 'upstream' ),
                    'id'   => 'login_heading',
                    'type' => 'text',
                    'desc' => __( 'The heading used on the client login page.', 'upstream' ),
                ),
                array(
                    'name' => __( 'Login Page Text', 'upstream' ),
                    'id'   => 'login_text',
                    'type' => 'textarea_small',
                    'desc' => __( 'Text or instructions that can be added below the login form.', 'upstream' ),

                ),
                array(
                    'name'    => __( 'Login Page Client Logo', 'upstream' ),
                    'id'      => 'login_client_logo',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether Client\'s Logo should be displayed on login page if available.', 'upstream' ),
                    'default' => '1',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name'    => __( 'Login Page Project Name', 'upstream' ),
                    'id'      => 'login_project_name',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether Project\'s name should be displayed on login page.', 'upstream' ),
                    'default' => '1',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name' => __( 'Admin Email', 'upstream' ),
                    'id'   => 'admin_email',
                    'type' => 'text',
                    'desc' => __( 'The email address that clients can use to contact you.', 'upstream' ),
                ),
                array(
                    'name'    => __( 'Admin Support Link Label', 'upstream' ),
                    'id'      => 'admin_support_label',
                    'type'    => 'text',
                    'desc'    => __( 'Label that describes the Admin Support Link.', 'upstream' ),
                    'default' => __('Contact Admin', 'upstream')
                ),
                array(
                    'name'    => __( 'Admin Support Link', 'upstream' ),
                    'id'      => 'admin_support_link',
                    'type'    => 'text',
                    'desc'    => __( 'Link to contact form or knowledgebase to help clients obtain support.', 'upstream' ),
                    'default' => 'mailto:' . upstream_admin_email()
                ),
                array(
                    'name' => __( 'Collapse Sections', 'upstream' ),
                    'id'   => 'frontend_collapse_sections',
                    'type' => 'title',
                    'desc' => __('Options to collapse different sections on the client area on frontend.', 'upstream'),
                    'before_row' => '<hr>'
                ),
                array(
                    'name'    => __( 'Collapse Project Details box', 'upstream' ),
                    'id'      => 'collapse_project_details',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether to collapse the Project Details box automatically when a user opens a project page.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name'    => __( 'Collapse Project Milestones box', 'upstream' ),
                    'id'      => 'collapse_project_milestones',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether to collapse the Milestones box automatically when a user opens a project page.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name'    => __( 'Collapse Project Tasks box', 'upstream' ),
                    'id'      => 'collapse_project_tasks',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether to collapse the Tasks box automatically when a user opens a project page.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name'    => __( 'Collapse Project Bugs box', 'upstream' ),
                    'id'      => 'collapse_project_bugs',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether to collapse the Bugs box automatically when a user opens a project page.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name'    => __( 'Collapse Project Files box', 'upstream' ),
                    'id'      => 'collapse_project_files',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether to collapse the Files box automatically when a user opens a project page.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name'    => __( 'Collapse Project Discussion box', 'upstream' ),
                    'id'      => 'collapse_project_discussion',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether to collapse the Discussion box automatically when a user opens a project page.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name' => __( 'Toggle Features', 'upstream' ),
                    'id'   => 'toggle_features',
                    'type' => 'title',
                    'desc' => __('Options to toggle different sections and features.', 'upstream'),
                    'before_row' => '<hr>'
                ),
                array(
                    'name'    => __( 'Disable Clients and Client Users', 'upstream' ),
                    'id'      => 'disable_clients',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether if Clients and Client Users can be added and used on Projects.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name'    => __( 'Disable Projects Categorization', 'upstream' ),
                    'id'      => 'disable_categories',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether Projects can be sorted into categories by managers and users.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name'    => __( 'Project Progress Icons', 'upstream' ),
                    'id'      => 'disable_project_overview',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether to display the Project Progress Icons section on frontend.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        1 => __('Do not show', 'upstream'),
                        0 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name'    => __( 'Disable Project Details', 'upstream' ),
                    'id'      => 'disable_project_details',
                    'type'    => 'radio_inline',
                    'desc'    => __( 'Choose whether to display the Project Details section on frontend.', 'upstream' ),
                    'default' => '0',
                    'options' => array(
                        0 => __('No', 'upstream'),
                        1 => __('Yes', 'upstream')
                    )
                ),
                array(
                    'name' => __( 'Disable Bugs', 'upstream' ),
                    'id'   => 'disable_bugs',
                    'type' => 'multicheck',
                    'desc' => __( 'Ticking this box will disable the Bugs section on both the frontend and the admin area.', 'upstream' ),
                    'default' => '',
                    'options' => array(
                        'yes' => __('Disable the Bugs section?', 'upstream')
                    ),
                    'select_all_button' => false
                ),
                array(
                    'name' => __( 'Disable Tasks', 'upstream' ),
                    'id'   => 'disable_tasks',
                    'type' => 'multicheck',
                    'desc' => __( 'Ticking this box will disable the Tasks section on both the frontend and the admin area.', 'upstream' ),
                    'default' => '',
                    'options' => array(
                        'yes' => __('Disable the Tasks section?', 'upstream')
                    ),
                    'select_all_button' => false
                ),
                array(
                    'name' => __( 'Disable Milestones', 'upstream' ),
                    'id'   => 'disable_milestones',
                    'type' => 'multicheck',
                    'desc' => __( 'Ticking this box will disable the Milestones section on both the frontend and the admin area.', 'upstream' ),
                    'default' => '',
                    'options' => array(
                        'yes' => __('Disable the Milestones section?', 'upstream')
                    ),
                    'select_all_button' => false
                ),
                array(
                    'name' => __( 'Disable Files', 'upstream' ),
                    'id'   => 'disable_files',
                    'type' => 'multicheck',
                    'desc' => __( 'Ticking this box will disable the Files section on both the frontend and the admin area.', 'upstream' ),
                    'default' => '',
                    'options' => array(
                        'yes' => __('Disable the Files section?', 'upstream')
                    ),
                    'select_all_button' => false
                ),
                array(
                    'name'    => __('Disable Discussion on Projects', 'upstream'),
                    'id'      => 'disable_project_comments',
                    'type'    => 'radio_inline',
                    'desc'    => __('Either allow comments on projects on both the frontend and the admin area or hide the section.', 'upstream'),
                    'default' => '1',
                    'options' => array(
                        '1' => __('Allow comments on projects', 'upstream'),
                        '0' => __('Disable section', 'upstream')
                    )
                ),
                array(
                    'name'    => __('Disable Discussion on Milestones', 'upstream'),
                    'id'      => 'disable_comments_on_milestones',
                    'type'    => 'radio_inline',
                    'desc'    => sprintf(__('Either allow comments on %s or hide the section.', 'upstream'), __('Milestones', 'upstream')),
                    'default' => '1',
                    'options' => array(
                        '1' => __('Allow comments on Milestones', 'upstream'),
                        '0' => __('Disable section', 'upstream')
                    )
                ),
                array(
                    'name'    => __('Disable Discussion on Tasks', 'upstream'),
                    'id'      => 'disable_comments_on_tasks',
                    'type'    => 'radio_inline',
                    'desc'    => sprintf(__('Either allow comments on %s or hide the section.', 'upstream'), __('Tasks', 'upstream')),
                    'default' => '1',
                    'options' => array(
                        '1' => __('Allow comments on Tasks', 'upstream'),
                        '0' => __('Disable section', 'upstream')
                    )
                ),
                array(
                    'name'    => __('Disable Discussion on Bugs', 'upstream'),
                    'id'      => 'disable_comments_on_bugs',
                    'type'    => 'radio_inline',
                    'desc'    => sprintf(__('Either allow comments on %s or hide the section.', 'upstream'), __('Bugs', 'upstream')),
                    'default' => '1',
                    'options' => array(
                        '1' => __('Allow comments on Bugs', 'upstream'),
                        '0' => __('Disable section', 'upstream')
                    )
                ),
                array(
                    'name'    => __('Disable Discussion on Files', 'upstream'),
                    'id'      => 'disable_comments_on_files',
                    'type'    => 'radio_inline',
                    'desc'    => sprintf(__('Either allow comments on %s or hide the section.', 'upstream'), __('Files', 'upstream')),
                    'default' => '1',
                    'options' => array(
                        '1' => __('Allow comments on Files', 'upstream'),
                        '0' => __('Disable section', 'upstream')
                    )
                ),
                array(
                    'name' => __( 'Remove Data', 'upstream' ),
                    'id'   => 'remove_data',
                    'type' => 'multicheck',
                    'desc' => __( 'Ticking this box will delete all UpStream data when plugin is uninstalled.', 'upstream' ),
                    'default' => '',
                    'options' => array(
                        'yes' => __('Remove all data on uninstall?', 'upstream')
                    ),
                    'select_all_button' => false,
                    'before_row' => '<hr>'
                ),

            ) )
        );

        return $options;

    }

}


endif;
