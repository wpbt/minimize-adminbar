=== Minimize Admin Bar ===
Contributors: bharatthapa
Tags: admin bar, toolbar, distraction free, productivity, minimal
Requires at least: 6.9
Tested up to: 7.1
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Tuck the WordPress admin bar out of the way with one click, and get it back just as fast.

== Description ==

The WordPress admin bar is useful, but it's not always something you want staring back at you while you're focused on content, design, or client work. Minimize Admin Bar adds a single small toggle that lets you collapse the bar out of view, and bring it back the moment you need it.

**How it works**

* A small caret button sits at the top-left corner of the screen, right where the admin bar begins.
* Click it, and the entire admin bar fades away — the button itself slides into a compact pill in the top-right corner instead.
* Click that pill, and the bar smoothly returns.
* Your preference is remembered per user, so it stays exactly how you left it the next time you log in — on any page, front end or admin.

**Built to stay out of the way**

* No settings screen, no configuration, no bloat — it does one thing.
* Smooth, subtle animation on both hide and show, with full respect for the `prefers-reduced-motion` setting for anyone who's asked their system to limit motion.
* Matches WordPress's own responsive behavior, so it looks and works correctly on mobile screens too, not just desktop.
* The toggle button lives independently of the admin bar's own markup, so it isn't affected by themes or plugins that customize the bar itself.

**Who this is for**

Developers, designers, and anyone who spends long stretches working directly on the front end of a site and would rather see their content without a bar running across the top of it — while still being one click away from getting it back.

== Installation ==

1. Upload the `minimize-adminbar` folder to `/wp-content/plugins/`, or install the plugin zip directly through **Plugins → Add New → Upload Plugin** in your WordPress dashboard.
2. Activate the plugin through the **Plugins** screen.
3. Look for the small caret button at the top-left of your screen — click it to collapse the admin bar, and click the pill that appears in the top-right corner to bring it back.

No configuration is required.

== Frequently Asked Questions ==

= Does this remove the admin bar for all users? =

No. The hidden/shown state is saved per user, so each person's preference is their own — hiding it for yourself doesn't affect anyone else on the site.

= Does this work on the front end of the site, not just wp-admin? =

Yes. The toggle appears anywhere the admin bar itself would normally show, on both the front end and in the dashboard.

= Will this conflict with other plugins that customize the admin bar? =

It shouldn't. The toggle button is rendered independently of the admin bar's own menu structure, so it doesn't rely on — or interfere with — items other plugins add to the bar.

= Does this permanently disable the admin bar? =

No. It's a visual toggle only. Nothing about the "Show Toolbar" user profile setting or the admin bar's normal behavior is changed — this just gives you a fast, animated way to tuck it away and bring it back.

= What happens to my saved preference if I uninstall the plugin? =

Uninstalling the plugin (not just deactivating it) removes the saved preference for every user, along with everything else the plugin added.

== Screenshots ==

1. The toggle button in its default position, top-left of the admin bar.
2. The admin bar collapsed, with the toggle now a small pill in the top-right corner.

== Changelog ==

= 1.0.0 =
* Initial release: toggle button, animated hide/show, per-user persistence, mobile-responsive sizing, and reduced-motion support.

== Upgrade Notice ==

= 1.0.0 =
Initial release.