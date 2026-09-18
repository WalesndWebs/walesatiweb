<?php
/**
 * Wales & Webs — Digital Systems. Real Impact.
 * Official Production Landing Page matching fe.jpeg
 */
require_once __DIR__ . '/includes/db.php';

// Fetch dynamic portfolio projects from database
$portfolio_items = $pdo->query("SELECT * FROM portfolio WHERE featured = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();

// Fetch dynamic recent blog insights from database
$blog_posts = $pdo->query("SELECT * FROM blog_posts ORDER BY published_date DESC LIMIT 4")->fetchAll();

require_once __DIR__ . '/partials/header.php';
?>

  <!-- ========================================================================
       HERO SECTION (from fe.jpeg)
       ======================================================================== -->
  <section class="hero-section" id="hero">
    <div class="hero-glow-bg"></div>
    <div class="container hero-container">
      <div class="hero-grid">

        <!-- Left Column: Copy & CTAs -->
        <div class="hero-content">
          <div class="hero-pill-tag">
            <span class="pulse-dot"></span>
            <span>Digital Systems. Real Impact.</span>
          </div>

          <h1 class="hero-title">
            We Design The Systems That Solve Real Business Problems.
          </h1>

          <p class="hero-description">
            We partner with ambitious businesses to design, build, and automate digital systems that improve operations, enhance customer experience, and drive long-term growth.
          </p>

          <div class="hero-cta-group">
            <a href="#contact" class="btn btn-hero-primary open-contact-modal">
              Discuss Your Business &rarr;
            </a>
            <a href="#projects" class="btn btn-hero-secondary">
              See Our Work &rarr;
            </a>
          </div>

          <div class="hero-trust-indicators">
            <div class="trust-avatar-group">
              <img src="assets/images/avatar-caroline.jpg" alt="Client Avatar" class="trust-avatar" onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=80&h=80&q=80'">
              <img src="assets/images/avatar-tunde.jpg" alt="Client Avatar" class="trust-avatar" onerror="this.src='https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&h=80&q=80'">
              <img src="assets/images/avatar-edima.jpg" alt="Client Avatar" class="trust-avatar" onerror="this.src='https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=80&h=80&q=80'">
            </div>
            <div class="trust-text">
              <strong>Trusted by 50+ businesses</strong>
              <span>Delivering measurable systems &amp; automation</span>
            </div>
          </div>
        </div>

        <!-- Right Column: Interactive 3D System Mockup -->
        <div class="hero-visual-wrapper">
          <div class="system-dashboard-window">
            
            <!-- Window Header -->
            <div class="dashboard-window-bar">
              <div class="window-dots">
                <span class="dot dot-red"></span>
                <span class="dot dot-yellow"></span>
                <span class="dot dot-green"></span>
              </div>
              <div class="window-title">wales-webs-telemetry-live.io</div>
              <div class="window-status-pill">
                <span class="status-indicator live"></span> LIVE
              </div>
            </div>

            <!-- Dashboard Body -->
            <div class="dashboard-window-body">
              
              <!-- Metrics Row -->
              <div class="dash-metrics-grid">
                <div class="dash-metric-card">
                  <span class="dash-label">System Performance</span>
                  <div class="dash-val-row">
                    <span class="dash-value">99.98%</span>
                    <span class="dash-change positive">+0.4%</span>
                  </div>
                  <div class="dash-bar-outer"><div class="dash-bar-inner" style="width: 98%;"></div></div>
                </div>

                <div class="dash-metric-card">
                  <span class="dash-label">Automated Workflows</span>
                  <div class="dash-val-row">
                    <span class="dash-value">1,482</span>
                    <span class="dash-badge active">RUNNING</span>
                  </div>
                  <div class="dash-bar-outer"><div class="dash-bar-inner bar-green" style="width: 86%;"></div></div>
                </div>

                <div class="dash-metric-card">
                  <span class="dash-label">Customer Velocity</span>
                  <div class="dash-val-row">
                    <span class="dash-value">4.2x</span>
                    <span class="dash-change positive">+80%</span>
                  </div>
                  <div class="dash-bar-outer"><div class="dash-bar-inner bar-purple" style="width: 92%;"></div></div>
                </div>
              </div>

              <!-- Main Interactive Graph Simulation -->
              <div class="dash-graph-panel">
                <div class="graph-header">
                  <div>
                    <span class="graph-title">Revenue &amp; Operations Trajectory</span>
                    <span class="graph-sub">Automated Systems vs Manual Legacy</span>
                  </div>
                  <div class="graph-tags">
                    <span class="tag-pill tag-green">● Digital System</span>
                    <span class="tag-pill tag-muted">○ Legacy Manual</span>
                  </div>
                </div>

                <div class="svg-graph-box">
                  <svg viewBox="0 0 500 160" class="graph-svg" preserveAspectRatio="none">
                    <defs>
                      <linearGradient id="curveGlow" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#00e599" stop-opacity="0.35"/>
                        <stop offset="100%" stop-color="#00e599" stop-opacity="0.0"/>
                      </linearGradient>
                      <linearGradient id="lineGrad" x1="0" y1="0" x2="1" y2="0">
                        <stop offset="0%" stop-color="#00f0ff"/>
                        <stop offset="50%" stop-color="#00e599"/>
                        <stop offset="100%" stop-color="#8b5cf6"/>
                      </linearGradient>
                    </defs>
                    <!-- Grid Lines -->
                    <line x1="0" y1="40" x2="500" y2="40" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4"/>
                    <line x1="0" y1="80" x2="500" y2="80" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4"/>
                    <line x1="0" y1="120" x2="500" y2="120" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4"/>
                    
                    <!-- Legacy Line (flat) -->
                    <path d="M 0 130 Q 150 125 280 120 T 500 115" fill="none" stroke="#475569" stroke-width="2" stroke-dasharray="5"/>
                    
                    <!-- Filled Curve -->
                    <path d="M 0 135 Q 120 120 220 70 T 500 15 L 500 160 L 0 160 Z" fill="url(#curveGlow)"/>
                    
                    <!-- Digital System Line -->
                    <path d="M 0 135 Q 120 120 220 70 T 500 15" fill="none" stroke="url(#lineGrad)" stroke-width="3.5" stroke-linecap="round"/>

                    <!-- Pulsing node point -->
                    <circle cx="500" cy="15" r="5" fill="#00e599" />
                    <circle cx="500" cy="15" r="10" fill="none" stroke="#00e599" stroke-width="2" opacity="0.6"/>
                  </svg>
                </div>
              </div>

              <!-- Floating Connected Feature Badges -->
              <div class="dash-connected-nodes">
                <div class="node-pill">
                  <span class="node-icon">⚡</span>
                  <span>Instant Client Onboarding</span>
                </div>
                <div class="node-pill">
                  <span class="node-icon">🔄</span>
                  <span>Real-Time Cloud Synchronization</span>
                </div>
                <div class="node-pill">
                  <span class="node-icon">🛡️</span>
                  <span>Enterprise Security &amp; RBAC</span>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ========================================================================
       METRICS COUNTER ROW (from fe.jpeg)
       ======================================================================== -->
  <section class="metrics-counter-section">
    <div class="container">
      <div class="metrics-counter-grid">
        
        <div class="metric-counter-item">
          <div class="metric-num">50<span class="accent-plus">+</span></div>
          <div class="metric-sublabel">Projects Delivered</div>
        </div>

        <div class="metric-counter-item">
          <div class="metric-num">30<span class="accent-plus">+</span></div>
          <div class="metric-sublabel">Businesses Transformed</div>
        </div>

        <div class="metric-counter-item">
          <div class="metric-num">5<span class="accent-plus">+</span></div>
          <div class="metric-sublabel">Years Of Impact</div>
        </div>

        <div class="metric-counter-item">
          <div class="metric-num">100<span class="accent-plus">%</span></div>
          <div class="metric-sublabel">Client Commitment</div>
        </div>

        <div class="metric-counter-item">
          <div class="metric-num">24<span class="accent-slash">/</span>7</div>
          <div class="metric-sublabel">Support Available</div>
        </div>

      </div>
    </div>
  </section>

  <!-- ========================================================================
       METHODOLOGY SECTION (from fe.jpeg)
       ======================================================================== -->
  <section class="methodology-section" id="story">
    <div class="container">
      <div class="section-center-head">
        <div class="section-eyebrow">OUR METHODOLOGY</div>
        <h2 class="section-title">
          We Don’t Just Build Websites. We Solve Business Problems.
        </h2>
        <p class="section-lead-center">
          Technology without strategic alignment is just overhead. We systematically identify inefficiencies, craft bespoke architectures, and engineer digital systems that compound your growth.
        </p>
      </div>

      <div class="methodology-cards-grid">
        
        <!-- Card 1: Business Problems -->
        <div class="method-card">
          <div class="method-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
          </div>
          <span class="method-step-tag">01 / DIAGNOSIS</span>
          <h3 class="method-title">Business Problems</h3>
          <p class="method-desc">
            Every business faces challenges that slow growth, waste time, and reduce profitability.
          </p>
          <a href="#contact" class="method-link open-contact-modal">Learn More &rarr;</a>
        </div>

        <!-- Card 2: Our Strategy -->
        <div class="method-card">
          <div class="method-icon-wrap icon-purple">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
            </svg>
          </div>
          <span class="method-step-tag">02 / ARCHITECTURE</span>
          <h3 class="method-title">Our Strategy</h3>
          <p class="method-desc">
            We study your processes, understand your goals, and design the right system.
          </p>
          <a href="#contact" class="method-link open-contact-modal">Learn More &rarr;</a>
        </div>

        <!-- Card 3: Technology That Works -->
        <div class="method-card">
          <div class="method-icon-wrap icon-cyan">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="4" y="4" width="16" height="16" rx="2" ry="2"/>
              <rect x="9" y="9" width="6" height="6"/>
              <line x1="9" y1="1" x2="9" y2="4"/>
              <line x1="15" y1="1" x2="15" y2="4"/>
              <line x1="9" y1="20" x2="9" y2="23"/>
              <line x1="15" y1="20" x2="15" y2="23"/>
              <line x1="20" y1="9" x2="23" y2="9"/>
              <line x1="20" y1="14" x2="23" y2="14"/>
              <line x1="1" y1="9" x2="4" y2="9"/>
              <line x1="1" y1="14" x2="4" y2="14"/>
            </svg>
          </div>
          <span class="method-step-tag">03 / EXECUTION</span>
          <h3 class="method-title">Technology That Works</h3>
          <p class="method-desc">
            We build secure, scalable systems that automate, organize, and empower your business.
          </p>
          <a href="#contact" class="method-link open-contact-modal">Learn More &rarr;</a>
        </div>

        <!-- Card 4: Business Transformation -->
        <div class="method-card">
          <div class="method-icon-wrap icon-green">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
              <polyline points="17 6 23 6 23 12"/>
            </svg>
          </div>
          <span class="method-step-tag">04 / COMPOUNDING</span>
          <h3 class="method-title">Business Transformation</h3>
          <p class="method-desc">
            Real transformation. Improved performance, happier customers, sustainable growth.
          </p>
          <a href="#contact" class="method-link open-contact-modal">Learn More &rarr;</a>
        </div>

      </div>
    </div>
  </section>

  <!-- ========================================================================
       FEATURED CASE STUDIES SECTION (from fe.jpeg)
       ======================================================================== -->
  <section class="case-studies-section" id="projects">
    <div class="container">
      
      <div class="two-col-header">
        <div>
          <div class="section-eyebrow">FEATURED CASE STUDIES</div>
          <h2 class="section-title">Real projects. Real results.</h2>
        </div>
        <a href="portfolio.php" class="view-all-link">
          View All Case Studies &rarr;
        </a>
      </div>

      <div class="case-studies-grid">
        <?php if (empty($portfolio_items)): ?>
          <p style="color: var(--text-secondary); text-align: center; grid-column: 1 / -1;">No projects found in database.</p>
        <?php else: ?>
          <?php foreach ($portfolio_items as $project): ?>
            <div class="case-study-card" id="case-item-<?= $project['id'] ?>">
              <div class="case-thumb-box">
                <img src="<?= htmlspecialchars($project['image_url']) ?>" alt="<?= htmlspecialchars($project['client_name']) ?>" class="case-thumb-img" loading="lazy" onerror="this.src='assets/images/case-prodigy.jpg'">
                <div class="case-tag-badge"><?= htmlspecialchars($project['tags']) ?></div>
              </div>
              
              <div class="case-body">
                <h3 class="case-title"><?= htmlspecialchars($project['client_name']) ?></h3>
                <p class="case-description"><?= htmlspecialchars($project['description']) ?></p>

                <?php if (!empty($project['stats'])): ?>
                  <div class="case-stats-row">
                    <?php 
                      $stats_arr = explode('·', $project['stats']);
                      foreach ($stats_arr as $st): 
                    ?>
                      <span class="stat-pill"><?= htmlspecialchars(trim($st)) ?></span>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

                <a href="portfolio.php" class="case-link-btn">
                  View Case Study &rarr;
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

    </div>
  </section>

  <!-- ========================================================================
       THE USABIME PHILOSOPHY SECTION (from fe.jpeg)
       ======================================================================== -->
  <section class="usabime-section" id="usabime">
    <div class="container">
      <div class="usabime-panel-box">
        <div class="usabime-glow-aura"></div>
        
        <div class="usabime-content-center">
          <div class="usabime-logo-badge">
            <span class="logo-dot"></span>
            <span>USABIME PLATFORM &amp; ECOSYSTEM</span>
          </div>

          <h2 class="usabime-title">The Usabime Philosophy</h2>

          <p class="usabime-copy">
            We believe technology should create value for businesses, the people who use it, and the teams who build it.
          </p>

          <!-- The 3 Pillars with Connected Flow -->
          <div class="usabime-pillars-row">
            
            <div class="pillar-card">
              <div class="pillar-icon">👥</div>
              <h4 class="pillar-title">People</h4>
              <p class="pillar-text">Intuitive interfaces and streamlined experiences that teams actually enjoy using daily.</p>
            </div>

            <div class="pillar-connector">
              <svg width="40" height="12" viewBox="0 0 40 12" fill="none">
                <path d="M0 6H38M38 6L32 1M38 6L32 11" stroke="#00e599" stroke-width="1.5" stroke-dasharray="3 3"/>
              </svg>
            </div>

            <div class="pillar-card pillar-featured">
              <div class="pillar-icon">💼</div>
              <h4 class="pillar-title">Business</h4>
              <p class="pillar-text">Automated profitability, reduced operating costs, and scalable operational capacity.</p>
            </div>

            <div class="pillar-connector">
              <svg width="40" height="12" viewBox="0 0 40 12" fill="none">
                <path d="M0 6H38M38 6L32 1M38 6L32 11" stroke="#8b5cf6" stroke-width="1.5" stroke-dasharray="3 3"/>
              </svg>
            </div>

            <div class="pillar-card">
              <div class="pillar-icon">⚡</div>
              <h4 class="pillar-title">Technology</h4>
              <p class="pillar-text">Rock-solid infrastructure, real-time database reactivity, and bulletproof security.</p>
            </div>

          </div>

          <div class="usabime-action-btn">
            <button type="button" class="btn btn-purple btn-usabime open-usabime-modal">
              Learn More About Usabime &rarr;
            </button>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================
       WHAT WE HELP BUSINESSES BUILD (SERVICES GRID - from fe.jpeg)
       ======================================================================== -->
  <section class="services-grid-section" id="services">
    <div class="container">
      
      <div class="section-center-head">
        <div class="section-eyebrow">OUR EXPERTISE</div>
        <h2 class="section-title">What We Help Businesses Build</h2>
        <p class="section-lead-center">
          End-to-end digital solutions engineered to scale your operations, reduce overhead, and accelerate growth.
        </p>
      </div>

      <div class="services-six-grid">
        
        <!-- Service 1: Web Systems -->
        <div class="service-box">
          <div class="service-box-header">
            <div class="service-icon-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="2" y1="12" x2="22" y2="12"/>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
              </svg>
            </div>
            <span class="service-order">01</span>
          </div>
          <h3 class="service-title">Web Systems</h3>
          <p class="service-text">
            High-performing web and web applications that convert visitors into customers.
          </p>
          <a href="#contact" class="service-learn open-contact-modal">Explore Systems &rarr;</a>
        </div>

        <!-- Service 2: Automation -->
        <div class="service-box">
          <div class="service-box-header">
            <div class="service-icon-box icon-green">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="23 4 23 10 17 10"/>
                <polyline points="1 20 1 14 7 14"/>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
              </svg>
            </div>
            <span class="service-order">02</span>
          </div>
          <h3 class="service-title">Automation</h3>
          <p class="service-text">
            Automate workflows, processes, and manual tasks to save time and reduce errors.
          </p>
          <a href="#contact" class="service-learn open-contact-modal">Automate Workflows &rarr;</a>
        </div>

        <!-- Service 3: Mobile Apps -->
        <div class="service-box">
          <div class="service-box-header">
            <div class="service-icon-box icon-purple">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                <line x1="12" y1="18" x2="12.01" y2="18"/>
              </svg>
            </div>
            <span class="service-order">03</span>
          </div>
          <h3 class="service-title">Mobile Apps</h3>
          <p class="service-text">
            Custom mobile applications for iOS and Android that drive customer engagement and loyalty.
          </p>
          <a href="#contact" class="service-learn open-contact-modal">Build Mobile &rarr;</a>
        </div>

        <!-- Service 4: Dashboard Systems -->
        <div class="service-box">
          <div class="service-box-header">
            <div class="service-icon-box icon-cyan">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                <line x1="3" y1="9" x2="21" y2="9"/>
                <line x1="9" y1="21" x2="9" y2="9"/>
              </svg>
            </div>
            <span class="service-order">04</span>
          </div>
          <h3 class="service-title">Dashboard Systems</h3>
          <p class="service-text">
            Real-time dashboards and portals that give you full visibility and command of your business operations.
          </p>
          <a href="#contact" class="service-learn open-contact-modal">View Dashboards &rarr;</a>
        </div>

        <!-- Service 5: Integration -->
        <div class="service-box">
          <div class="service-box-header">
            <div class="service-icon-box icon-orange">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
              </svg>
            </div>
            <span class="service-order">05</span>
          </div>
          <h3 class="service-title">Integration</h3>
          <p class="service-text">
            Connect your tools, payment gateways, accounting systems, and CRM for unified data flow.
          </p>
          <a href="#contact" class="service-learn open-contact-modal">Connect Tools &rarr;</a>
        </div>

        <!-- Service 6: Consulting -->
        <div class="service-box">
          <div class="service-box-header">
            <div class="service-icon-box icon-pink">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
              </svg>
            </div>
            <span class="service-order">06</span>
          </div>
          <h3 class="service-title">Consulting</h3>
          <p class="service-text">
            Business and technology strategy consulting to help you make smarter technical and investment decisions.
          </p>
          <a href="#contact" class="service-learn open-contact-modal">Book Consulting &rarr;</a>
        </div>

      </div>

    </div>
  </section>

  <!-- ========================================================================
       INSIGHTS & RESOURCES SECTION (from fe.jpeg)
       ======================================================================== -->
  <section class="insights-section" id="resources">
    <div class="container">
      
      <div class="two-col-header">
        <div>
          <div class="section-eyebrow">INSIGHTS &amp; RESOURCES</div>
          <h2 class="section-title">Helpful articles, guides, and insights to grow your business.</h2>
        </div>
        <a href="blog.php" class="view-all-link">
          View All Articles &rarr;
        </a>
      </div>

      <div class="insights-layout-grid">
        
        <!-- 4 Blog Cards Grid -->
        <div class="articles-cards-subgrid">
          <?php foreach ($blog_posts as $post): ?>
            <article class="insight-card" id="post-<?= $post['id'] ?>">
              <div class="insight-thumb">
                <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy" onerror="this.src='assets/images/case-prodigy.jpg'">
                <span class="insight-category-badge"><?= htmlspecialchars($post['category'] ?? 'Strategy') ?></span>
              </div>
              <div class="insight-body">
                <div class="insight-meta">
                  <span><?= date('M d, Y', strtotime($post['published_date'])) ?></span>
                  <span>&bull;</span>
                  <span>5 min read</span>
                </div>
                <h3 class="insight-title">
                  <a href="blog-single.php?slug=<?= htmlspecialchars($post['slug']) ?>">
                    <?= htmlspecialchars($post['title']) ?>
                  </a>
                </h3>
                <p class="insight-excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
                <a href="blog-single.php?slug=<?= htmlspecialchars($post['slug']) ?>" class="insight-read-more">
                  Read More &rarr;
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <!-- Newsletter Card Sidebar -->
        <div class="newsletter-sidebar-box">
          <div class="newsletter-box-glow"></div>
          <div class="newsletter-box-content">
            <div class="newsletter-icon-circle">📩</div>
            <h3 class="newsletter-head">Get Insights That Drive Growth</h3>
            <p class="newsletter-sub">
              Subscribe to get the latest tips, automation strategies, and business technology insights delivered directly to your inbox.
            </p>
            
            <form class="newsletter-inline-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Wales & Webs insights!'); this.reset();">
              <div class="newsletter-field-wrap">
                <input type="email" placeholder="Enter your business email" required class="newsletter-input" aria-label="Business Email">
              </div>
              <button type="submit" class="btn btn-primary-green btn-full">
                Subscribe &rarr;
              </button>
            </form>
            <div class="newsletter-privacy-note">
              🔒 No spam ever. Unsubscribe at any time.
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- ========================================================================
       PRE-FOOTER BANNER & TRUST PILLARS (from fe.jpeg)
       ======================================================================== -->
  <section class="prefooter-section" id="contact">
    <div class="container">
      
      <div class="prefooter-banner-card">
        <div class="prefooter-banner-glow"></div>
        <div class="prefooter-banner-content">
          <div class="prefooter-eyebrow">LET’S BUILD TOGETHER</div>
          <h2 class="prefooter-title">Ready to Solve Your Next Business Challenge?</h2>
          <p class="prefooter-subtitle">
            Let’s design and build the right system for your business. We handle the strategy, engineering, and continuous growth.
          </p>
          
          <div class="prefooter-btns">
            <a href="#contact" class="btn btn-primary-green btn-lg open-contact-modal">
              Discuss Your Project &rarr;
            </a>
            <a href="#contact" class="btn btn-outline-white btn-lg open-contact-modal">
              Book a Free Consultation
            </a>
          </div>
        </div>
      </div>

      <!-- 4 Core Benefits Pillars -->
      <div class="trust-pillars-four-grid">
        
        <div class="pillar-benefit-card">
          <div class="pillar-benefit-icon">🤝</div>
          <h4 class="pillar-benefit-title">No Pressure</h4>
          <p class="pillar-benefit-desc">Just a friendly conversation to understand your business needs and bottlenecks.</p>
        </div>

        <div class="pillar-benefit-card">
          <div class="pillar-benefit-icon">🎯</div>
          <h4 class="pillar-benefit-title">Tailored Solutions</h4>
          <p class="pillar-benefit-desc">Custom digital systems designed specifically around how your company operates.</p>
        </div>

        <div class="pillar-benefit-card">
          <div class="pillar-benefit-icon">🌱</div>
          <h4 class="pillar-benefit-title">Long-term Partner</h4>
          <p class="pillar-benefit-desc">We grow with your business, providing active support, maintenance, and scale.</p>
        </div>

        <div class="pillar-benefit-card">
          <div class="pillar-benefit-icon">📈</div>
          <h4 class="pillar-benefit-title">Proven Results</h4>
          <p class="pillar-benefit-desc">Our solutions deliver real impact, reduced operating costs, and measurable revenue.</p>
        </div>

      </div>

    </div>
  </section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
