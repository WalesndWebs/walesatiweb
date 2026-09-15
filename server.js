import express from 'express';
import path from 'path';
import { fileURLToPath } from 'url';
import session from 'express-session';
import cookieParser from 'cookie-parser';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const PORT = 3000;

// Body & Cookie Parsing
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());
app.use(session({
  secret: 'wales_webs_secret_key_2025',
  resave: false,
  saveUninitialized: false,
  cookie: { maxAge: 24 * 60 * 60 * 1000 }
}));

// EJS Setup
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Static Files
app.use('/assets', express.static(path.join(__dirname, 'assets')));
app.use(express.static(__dirname));

// ==========================================
// IN-MEMORY DATA STORE
// ==========================================

const caseStudies = [
  {
    id: 1,
    title: 'SkyCapital Digital Onboarding',
    slug: 'skycapital-digital-onboarding',
    category: 'FinTech',
    description: 'End-to-end onboarding system that verifies, assesses, and manages customers seamlessly.',
    challenge: 'Manual onboarding was slow, error-prone, and couldn\'t scale with customer growth.',
    solution: 'Built a fully automated digital onboarding system with KYC verification, document upload, and real-time status tracking.',
    results: 'Reduced onboarding time by 80% while maintaining 99.9% accuracy.',
    metric_1_label: 'Users Onboarded',
    metric_1_value: '10K+',
    metric_2_label: 'Processing Time',
    metric_2_value: '80%',
    metric_3_label: 'Accuracy Rate',
    metric_3_value: '99.9%',
    client_name: 'SkyCapital',
    featured: true,
    status: 'published'
  },
  {
    id: 2,
    title: 'Taste by Edima',
    slug: 'taste-by-edima',
    category: 'Restaurant',
    description: 'Restaurant website with online ordering, gallery, and brand storytelling that boosted customer engagement.',
    challenge: 'No online presence meant missed orders and poor customer engagement.',
    solution: 'Created a modern website with online ordering, photo gallery, reservation system, and integrated payment.',
    results: 'Significant increase in online orders and customer retention.',
    metric_1_label: 'Online Orders',
    metric_1_value: '+65%',
    metric_2_label: 'Engagement',
    metric_2_value: '+120%',
    metric_3_label: 'Repeat Customers',
    metric_3_value: '+85%',
    client_name: 'Taste by Edima',
    featured: true,
    status: 'published'
  },
  {
    id: 3,
    title: 'Laundry Management System',
    slug: 'laundry-management-system',
    category: 'Operations',
    description: 'A complete laundry management solution that automated operations and improved tracking.',
    challenge: 'Manual tracking led to lost items, delayed deliveries, and unhappy customers.',
    solution: 'Built a full management system with order tracking, inventory, customer notifications, and delivery scheduling.',
    results: 'Streamlined operations and improved customer satisfaction dramatically.',
    metric_1_label: 'Orders Managed',
    metric_1_value: '5K+',
    metric_2_label: 'Efficiency',
    metric_2_value: '+70%',
    metric_3_label: 'Customer Satisfaction',
    metric_3_value: '98%',
    client_name: 'FreshPress Laundry',
    featured: true,
    status: 'published'
  },
  {
    id: 4,
    title: 'AdeConcept Corporate Website',
    slug: 'adeconcept-corporate-website',
    category: 'Corporate',
    description: 'A modern corporate website that positions AdeConcept as a trusted printing & branding partner.',
    challenge: 'Outdated website wasn\'t generating leads or reflecting their brand quality.',
    solution: 'Designed and developed a modern, fast, SEO-optimized corporate website with portfolio and contact forms.',
    results: 'Massive increase in lead generation and brand visibility.',
    metric_1_label: 'Leads Generated',
    metric_1_value: '+90%',
    metric_2_label: 'Brand Visibility',
    metric_2_value: '+85%',
    metric_3_label: 'Engagement',
    metric_3_value: '+110%',
    client_name: 'AdeConcept',
    featured: true,
    status: 'published'
  }
];

const posts = [
  {
    id: 1,
    title: 'Why 80% of Business Websites Don\'t Generate Leads (And How to Fix It)',
    slug: 'why-business-websites-dont-generate-leads',
    excerpt: 'Most business websites are just digital brochures. Learn how to turn yours into a lead-generating machine.',
    category: 'Strategy',
    author: 'Wales & Webs Team',
    status: 'published'
  },
  {
    id: 2,
    title: 'The Power of Business Automation: Save Time, Increase Profit',
    slug: 'power-of-business-automation',
    excerpt: 'Discover how automating repetitive tasks can free up your team and boost your bottom line.',
    category: 'Automation',
    author: 'Wales & Webs Team',
    status: 'published'
  },
  {
    id: 3,
    title: 'User Experience Design Principles That Increase Conversions',
    slug: 'ux-design-principles-conversions',
    excerpt: 'Simple UX changes can double your conversion rate. Here are the principles that actually work.',
    category: 'Design',
    author: 'Wales & Webs Team',
    status: 'published'
  },
  {
    id: 4,
    title: 'How Digital Systems Help Businesses Scale Without Chaos',
    slug: 'digital-systems-scale-without-chaos',
    excerpt: 'Scaling a business without proper systems leads to chaos. Here\'s how to do it right.',
    category: 'Growth',
    author: 'Wales & Webs Team',
    status: 'published'
  }
];

const contacts = [
  {
    id: 1,
    name: 'John Doe',
    email: 'john@example.com',
    phone: '+234 801 234 5678',
    company: 'Fintech Corp',
    service_type: 'Web Systems',
    budget: '$5,000 - $10,000',
    message: 'We want to re-architect our user onboarding platform.',
    status: 'new',
    created_at: new Date(Date.now() - 3600000 * 5)
  },
  {
    id: 2,
    name: 'Sarah Connor',
    email: 'sarah@skynet.io',
    phone: '+234 809 876 5432',
    company: 'Automation Labs',
    service_type: 'Automation',
    budget: '$10,000+',
    message: 'Need workflow automation across inventory and sales.',
    status: 'read',
    created_at: new Date(Date.now() - 3600000 * 24)
  }
];

const subscribers = [
  {
    id: 1,
    email: 'alex@startup.io',
    name: 'Alex Vance',
    status: 'active',
    subscribed_at: new Date(Date.now() - 3600000 * 12)
  },
  {
    id: 2,
    email: 'grace@techcompany.com',
    name: 'Grace Hopper',
    status: 'active',
    subscribed_at: new Date(Date.now() - 3600000 * 48)
  }
];

// ==========================================
// ROUTES & CONTROLLERS
// ==========================================

// Homepage
app.get(['/', '/index.php'], (req, res) => {
  const stats = {
    total_contacts: contacts.length,
    total_subscribers: subscribers.length,
    total_case_studies: caseStudies.length,
    total_posts: posts.length
  };
  res.render('index', { caseStudies, posts, stats });
});

// API: Case Studies
app.get(['/api/case-studies', '/api/case-studies.php'], (req, res) => {
  const { slug, category, featured } = req.query;

  if (slug) {
    const cs = caseStudies.find(item => item.slug === slug);
    if (!cs) {
      return res.json({ success: false, message: 'Case study not found' });
    }
    return res.json({ success: true, message: 'Case study fetched', data: cs });
  }

  let filtered = caseStudies.filter(item => item.status === 'published');
  if (category) {
    filtered = filtered.filter(item => item.category.toLowerCase() === category.toLowerCase());
  }
  if (featured) {
    filtered = filtered.filter(item => item.featured);
  }

  res.json({ success: true, message: 'Case studies fetched', data: filtered });
});

// API: Contact Form
app.post(['/api/contact', '/api/contact.php'], (req, res) => {
  const { name, email, phone, company, service_type, budget, message } = req.body;

  if (!name || !email || !message) {
    return res.json({ success: false, message: 'Name, email, and message are required' });
  }

  const newContact = {
    id: contacts.length + 1,
    name: String(name).trim(),
    email: String(email).trim(),
    phone: phone ? String(phone).trim() : '',
    company: company ? String(company).trim() : '',
    service_type: service_type ? String(service_type).trim() : 'General',
    budget: budget ? String(budget).trim() : '',
    message: String(message).trim(),
    status: 'new',
    created_at: new Date()
  };

  contacts.unshift(newContact);

  res.json({
    success: true,
    message: 'Thank you! We will get back to you within 24 hours.',
    data: { id: newContact.id }
  });
});

// API: Newsletter Form
app.post(['/api/newsletter', '/api/newsletter.php'], (req, res) => {
  const { email, name } = req.body;

  if (!email || !email.includes('@')) {
    return res.json({ success: false, message: 'Please enter a valid email address' });
  }

  const existing = subscribers.find(s => s.email.toLowerCase() === email.toLowerCase());
  if (existing) {
    return res.json({ success: false, message: 'You are already subscribed!' });
  }

  const newSub = {
    id: subscribers.length + 1,
    email: String(email).trim(),
    name: name ? String(name).trim() : '',
    status: 'active',
    subscribed_at: new Date()
  };

  subscribers.unshift(newSub);

  res.json({
    success: true,
    message: 'Successfully subscribed! Welcome to the Wales & Webs community.'
  });
});

// API: Stats
app.get(['/api/stats', '/api/stats.php'], (req, res) => {
  const stats = {
    total_contacts: contacts.length,
    new_contacts_week: contacts.filter(c => c.status === 'new').length,
    total_subscribers: subscribers.length,
    total_case_studies: caseStudies.length,
    total_posts: posts.length,
    recent_contacts: contacts.slice(0, 5),
    recent_subscribers: subscribers.slice(0, 5)
  };

  res.json({ success: true, message: 'Stats fetched successfully', data: stats });
});

// Admin Authentication Middleware
function requireAdmin(req, res, next) {
  if (req.session && req.session.adminId) {
    return next();
  }
  res.redirect('/admin/login');
}

// Admin: Login Page
app.get(['/admin', '/admin/', '/admin/index.php', '/admin/login'], (req, res) => {
  if (req.session && req.session.adminId) {
    return res.redirect('/admin/dashboard');
  }
  res.render('admin/login', { error: null });
});

// Admin: Login POST
app.post(['/admin/login', '/admin/index.php'], (req, res) => {
  const { username, password } = req.body;

  if (username === 'admin' && password === 'admin123') {
    req.session.adminId = 1;
    req.session.adminName = 'Super Admin';
    req.session.adminUsername = 'admin';
    return res.redirect('/admin/dashboard');
  }

  res.render('admin/login', { error: 'Invalid username or password' });
});

// Admin: Dashboard
app.get(['/admin/dashboard', '/admin/dashboard.php'], requireAdmin, (req, res) => {
  const stats = {
    contacts: contacts.length,
    new_contacts: contacts.filter(c => c.status === 'new').length,
    subscribers: subscribers.length,
    case_studies: caseStudies.length,
    posts: posts.length
  };

  res.render('admin/dashboard', {
    stats,
    recentContacts: contacts.slice(0, 10),
    recentSubscribers: subscribers.slice(0, 10),
    adminName: req.session.adminName || 'Admin'
  });
});

// Admin: Logout
app.get(['/admin/logout', '/admin/logout.php'], (req, res) => {
  req.session.destroy(() => {
    res.redirect('/admin');
  });
});

// Health check endpoint
app.get('/api/health', (req, res) => {
  res.json({ status: 'ok' });
});

// Start Server on Port 3000
app.listen(PORT, '0.0.0.0', () => {
  console.log(`Wales & Webs app listening on http://0.0.0.0:${PORT}`);
});
