# Live Glossary Search


## Description

Live Glossary Search is a powerful WordPress plugin that allows you to create a searchable glossary with custom glossary items. The plugin includes live search functionality, making it easier for users to find definitions quickly.

## Features
- Custom post type: "Glossary Item"
- Live search functionality
- Alphabetical grouping of glossary terms
- Custom link override for each glossary item
- Settings to append "What is:" to glossary item titles

## Installation

1. Download the plugin and upload it to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to **Glossary Items** in the admin panel to start adding new glossary terms.
4. Use the `[glossary_search_shortcode]` shortcode to display the searchable glossary on any page.

## Shortcode Usage

### Display Live Search Glossary
```html
[glossary_search_shortcode]
```

## Screenshots
1. **Glossary List View** – Displays glossary terms grouped alphabetically.
2. **Live Search in Action** – Search for terms in real-time.
3. **Glossary Item Edit Page** – Custom link override and content editor.

## Frequently Asked Questions

### How do I add a glossary item?
Go to "Glossary Items" in your WordPress dashboard and click "Add New." Fill in the title, content, and optional link override.

### Can I disable "What is:" from appearing before titles?
Yes! You can disable this in the **Glossary Settings** under WordPress Admin > Settings > Glossary Settings.

## Changelog

### 1.2
- Added security enhancements (nonce verification, escaping, and sanitization)
- Improved admin settings with proper capability checks
- Standardized function prefixes to prevent conflicts

### 1.1
- Improved description and functionality
- Updated author information

### 1.0
- Initial release

## Author
**Abdel**  
[Upwork Profile](https://www.upwork.com/freelancers/~01e0ebea64e80eb1de)

## License
This plugin is licensed under the GPL-2.0+ license. See [License](https://www.gnu.org/licenses/gpl-2.0.html) for details.