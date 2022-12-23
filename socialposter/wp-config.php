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
define('DB_NAME', 'socialposter');

/** MySQL database username */
define('DB_USER', 'socialposter');

/** MySQL database password */
define('DB_PASSWORD', 'WIN313logicso');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '`jk@s(aqSW3X1SD_$<@9LB=vMmk,h5%K+TTCwLI[@#CkA84sCXI)tWSJEZp*ij2h');
define('SECURE_AUTH_KEY',  '`[z4)/D;v#5]b/Iz*XXG7 h%;Sz^Q J/m3=$ct`ACymLq4 `@{e[EA$1h)kJeiW$');
define('LOGGED_IN_KEY',    'uhF5@Q05wdiv1t[7y}cJ9CEJ|#RVaYCFo~A0Y}vkmyhsp$350%E[,h,4#0fX+FY8');
define('NONCE_KEY',        '=R=xzGN]sD:=ip(`=R3xLIy@8;6XCMM_/9iehFSCRdtar%3n$*-;ZBe!1YAGO=10');
define('AUTH_SALT',        'g8$<w[dfU*PqXTB M}@.#ow5PO,!OD3-Df@}/y>$I*+,%Y_f%0JoGA5uOj )K8h%');
define('SECURE_AUTH_SALT', '4/Iyb&13zc?H^!:$h}6.E/9s,Q+_5[(-iRcq#d kh/K`z)Ew<`e2%S^sLI(gN!l4');
define('LOGGED_IN_SALT',   'efuOo@6%h^`j!WK)O>Q}%~7?2b+$G-n YRj])$I[;I/$?!Q(t+DVloh5pK^JC:ZP');
define('NONCE_SALT',       'YGpJSY<-H8;hdFq=1I+rl%.?&uU=L-]#s|8Bk[=G%BmqJo$_OkAM<D,jx6Q/Rq{M');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
