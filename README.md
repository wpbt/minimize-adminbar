# Minimize Admin Bar

A small WordPress plugin that lets you collapse the admin bar out of view with one click, and bring it back just as fast. Per-user, animated, no settings screen.

## What it does

- A caret toggle button, fixed at the top-left corner, front end and wp-admin both.
- Click it to fade the bar out — the button itself becomes a small round pill in the top-right corner.
- Click the pill to bring the bar back.
- State is saved per-user and persists across page loads, sessions, and devices.
- Fully responsive and respects reduced-motion settings.

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

## Author

Bharat Thapa — https://bharatt.com.np