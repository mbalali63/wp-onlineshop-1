<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "electorn-shop1" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', ':;wM33do859J:8wb8i0UC7k(Po5!U!5@;SPm0;0RpJ1/W65CHbNx+b@f~|03B:qL');
define('SECURE_AUTH_KEY', '14a~1TCewO8W;TBK54g44k~LG&67n:V@0f+62P3g&m;10]d|)R*f1g6Gg_nVQWpk');
define('LOGGED_IN_KEY', 'x1/0/i1FSwm~OwGUyXcX@q:rbMn@z12u]i;q%@ovlOx0Qr71/X&3dY:(fP7#)3-p');
define('NONCE_KEY', '04x%xks(Frc443ymy:_3ZUEehwy!R&Q@zJ*(U7I544x-4io;52FO~!;+[8x61HFm');
define('AUTH_SALT', '59j1i18p0Dl;mX/0!99%6#r_0In7#1]]Fr+5Z)h)o(vhwcykiiuO7867s791qVKC');
define('SECURE_AUTH_SALT', '1B2889V[bILE22y|G28!kMlF/sq8;CWY;(Mz:v]EA/w39q~]]q;58Uky89[QnGoh');
define('LOGGED_IN_SALT', 'o7~]AH1p))7%Rr05h+FX#9dvj|1E9k/%:6Td_753/5A(CWYd;/#uJ82d#15e7312');
define('NONCE_SALT', 'w[_u|#~2;!cg)!2d5p+MXvTW-1gKU9!E4v]&LHI_+173O1l0e1mIzgpEOn14koo/');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'oLLV0_';


/* Add any custom values between this line and the "stop editing" line. */

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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
