# BricksFlexAddons

[![Version](https://img.shields.io/badge/version-0.2.0-blue.svg)](https://bricksflexaddons.com)
[![License](https://img.shields.io/badge/license-GPLv2-orange.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

A modular add-on pack for Bricks Builder that lets you pick and choose only the advanced elements you need, plus a suite of powerful dynamic data tags. Perfect for agencies and freelancers with unlimited site licenses and fair pricing.

## 🌟 Features

### Core Elements

- **Flex Modal**
  - Centered or off-canvas slide-in modal
  - Full styling controls
  - Slide from any edge
  - Nestable inner content

- **Off-Canvas Drawer**
  - Slide panels from any direction
  - Configurable width
  - Backdrop blur effects
  - Keep-open-in-Builder toggle

- **Animated Headlines**
  - Typewriter animations
  - Staggered text effects
  - Highlight animations

- **Interactive Images**
  - Before/After sliders
  - Hotspots
  - Zoom and pan functionality
  - Image accordions

- **Sortable Tables**
  - Filterable and searchable
  - Pagination support
  - Dynamic data binding

- **Micro-Interactions**
  - Custom cursor effects
  - Reaction buttons
  - Hover parallax effects

### Dynamic Data Tags

Access powerful dynamic data tags through Bricks' Dynamic Data API:

- `{parent_page_title}` - Returns parent page title
- `{parent_page_content}` - Returns raw parent page content
- `{current_user_first_name}` - Current user's first name
- `{current_user_role}` - Current user's role
- `{woo_cart_total_price}` - WooCommerce cart total
- `{device_type}` - Current device type
- `{query_var:utm_campaign}` - UTM campaign parameter

## 💰 Pricing Plans

- **Single Section** - $4.99/month
  - Pick any one element bundle
  - Unlimited site activations

- **All-Access Studio** - $9.99/month $64.99/year $125 one-time fee
  - All sections & dynamic tags
  - Lifetime updates
  - Unlimited site activations

## 🛠️ Technical Details

### Plugin Structure
```
bricks-flex-addons/
├── flex-addons.php            # Main plugin loader
├── includes/
│   ├── elements/              # Individual element folders
│   └── dynamic-tags/          # Dynamic tag class files
├── assets/
└── readme.txt
```

### Technology Stack
- PHP: Bricks' \Bricks\Element and Dynamic Data Tag APIs
- JavaScript: Vanilla JS
- CSS: Modern CSS with variables, flex/grid
- Icons: FontAwesome (CDN)
- Billing: Freemius SDK

## 🚀 Development

- Local development: LocalWP + GitHub Desktop
- Version control: GitHub with CI/CD via GitHub Actions
- Code quality: Automated linting and testing

## 📚 Documentation

Visit [BricksFlexAddons.com](https://bricksflexaddons.com) for:
- Detailed documentation
- Usage examples
- API reference
- Support resources

## 🔜 Coming Soon

- Google Sheets import
- CSV-to-Table converter
- Content Timeline
- Masonry Grid
- And more!

## 📝 License

This plugin is licensed under the GPL v2 or later.

## 🤝 Support

For support, feature requests, or bug reports, please visit our [support portal](https://bricksflexaddons.com/support).
