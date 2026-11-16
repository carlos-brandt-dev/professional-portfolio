# Professional Portfolio (PHP)

Academic personal portfolio developed using **PHP, HTML, and CSS**. Includes project information, coursework, certifications, a contact form, and an evaluation form.

## Run locally

Requires PHP 8+ (no database needed). From this folder:

```bash
php -S localhost:8000
```

Open `http://localhost:8000` in your browser. The contact and evaluation forms store submissions in local text files under `data/`. These files are excluded from Git by `.gitignore`. Do not use the PHP development server for public hosting.

## Public-source privacy notes

- Personal documents (résumés, academic plans and certificates) have been omitted. Their on-page labels remain, but the files are not linked.
- Existing contact and evaluation submissions have been removed.
- The original hard-coded administrator password has been removed. To use the private submission-view pages, configure the `PORTFOLIO_ADMIN_PASSWORD` environment variable on your local machine or hosting environment. Never commit a password to Git.
- Contact email links use a professional contact address.

This is a **source-code portfolio**, not a hosted PHP website. GitHub Pages does not execute PHP. The form-storage approach is suitable for a local academic demonstration, not a production contact system.

## Screenshots

### Home
![Portfolio Home](Screenshot%202026-11-16%20161309.png)

### Certifications
![Technical Certifications](Screenshot%202026-11-16%20161333.png)

### Contact
![Contact Form](Screenshot%202026-11-16%20161356.png)

