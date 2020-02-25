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
define( 'DB_NAME', 'nwagency_plb' );

/** MySQL database username */
define( 'DB_USER', 'nwagency_plb' );

/** MySQL database password */
define( 'DB_PASSWORD', 'sQeVqA7ZQrm955DQ' );

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
define( 'AUTH_KEY',         'a6;=[AO~[RmEVAYs8P-iHl FW>FN.KV_5ilOuM?NHC6ZyJ3X{+B_^`T]K#LqTyaV' );
define( 'SECURE_AUTH_KEY',  'NWz%|LT(j/^fhw>$tKL6nz2TKsQ)t2;(M5[h nPp@+ sw{b&PKkJ($ LWIIHio35' );
define( 'LOGGED_IN_KEY',    '&T@Q|J1NbE5;D5lC47C(It--[)RlO9A~fO$2B4|:|8e4$^qOcggwx/XR67?a|=7a' );
define( 'NONCE_KEY',        'lhG6lO(g14XSi`:J`N!4NxnC,WNCC R7-.U}S2wiG/VXSHOgm{Eqh?~1G5`T|i41' );
define( 'AUTH_SALT',        'f|[~FGh)@Ui5On)YD!mhD@,:|e;WL3]YBufLAG!lN88>[5zQF6)/!<Z;<*Qx``h;' );
define( 'SECURE_AUTH_SALT', 'vYSj2M`gb%n8xU]<ltZIMw4c>Hs5[r(~_> ?8hCz{=!88GVe[se2D6U$Y9$afdvr' );
define( 'LOGGED_IN_SALT',   'Mx{7Aj#f-U[9=T6SerU^r#&6LC[q^fzXopp9J,4~FAY$i[,~Nu^R`/3w//2Y}o:6' );
define( 'NONCE_SALT',       'H&1A/Jry:W0@Zc/`YvOs5*[]t5xbu1BIQ&KR1HM3K;~1KGK6PBJ$r0oD9Wu,_B=I' );

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
