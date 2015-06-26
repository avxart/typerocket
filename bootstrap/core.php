<?php
/*
|--------------------------------------------------------------------------
| Enhance WordPress
|--------------------------------------------------------------------------
|
| Enhance WordPress with a few functions that help clean up the interface
|
*/
$tr_enhance_obj = new \TypeRocket\Enhance();
$tr_enhance_obj->run();
unset( $tr_enhance_obj );

/*
|--------------------------------------------------------------------------
| Load Plugins
|--------------------------------------------------------------------------
|
| Load TypeRocket plugins.
|
*/
if ( \TypeRocket\Config::getPlugins() ) {
	$plugins_collection = new \TypeRocket\Plugin\Collection( \TypeRocket\Config::getPlugins() );
	$plugin_loader      = new \TypeRocket\Plugin\Loader( $plugins_collection );
	$plugin_loader->load();
	unset( $tr_plugins_obj );
}

/*
|--------------------------------------------------------------------------
| Init WordPress Hooks
|--------------------------------------------------------------------------
|
| Add hook into WordPress to give the main functionality needed for
| TypeRocket to work.
|
*/
$crud = new TypeRocket\Crud();
add_action( 'save_post', array( $crud, 'save_post' ) );
add_action( 'wp_insert_comment', array( $crud, 'save_comment' ) );
add_action( 'edit_comment', array( $crud, 'save_comment' ) );
add_action( 'edit_user_profile_update', array( $crud, 'save_user' ) );
add_action( 'personal_options_update', array( $crud, 'save_user' ) );

/*
|--------------------------------------------------------------------------
| Run Registry
|--------------------------------------------------------------------------
|
| Runs after hooks muplugins_loaded, plugins_loaded and setup_theme
| This allows the registry to work outside of the themes folder. Use
| the typerocket_loaded hook to access TypeRocket from your WP plugins.
|
*/
do_action( 'typerocket_loaded' );

add_action( 'after_setup_theme', function () {
	\TypeRocket\Registry::run();
} );

define( 'TR_END', microtime( true ) );