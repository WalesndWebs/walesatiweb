<?php
// api/case-studies.php - Returns projects and case studies for Hostinger
require_once __DIR__ . '/../includes/config.php';
header('Content-Type: application/json');

$caseStudies = [
    [
        'id' => 'carolines-place',
        'title' => "Caroline's Place",
        'category' => 'Website · Booking System · POS',
        'summary' => 'A modern website and booking system for a premium beauty and wellness brand.',
        'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80',
        'client' => 'Caroline M., CEO',
        'results' => ['85% reduction in appointment scheduling time', '3x increase in repeat client bookings']
    ],
    [
        'id' => 'prodigy-group',
        'title' => 'Prodigy Group',
        'category' => 'Website · Client Portal · Automation',
        'summary' => 'Built a professional online presence and client portal for a growing group.',
        'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=600&q=80',
        'client' => 'Tunde A., MD',
        'results' => ['Over 10,000 users processed securely', '75% faster application assessment']
    ],
    [
        'id' => 'taste-by-edima',
        'title' => 'Taste by Edima',
        'category' => 'Website · E-commerce · Social Media',
        'summary' => 'Helped a food brand grow its online presence and increase sales.',
        'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=600&q=80',
        'client' => 'Edima T., Founder',
        'results' => ['+140% direct monthly food orders', '30% savings on third-party aggregator commissions']
    ],
    [
        'id' => 'printmadeasy',
        'title' => 'Printmadeasy',
        'category' => 'Website · E-commerce · SEO',
        'summary' => 'Designed a simple, fast and effective online store for custom printing.',
        'image' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=600&q=80',
        'client' => 'Operations Team',
        'results' => ['Instant checkout for 90% of standard orders', '+220% increase in organic Google search leads']
    ]
];

echo json_encode([
    'success' => true,
    'data' => $caseStudies
]);
