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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// Set base path
define('APP_URL', 'http://localhost/securityagent/public');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ontime_blog' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '~_Eb}QOY6kp(6Q5TqmKXgo2Fy`c$2*ZN(O1^,@:45##f#H2 gJh8Jra--&/{.2=z' );
define( 'SECURE_AUTH_KEY',  '>12uNTHVcK9lg1t)tQziW==;JNVBvp tYV ,zS.ji<=sTqRC}xHa}l7^Vg|vhrXe' );
define( 'LOGGED_IN_KEY',    '$[+L;<S]#7mYOD=%lI.<Xl{:x9`vpscNk#:&`#q8B&mNP)ZTW 7+q`@WZ<e$(CVz' );
define( 'NONCE_KEY',        'A-GFWpKq9Ghzd`CPJ0^`(=Xh7jLq2yZ-8>k+cF<FU;9TT p6C<r7@(`(d[i`D0T7' );
define( 'AUTH_SALT',        '^C*k73@r#Vs_1%7uS3xqgrJi^utU$8(@-KzjGFX}SAq|#4 K(7Ff,+HK~43<59bs' );
define( 'SECURE_AUTH_SALT', '|`3OBpR3QSz4f&s.!=.dO*1F-:i[>x&1ZX1:,/[+j!u*NW5:C#zuz8|a*6ZKu6^n' );
define( 'LOGGED_IN_SALT',   'YcOz1$L}4n/<T8GRiB+$4c2|Vd~X$sY[_4P`aGpcyR.]rdX_SG>yyQb3O2dXsNfh' );
define( 'NONCE_SALT',       'q`eB~5TbA[g!wD?#E/{*Om@UOV7)jDV^_~^jW9)wnY{3h=:)DvINy:xUxvF-KLf-' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
