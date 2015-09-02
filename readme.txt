=== Fancy Excerpt ===
Contributors: Denis-de-Bernardy, Mike_Koepke
Donate link: https://www.semiologic.com/donate/
Tags: fancy excerpt, fancy-excerpt, excerpt, semiologic
Requires at least: 3.0
Tested up to: 4.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The fancy excerpt plugin for WordPress replaces the default automatic excerpt generator with a sentence aware excerpt generator.

== Description ==


> *This plugin has been retired.  No further development will occur on it.*

The fancy excerpt plugin for WordPress replaces the default automatic excerpt generator with a sentence aware excerpt generator.

When automatically generating an excerpt, WordPress will no longer cut your posts after an arbitrary number of characters. Instead, it will keep adding complete paragraphs until 30 words or more are returned. It then completes the excerpt with a More... link.

Before:

> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut in sem eget est pharetra hendrerit. Nulla condimentum venenatis lectus.

> Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin lacus. Aenean eget libero. Suspendisse volutpat nonummy magna.

> Fusce pharetra volutpat mi. Fusce auctor cursus arcu. Maecenas feugiat dolor a felis. Vivamus facilisis [...]

After:

> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut in sem eget est pharetra hendrerit. Nulla condimentum venenatis lectus.

> Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin lacus. Aenean eget libero. Suspendisse volutpat nonummy magna.

> More...

= Help Me! =

No further support is provided.


== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

This plugin does not provide any user interface.


== Frequently Asked Questions ==

= It Doesn't Work When I Send A Trackback =

I'm aware. Last I checked, there wasn't anything I could do about it.


== Change Log ==

= 3.5.1 =

- Development has ceased on this plugin.  Updated source and readme accordingly

= 3.5 =

- WP 4.0 compat

= 3.4.1 =

- Fix localization

= 3.4 =

- Code refactoring
- WP 3.9 Ccmpat

= 3.3.1 =

- Simple code change to PHP5 constructor call

= 3.3 =

- Fixed missing 2nd parameter in 'the_content_more_link' filter call.
- WP 3.8 compat

= 3.2 =

- WP 3.6 compat
- PHP 5.4 compat

= 3.1 =

- Add hack to correct ShareThis plugin adding double rows of buttons.  ShareThis really needs an option to not include in excerpts.
- Added Norwegian language file (props TJ Bratveit)

= 3.0.2 =

- Fix uninitialized variable

= 3.0.1 =

- Improve list handling

= 3.0 =

- Split on paragraphs *and* sentences
- Enhance escape/unescape methods
- Support shortcodes, scripts and object tags in excerpts
- Localization
- Code enhancements and optimizations