<?php
// Wales & Webs - Header Partial (Hostinger PHP)
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wales & Webs — Digital Systems for Modern Businesses</title>
  <meta name="description" content="We design websites, automate your workflows, manage your social media and help you grow with smart digital solutions built around how your business actually works.">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌐</text></svg>">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Caveat:wght@600;700&display=swap" rel="stylesheet">

  <!-- Stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- Site Navigation Header -->
  <header class="site-header" id="siteHeader">
    <div class="container navbar">
      <div class="nav-container">
        
        <!-- Brand Logo -->
        <a href="index.php" class="brand-logo" id="mainBrandLogo">
          <div class="brand-icon-svg">
            <svg width="34" height="34" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#00f0ff" />
                  <stop offset="50%" stop-color="#3b82f6" />
                  <stop offset="100%" stop-color="#a855f7" />
                </linearGradient>
              </defs>
              <rect width="40" height="40" rx="10" fill="#0d111c" stroke="rgba(255,255,255,0.08)"/>
              <path d="M8 12L14 28L18 18L22 28L28 12" stroke="url(#logoGradient)" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="32" cy="13" r="2.5" fill="#00e599"/>
            </svg>
          </div>
          <div class="brand-text">
            <span class="brand-name">Wales &amp; Webs</span>
            <span class="brand-tagline">Build &middot; Automate &middot; Grow</span>
          </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="nav-links" id="navMenu">
          <a href="#story" class="nav-link">Our Story</a>

          <!-- Services Dropdown -->
          <div class="nav-dropdown">
            <a href="#services" class="nav-link">
              Our Services
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
            </a>
            <div class="dropdown-menu">
              <a href="#services" class="dropdown-item">Websites &amp; E-commerce</a>
              <a href="#services" class="dropdown-item">Business Systems Automation</a>
              <a href="#services" class="dropdown-item">Automation &amp; AI Integration</a>
              <a href="#services" class="dropdown-item">Digital Growth &amp; SEO</a>
              <a href="#services" class="dropdown-item">Client Portal &amp; Support</a>
            </div>
          </div>

          <!-- Resources Dropdown -->
          <div class="nav-dropdown">
            <a href="#resources" class="nav-link">
              Resources
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
            </a>
            <div class="dropdown-menu">
              <a href="#usabime" class="dropdown-item">Usabime Platform</a>
              <a href="#projects" class="dropdown-item">Case Studies</a>
              <a href="#process" class="dropdown-item">Our Work Process</a>
            </div>
          </div>

          <a href="#contact" class="nav-link open-contact-modal">Contact Us</a>
        </nav>

        <!-- Right Header Actions -->
        <div class="nav-actions">
          <a href="#contact" class="btn btn-outline-green btn-client-portal open-contact-modal" id="navClientPortal">Client Portal</a>
          <button type="button" class="btn btn-purple btn-usabime open-usabime-modal" id="navUsabime">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Usabime
          </button>
          <button class="mobile-toggle" id="mobileMenuBtn" aria-label="Toggle Navigation">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
        </div>

      </div>
    </div>
  </header>
