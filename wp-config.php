<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link https://fr.wordpress.org/support/article/editing-wp-config-php/ Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('WP_CACHE', true);
define( 'WPCACHEHOME', 'C:\MAMP\htdocs\oc_p11\wp-content\plugins\wp-super-cache/' );
define( 'DB_NAME', 'oc_p11' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'root' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'BLgY#{U[=4bAE)3n72>BEPouJV&/j|=*v!tAglre[_.aUHHR,a+yG($OoWn!yTR%' );
define( 'SECURE_AUTH_KEY',  '5mf[pQ.Z4[#fs:~.g:s:)yryxvN_H=(<?qD5&#nNLY*t9mv-,k[XREzeK&CdU?Uj' );
define( 'LOGGED_IN_KEY',    '~_gGxp~Ur|<H}3zDOu3;w_5y&q#)3l:(<,$l%Am]%N]n*;B%3(*_<&WgY3lbG]dP' );
define( 'NONCE_KEY',        '8i,gG~Ub_5}?uUx:FmU}GU9$4o?>kk0KZsh@@N^_czpFE_Z#PbS7]!.@+r/awD%+' );
define( 'AUTH_SALT',        'g/`A>LP:#i8E4^fqk~<A|_*J ^8xzIW(cwKtvwS`%n(/,CNWvo&MG<JsQ@$(8@p,' );
define( 'SECURE_AUTH_SALT', 'REv_NB3Q~C_D4M(bD318k`@Y6R;d_zzn6K}j<4=tSdmHoX8`,1!-(1uKl(ME>Sl,' );
define( 'LOGGED_IN_SALT',   'J:=xwbC-b HVS`A0KZE=/Yk/fzy{c4-2Lx)Q1Ct*Io~PO#(SZ:PS*@?sQU_Oe8X~' );
define( 'NONCE_SALT',       'e6]@X6y?Q6cWvM9;qbb!q;Sem$>pu1BPJlqdtM h~3UO.&E)JHsOcT:w{DDy;z >' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs et développeuses : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs et développeuses d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur la documentation.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
