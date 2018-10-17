<?php
do_action( 'pp_admin_handlers' );

if ( ! empty($_POST) ) {
	global $pp_plugin_page;

	if ( strpos( $_SERVER['REQUEST_URI'], 'pp-edit-permissions' ) 
	|| ( ! empty($_POST['action']) && ( in_array( $_POST['action'], array( 'pp_updateroles', 'pp_updateexceptions', 'pp_updateclone' ) ) ) )
	|| ( ( isset($_REQUEST['_wp_http_referer']) && strpos( $_REQUEST['_wp_http_referer'], 'pp-edit-permissions' ) ) )
	|| strpos( $_SERVER['REQUEST_URI'], 'page=pp-group-new' )
	)
	{
		add_action( 'pp_user_init', '_pp_agent_edit_handler' );
	}
}

if ( ! empty( $_REQUEST['action'] ) || ! empty($_REQUEST['action2']) || ! empty( $_REQUEST['pp_action'] ) ) {
	if ( strpos( $_SERVER['REQUEST_URI'], 'page=pp-groups' ) || ( ! empty( $_REQUEST['wp_http_referer'] ) && ( strpos( $_REQUEST['wp_http_referer'], 'page=pp-groups' ) ) ) ) {
		add_action( 'pp_user_init', '_pp_permits_handler' );
	}
}

function _pp_agent_edit_handler() {
	require_once( dirname(__FILE__) . '/pp-agent-edit-handler.php' );
}

function _pp_permits_handler() {
	require_once( dirname(__FILE__) . '/pp-permits-handler.php' );
}
