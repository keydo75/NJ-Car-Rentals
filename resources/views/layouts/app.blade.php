<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="NJ Car Rentals - Premium car rental and buy-and-sell services in Olongapo. Wide selection of well-maintained vehicles.">
    <title>@yield('title') - NJ Car Rentals</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('styles')
</head>

<body class="theme-transition">
<div id="top"></div>

<!-- Enhanced Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/njcarrentallogo-removebg-preview.png') }}" alt="NJ Car Rentals" class="brand-logo me-3">
            <span class="brand-name">Car Rentals</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vehicles.rental*') ? 'active' : '' }}" href="{{ route('vehicles.rental') }}">
                        <i class="bi bi-car-front me-1"></i> For Rent
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vehicles.sale*') ? 'active' : '' }}" href="{{ route('vehicles.sale') }}">
                        <i class="bi bi-tag me-1"></i> For Sale
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="bi bi-envelope me-1"></i> Contact
                    </a>
                </li>
            </ul>

            <!-- Search Form -->
            <form class="d-flex me-3" role="search" method="GET" action="{{ route('vehicles.index') }}">
                <div class="input-group">
                    <input class="form-control" type="search" name="q" placeholder="Search vehicles..." aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- User Menu -->
            <div class="d-flex align-items-center gap-3">
                <!-- Chat Notification Bell -->
                @if(auth()->guard('customer')->check() || auth()->guard('admin')->check() || auth()->guard('staff')->check())
                <div class="notification-bell">
                    <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false" id="chatNotificationBtn">
                        <i class="bi bi-bell" style="font-size: 1.3rem;"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none;">
                            <span id="notificationCount">0</span>
                        </a>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown" style="width: 320px; max-height: 400px; overflow-y: auto;">
                        <div class="dropdown-header d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-bell me-2"></i>Notifications</span>
                        </div>
                        <div id="notificationList">
                            <div class="dropdown-item text-muted text-center py-3">
                                <i class="bi bi-bell-slash d-block mb-2" style="font-size: 1.5rem; opacity: 0.5;"></i>
                                No new notifications
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center text-primary" href="{{ auth()->guard('customer')->check() ? route('customer.chat') : route('admin.chat') }}">
                            <i class="bi bi-chat-dots me-1"></i>View All Messages
                        </a>
                    </div>
                </div>
                @endif
                
                @if(auth()->guard('customer')->check())
                    <!-- Customer Logged In -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <span class="d-none d-lg-inline">{{ auth()->guard('customer')->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="bi bi-person-circle me-2"></i>{{ auth()->guard('customer')->user()->name }}
                                </h6>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.bookings') }}">
                                <i class="bi bi-calendar-check me-2"></i>My Bookings
                            </a></li>

                            <li><a class="dropdown-item" href="{{ route('customer.chat') }}">
                                <i class="bi bi-chat-dots me-2"></i>Chat with Support
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('vehicles.rental') }}">
                                <i class="bi bi-car-front me-2"></i>Rent a Car
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('vehicles.sale') }}">
                                <i class="bi bi-tag me-2"></i>Buy a Car
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @elseif(auth()->guard('admin')->check())
                    <!-- Admin Logged In -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle admin">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <span class="d-none d-lg-inline">{{ auth()->guard('admin')->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="bi bi-shield-check me-2"></i>Administrator
                                </h6>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.chat') }}">
                                <i class="bi bi-chat-dots me-2"></i>Chat with Customers
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @elseif(auth()->guard('staff')->check())
                    <!-- Staff Logged In -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle staff">
                                <i class="bi bi-briefcase-fill"></i>
                            </div>
                            <span class="d-none d-lg-inline">{{ auth()->guard('staff')->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="bi bi-briefcase me-2"></i>Staff Member
                                </h6>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('staff.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Staff Dashboard
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('staff.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Not Logged In -->
                    <a href="{{ route('customer.login') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                    <a href="{{ route('customer.register') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-person-plus me-1"></i>Register
                    </a>
                @endif
            </div>
    </div>
</nav>

<!-- Main Content -->
<main style="padding-top: 76px;">
    @yield('content')
</main>

<!-- Enhanced Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="row gy-5">
            <!-- Brand Column -->
            <div class="col-lg-4">
                <div class="footer-brand">
                    <img src="{{ asset('images/njcarrentallogo-removebg-preview.png') }}" alt="NJ Car Rentals" class="footer-logo me-3">
                    <span>NJ Car Rentals</span>
                </div>
                <p class="mt-3" style="color: var(--text-secondary);">
                    Your trusted partner for premium car rentals and quality vehicle sales in Olongapo. Experience excellence in every journey.
                </p>
                <div class="footer-contact mt-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="contact-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Call Us</small>
                            <span>+63 999 123 4567</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="contact-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Email Us</small>
                            <span>contact@njcarrentals.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-6 col-lg-2">
                <h6 class="footer-title">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-2"></i>Home</a></li>
                    <li><a href="{{ route('vehicles.rental') }}"><i class="bi bi-chevron-right me-2"></i>For Rent</a></li>
                    <li><a href="{{ route('vehicles.sale') }}"><i class="bi bi-chevron-right me-2"></i>For Sale</a></li>
                    <li><a href="{{ route('contact') }}"><i class="bi bi-chevron-right me-2"></i>Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-6 col-lg-2">
                <h6 class="footer-title">Services</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('vehicles.rental') }}"><i class="bi bi-chevron-right me-2"></i>Car Rental</a></li>
                    <li><a href="{{ route('vehicles.sale') }}"><i class="bi bi-chevron-right me-2"></i>Buy a Car</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-4">
                <h6 class="footer-title">Stay Updated</h6>
                <p class="text-muted mb-3">Subscribe to our newsletter for exclusive offers and updates.</p>
                <form class="subscribe-form" method="POST" action="{{ route('subscribe') }}">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="Your email address" required>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                    <div class="subscribe-feedback visually-hidden mt-2" aria-live="polite"></div>
                </form>

                <!-- Social Links -->
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} NJ Car Rentals. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop" aria-label="Back to top">
    <i class="bi bi-arrow-up"></i>
</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Scripts -->
<script>
(function () {
    // Force dark theme
    document.documentElement.setAttribute('data-bs-theme', 'dark');
    localStorage.setItem('theme', 'dark');

    // Remove transition class after load
    window.addEventListener('load', () => {
        document.body.classList.remove('theme-transition');
    });

    // Navbar scroll effect
    const navbar = document.getElementById('mainNav');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // Back to top button
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Newsletter form
    const form = document.querySelector('.subscribe-form');
    if (form) {
        const feedback = form.querySelector('.subscribe-feedback');
        form.addEventListener('submit', e => {
            e.preventDefault();
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'Accept': 'application/json' }
            }).then(r => r.json())
              .then(d => {
                  feedback.classList.remove('visually-hidden', 'text-danger');
                  feedback.classList.add('text-success');
                  feedback.textContent = d.message || 'Thank you for subscribing!';
                  form.reset();
                  setTimeout(() => {
                      feedback.classList.add('visually-hidden');
                  }, 5000);
              }).catch(() => {
                  feedback.classList.remove('visually-hidden', 'text-success');
                  feedback.classList.add('text-danger');
                  feedback.textContent = 'Something went wrong. Please try again.';
              });
        });
    }

    // Dropdown hover effect for desktop
    if (window.matchMedia('(min-width: 992px)').matches) {
        document.querySelectorAll('.navbar .dropdown').forEach(dropdown => {
            dropdown.addEventListener('mouseenter', () => {
                dropdown.classList.add('show');
                dropdown.querySelector('.dropdown-toggle').setAttribute('aria-expanded', 'true');
                dropdown.querySelector('.dropdown-menu').classList.add('show');
            });
            dropdown.addEventListener('mouseleave', () => {
                dropdown.classList.remove('show');
                dropdown.querySelector('.dropdown-toggle').setAttribute('aria-expanded', 'false');
                dropdown.querySelector('.dropdown-menu').classList.remove('show');
            });
        });
    }
})();
</script>

<!-- Chat Notification System -->
@if(auth()->guard('customer')->check() || auth()->guard('admin')->check() || auth()->guard('staff')->check())
<script>
function checkNotifications() {
    const unreadUrl = '{{ auth()->guard("customer")->check() ? route("customer.chat.unread") : route("admin.chat.unread") }}';
    
    fetch(unreadUrl)
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            const count = document.getElementById('notificationCount');
            const list = document.getElementById('notificationList');
            
            if (data.unread > 0) {
                badge.style.display = 'inline-flex';
                count.textContent = data.unread > 9 ? '9+' : data.unread;
                
                // Update notification list
                if (data.latest_message) {
                    list.innerHTML = `
                        <a class="dropdown-item" href="{{ auth()->guard('customer')->check() ? route('customer.chat') : route('admin.chat') }}">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <i class="bi bi-chat-dots-fill text-primary"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-medium">${data.latest_message.sender}</div>
                                    <small class="text-muted text-truncate d-block">${data.latest_message.message}</small>
                                    <small class="text-muted">${data.latest_message.time}</small>
                                </div>
                        </a>
                    `;
                }
            } else {
                badge.style.display = 'none';
                list.innerHTML = `
                    <div class="dropdown-item text-muted text-center py-3">
                        <i class="bi bi-bell-slash d-block mb-2" style="font-size: 1.5rem; opacity: 0.5;"></i>
                        No new notifications
                    </div>
                `;
            }
        })
        .catch(error => console.error('Error checking notifications:', error));
}

// Check notifications every 10 seconds
setInterval(checkNotifications, 10000);

// Check on page load
document.addEventListener('DOMContentLoaded', checkNotifications);
</script>
@endif

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')

<style>
/* Logo Styles */
.brand-logo {
    height: 40px;
    width: auto;
    object-fit: contain;
}

.footer-logo {
    height: 50px;
    width: auto;
    object-fit: contain;
}

/* Additional Layout Styles */
.avatar-circle {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-inverse);
    font-size: 0.9rem;
}

.avatar-circle.admin {
    background: linear-gradient(135deg, var(--color-info) 0%, #0284c7 100%);
}

.avatar-circle.staff {
    background: linear-gradient(135deg, var(--color-success) 0%, #059669 100%);
}

.contact-icon {
    width: 40px;
    height: 40px;
    background: var(--bg-card);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-accent);
}

.footer-bottom-links {
    display: flex;
    gap: var(--space-lg);
}

.footer-bottom-links a {
    font-size: 0.9rem;
}

@media (max-width: 991px) {
    .navbar-collapse {
        margin-top: var(--space-md);
    }
    
    .footer-bottom {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-bottom-links {
        justify-content: center;
    }
}
</style>

</body>
</html>
