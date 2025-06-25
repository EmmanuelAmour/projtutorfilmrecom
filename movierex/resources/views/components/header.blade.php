<header class="modern-header">
    <div class="header-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <a href="/" class="logo-link" aria-label="MovieRex - Accueil">
                <div class="logo-wrapper">
                    <img src="{{ asset('img/logo_no_bg.png') }}" alt="MovieRex Logo" class="logo-image" loading="lazy">
                    <h1 class="logo-text">MovieRex</h1>
                </div>
            </a>
        </div>

        <!-- Enhanced Search Bar -->
        <div class="flex-1 min-w-[300px] max-w-xl order-last lg:order-none w-full lg:w-auto">
            <form id="search-form" action="/search/movie/" method="GET" class="relative">
                <input type="text" name="query" id="search-input" placeholder="Rechercher un film..."
                    class="w-full px-4 py-2 rounded-full bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400"
                    aria-label="Recherche">
                <button type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-amber-400 rounded-full hover:bg-amber-500 transition-colors focus:outline-none focus:ring-2 focus:ring-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="sr-only">Rechercher</span>
                </button>
            </form>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Toggle navigation menu"
            aria-expanded="false">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>

        <!-- Navigation and User Section -->
        <div class="nav-user-section" id="nav-user-section">
            <!-- Enhanced Navigation -->
            <nav class="main-navigation" role="navigation" aria-label="Main navigation">
                <div class="nav-links">
                    <a href="/popular" class="nav-link" data-category="popular">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <span>Popular</span>
                    </a>
                    <a href="/upcoming" class="nav-link" data-category="upcoming">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        <span>Upcoming</span>
                    </a>
                    <a href="/trending" class="nav-link" data-category="trending">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <polyline points="22,7 13.5,15.5 8.5,10.5 2,17" />
                            <polyline points="16,7 22,7 22,13" />
                        </svg>
                        <span>Trending</span>
                    </a>


                    <a href=" {{ route('rex.matches') }} " class="nav-link">

                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <span>Rex</span>
                    </a>

                </div>
            </nav>

            <!-- Enhanced User Section -->
            <div class="user-section">
                @auth
                    <!-- Rex Button with Notification Badge -->
                    <!--
                                    <button class="rex-button" id="rex-button" onclick="showNotification()"
                                        aria-label="Rex recommendations">
                                        <svg class="rex-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M9 12l2 2 4-4" />
                                            <path d="M21 12c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z" />
                                            <path d="M3 12c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z" />
                                        </svg>
                                        <span>Rex</span>
                                        <div class="notification-badge" id="rex-badge">3</div>
                                    </button>
                                -->
                    <!-- User Profile Dropdown -->
                    <div class="user-profile-dropdown">
                        <button class="profile-trigger" id="profile-trigger" aria-label="User menu"
                            aria-expanded="false">
                            <div class="user-avatar">
                                <span class="avatar-text">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="user-info">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-status">Premium</span>
                            </div>
                            <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6,9 12,15 18,9" />
                            </svg>
                        </button>

                        <div class="profile-dropdown-menu" id="profile-dropdown-menu" role="menu">
                            <div class="dropdown-header">
                                <div class="user-avatar large">
                                    <span class="avatar-text">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="user-details">
                                    <span class="user-name">{{ Auth::user()->name }}</span>
                                    <span class="user-email">{{ Auth::user()->email }}</span>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <a href="/profile" class="dropdown-item" role="menuitem">
                                <svg class="item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                <span>Profile</span>
                            </a>

                            <a href="/watchlist" class="dropdown-item" role="menuitem">
                                <svg class="item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.29 1.51 4.04 3 5.5l7 7z" />
                                </svg>
                                <span>My List</span>
                            </a>

                            <a href="/settings" class="dropdown-item" role="menuitem">
                                <svg class="item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3" />
                                    <path
                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                                </svg>
                                <span>Settings</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <form method="get" action="{{ route('logout') }}" class="dropdown-form">
                                @csrf
                                <button type="submit" class="dropdown-item logout" role="menuitem">
                                    <svg class="item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16,17 21,12 16,7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Guest User Buttons -->
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="auth-button login-button">
                            <svg class="auth-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <polyline points="10,17 15,12 10,7" />
                                <line x1="15" y1="12" x2="3" y2="12" />
                            </svg>
                            <span>Sign In</span>
                        </a>
                        <a href="{{ route('register') }}" class="auth-button register-button">
                            <svg class="auth-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <line x1="20" y1="8" x2="20" y2="14" />
                                <line x1="23" y1="11" x2="17" y2="11" />
                            </svg>
                            <span>Sign Up</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Search Overlay for Mobile -->
    <div class="search-overlay" id="search-overlay">
        <div class="search-overlay-content">
            <form class="mobile-search-form">
                <input type="text" placeholder="Search movies, series, actors..." class="mobile-search-input"
                    id="mobile-search-input">
                <button type="submit" class="mobile-search-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                </button>
            </form>
            <button class="close-search-overlay" id="close-search-overlay">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
    </div>
</header>

<style>
    /* Modern Header Styles */
    :root {
        --header-height: 80px;
        --primary-color: #f59e0b;
        --primary-hover: #d97706;
        --secondary-color: #6b7280;
        --background-dark: #1f2937;
        --background-darker: #111827;
        --text-primary: #ffffff;
        --text-secondary: #9ca3af;
        --border-color: #374151;
        --shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 12px;
    }

    .modern-header {
        background: linear-gradient(135deg, var(--background-darker) 0%, var(--background-dark) 100%);
        backdrop-filter: blur(20px);
        border-bottom: 2px solid var(--primary-color);
        position: sticky;
        top: 0;
        z-index: 1000;
        height: var(--header-height);
        box-shadow: var(--shadow-lg);
    }

    .header-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    /* Logo Section */
    .logo-section {
        flex-shrink: 0;
    }

    .logo-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: var(--transition);
        border-radius: var(--border-radius);
        padding: 0.5rem;
    }

    .logo-link:hover {
        transform: scale(1.05);
    }

    .logo-link:focus-visible {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    .logo-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .logo-image {
        width: 40px;
        height: 40px;
        border-radius: 8px;
    }

    .logo-text {
        font-size: 1.875rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-color), #ea580c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }

    /* Enhanced Search Section */
    .search-section {
        flex: 1;
        max-width: 600px;
        position: relative;
    }

    .search-form {
        position: relative;
        width: 100%;
    }

    .search-wrapper {
        display: flex;
        align-items: center;
        background: rgba(55, 65, 81, 0.8);
        backdrop-filter: blur(10px);
        border: 2px solid transparent;
        border-radius: 50px;
        transition: var(--transition);
        overflow: hidden;
    }

    .search-wrapper:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
    }

    .search-input-container {
        flex: 1;
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        width: 20px;
        height: 20px;
        color: var(--text-secondary);
        z-index: 2;
    }

    .search-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        background: transparent;
        border: none;
        color: var(--text-primary);
        font-size: 1rem;
        outline: none;
    }

    .search-input::placeholder {
        color: var(--text-secondary);
    }

    .clear-button {
        position: absolute;
        right: 0.5rem;
        width: 32px;
        height: 32px;
        background: rgba(107, 114, 128, 0.5);
        border: none;
        border-radius: 50%;
        color: var(--text-secondary);
        cursor: pointer;
        transition: var(--transition);
        display: none;
        align-items: center;
        justify-content: center;
    }

    .clear-button.show {
        display: flex;
    }

    .clear-button:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .clear-button svg {
        width: 16px;
        height: 16px;
    }

    .search-submit {
        padding: 0.875rem 1.25rem;
        background: var(--primary-color);
        border: none;
        color: #000;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-submit:hover {
        background: var(--primary-hover);
    }

    .search-submit svg {
        width: 20px;
        height: 20px;
    }

    /* Search Suggestions */
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--background-dark);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        margin-top: 0.5rem;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: var(--shadow-lg);
    }

    .search-suggestions.show {
        display: block;
    }

    .suggestion-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: var(--transition);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .suggestion-item:hover {
        background: rgba(245, 158, 11, 0.1);
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    /* Mobile Menu Toggle */
    .mobile-menu-toggle {
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
        gap: 4px;
    }

    .hamburger-line {
        width: 24px;
        height: 2px;
        background: var(--text-primary);
        transition: var(--transition);
        border-radius: 2px;
    }

    .mobile-menu-toggle[aria-expanded="true"] .hamburger-line:nth-child(1) {
        transform: rotate(45deg) translate(6px, 6px);
    }

    .mobile-menu-toggle[aria-expanded="true"] .hamburger-line:nth-child(2) {
        opacity: 0;
    }

    .mobile-menu-toggle[aria-expanded="true"] .hamburger-line:nth-child(3) {
        transform: rotate(-45deg) translate(6px, -6px);
    }

    /* Navigation and User Section */
    .nav-user-section {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    /* Enhanced Navigation */
    .main-navigation {
        display: flex;
    }

    .nav-links {
        display: flex;
        gap: 0.5rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        color: var(--text-primary);
        text-decoration: none;
        border-radius: var(--border-radius);
        transition: var(--transition);
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.1), transparent);
        transition: var(--transition);
    }

    .nav-link:hover::before {
        left: 100%;
    }

    .nav-link:hover {
        color: var(--primary-color);
        background: rgba(245, 158, 11, 0.1);
        transform: translateY(-2px);
    }

    .nav-icon {
        width: 18px;
        height: 18px;
        transition: var(--transition);
    }

    .nav-link:hover .nav-icon {
        transform: scale(1.1);
    }

    /* User Section */
    .user-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Rex Button */
    .rex-button {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, #eab308, #ca8a04);
        color: #000;
        border: none;
        border-radius: var(--border-radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }

    .rex-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(234, 179, 8, 0.4);
    }

    .rex-icon {
        width: 18px;
        height: 18px;
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444;
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        min-width: 20px;
        text-align: center;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    /* User Profile Dropdown */
    .user-profile-dropdown {
        position: relative;
    }

    .profile-trigger {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem;
        background: transparent;
        border: 2px solid transparent;
        border-radius: var(--border-radius);
        color: var(--text-primary);
        cursor: pointer;
        transition: var(--transition);
    }

    .profile-trigger:hover {
        border-color: var(--primary-color);
        background: rgba(245, 158, 11, 0.1);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #000;
    }

    .user-avatar.large {
        width: 48px;
        height: 48px;
    }

    .avatar-text {
        font-size: 1.125rem;
        text-transform: uppercase;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.875rem;
    }

    .user-status {
        font-size: 0.75rem;
        color: var(--primary-color);
        font-weight: 500;
    }

    .dropdown-arrow {
        width: 16px;
        height: 16px;
        transition: var(--transition);
    }

    .profile-trigger[aria-expanded="true"] .dropdown-arrow {
        transform: rotate(180deg);
    }

    /* Dropdown Menu */
    .profile-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        width: 280px;
        background: var(--background-dark);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: var(--transition);
        margin-top: 0.5rem;
    }

    .profile-dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-header {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        background: rgba(245, 158, 11, 0.1);
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-email {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .dropdown-divider {
        height: 1px;
        background: var(--border-color);
        margin: 0.5rem 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1.5rem;
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .dropdown-item:hover {
        background: rgba(245, 158, 11, 0.1);
        color: var(--primary-color);
    }

    .dropdown-item.logout:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .item-icon {
        width: 18px;
        height: 18px;
    }

    .dropdown-form {
        width: 100%;
    }

    /* Auth Buttons */
    .auth-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .auth-button {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        font-size: 0.875rem;
    }

    .login-button {
        background: var(--primary-color);
        color: #000;
    }

    .login-button:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
    }

    .register-button {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .register-button:hover {
        background: var(--primary-color);
        color: #000;
        transform: translateY(-2px);
    }

    .auth-icon {
        width: 18px;
        height: 18px;
    }

    /* Search Overlay for Mobile */
    .search-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(10px);
        z-index: 2000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .search-overlay.show {
        display: flex;
    }

    .search-overlay-content {
        width: 100%;
        max-width: 500px;
        position: relative;
    }

    .mobile-search-form {
        display: flex;
        background: var(--background-dark);
        border-radius: 50px;
        overflow: hidden;
        border: 2px solid var(--primary-color);
    }

    .mobile-search-input {
        flex: 1;
        padding: 1rem 1.5rem;
        background: transparent;
        border: none;
        color: var(--text-primary);
        font-size: 1.125rem;
        outline: none;
    }

    .mobile-search-input::placeholder {
        color: var(--text-secondary);
    }

    .mobile-search-submit {
        padding: 1rem 1.5rem;
        background: var(--primary-color);
        border: none;
        color: #000;
        cursor: pointer;
    }

    .mobile-search-submit svg {
        width: 24px;
        height: 24px;
    }

    .close-search-overlay {
        position: absolute;
        top: -60px;
        right: 0;
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 50%;
        color: var(--text-primary);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-search-overlay svg {
        width: 24px;
        height: 24px;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .nav-links {
            gap: 0.25rem;
        }

        .nav-link span {
            display: none;
        }

        .nav-link {
            padding: 0.75rem;
        }
    }

    @media (max-width: 768px) {
        .header-container {
            padding: 0 0.75rem;
        }

        .search-section {
            display: none;
        }

        .mobile-menu-toggle {
            display: flex;
        }

        .nav-user-section {
            position: fixed;
            top: var(--header-height);
            left: 0;
            right: 0;
            background: var(--background-darker);
            border-top: 1px solid var(--border-color);
            padding: 1rem;
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
            max-height: calc(100vh - var(--header-height));
            overflow-y: auto;
        }

        .nav-user-section.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .main-navigation {
            width: 100%;
        }

        .nav-links {
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-link {
            padding: 1rem;
            justify-content: flex-start;
        }

        .nav-link span {
            display: inline;
        }

        .user-section {
            width: 100%;
            justify-content: center;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .auth-buttons {
            width: 100%;
            justify-content: center;
        }

        .auth-button {
            flex: 1;
            justify-content: center;
        }

        .profile-dropdown-menu {
            position: fixed;
            top: var(--header-height);
            left: 1rem;
            right: 1rem;
            width: auto;
        }
    }

    /* Utility Classes */
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Focus Styles */
    *:focus-visible {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }
</style>

<script>
    // Enhanced Header JavaScript
    class ModernHeader {
        constructor() {
            this.searchInput = document.getElementById('search-input');
            this.searchForm = document.getElementById('search-form');
            this.clearButton = document.getElementById('clear-search');
            this.searchSuggestions = document.getElementById('search-suggestions');
            this.mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            this.navUserSection = document.getElementById('nav-user-section');
            this.profileTrigger = document.getElementById('profile-trigger');
            this.profileDropdown = document.getElementById('profile-dropdown-menu');
            this.searchOverlay = document.getElementById('search-overlay');
            this.closeSearchOverlay = document.getElementById('close-search-overlay');
            this.mobileSearchInput = document.getElementById('mobile-search-input');

            this.debounceTimer = null;
            this.isDropdownOpen = false;
            this.isMobileMenuOpen = false;

            this.init();
        }

        init() {
            this.setupSearch();
            this.setupMobileMenu();
            this.setupProfileDropdown();
            this.setupKeyboardNavigation();
            this.setupClickOutside();
        }

        setupSearch() {
            if (!this.searchInput || !this.searchForm) return;

            // Enhanced search form submission
            this.searchForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleSearch();
            });

            // Real-time search suggestions
            this.searchInput.addEventListener('input', (e) => {
                this.handleSearchInput(e.target.value);
            });

            // Clear button functionality
            if (this.clearButton) {
                this.clearButton.addEventListener('click', () => {
                    this.clearSearch();
                });
            }

            // Mobile search overlay
            if (this.closeSearchOverlay) {
                this.closeSearchOverlay.addEventListener('click', () => {
                    this.closeSearchOverlay();
                });
            }
        }

        handleSearch() {
            const query = this.searchInput.value.trim();
            if (query) {
                // Add loading state
                this.searchForm.classList.add('loading');

                // Redirect to search results
                window.location.href = `/search/movie/${encodeURIComponent(query)}`;
            } else {
                this.showSearchError();
            }
        }

        handleSearchInput(value) {
            // Show/hide clear button
            if (this.clearButton) {
                this.clearButton.classList.toggle('show', value.length > 0);
            }

            // Debounced search suggestions
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                if (value.length >= 2) {
                    this.fetchSearchSuggestions(value);
                } else {
                    this.hideSearchSuggestions();
                }
            }, 300);
        }

        async fetchSearchSuggestions(query) {
            try {
                // Simulate API call - replace with your actual endpoint
                const response = await fetch(`/api/search/suggestions?q=${encodeURIComponent(query)}`);
                const suggestions = await response.json();
                this.showSearchSuggestions(suggestions);
            } catch (error) {
                console.error('Failed to fetch suggestions:', error);
            }
        }

        showSearchSuggestions(suggestions) {
            if (!this.searchSuggestions || !suggestions.length) return;

            this.searchSuggestions.innerHTML = suggestions.map(item => `
                <div class="suggestion-item" data-id="${item.id}" data-type="${item.type}">
                    <img src="${item.poster}" alt="${item.title}" width="40" height="60" style="border-radius: 4px;">
                    <div>
                        <div style="font-weight: 600;">${item.title}</div>
                        <div style="font-size: 0.875rem; color: var(--text-secondary);">${item.year} • ${item.type}</div>
                    </div>
                </div>
            `).join('');

            this.searchSuggestions.classList.add('show');

            // Add click handlers to suggestions
            this.searchSuggestions.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', () => {
                    const id = item.dataset.id;
                    const type = item.dataset.type;
                    window.location.href = `/${type}/${id}`;
                });
            });
        }

        hideSearchSuggestions() {
            if (this.searchSuggestions) {
                this.searchSuggestions.classList.remove('show');
            }
        }

        clearSearch() {
            if (this.searchInput) {
                this.searchInput.value = '';
                this.searchInput.focus();
                this.clearButton.classList.remove('show');
                this.hideSearchSuggestions();
            }
        }

        showSearchError() {
            this.searchInput.focus();
            this.searchInput.style.borderColor = '#ef4444';
            this.searchForm.classList.add('error');

            setTimeout(() => {
                this.searchInput.style.borderColor = '';
                this.searchForm.classList.remove('error');
            }, 2000);
        }

        setupMobileMenu() {
            if (!this.mobileMenuToggle || !this.navUserSection) return;

            this.mobileMenuToggle.addEventListener('click', () => {
                this.toggleMobileMenu();
            });
        }

        toggleMobileMenu() {
            this.isMobileMenuOpen = !this.isMobileMenuOpen;

            this.mobileMenuToggle.setAttribute('aria-expanded', this.isMobileMenuOpen);
            this.navUserSection.classList.toggle('show', this.isMobileMenuOpen);

            // Prevent body scroll when menu is open
            document.body.style.overflow = this.isMobileMenuOpen ? 'hidden' : '';
        }

        setupProfileDropdown() {
            if (!this.profileTrigger || !this.profileDropdown) return;

            this.profileTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleProfileDropdown();
            });
        }

        toggleProfileDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;

            this.profileTrigger.setAttribute('aria-expanded', this.isDropdownOpen);
            this.profileDropdown.classList.toggle('show', this.isDropdownOpen);
        }

        setupKeyboardNavigation() {
            // Escape key handling
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (this.isDropdownOpen) {
                        this.toggleProfileDropdown();
                    }
                    if (this.isMobileMenuOpen) {
                        this.toggleMobileMenu();
                    }
                    this.hideSearchSuggestions();
                }
            });

            // Arrow key navigation for search suggestions
            if (this.searchInput) {
                this.searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                        e.preventDefault();
                        this.navigateSuggestions(e.key === 'ArrowDown' ? 1 : -1);
                    }
                });
            }
        }

        navigateSuggestions(direction) {
            const suggestions = this.searchSuggestions.querySelectorAll('.suggestion-item');
            if (!suggestions.length) return;

            const current = this.searchSuggestions.querySelector('.suggestion-item.active');
            let index = current ? Array.from(suggestions).indexOf(current) : -1;

            // Remove current active state
            if (current) current.classList.remove('active');

            // Calculate new index
            index += direction;
            if (index < 0) index = suggestions.length - 1;
            if (index >= suggestions.length) index = 0;

            // Add active state to new item
            suggestions[index].classList.add('active');
            suggestions[index].scrollIntoView({
                block: 'nearest'
            });
        }

        setupClickOutside() {
            document.addEventListener('click', (e) => {
                // Close profile dropdown
                if (this.isDropdownOpen && !this.profileTrigger.contains(e.target)) {
                    this.toggleProfileDropdown();
                }

                // Close search suggestions
                if (!this.searchForm.contains(e.target)) {
                    this.hideSearchSuggestions();
                }

                // Close mobile menu
                if (this.isMobileMenuOpen && !this.navUserSection.contains(e.target) && !this
                    .mobileMenuToggle.contains(e.target)) {
                    this.toggleMobileMenu();
                }
            });
        }

        showSearchOverlay() {
            if (this.searchOverlay) {
                this.searchOverlay.classList.add('show');
                if (this.mobileSearchInput) {
                    this.mobileSearchInput.focus();
                }
            }
        }

        closeSearchOverlay() {
            if (this.searchOverlay) {
                this.searchOverlay.classList.remove('show');
            }
        }
    }

    // Rex notification function (preserved from original)
    function showNotification() {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'rex-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <div class="notification-icon">🎬</div>
                <div class="notification-text">
                    <strong>Rex Recommendations</strong>
                    <p>3 new personalized movie suggestions available!</p>
                </div>
                <button class="notification-close">&times;</button>
            </div>
        `;

        // Add styles
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: linear-gradient(135deg, #f59e0b, #ea580c);
            color: #000;
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            z-index: 2000;
            max-width: 300px;
            animation: slideInRight 0.3s ease-out;
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => notification.remove(), 300);
        }, 5000);

        // Close button functionality
        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.remove();
        });

        // Update badge count
        const badge = document.getElementById('rex-badge');
        if (badge) {
            badge.textContent = '0';
            badge.style.display = 'none';
        }
    }

    // Initialize header when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        new ModernHeader();
        console.log('Modern header initialized successfully!');
    });

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        .rex-notification .notification-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .rex-notification .notification-icon {
            font-size: 2rem;
        }
        
        .rex-notification .notification-text strong {
            display: block;
            margin-bottom: 0.25rem;
        }
        
        .rex-notification .notification-text p {
            margin: 0;
            font-size: 0.875rem;
            opacity: 0.8;
        }
        
        .rex-notification .notification-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            margin-left: auto;
        }
    `;
    document.head.appendChild(style);
</script>
