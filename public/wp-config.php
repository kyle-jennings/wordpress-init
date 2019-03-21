<?php

// if an env file is found lets load the vars and flag this is a local dev site.
$env_file_dir = dirname( dirname( dirname( __FILE__ ) ) );

if ( file_exists( $env_file_dir . DIRECTORY_SEPARATOR . '.env' )
	&& file_exists( dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php' )
) {
	include_once dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
	$dotenv = new Dotenv\Dotenv( $env_file_dir );
	$dotenv->load();
	define( 'EPI_LOCAL', true );
}

$table_prefix = getenv( 'TABLE_PREFIX' ) ? getenv( 'TABLE_PREFIX' ) : 'www3_';

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv( 'DB_NAME' ) );

/** MySQL database username */
define( 'DB_USER', getenv( 'DB_USER' ) );

/** MySQL database password */
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );

/** MySQL hostname */
define( 'DB_HOST', getenv( 'DB_HOST' ) );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', getenv( 'AUTH_KEY' ) );
define( 'SECURE_AUTH_KEY', getenv( 'SECURE_AUTH_KEY' ) );
define( 'LOGGED_IN_KEY', getenv( 'LOGGED_IN_KEY' ) );
define( 'NONCE_KEY', getenv( 'NONCE_KEY' ) );
define( 'AUTH_SALT', getenv( 'AUTH_SALT' ) );
define( 'SECURE_AUTH_SALT', getenv( 'SECURE_AUTH_SALT' ) );
define( 'LOGGED_IN_SALT', getenv( 'LOGGED_IN_SALT' ) );
define( 'NONCE_SALT', getenv( 'NONCE_SALT' ) );


if ( is_readable( './extras.php' ) ) {
	require_once './extras.php';
}


// ======================================
// Load a Memcached config if we have one
// ======================================
if ( file_exists( dirname( __FILE__ ) . '/memcached.php' ) ) {
	$memcached_servers = include dirname( __FILE__ ) . '/memcached.php';
}



// dont touch this.
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define( 'WPLANG', '' );

// Fix Uploads.
define( 'FS_METHOD', 'direct' );

// prevent autoupdates and plugins/theme editing.
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'AUTOMATIC_UPDATER_DISABLED', false );

// turn off post revisions.
define( 'WP_POST_REVISIONS', false );

// Change the content folder location.
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content' );
define( 'WP_SITEURL', 'https://' . $_SERVER['SERVER_NAME'] . '/wordpress/' ); // WordPress Address.
define( 'WP_HOME', 'https://' . $_SERVER['SERVER_NAME'] ); // Site Address.


define( 'WP_DEBUG', true );

// ===================
// Bootstrap WordPress
// ===================
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/wordpress/' );
}


require_once ABSPATH . 'wp-settings.php';
