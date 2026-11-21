# I-Net Infotech admin (UI only)
Open `admin/index.php`. Keep the `admin/` folder next to `index.php` so `../assets/` resolves.

## Pages (each mirrors a page of the new site)
- Home page: top banner, word strip, "Pick your track" posters, certification strip heading, closing banner.
- About: intro, mission/vision/goal, "What we do", "Why I-Net".
- Courses: course list (card + details page fields) and a "Page text" tab (heading, "How it works").
- Services: service list (tabs on the Services page) and "How we work" steps.
- Placements: placed-student photos (dome and home faces strip) and a "Page text" tab.
- Gallery: wall heading and pictures.
- Certifications: logos in the home page strip.
- Contact & footer: Contact page text, plus phones, address, menu and footer used on every page.
- The old Testimonials page was removed because the new design has no testimonials section.

## Data
- `js/content.js` holds the default text of every page (copied from the live site). `load('key')` lays saved edits over it.
- `Store.get/set` in `js/admin.js` use localStorage for the demo (`inet.<key>`). Replace with fetch() to your API; each page has an `API:` comment.
- Keys: home, about, coursesPage, services, pcontent, gallery, contact, site, courses, certs, students.
- Note: the new site pages are static HTML. To make them show admin edits, read the same keys on the site (as `DB()` in js/main.js already does for courses).
