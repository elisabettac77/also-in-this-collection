=== Also In This Series ===
Contributors: Elisabetta Carrara
Donate link: https://donate.stripe.com/cN228ZaeFajw54QfYY
Tags: related posts, collection, posts, SEO, internal links, widget
Requires CP: 2.0
Requires PHP: 8.0
Tested up to: 2.4.1
Stable tag: 1.0
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is a fork of Also In This Series WordPress Plugin by Jon Weatherhead

Group related posts in a post collection and automatically list all of the posts in the collection as part of the content.

== Description ==

Group related posts in a collection. Automatically insert a list of all posts in the collection as part of the content.

Manually embed a collection listing with the provided shortcode and widget. Override the series template with a custom template.

== How To Use ==

Create new Collection terms from the Collection manager under Posts. Add posts to collection either through the quick edit screen or through the full edit screen.

Also In This Collection can be configured to automatically insert a collection listing in posts belonging to a collection.

To do so, navigate to Also In This Collection settings under the settings option.

=== Settings ===

* **Title heading level** sets the HTML tag that will wrap the collection title in collection inserted automatically, with shortcodes, and with widgets.
* **Title template** picks from a list of title presets for displaying the title, including a preset for no title.
* **Automatically display collection listing on post** allows for automatic listing insertion in posts that belong to a collection.
* **Order of collection display** controls the order of posts (newest first or oldest first) in collection listings.
* **Window collection listing display** creates a window around the current post in a collection listing. This is useful for large collections where it is cumbersome to show the entire listing at once.
* **Do not display collection listing** prevents the collection listing from being shown. When checked, a link to the collection is always shown.
* **Always show collection link** forces a link to the collection archive regardless of windowing. When unchecked, a link to the collection will not be shown when the entire collection listing is visible.

=== Shortcode ===

To manually insert the collection listing of a post within a collection as part of the content, use the shortcode [alsointhiscollection].

This will have no effect if the post isn't in a collection.

To manually insert a specific collection, use the collection-slug attribute with the shortcode like [alsointhiscollection collection-slug="your-collection-slug"].


The shortcode attributes are

* collection-slug="slug"
* use-frame="yes|no"
* frame-width="number"
* sort-order="asc|desc"
* title-wrap="h1|h2|h3|span"
* title-template="also-in|ordinal|none"
* hide-collection-listing="yes|no"
* always-link-collection="yes|no"

=== Widget ===

A widget that exposes all of the above options is available.

=== Custom Template ===

If you'd like to use your own collection listing template, there are two options available.

* Place a template file `also-in-this-collection/collectionlisting.php` in your theme.
* Use the alsointhiscollection_template filter to provide an absolute path to a template file.

== Installation ==

1. Unpack the plugin zip and upload the contents to the /wp-content/plugins/ directory. Alternatively, upload the plugin zip via the install screen within the WordPress Plugins manager
2. Activate the plugin through the Plugins manager in WordPress
