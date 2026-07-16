# Graph Report - .  (2026-07-16)

## Corpus Check
- Large corpus: 26026 files · ~20,194,970 words. Semantic extraction will be expensive (many Claude tokens). Consider running on a subfolder.

## Summary
- 826 nodes · 1220 edges · 157 communities (125 shown, 32 thin omitted)
- Extraction: 92% EXTRACTED · 8% INFERRED · 0% AMBIGUOUS · INFERRED: 97 edges (avg confidence: 0.79)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- Date & Administration Utilities
- Dashboard Controller
- Auth & Family Controllers
- Helper Functions
- Content & Article Controllers
- Service Boot Events
- Service Providers
- HTTP Middleware
- Menu Management
- Video Management
- Exception Handler
- Photo Management
- Auth Middleware Guards
- Contact Form Controller
- Popup Management
- Slider Management
- Frontend JavaScript
- Base Controller
- Website Identity Controller
- Password Reset Email
- Admin Dashboard Views
- Console Kernel & Scheduler
- Album Request Validation
- Menu Request Validation
- Market Data Requests
- Jemaat Data Import
- Localization Middleware
- Role Middleware
- User Access Middleware
- Email Verification
- OTP Verification
- Food Price Requests
- Website Identity Requests
- Store Request Validation
- Commodity Master Requests
- Food Balance Requests
- Food Balance Report Requests
- Jemaat View Model
- Jemaat Detail View Model
- Module 39
- Module 40
- Module 41
- Module 42
- Module 43
- Module 44
- Module 45
- Module 46
- Module 47
- Module 48
- Module 49
- Module 50
- Module 51
- Module 52
- Module 53
- Module 54
- Module 55
- Module 56
- Module 57
- Module 58
- Module 59
- Module 60
- Module 61
- Module 62
- Module 63
- Module 64
- Module 73
- Module 74
- Module 75
- Module 76
- Module 77
- Module 78
- Module 79
- Module 80
- Module 81
- Module 82
- Module 83
- Module 84
- Module 85
- Module 87
- Module 88
- Module 89
- Module 90

## God Nodes (most connected - your core abstractions)
1. `Jemaat` - 38 edges
2. `Menu` - 16 edges
3. `JemaatController` - 14 edges
4. `Berita` - 14 edges
5. `User` - 14 edges
6. `ArtikelController` - 13 edges
7. `FotoController` - 13 edges
8. `HubunganKeluarga` - 13 edges
9. `KkJemaat` - 13 edges
10. `JemaatService` - 13 edges

## Surprising Connections (you probably didn't know these)
- `DashboardController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/DashboardController.php →   _Bridges community 1 → community 2_
- `UserController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/UserController.php →   _Bridges community 2 → community 3_
- `ContactUSController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/ContactUSController.php →   _Bridges community 2 → community 13_
- `WilayahController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Master/WilayahController.php →   _Bridges community 2 → community 0_
- `PageController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/PageController.php →   _Bridges community 2 → community 4_

## Import Cycles
- None detected.

## Communities (157 total, 32 thin omitted)

### Community 0 - "Date & Administration Utilities"
Cohesion: 0.07
Nodes (21): Request, WilayahController, Atestasi, Foto, GroupWilayah, IdentitasWeb, Link, MasterBulan (+13 more)

### Community 1 - "Dashboard Controller"
Cohesion: 0.05
Nodes (14): parseTanggalIndo(), DashboardController, Request, AtestasiKeluarController, Request, BaptisanController, JemaatController, Request (+6 more)

### Community 2 - "Auth & Family Controllers"
Cohesion: 0.05
Nodes (22): KKController, ConfirmPasswordController, ForgotPasswordController, LoginController, RegisterController, ResetPasswordController, VerificationController, LocalizationController (+14 more)

### Community 3 - "Helper Functions"
Cohesion: 0.07
Nodes (13): FunctionHelper, Request, UserController, MfaController, Request, HomeController, ManajemenUserController, Request (+5 more)

### Community 4 - "Content & Article Controllers"
Cohesion: 0.10
Nodes (5): PageController, ArtikelController, ArtikelRequest, Berita, KategoriBerita

### Community 5 - "Service Boot Events"
Cohesion: 0.14
Nodes (5): MeninggalDunia, JemaatStatusService, UserFactory, Factory, static

### Community 6 - "Service Providers"
Cohesion: 0.13
Nodes (6): AppServiceProvider, AuthServiceProvider, BroadcastServiceProvider, DatabaseServiceProvider, EventServiceProvider, ServiceProvider

### Community 7 - "HTTP Middleware"
Cohesion: 0.15
Nodes (9): Authenticate, EncryptCookies, PreventRequestsDuringMaintenance, TrimStrings, TrustHosts, TrustProxies, ValidateSignature, VerifyCsrfToken (+1 more)

### Community 8 - "Menu Management"
Cohesion: 0.16
Nodes (3): MenuController, Request, Menu

### Community 9 - "Video Management"
Cohesion: 0.16
Nodes (3): VideoController, VideoRequest, Video

### Community 10 - "Exception Handler"
Cohesion: 0.17
Nodes (8): Handler, Alert, JemaatTableRow, Closure, Component, ExceptionHandler, Throwable, View

### Community 11 - "Photo Management"
Cohesion: 0.21
Nodes (3): FotoController, Request, Album

### Community 12 - "Auth Middleware Guards"
Cohesion: 0.19
Nodes (9): CheckUserIsActive, Closure, Request, CustomCKFinderAuth, Closure, Closure, Request, RedirectIfAuthenticated (+1 more)

### Community 13 - "Contact Form Controller"
Cohesion: 0.22
Nodes (6): ContactUSController, Request, Request, KontakController, Request, ContactUS

### Community 14 - "Popup Management"
Cohesion: 0.28
Nodes (3): Request, PopupController, popup

### Community 15 - "Slider Management"
Cohesion: 0.28
Nodes (3): Request, SliderController, Slider

### Community 16 - "Frontend JavaScript"
Cohesion: 0.18
Nodes (6): debounce(), iconNavbarSidenav, iconSidenav, navbarBlurOnScroll(), referenceButtons, sidenav

### Community 17 - "Base Controller"
Cohesion: 0.57
Nodes (6): Controller, Controller, AuthorizesRequests, BaseController, DispatchesJobs, ValidatesRequests

### Community 19 - "Password Reset Email"
Cohesion: 0.32
Nodes (3): ForgotPassword, Notification, Queueable

### Community 20 - "Admin Dashboard Views"
Cohesion: 0.29
Nodes (6): admin.dashboard.aksi, admin.dashboard.laporan, admin.dashboard.umurG, admin.dashboard.usia, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 21 - "Console Kernel & Scheduler"
Cohesion: 0.40
Nodes (3): Kernel, ConsoleKernel, Schedule

### Community 26 - "Localization Middleware"
Cohesion: 0.60
Nodes (3): Localization, Closure, Request

### Community 27 - "Role Middleware"
Cohesion: 0.60
Nodes (3): Closure, Request, Role

### Community 28 - "User Access Middleware"
Cohesion: 0.60
Nodes (3): Closure, Request, UserAccess

### Community 29 - "Email Verification"
Cohesion: 0.60
Nodes (3): Closure, Request, VerifyEmail

### Community 30 - "OTP Verification"
Cohesion: 0.60
Nodes (3): Closure, Request, VerifyOtp

### Community 39 - "Module 39"
Cohesion: 0.50
Nodes (3): components.fixed-plugin, layouts.navbars.auth.sidenav, sweetalert::alert

### Community 41 - "Module 41"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 42 - "Module 42"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 43 - "Module 43"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 44 - "Module 44"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 45 - "Module 45"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 46 - "Module 46"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 47 - "Module 47"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 48 - "Module 48"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 49 - "Module 49"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 50 - "Module 50"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 51 - "Module 51"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 52 - "Module 52"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 53 - "Module 53"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 54 - "Module 54"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 55 - "Module 55"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 56 - "Module 56"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 57 - "Module 57"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 58 - "Module 58"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 59 - "Module 59"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 60 - "Module 60"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 61 - "Module 61"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 62 - "Module 62"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

### Community 63 - "Module 63"
Cohesion: 0.50
Nodes (3): includes.alert, layouts.footers.auth.footer, layouts.navbars.auth.topnav

## Knowledge Gaps
- **112 isolated node(s):** `iconNavbarSidenav`, `iconSidenav`, `sidenav`, `referenceButtons`, `layouts.navbars.auth.topnav` (+107 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **32 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Jemaat` connect `Dashboard Controller` to `Date & Administration Utilities`, `Service Boot Events`?**
  _High betweenness centrality (0.034) - this node is a cross-community bridge._
- **Why does `RouteServiceProvider` connect `Auth & Family Controllers` to `Service Providers`?**
  _High betweenness centrality (0.030) - this node is a cross-community bridge._
- **Why does `ArtikelRequest` connect `Content & Article Controllers` to `Date & Administration Utilities`, `Market Data Requests`?**
  _High betweenness centrality (0.015) - this node is a cross-community bridge._
- **What connects `iconNavbarSidenav`, `iconSidenav`, `sidenav` to the rest of the system?**
  _112 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Date & Administration Utilities` be split into smaller, more focused modules?**
  _Cohesion score 0.06766917293233082 - nodes in this community are weakly interconnected._
- **Should `Dashboard Controller` be split into smaller, more focused modules?**
  _Cohesion score 0.05384615384615385 - nodes in this community are weakly interconnected._
- **Should `Auth & Family Controllers` be split into smaller, more focused modules?**
  _Cohesion score 0.05370101596516691 - nodes in this community are weakly interconnected._