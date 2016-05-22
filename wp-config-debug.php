<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'austin43_agentassets');

/** MySQL database username */
define('DB_USER', 'austin43_wpuser');

/** MySQL database password */
define('DB_PASSWORD', 'of}a5O%kxT9@');

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
define('AUTH_KEY',         'H=4pPEQU|X{8|MEpv1FKmE1sv4)0mZ?4Wz1.tE)~;vg0gyCk:V0VN_@lBN+BTf>;');
define('SECURE_AUTH_KEY',  '58s/jRY}Yr?ea2]#11z`ms<xz+w</p @rAiw~kHq#o-j;TPaRMo~d<dD|[^&|qaD');
define('LOGGED_IN_KEY',    '.`e/8Z8b&Y10zf0DdS&J!)3+}9qi*`dk[|!&} !v:[jjoXg_ </X2X+o2[0i4N]<');
define('NONCE_KEY',        '1G++u~XE5w<Za/+cyO`%6ZdspN9p++qvvLMOn7&`~0t9W eVr37(;N$:x9[7L92+');
define('AUTH_SALT',        '@DN_&Nnu^bvyuO/kqqUf5F_Y+yG)]Ac1F(FD.==/Y54Q%E0|Izk{|yaRce6?WTDh');
define('SECURE_AUTH_SALT', '<+DFAU(XGyay%eWG]|RtVx,>&}1OnWg_A)AD ep[e*r7-M03Z,P|Khm:j9zYeh =');
define('LOGGED_IN_SALT',   '8J_.}KQ`V0{J:_Q4N5H 3+x%1MT@L/Z+SV/StiZMz$O2vvk$syCGxh,H(%|Z+2JJ');
define('NONCE_SALT',       '}H(_6lacq~4^$tC4fSQ+`f[!m}Z6O2M[EVvud?`=N;q22QPJ}@:E2%p.6wl17bJ9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tfs_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', 'agentassets.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
/* Domain Mapping Plugin */
define( 'SUNRISE', 'on' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
