<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'chicago_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '0W-%`+]I2pE@FoU{.J<f-f;bt_ku3.>+%8m/~-sBpZ43-Fp)Xp_azHud3>;`41]q');
define('SECURE_AUTH_KEY',  'o,6pFI+KvWAB5YpN~m95EQ,>n(~V0wQTb&vD<vLt.ul9&iAf0Gv)gO25mTN6Z+<4');
define('LOGGED_IN_KEY',    '|6OqUDR^?/@]G*Klju|LvkjmM+6UJxf^x8|/jK.6r y^xeIsaEeLq!MZQWH!s$H:');
define('NONCE_KEY',        'vvp-.D@JE FcYZ`8wFZ|D-9u^4g/#3W4/xFP-/|HfA,.h<|4g{L@Ms[}|ShT1XjM');
define('AUTH_SALT',        ']{wKB%mP,g^T]|B;J0W?egmbeA|+f:S!>7~Y7|R-I;-Z|vt|o~%DCo!f!5_C J%5');
define('SECURE_AUTH_SALT', 'c(,Hmk-%M#.CoW(N~R6zOXw4mPOjPK;32w/rP].e)d&^1N{t7e6QvH@l+3E]SL%v');
define('LOGGED_IN_SALT',   '2`shi%@&v%j7|fR650U!|LQH&-B M:$bK:qYtoo%06-;*}1K:J>DOZYDHqs[@|9p');
define('NONCE_SALT',       '%*-de.T6<E/%gA:CX[.^|gmg$jejZ|[r4R]U@#_$i9a)L4lyoi9c{afO}+yC_8%K');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
