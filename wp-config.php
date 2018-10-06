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
define('DB_NAME', 'cmsdev-db');

/** MySQL database username */
define('DB_USER', 'cmsdev-user');

/** MySQL database password */
define('DB_PASSWORD', 'cmsdev-pass');

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
define('AUTH_KEY',         '/9$aKA*c/K#5$={MC?Q8?xe^u<1|lF-Jx.Z*{)*+q4+STq2N3K^5NeGzH~}9pU&N');
define('SECURE_AUTH_KEY',  '~j)fh6Xg+JDsp7^Tk7N2^8 82VAU&HjoIL|2g=@<!!8Pmtz3QqlU1CUM`HPLy1Fw');
define('LOGGED_IN_KEY',    'DV/n i_N?bqw@U|]S-x4J 2,#&L)he2VO7B[Mww*U&4tl2[g=?L%d}?V_D qgD5l');
define('NONCE_KEY',        'Qv>P>4&UA1~N5@TdDRoh=OlgAYEAS=OZw]m),1TKaM7q>B=SsUD>[n6X1TE+S;B#');
define('AUTH_SALT',        '?_CvT}ZSK#y.EPxPLRRj%J2`(?~y{^du6JW1J+EGv=%Hj*$_N+T?&=h$sn~Ev|lh');
define('SECURE_AUTH_SALT', '`vl#ZB$m&nNYr;74$D.-(I,Zq0G_Rz*|~O8{uFB2_k%~;qByS%%%CT3[Yx}D]7qs');
define('LOGGED_IN_SALT',   '+(-3&I(38?Gr#mkrQfQbUZf`zbV]07C Deh}%?+kD[(+#&|:^n8Ks$&wk=S7K8k5');
define('NONCE_SALT',       '=Edlr:TYI]dS3CIM#[f<40rZ5_:`sW A5?_@q-}*; NEN_8tSkhBE)72fDU0Qc6)');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
