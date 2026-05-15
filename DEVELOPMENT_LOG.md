# LGSL Development Log

## 2026-05-15

- Fixed Turkish language coverage in `lgsl_files/languages/turkish.php` so it matches the English language key set.
- Improved Turkish translations for several visible labels and status strings.
- Hardened `install.php` by validating the table name before using it in `CREATE TABLE`.
- Escaped installer form values before rendering them into HTML.
- Safely encoded installer values before rendering them into JavaScript.
- Improved several Turkish strings in the installer language dictionary.
- Added `HttpOnly` protection to the admin authentication cookie in `admin.php`.
- Fixed invalid admin login form markup by closing the table before the form wrapper ends.
- Added `lgsl_files/styles/modern_style.css` as a new responsive modern theme.
- Added `lgsl_files/scripts/modern.js` for modern-theme UI enhancements such as mobile table labels and player bar animation.
- Extended the Modern theme with page/menu entrance animation, staggered server-card animation, status pulse/wait effects, hover lift, icon motion, row highlights, and reduced-motion support.
- Refined Modern theme link styling so button-like controls, menu links, server-name links, address pills, pagination, and detail icons do not show unwanted underlines.
- Added extra Modern theme interaction polish for buttons, address pills, server-card glow, and hover motion.
- Reworked Modern theme mobile layout into responsive server cards with grid areas for name, status, address, map, players, and details.
- Added mobile overflow handling for long server names, Unicode names, and IP/port pills.
- Improved mobile admin/details/table spacing so controls fit within narrow screens.
- Fixed duplicated server names in the Modern theme by hiding the non-link server-name copy and keeping the clickable name.
- Expanded the Modern theme desktop layout to a wider 1360px page width with fixed list column sizing for a more spacious server table.
- Added the Modern theme to the installer style selector, generated config comments, and debug style selector.
- Updated the local web server test setup to use the Modern theme and Modern UI enhancements by default.
- Completed missing localization keys across all language files so every language now has the same 81 text keys as English.
- Added `utf8mb4` database/connection support for improved Unicode server names.
- Added local database seeding for 15 CS 1.6 servers.
- Updated the local web server test setup so it refreshes the web root, prepares the DB, and seeds the server list.
- Added shared server-list column definitions to keep the table header and content aligned.
- Expanded the Modern theme desktop width to 1480px and aligned status, address, map, players, and details columns through `colgroup`.
- Strengthened the Modern theme duplicate-name fix so only the clickable server name is visible.
- Re-verified local UTF-8 output for seeded Unicode server names without mojibake.
- Improved the Modern theme details page with a wider responsive layout, stronger map preview panel, cleaner info blocks, and polished expandable sections.
- Reworked the Modern server list desktop layout so rows use the full available page width instead of stopping before the right edge.
- Added a Modern theme hamburger navigation for mobile while keeping the desktop navigation as a polished horizontal menu.
- Replaced the Modern theme admin corner link with a responsive profile control: login button for guests and avatar dropdown for authenticated admins.
- Added optional server-list filters for map, mode, game, type, player occupancy, and search.
- Exposed server-list filters in the installer config generation.
- Added localized filter labels across all bundled languages.
- Added a Classic Counter-Strike 1.6 map catalog and common mode labels for Modern theme filters.
- Connected filter game/type options to LGSL's existing `lgsl_protocol.php` game/protocol metadata.
- Refined the Modern theme status/address columns so mobile rows use smaller status icons and long IP addresses stay on one line.
- Updated Modern filter input/select styling with compact toolbar controls, focus states, and mobile-friendly spacing.
- Redesigned the Modern theme admin page with a dedicated header, profile dropdown, hero area, card-like content shell, and polished management tables/forms.
- Added localized Modern admin header/profile labels across all bundled languages.
- Added a Modern theme footer with project/about text, version link, license badge text, and localized footer copy.
- Updated LGSL version references from 6.2.1 to 6.2.2.
- Updated README changelog for v6.2.2 with Modern theme, filters, admin redesign, localization, UTF-8, installer, and security improvements.
- Confirmed the deployment/default language in the source config remains English.

## Local Web Server Test Setup

- A local web server test environment is available for browser testing.
- LGSL project files are copied into the local web root for testing.
- The original local web root demo files were moved into a backup folder.
- Updated the local PHP configuration for PHP 8 compatibility.
- Verified the local web server target responds at `http://localhost/` with the LGSL page.
- Verified edited PHP files with the local PHP CLI.
- Found the local MySQL password for the test environment.
- Created the local `lgsl` database and `lgsl` table for testing.
- Updated the local test copy config to use the local database password.
- Added a local setup helper to refresh the test web root and recreate the local database/table automatically.
- Verified the Modern theme loads at `http://localhost/` with local language text and no AJAX request error.
- Verified updated Modern theme assets load with the new animation layer.
- Verified the seeded server list appears on `http://localhost/` without AJAX errors.
- Verified the Modern mobile layout at 390px width: 15 server cards, generated mobile labels, and no AJAX errors.
- Verified the duplicate-name fix in browser: `.servername_nolink` is hidden and `.servername_link` remains visible for all seeded rows.
- Keep `install.php` only while installing or testing locally; remove it from a public server after setup.
