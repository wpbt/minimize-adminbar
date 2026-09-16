# Minimize Admin Bar

A small WordPress plugin that lets you collapse the admin bar out of view with one click, and bring it back just as fast. Per-user, animated, no settings screen.

## What it does

- Adds a caret toggle button, fixed at the top-left corner of the screen (front end and wp-admin both).
- Click it → the admin bar fades out, and the button itself slides into a small round pill in the top-right corner.
- Click the pill → the bar comes back.
- State is saved per-user via `usermeta`, synced through a lightweight AJAX call, so it persists across page loads and devices.
- Respects `prefers-reduced-motion`.
- Matches WP core's own 782px mobile breakpoint so sizing doesn't break on small screens.

## File structure

```
minimize-adminbar/
├── minimize-adminbar.php     # Bootstrap: constants, includes, plugins_loaded hook
├── uninstall.php             # Deletes the usermeta key on uninstall
├── inc/
│   └── main-class.php        # Minimize_AdminBar class — all the actual logic
└── assets/
    ├── admin-bar.css
    └── admin-bar.js
```

## How it works (the important design decision)

The toggle button is **not** a `$wp_admin_bar->add_node()` item. It's printed as a standalone `<button>` via `wp_footer` / `admin_footer`, completely outside `#wpadminbar`'s own markup.

This matters: WP core has its own responsive CSS rules for the admin bar's child items (hiding things at narrower widths). Early versions of this plugin added the toggle as a real admin-bar node, and it kept getting caught by those rules — invisible or broken on mobile depending on core's own layout logic. Making it a fully independent element sidesteps that entire bug class instead of patching around it.

The hidden/visible state has exactly one source of truth: an `html.cab-bar-hidden` class. It's set:
- **Server-side**, synchronously in `<head>` (`print_early_state_script`) — so there's no flash of the wrong state before JS loads.
- **Client-side**, toggled on click.

Both read from the same PHP `get_state()` / JS `MAB_DATA.state`, so there's never two competing mechanisms fighting each other.

## Hooks used

| Hook | Purpose |
|---|---|
| `plugins_loaded` | Bootstraps the plugin class |
| `init` | Loads text domain |
| `wp_head` / `admin_head` | Prints the early state script (no flash) |
| `wp_footer` / `admin_footer` | Prints the toggle button |
| `wp_enqueue_scripts` / `admin_enqueue_scripts` | Loads JS/CSS, localizes `MAB_DATA` |
| `wp_ajax_save_admin_bar_state` | Saves the toggle state to usermeta |

## Local dev / testing

Symlink or copy the folder into `wp-content/plugins/`, activate it, and check:
- [ ] Toggle click works on both front end and wp-admin
- [ ] State survives a page reload (no flash of the wrong state)
- [ ] State persists across different pages/sessions for the same user
- [ ] Looks right under 782px width (WP's own mobile breakpoint)
- [ ] Animation respects OS-level reduced-motion setting

## Known limitations / not yet built

- No drag-to-reposition (the `position` key in the saved state is a placeholder for this — never wired up).
- No settings/admin UI — intentional, not a gap.
- No multisite-specific testing done yet.

## Author

Bharat Thapa — https://bharatt.com.np