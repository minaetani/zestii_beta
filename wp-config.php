<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //

if(strstr($_SERVER['SERVER_NAME'],'zerobasezestii.local')){
	//**The name of the database for WordPress */
	define( 'DB_NAME', 'local' );
	//** MySQL database username  */
	define( 'DB_USER', 'root' );
	//** MySQL database password */
	define( 'DB_PASSWORD', 'root' );
	//** MySQL hostname */
	define( 'DB_HOST', 'localhost' );
} else {
	//* Find what the deal with each hosting company and modify information*/
	define( 'DB_NAME', 'dbysee0rirk77u' );
	define( 'DB_USER', 'ugbgwpkxwvlg1' );
	define( 'DB_PASSWORD', '2E#r(i@b#6$1' );
	define( 'DB_HOST', '127.0.0.1' ); 
}

 
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'S/VIjM5eO0eCbU1S541V1G/XQW2wXkWyrsV6T7uHpjvhY1KQZqlVYhKcwRc1ZeL+xGiY9wEYHaVjyFKGjNL4Jw==');
define('SECURE_AUTH_KEY',  'XfzxgRt9Hf2hrTFMf6yNmwvCtuC9ZBj+DudPX2w2Y1zYUQfKXT96TmStaQRDteC5ysanWXdM010JkPLsoAekqA==');
define('LOGGED_IN_KEY',    '3JkH2oHfP0iH99TLV8t8S2X53/vtCxkAO6vSAZxEsYr3mqo/xDaY4qttnbewueOxhEolXNRS2zd/4eHedHnMeQ==');
define('NONCE_KEY',        'rMC/yBGDKw91Z8DKtuWFe96rSS9hvcfiQsGe5OEPMWIp5bcfwxokChw/ITyzzCnRJd9XLRvtIIhKEO6Bt+DVKw==');
define('AUTH_SALT',        'PcCpHDo8iDqCcl4bmx/H/Z9ZE8ImIgk8ih3uGJ0wW66btIJHfgNi/EueB1RTMPwSppceoXT+OGVf5dEpVEEfGQ==');
define('SECURE_AUTH_SALT', 'soqKqV+HwpphmJGsBrPFmo5zQ5jB3Oyg9Z4Hq0BnwPPfspQ38Ag18/vumhUUZfBjFPucTlk0qQU7mBonxEoOGA==');
define('LOGGED_IN_SALT',   'R/C715vFQurTKu3koMYQqi3nzSI5HDa4/oRTsNTzX92OAeuNKc6I4+u2c/na65MwCK3VhE3BIP19xzv/+uSABQ==');
define('NONCE_SALT',       'Rn88aVzvkYXmkJsTzpCSVztup9Fi06zOnFRAyozltyScld8sehpSawK2fsYIfcJKTfxOvqNzhSJ6yYutvRBtzg==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';






define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'zerobasezestii.local' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
