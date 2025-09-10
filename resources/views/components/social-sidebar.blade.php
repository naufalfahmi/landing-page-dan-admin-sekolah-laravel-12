{{-- 
    Social Media Sidebar Component
    Floating vertical sidebar with social media icons
    
    Features:
    - Fixed position on the right side of screen (sticky/fixed)
    - Floating animation for each icon with staggered delays
    - Hover effect that expands to show labels
    - Mobile responsive design (desktop, tablet, phone)
    - 4 social media platforms: Instagram, TikTok, Facebook, YouTube
    - Accessibility features (focus states, reduced motion support)
    - High contrast mode support
    - Touch-friendly on mobile devices
    
    CSS Classes Used:
    - social-sidebar: Main container with Bootstrap classes
    - social-btn: Individual button styling
    - social-label: Hidden label that appears on hover
    - social-{platform}: Platform-specific color gradients
    
    Responsive Breakpoints:
    - Desktop (1025px+): 60px buttons, 200px expanded width
    - Tablet (769px-1024px): 55px buttons, 180px expanded width  
    - Mobile (576px-768px): 50px buttons, 160px expanded width
    - Small Mobile (≤575px): 45px buttons, 140px expanded width
    
    Animation:
    - Floating effect with 3s duration and staggered delays
    - Smooth hover transitions with cubic-bezier easing
    - Respects user's reduced motion preferences
--}}

@php
    $socialSidebarEnabled = \App\Models\Setting::getValue('social_sidebar_enabled', true);
    $instagramUrl = \App\Models\Setting::getValue('instagram_url', '');
    $tiktokUrl = \App\Models\Setting::getValue('tiktok_url', '');
    $facebookUrl = \App\Models\Setting::getValue('facebook_url', '');
    $youtubeUrl = \App\Models\Setting::getValue('youtube_url', '');
@endphp

@if($socialSidebarEnabled)
<div class="social-sidebar position-fixed top-50 end-0 translate-middle-y me-2 d-flex flex-column gap-3">
    {{-- Instagram --}}
    @if($instagramUrl)
    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="social-btn social-instagram" title="Follow us on Instagram">
        <i class="fab fa-instagram"></i>
        <span class="social-label">Instagram</span>
    </a>
    @endif
    
    {{-- TikTok --}}
    @if($tiktokUrl)
    <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer" class="social-btn social-tiktok" title="Follow us on TikTok">
        <i class="fab fa-tiktok"></i>
        <span class="social-label">TikTok</span>
    </a>
    @endif
    
    {{-- Facebook --}}
    @if($facebookUrl)
    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="social-btn social-facebook" title="Follow us on Facebook">
        <i class="fab fa-facebook-f"></i>
        <span class="social-label">Facebook</span>
    </a>
    @endif
    
    {{-- YouTube --}}
    @if($youtubeUrl)
    <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer" class="social-btn social-youtube" title="Subscribe to our YouTube">
        <i class="fab fa-youtube"></i>
        <span class="social-label">YouTube</span>
    </a>
    @endif
</div>
@endif
