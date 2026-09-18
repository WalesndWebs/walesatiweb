<?php
// includes/db.php - Wales & Webs Unified Database (MySQL / SQLite PDO)
// Supports MySQL (Hostinger/cPanel) and SQLite (Local container & development)

$db_file = __DIR__ . '/../data/walesandwebs.sqlite';
$data_dir = __DIR__ . '/../data';

if (!is_dir($data_dir)) {
    @mkdir($data_dir, 0777, true);
}

// Database Credentials (Optional MySQL environment variables or fallback to SQLite)
$db_type = getenv('DB_TYPE') ?: (getenv('DB_HOST') ? 'mysql' : 'sqlite');
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'wales_and_webs';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';

$pdo = null;

try {
    if ($db_type === 'mysql' && getenv('DB_HOST')) {
        $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
        $pdo = new PDO($dsn, $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } else {
        // Default to SQLite (Zero-config, fast, durable)
        $dsn = "sqlite:" . $db_file;
        $pdo = new PDO($dsn, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
} catch (PDOException $e) {
    // If MySQL failed, fallback to SQLite
    try {
        $dsn = "sqlite:" . $db_file;
        $pdo = new PDO($dsn, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $ex) {
        die("Database connection failed: " . htmlspecialchars($ex->getMessage()));
    }
}

// Ensure Schema & Seed Data
function init_database($pdo) {
    // 1. Admins Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(150) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 2. Portfolio Projects Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS portfolio (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        client_name VARCHAR(150) NOT NULL,
        tags VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        stats VARCHAR(255) DEFAULT '',
        image_url VARCHAR(255) NOT NULL,
        project_link VARCHAR(255) DEFAULT '#',
        featured INTEGER DEFAULT 1,
        sort_order INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 3. Blog Posts Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS blog_posts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        category VARCHAR(100) DEFAULT 'Strategy',
        excerpt TEXT,
        content TEXT NOT NULL,
        image_url VARCHAR(255) NOT NULL,
        author VARCHAR(100) DEFAULT 'Wales & Webs Team',
        published_date DATE NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Seed default admin if empty
    $checkAdmin = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
    if ($checkAdmin == 0) {
        $adminPass = password_hash('admin123', PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO admins (username, password, email) VALUES (?, ?, ?)");
        $stmt->execute(['admin', $adminPass, 'hello@walesandwebs.com']);
    }

    // Refresh default portfolio projects with exact fe.jpeg showcase
    $pdo->exec("DELETE FROM portfolio");
    $projects = [
        [
            "SkyCapital Digital Onboarding",
            "Fintech",
            "End-to-end onboarding system that verifies, assesses, and manages customers seamlessly.",
            "10K+ Users Onboarded · 80% Processing Time · 99.9% Accuracy",
            "assets/images/case-prodigy.jpg",
            "#",
            1,
            1
        ],
        [
            "Taste by Edima",
            "Restaurant",
            "Restaurant website with online ordering, gallery, and brand storytelling that boosted customer engagement.",
            "65% Online Orders · 120% Engagement · 85% Repeat Customers",
            "assets/images/case-taste.jpg",
            "#",
            1,
            2
        ],
        [
            "Laundry Management System",
            "Operations",
            "A complete laundry management solution that automated operations and improved tracking.",
            "5K+ Orders Managed · 70% Efficiency · 98% Customer Satisfaction",
            "assets/images/case-caroline.jpg",
            "#",
            1,
            3
        ],
        [
            "AdeConcept Corporate Website",
            "Corporate",
            "A modern corporate website that positions AdeConcept as a trusted printing & branding partner.",
            "90% Leads Generated · 85% Brand Visibility · 110% Engagement",
            "assets/images/case-print.jpg",
            "#",
            1,
            4
        ]
    ];

    $stmtProj = $pdo->prepare("INSERT INTO portfolio (client_name, tags, description, stats, image_url, project_link, featured, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($projects as $p) {
        $stmtProj->execute($p);
    }

    // Refresh default blog posts with exact fe.jpeg insights
    $pdo->exec("DELETE FROM blog_posts");
    $blogs = [
        [
            "Why 80% of Business Websites Don't Generate Leads (And How to Fix It)",
            "why-80-percent-business-websites-dont-generate-leads",
            "Strategy",
            "Most business websites look pretty but act like digital brochures. Discover the structural changes needed to convert visits into qualified inbound leads.",
            "<p>Most corporate websites suffer from a fatal flaw: they are designed to look impressive to the owners rather than drive action for prospective buyers...</p><h3>1. The Value Proposition Clarity</h3><p>If a visitor cannot explain what your business does within 5 seconds of loading the header, they will bounce...</p>",
            "assets/images/case-prodigy.jpg",
            "Wales & Webs Team",
            "2025-05-20"
        ],
        [
            "The Power of Business Automation: Save Time, Increase Profit",
            "the-power-of-business-automation-save-time-increase-profit",
            "Technology",
            "Automate repetitive workflows, invoice follow-ups, and onboarding pipelines to reclaim 20+ hours each week while scaling your business capacity.",
            "<p>Automation is no longer an enterprise luxury. Small and mid-size companies are running circles around slower legacy competitors by letting software execute manual steps...</p>",
            "assets/images/case-taste.jpg",
            "Wales & Webs Team",
            "2025-05-15"
        ],
        [
            "User Experience Design Principles That Increase Conversions",
            "user-experience-design-principles-that-increase-conversions",
            "Design",
            "Explore how visual hierarchy, deliberate typography, and reduced cognitive friction dramatically increase booking and checkout conversion rates.",
            "<p>Every additional click, vague label, or excessive form field cuts conversion probability in half. Here is the framework we apply to all client systems...</p>",
            "assets/images/case-caroline.jpg",
            "Wales & Webs Team",
            "2025-05-12"
        ],
        [
            "How Digital Systems Help Businesses Scale Without Chaos",
            "how-digital-systems-help-businesses-scale-without-chaos",
            "Growth",
            "Scaling revenue without standardized digital systems leads to operational burnout. Learn how connected dashboards and client portals maintain quality.",
            "<p>When growth causes chaos, the problem isn't your team—it's your infrastructure. Centralized portals and automated pipelines provide the stability required to 10x your client base...</p>",
            "assets/images/case-print.jpg",
            "Wales & Webs Team",
            "2025-05-05"
        ]
    ];

    $stmtBlog = $pdo->prepare("INSERT INTO blog_posts (title, slug, category, excerpt, content, image_url, author, published_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($blogs as $b) {
        $stmtBlog->execute($b);
    }
}

// Auto-run initialization
init_database($pdo);
