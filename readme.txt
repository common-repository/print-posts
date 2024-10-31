=== Print Posts ===
Contributors: jaredharbour, joshl
Tags: posts, tags, categories, options, settings
Requires at least: 3.1.2
Tested up to: 3.1.2
Stable tag: 1.0.1

Adds a shortcode that displays posts based on what you add in for values.

== Description ==

This plugin adds a shortcode to display a list of posts.  The list of posts can be displayed in 2 formats, normal and expanded.  If you also install the Themekit plugin you will gain access to several options to customize the short code.

For more information on Themekit, check out [themekitwp.com](http://themekitwp.com/).

Features Include:

* Print posts by category name or id
* Print posts by tags
* Print posts related to the current post
* Print posts by the current author
* Ability to change the number of posts that get displayed
* Ability to change how many posts display in expanded view before going to the normal view 


== Installation ==

1. Install the Print Posts plugin by uploading the files to your WordPress plugin directory, or by installing directly through your site.
2. Activate the Plugin.
3. That's it.  You're ready to go!

(Optional) Install ThemeKit either via the WordPress.org plugin directory, or by uploading the files to your server (if you already have Themekit installed you may only need to upgrade to the latest version)


== Frequently Asked Questions ==

= Why do I need Themekit for this plugin? =

Themekit isn't required, but it will give you some more options to play with.

= How do I use the shortcode? =

Display posts from a category - [print_posts cat=1]

Display posts from a category using the category name - [print_posts category_name="cat name here"]

Display posts from a tag or set of tags - [print_posts tag="tags,go,here"]

Display posts related to the current post - [print_posts show_related_posts=true]

Display posts by the current posts author - [print_posts show_posts_by_author=true]

Change the number of posts to display - [print_posts display_count=5] (defaults to show all posts)

Change the number of posts that are shown in the expanded view - [print_posts expanded_count=3]

Feel free to mix and match the values as you need, and if you download and install Themekit you'll have even more options to play with.


== Changelog ==

= 1.0.1 =
* Added div with and ID of print_posts around shortcode output so themekit styles could be more CSS specific.
* Added font controller options to expanded headline (and headline hover)

= 1.0 =
* Initial release
