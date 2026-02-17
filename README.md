![](https://i.ibb.co/DHNxDfjg/Private-Profile-Plus.png)
## Private Profile Plus

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/huseyinfiliz/private-profile-plus.svg)](https://packagist.org/packages/huseyinfiliz/private-profile-plus) [![Total Downloads](https://img.shields.io/packagist/dt/huseyinfiliz/private-profile-plus.svg)](https://packagist.org/packages/huseyinfiliz/private-profile-plus)

A [Flarum](https://flarum.org/) extension that provides tiered profile visibility controls with admin defaults and per-user overrides.

## Features

- **Admin Global Default** — Set a forum-wide default profile visibility level
- **Per-User Override** — Users can individually override the global default from their settings page
- **Three Visibility Levels**:
  - **Everyone** — Profile posts and discussions visible to all visitors
  - **Members Only** — Visible only to logged-in members
  - **Private** — Visible only to the profile owner and users with bypass permission
- **Permission-Based Bypass** — Grant specific groups (e.g. Moderators) access to view all profiles
- **Zero Migration** — Existing users automatically inherit the admin default, no database changes needed

## Installation

```bash
composer require huseyinfiliz/private-profile-plus
```

## Updating

```bash
composer update huseyinfiliz/private-profile-plus
php flarum cache:clear
```

## Configuration

### Admin Settings

1. Enable the extension in the admin panel
2. Set the **Global Default Profile Visibility** (Everyone / Members Only / Private)
3. Optionally grant the **Bypass profile visibility** permission to Moderators or other groups under the Permissions tab

### User Settings

Users can override the global default from their settings page:

- **Default** — inherits the admin global setting
- **Everyone**
- **Members Only**
- **Private**

## Links

- [GitHub](https://github.com/huseyinfiliz/private-profile-plus)
- [Packagist](https://packagist.org/packages/huseyinfiliz/private-profile-plus)
- [Discuss](https://discuss.flarum.org/)
- [Extiverse](https://flarum.org/extension/huseyinfiliz/private-profile-plus)

## Translate
[![Translate](https://weblate.rob006.net/widgets/flarum/-/huseyinfiliz-private-profile-plus/multi-auto.svg)](https://weblate.rob006.net/projects/flarum/huseyinfiliz-private-profile-plus/)


## Sponsor

This extension was developed with the sponsorship of [LibreTexts](https://libretexts.org).

## License

MIT
