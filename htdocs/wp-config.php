<?php

require_once "vendor/autoload.php";

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', $_ENV['database'] );

/** MySQL database username */
define( 'DB_USER', $_ENV['user'] );

/** MySQL database password */
define( 'DB_PASSWORD', $_ENV['pass'] );

/** MySQL hostname */
define( 'DB_HOST', $_ENV['host'] );


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         $_ENV['AUTH_KEY'] );
define( 'SECURE_AUTH_KEY',  $_ENV['SECURE_AUTH_KEY'] );
define( 'LOGGED_IN_KEY',    $_ENV['LOGGED_IN_KEY'] );
define( 'NONCE_KEY',        $_ENV['NONCE_KEY'] );
define( 'AUTH_SALT',        $_ENV['AUTH_SALT'] );
define( 'SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT'] );
define( 'LOGGED_IN_SALT',   $_ENV['LOGGED_IN_SALT'] );
define( 'NONCE_SALT',       $_ENV['NONCE_SALT'] );


// dont touch this
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('WPLANG', '');

//Fix Uploads
define('FS_METHOD',"direct");

// prevent autoupdates and plugins/theme editing
define('WP_AUTO_UPDATE_CORE', false);
define( 'AUTOMATIC_UPDATER_DISABLED', false );
// define( 'DISALLOW_FILE_MODS', true );

// turn off post revisions
define( 'WP_POST_REVISIONS', false );

// Change the wp-conten folder location
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/wp-content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/wp-content' );



/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');