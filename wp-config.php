<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         'vZa @HK90r@?D_o@k!SMc.a~R,ON*T+w_C.aV(@dN,L7=8szK#SBGXMmpZM[7!;p');
define('SECURE_AUTH_KEY',  'NS-U1(Y#L*[9$Vg=V0k*/8fN:Hea@8#x}J2W!h:y##Q73 PA`T}No0;Tre4k@p!7');
define('LOGGED_IN_KEY',    'Hkv?/7Bpp=V*gqkOAN$zQl_cs(Ur3$I# AYy ?H8/oi-(kh X.Ed+9BHE^Ld#}p~');
define('NONCE_KEY',        '@;d^K!X#c@:K?*s%r!lhW6w|-``ZtBQ}1OUwhoAV8*yx,Q`_<Mm`^2<^E@%{I|q(');
define('AUTH_SALT',        '*$B!/7!,,Fab;%O.Fy!n]dC|B0rqw!HN4Es(6h11dk{rm!X2lRt7g9ZW6bE+@sU|');
define('SECURE_AUTH_SALT', 'qBV8&R{MQ+2Fd(``lbI_@CwnV?7##O2@uLAwiUb(8Z&Ct ~b8rD+!QWdPNQt-iqp');
define('LOGGED_IN_SALT',   'Ww_1WIs@mJ)?E&R};&R]*X/p3l7H[Y(%-/$A,i/3]h@fWQm=UHSYL)QE0M$ C#*l');
define('NONCE_SALT',       '=oL]1KX%eBxY~)CB]n7vqf3 r$-b2XeR-$lah: Kx15x_cUOzs;$^V&3;iFxv],l');

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';