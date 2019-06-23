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

/** The name of the database for WordPress */

define( 'DB_NAME', 'kankunsa_store' );


/** MySQL database username */

define( 'DB_USER', 'root' );


/** MySQL database password */

define( 'DB_PASSWORD', "" );


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

define( 'AUTH_KEY',         '2?I,`ULQL{k#YoydG5Q.5Hn*8k~<;D6=9,!.+NK7zsVyO)^$Z@kM>HUj~y~O!jnU' );

define( 'SECURE_AUTH_KEY',  'j|/XwT<O{PoOZ^JM%yg^T?QvBw{fV<12Qfhu[hThnv|LmNCosJ9Q`OU3dN2bu<XR' );

define( 'LOGGED_IN_KEY',    ',fR##b}b=~)m.=)T{}JF3fp$O9XADo?x(Z}gQcTjwl|QjEmzgwum_~o/#9]j<-IJ' );

define( 'NONCE_KEY',        '3qr;~[rJ*_!ot3UDr8chq ~<aK_:Lx$?agm<,cz5496~gjIM68+I#uSSPy@%M5V{' );

define( 'AUTH_SALT',        '=<7Yt Uw(-%o ]XjSJvs&])h#GZ7c#Un*bbzrHk!%Jm][wTWgY=0,Y0kk4`f8]p<' );

define( 'SECURE_AUTH_SALT', 'v>lB>b=I)W/mPT{Ii}$7jhc9fk-;p,fEc%QTjZ_0Xb&Wa.+d+n?Nz@N/O>RZC0F!' );

define( 'LOGGED_IN_SALT',   'zn4b_s*pMe~fszibE9TaVdZfZ`Su!1QY|pV5S0P%{`M4{)HUYSC/vKwFg{]iHu<S' );

define( 'NONCE_SALT',       'u.^EG#dgBhnfj4S@gv.4E(OItas>R.ZN5L#6W 0<6TUZ.(v%zVBuAEaA#{_XD{ti' );


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

 * visit the Codex.

 *

 * @link https://codex.wordpress.org/Debugging_in_WordPress

 */

ini_set('display_errors','Off');
ini_set('error_reporting', 'E_ALL');
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);


/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

}


/** Sets up WordPress vars and included files. */

require_once( ABSPATH . 'wp-settings.php' );

