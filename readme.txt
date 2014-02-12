=== FoundationTables ===
Contributors: ERA404
Requires at least: 3.2.1
Tested up to: 3.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

FoundationTables extends the WordPress page editor with a new toolset to easily insert, edit, style and delete Foundation-ready tables.

== Description ==

Succeeding the popularity of Zurb's Foundation framework, FoundationTables is a plugin written to harness the responsiveness the framework provides, and extend the WordPress page editor with a new toolset to easily insert, edit, and delete collections of tabular data.
If you're using a Foundation Theme, and are looking for a method to rapidly and responsively insert tabled data, this is the plugin for your site.

**One, Two, Three, Four, Five, Six Columns**

WordPress makes editing page content a snap. Even the rich-text editor's table tools are pretty good.
But if you're using a [FOUNDATION](http://foundation.zurb.com/ "The most advanced responsive front-end framework in the world") theme, wouldn't it be killer to take advantage of the responsive styles pioneered by [Zurb](http://foundation.zurb.com/ "Foundation is by Zurb")?
This plugin, FoundationTables integrates these row/column/pad classes to greatly cut down on your need for rewriting table styles and responsive media queries.

* Add as many tables to your page as needed
* Select a column width (1/12 = x-small, 2/12 = small, 3/12 = medium, 4/12 = wide, 6/12 = x-wide)
* Select one of the pre-styled themes (currently: Grey w/ Header, Grey w/ First Column Highlighted, Simple Grey), or style your own using independent stylesheets for your tables
* Click into a table cell for an enlarged HTML-friendly editor window
* Add new rows to a table (or new tables to a page) with the click of a button
* Omit columns (currently: maximum 6), by leaving them empty
* Insert the tables into your page content using a FoundationTable insert button built right into your RTE, or compact shortcodes
* Preview the table's position in your content without the hindrance of all of in-line markup tabular data requires 

This plugin was tested using the following Foundation-friendly themes:

* [Reactor](http://awtheme.com/ "Reactor Theme by AWTheme") by AWTheme
* [required+](http://themes.required.ch/ "required+ Theme by required+ GmbH") by required+ GmbH

More themes will be tested and documented shortly.

== Installation ==

1. Install FoundationTables either via the WordPress.org plugin directory, or by uploading the files to your server (in the `/wp-content/plugins/` directory).
1. Activate the plugin.
1. Access by expanding the FoundationTables section while managing pages.
1. Use the FoundationTable Insert Button (or shortcodes such as: `<div class="foundtabinsert" id="foundtab_2"></div>` ) to position the tables within the page content.

== Screenshots ==

1. An example of a table that uses the 'Grey w/ Header' styles
2. An example of a table that uses the 'Grey w/ First Column Highlighted' styles
3. An example of a table that uses the 'Simple Grey' styles
4. Inserting your table into the page content is as simple as clicking a button
5. The FoundationTable toolset with an example table being created


== Frequently Asked Questions ==

= Are there any new features planned? =
Yes.

= Can i propose a feature? =
If you wish. Sure.

== Changelog ==

= 0.21 =
* Updated hooks to work for 3.8.1, adjusted styles for better content entry.

= 0.1 =
* Plugin-out only in beta, currently. Standby for official release.