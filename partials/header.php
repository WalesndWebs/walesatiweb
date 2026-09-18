<?php
// Wales & Webs - Header Partial (Hostinger PHP)
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wales & Webs — We Design The Systems That Solve Real Business Problems</title>
  <meta name="description" content="We partner with ambitious businesses to design, build, and automate digital systems that improve operations, enhance customer experience, and drive long-term growth.">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌐</text></svg>">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Caveat:wght@600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- Top Announcement Bar (from fe.jpeg) -->
  <div class="top-announcement-bar" id="topAnnouncement">
    <div class="container announcement-inner">
      <div class="announcement-left">
        <span class="announcement-pill">New Case Study</span>
        <span class="announcement-text">How We Built a Digital Onboarding System That Reduced Processing Time by 80%</span>
      </div>
      <a href="#projects" class="announcement-action">View Case Study &rarr;</a>
    </div>
  </div>

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
            <span class="brand-tagline">Digital Systems. Real Impact.</span>
          </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="nav-links" id="navMenu">
          <a href="index.php" class="nav-link active">Home</a>
          <a href="#story" class="nav-link">Our Story</a>
          <a href="#services" class="nav-link">Services</a>
          <a href="#projects" class="nav-link">Projects</a>
          <a href="blog.php" class="nav-link">Resources</a>
          <a href="#usabime" class="nav-link">About Us</a>
          <a href="#contact" class="nav-link open-contact-modal">Contact</a>
        </nav>

        <!-- Right Header Actions -->
        <div class="nav-actions">
          <a href="#contact" class="btn btn-outline-portal open-contact-modal" id="navClientPortal">Client Portal</a>
          <a href="#contact" class="btn btn-primary-discuss open-contact-modal" id="navDiscussProject">Discuss Your Project &rarr;</a>
          <button class="mobile-toggle" id="mobileMenuBtn" aria-label="Toggle Navigation">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
        </div>

      </div>
    </div>
  </header>
