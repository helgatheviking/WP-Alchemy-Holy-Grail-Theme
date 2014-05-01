# WP Alchemy Holy Grail Theme

A child theme of Twenty Fourteen that is meant to show repeatable, sortable, WYSIWYG (tinyMCE-enabled) text editors complete with media buttons for your WP Alchemy metaboxes.

## General Requirements

As this is a child theme, you'll obviously need Twenty Fourteen to run it. But since it is meant to serve an example, you certainly don't need a parent theme to investigate the code.

WordPress 3.9 is required for this to work. I have removed any backwards-compatibility.

## Changelog

05/01/2014
* Update to Twenty Fourteen
* major update to kia-metabox.js scripts to support TinyMCE 4.0, toggling rich/text editors and media buttons

## Known issues
The repeating textarea groups have an open/close toggle switch. Currently the status is saved as post meta, but it really ought to be unique to each user.