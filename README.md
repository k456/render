# Render
### v1.1-beta-2

Render is a powerful plugin which enables you to insert useful and powerful functionality into your content. All without writing or even seeing any code.

Render is powered by WordPress shortcodes but, unlike all other shortcode plugins, shortcodes created by Render offer a live preview within your content so you can see how each feature looks before you hit publish and without having to use or learn the standard shortcode syntax.

Some of the shortcodes included are:

Button
Columns
Login form
Custom query
Conditional content display
User meta
Site details
Post meta
Current date/time
And more!

## Key features

Here's a basic rundown of what this plugin does so that you'll know what to look for:

* Includes a sizable library of very useful, unique shortcodes
* Provides a live preview of all included shortcodes when used in the visual editor of a post/page (so users never see the shortcodes with their ugly [shortcode] syntax but rather the end result of the shortcode)
* Creates an intuitive modal for browsing, searching and inserting shortcodes via TinyMCE button
* Includes ALL registered shortcodes in shortcode directory/modal and not just the ones created by this plugin
* Creates a widget through which any registered shortcode can be easily inserted into a sidebar
* Provides a very easy to use developer API for extending the plugin and integrating other shortcodes with this plugin

## Installation

Simply download the master zip (the button on the right that says "Download ZIP"), and use WP to install that zip.

## Changelog

### [1.1-beta-2](https://github.com/brashrebel/render/releases/tag/v1.1-beta-2)
* UPDATE: Removing a wrapping shortcode now strips off the shortcode and leaves the content.
* UPDATE: Conditional visibility and population for attributes.
* UPDATE: Delete database options on uninstall now available from Settings.
* UPDATE: Shift + enter submits modal when in text area.
* UPDATE: Added WP Pointers throughout.
* UPDATE: Custom input selectbox visually labeled.
* UPDATE: Tab shortcode.
* UPDATE: Revised and improved columns shortcode.
* UPDATE: Accordion shortcode.
* UPDATE: Shortcodes no longer return default attribute values.
* UPDATE: User opt-in tracking data.
* DEVELOPERS: Nesting shortcode "type" now available! 

### [1.1-beta-2](https://github.com/brashrebel/render/releases/tag/v1.1-beta-2)
* FIX: Users drop-down was un-populated.
* FIX: Repeater attribute fields adding extra, unused attributes to shortcode output.

### [1.1-beta-2](https://github.com/brashrebel/render/releases/tag/v1.1-beta-2)
* FIX: Styling messed up in Customizer.
* UPDATE: Can close Render Modal by clicking off of it.

### [1.1-beta-2](https://github.com/brashrebel/render/releases/tag/v1.1-beta-2)
* UPDATE: Integration extensions now disable their applicable plugin's TinyMCE buttons, but can be re-enabled from Render Settings.
* UPDATE: Allow seamless integration of licensing from extensions into Render.
* UPDATE: Force require at least PHP 5.3.
* DEVELOPERS: Improve shortcode attribute template functionality, especially the post list template.

### [1.1-beta-2](https://github.com/brashrebel/render/releases/tag/v1.0.2)
* FIX: Content in shortcodes disappearing when adding one shortcode into the entire content of another.
* FIX: Potential PHP notice of defining a licensing constant.
* UPDATE: Improved TinyMCE shortcode tooltip usability.
* UPDATE: Hide customizer prompt on widgets page for Render widget.
* UPDATE: Chosen custom input now shows deselect "X" when using custom input.

### [1.0.1](https://github.com/brashrebel/render/releases/tag/v1.0.1)
* FIX: Major ACF conflict.
* FIX: PHP notice.

### [1.0.0](https://github.com/brashrebel/render/releases/tag/v1.0.0)
* RELEASE: The initial release!