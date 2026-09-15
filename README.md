# Wales & Webs - Frontend

Complete frontend for Wales & Webs digital agency website.

## Tech Stack
- HTML5
- CSS3 (Custom properties, Grid, Flexbox)
- PHP (for includes/partials)
- JavaScript (Vanilla)
- Chart.js (for dashboard charts)

## File Structure
```
wales-and-webs/
├── index.php              # Main page
├── partials/
│   ├── header.php         # Navigation & announcement bar
│   └── footer.php         # Footer & scripts
├── assets/
│   ├── css/
│   │   └── style.css      # All styles
│   ├── js/
│   │   ├── main.js        # Animations & interactions
│   │   └── charts.js      # Dashboard chart configs
│   └── images/            # Upload your images here
```

## How to Run

### Option 1: PHP Server (Recommended)
```bash
cd wales-and-webs
php -S localhost:8000
```
Then open http://localhost:8000

### Option 2: XAMPP / WAMP / MAMP
1. Copy the `wales-and-webs` folder to your `htdocs` directory
2. Start Apache
3. Visit http://localhost/wales-and-webs

### Option 3: Live Server (VS Code)
1. Install "Live Server" extension
2. Right-click on `index.php` → "Open with Live Server"

## Customization

### Colors
Edit CSS variables in `assets/css/style.css`:
```css
:root {
  --accent-green: #10b981;
  --accent-purple: #8b5cf6;
  --bg-primary: #050508;
  --bg-card: #111118;
}
```

### Images
Replace placeholder divs in `index.php` with actual `<img>` tags:
```html
<img src="assets/images/your-image.jpg" alt="Description">
```

### Content
All content is in `index.php`. Edit text directly there.

## Features Included
- Responsive design (mobile, tablet, desktop)
- Dark theme with emerald green accents
- Animated dashboard mockup with Chart.js
- Scroll animations (fade-in)
- Counter animations for stats
- Mobile navigation
- Newsletter form (frontend only)
- Smooth scrolling

## Next Steps
1. Replace placeholder images with real project screenshots
2. Add backend for contact forms
3. Connect newsletter to email service (Mailchimp, etc.)
4. Add actual case study pages
5. Implement Client Portal authentication

---
Built by Wales & Webs
