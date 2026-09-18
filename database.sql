-- database.sql - Wales & Webs Database Schema for MySQL / Hostinger / cPanel
-- Import this into phpMyAdmin or your MySQL server

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(150) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(150) NOT NULL,
    tags VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    stats VARCHAR(255) DEFAULT '',
    image_url VARCHAR(255) NOT NULL,
    project_link VARCHAR(255) DEFAULT '#',
    featured TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category VARCHAR(100) DEFAULT 'Strategy',
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    author VARCHAR(100) DEFAULT 'Wales & Webs Team',
    published_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default Admin (username: admin, password: admin123)
INSERT INTO admins (username, password, email) VALUES 
('admin', '$2y$10$K9c3G7L4V9n5X2Y1Z0W8euq4vP6j7T8h5K2p9O1i3A5e7R8t0U4zW', 'hello@walesandwebs.com')
ON DUPLICATE KEY UPDATE username=username;

-- Default Case Studies matching fe.jpeg
INSERT INTO portfolio (client_name, tags, description, stats, image_url, project_link, featured, sort_order) VALUES
("SkyCapital Digital Onboarding", "Fintech", "End-to-end onboarding system that verifies, assesses, and manages customers seamlessly.", "10K+ Users Onboarded · 80% Processing Time · 99.9% Accuracy", "assets/images/case-prodigy.jpg", "#", 1, 1),
("Taste by Edima", "Restaurant", "Restaurant website with online ordering, gallery, and brand storytelling that boosted customer engagement.", "65% Online Orders · 120% Engagement · 85% Repeat Customers", "assets/images/case-taste.jpg", "#", 1, 2),
("Laundry Management System", "Operations", "A complete laundry management solution that automated operations and improved tracking.", "5K+ Orders Managed · 70% Efficiency · 98% Customer Satisfaction", "assets/images/case-caroline.jpg", "#", 1, 3),
("AdeConcept Corporate Website", "Corporate", "A modern corporate website that positions AdeConcept as a trusted printing & branding partner.", "90% Leads Generated · 85% Brand Visibility · 110% Engagement", "assets/images/case-print.jpg", "#", 1, 4)
ON DUPLICATE KEY UPDATE client_name=VALUES(client_name);

-- Default Blog Posts matching fe.jpeg
INSERT INTO blog_posts (title, slug, category, excerpt, content, image_url, author, published_date) VALUES
("Why 80% of Business Websites Don't Generate Leads (And How to Fix It)", "why-80-percent-business-websites-dont-generate-leads", "Strategy", "Most business websites look pretty but act like digital brochures. Discover the structural changes needed to convert visits into qualified inbound leads.", "<p>Most corporate websites suffer from a fatal flaw: they are designed to look impressive to the owners rather than drive action for prospective buyers...</p>", "assets/images/case-prodigy.jpg", "Wales & Webs Team", "2025-05-20"),
("The Power of Business Automation: Save Time, Increase Profit", "the-power-of-business-automation-save-time-increase-profit", "Technology", "Automate repetitive workflows, invoice follow-ups, and onboarding pipelines to reclaim 20+ hours each week while scaling your business capacity.", "<p>Automation is no longer an enterprise luxury. Small and mid-size companies are running circles around slower legacy competitors by letting software execute manual steps...</p>", "assets/images/case-taste.jpg", "Wales & Webs Team", "2025-05-15"),
("User Experience Design Principles That Increase Conversions", "user-experience-design-principles-that-increase-conversions", "Design", "Explore how visual hierarchy, deliberate typography, and reduced cognitive friction dramatically increase booking and checkout conversion rates.", "<p>Every additional click, vague label, or excessive form field cuts conversion probability in half. Here is the framework we apply to all client systems...</p>", "assets/images/case-caroline.jpg", "Wales & Webs Team", "2025-05-12"),
("How Digital Systems Help Businesses Scale Without Chaos", "how-digital-systems-help-businesses-scale-without-chaos", "Growth", "Scaling revenue without standardized digital systems leads to operational burnout. Learn how connected dashboards and client portals maintain quality.", "<p>When growth causes chaos, the problem isn't your team—it's your infrastructure...</p>", "assets/images/case-print.jpg", "Wales & Webs Team", "2025-05-05")
ON DUPLICATE KEY UPDATE slug=slug;
