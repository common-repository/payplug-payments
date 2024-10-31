=== PayPlug Payments ===
Contributors: nicolaskulka, mathieuaubert, plateforme-wp-digital
Author URI: http://www.plateformewpdigital.fr
Plugin URL: http://www.plateformewpdigital.fr/plugins
Requires at Least: 3.2
Tested Up To: 4.9
Tags: button, buy now, buy now button, easy, ecommerce, payplug, payplug button, payplug buy now button, payplug plugin, payplug plugin for wordpress, shortcode, widget, gateway, payplug gateway, payment gateway
Stable tag: 1.8.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Accept payments from your WordPress site via PayPlug payment gateway.

== Description ==

= English =
This plugin allows you to accept credit card payments via PayPlug. It has a simple shortcode and widget that lets you place buy buttons anywhere on your WordPress site.

<a href="http://www.payplug.fr/portal2/signup?sponsor=136" title="Register for free to PayPlug">Register for free to PayPlug</a>
This plugin, version 1.*, is based on <a href="https://github.com/payplug/payplug-php/tree/V1.1.2">API V1 Payplug</a>.
PayPlug's library relies on cURL to perform HTTP requests and requires OpenSSL to secure transactions. You also need PHP 5.2 or newer.

= Français =
Ce plugin vous permet d'accepter les paiements par carte de crédit via PayPlug. Il dispose d'un shortcode et d'un widget qui vous permet de placer des boutons d'achat n'importe où sur votre site WordPress.

<a href="http://www.payplug.fr/portal2/signup?sponsor=136" tile="Inscrivez-vous gratuitement à PayPlug">Inscrivez-vous gratuitement à PayPlug</a>
Ce plugin, en version 1.*, se base sur <a href="https://github.com/payplug/payplug-php/tree/V1.1.2">l'API V1 de Payplug</a>.
L'API V1 de PayPlug repose sur cURL pour effectuer des requêtes HTTP et nécessite OpenSSL pour sécuriser les transactions. Vous devez également utiliser PHP 5.2 ou plus récent.

= Localization =

* French
* English

= My Links =

* Twitter @[plateformewp](https://twitter.com/plateformewp)
* Facebook [Plateforme WP Digital](https://www.facebook.com/plateformewpdigital)
* Google+ [Plateforme WP Digital](https://plus.google.com/u/0/101743421589257173603/)

* Twitter @[KulkaNicolas](https://twitter.com/KulkaNicolas)
* Google+ [Nicolas Kulka](https://plus.google.com/u/0/105181416749428983955/)

* Twitter @[mat_aubert](https://twitter.com/mat_aubert)
* [http://mathieu-aubert.fr/](http://mathieu-aubert.fr/)

* [Plateforme WP digital](https://www.plateformewpdigital.fr/)

== Installation ==

= English =
1. Upload the directory `/plugin-payplug/` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create a <a href="http://www.payplug.fr/portal2/signup?sponsor=136" title="free PayPlug account">free PayPlug account</a>
4. Configure the plugin by going to the "PayPlug" menu

= Français =
1. Envoyez le dossier `/plugin-payplug/` dans le dossier `/wp-content/plugins/`
2. Activez le plugin sur la page des plugins de WordPress
3. Créer un <a href="http://www.payplug.fr/portal2/signup?sponsor=136" title="compte PayPlug gratuitement">compte PayPlug grauitement</a>
4. Configurez le plugin en allant dans le menu "PayPlug"

== Screenshots ==

1. PayPlug Settings

== Changelog ==

= 1.8.1 =
* Fix Failed to load plugin url: /plugins/payplug-payments/assets/js/button.js

= 1.8 =
* Change URL payplug for secure.payplug.com

= 1.7 =
* Add email, firstname and lastname support

= 1.6 =
* Add custom data support

= 1.5.1 =
* Fix readme

= 1.5 =
* Add order ID in PAYPLUG_Plugin::payplug_generate_payment_link function : PAYPLUG_Plugin::payplug_generate_payment_link( price, [ 'Button text', 'CSS class' , 'Icon', 'Order ID' ] )
* Add getIpn() function (example : https://wordpress.org/support/topic/configure-ipn_url-to-notify-application-that-payment-is-complete?replies=3)

= 1.4 =
* Compatibility WP 4.5

= 1.3 =
* Add return and ipn url support

= 1.2 =
* Add static method for developpers : PAYPLUG_Plugin::payplug_generate_payment_link( price, [ 'Button text', 'CSS class' , 'Icon' ] )
* Add tracker for Plateforme WP Digital to anonymously track how this plugin is used and help us make the plugin better

= 1.1 =
* Add support CSS class
* Add support Icon
* Bugfix https://wordpress.org/support/topic/probleme-permission

= 1.0 =
* This is the first version
