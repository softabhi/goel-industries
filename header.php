<?php
// session_start();
include('backend/connect.php');
$currentPage = basename($_SERVER['SCRIPT_NAME']);

$menuItems = [
  [
    "menuTitle" => "Material Management",
    "icon" => "fas fa-boxes", // Changed icon
    "pages" => [
      ["title" => "Add Raw Material", "url" => "add_raw_material.php"],
      ["title" => "Raw Material Report", "url" => "raw_material_report.php"],
      ["title" => "Supplier Management", "url" => "#"],
      ["title" => "Stock Levels & Records", "url" => "#"],
      ["title" => "Payments & Dues", "url" => "raw_material_pay_dues.php"]
    ],
  ],
  [
    "menuTitle" => "Coast Management",
    "icon" => "fas fa-boxes", // Changed icon
    "pages" => [
      ["title" => "Product Coast", "url" => "product_coast.php"],
      ["title" => "Supplier Management", "url" => "#"],
      ["title" => "Stock Levels & Records", "url" => "#"]
    ],
  ],
 [
    "menuTitle" => "User Management",
    "icon" => "fas fa-users-cog", // Changed icon
    "pages" => [
      ["title" => "Create User", "url" => "add_user.php"],
      ["title" => "User Report", "url" => "#"],
      ["title" => "Add Employe", "url" => "#"],
    ]
  ],
  [
    "menuTitle" => "Settings",
    "icon" => "fas fa-cogs",
    "pages" => [
      ["title" => "Profile", "url" => "profile.php"],
    ]
  ]
];

$activePageInfo = array_reduce($menuItems, function ($carry, $menuItem) use ($currentPage) {
  foreach ($menuItem['pages'] as $page) {
    if ($currentPage === $page['url']) {
      return [
        "breadcrumbItems" => [
          ["title" => $menuItem['menuTitle'], "url" => "index.php"],
          ["title" => $page['title'], "url" => $page['url']]
        ],
        "pageTitle" => $page['title'],
        "activeMenu" => $menuItem,
        "activePage" => $page
      ];
    }
  }
  return $carry;
}, null);

$breadcrumbItems = $activePageInfo['breadcrumbItems'] ?? [];
$pageTitle = $activePageInfo['pageTitle'] ?? '';
$activeMenu = $activePageInfo['activeMenu'] ?? null;
$activePage = $activePageInfo['activePage'] ?? $currentPage;
?>


<title><?= $pageTitle ?></title>
<link rel="icon" type="image/x-icon" href="./favicon.ico">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
  /* Main Dashboard Styles */
  :root {
    --primary-color: #072e63;
    --primary-light: #1a4275;
    --primary-dark: #700a0a;
    --accent-color: #f8c300;
    --text-color: #ffffff;
    --text-muted: #cccccc;
    --border-radius: 8px;
    --transition: all 0.3s ease;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --hover-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    --ndt-light: #f8f9fc;
    --ndt-dark: #5a5c69;
    --ndt-white: #fff;
    --ndt-gray-100: #f8f9fc;
    --ndt-gray-200: #eaecf4;
    --ndt-gray-300: #dddfeb;
    --ndt-gray-400: #d1d3e2;
    --ndt-gray-500: #b7b9cc;
    --ndt-gray-600: #858796;
    --ndt-gray-700: #6e707e;
    --ndt-gray-800: #5a5c69;
    --ndt-gray-900: #3a3b45;
    --ndt-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    --ndt-radius: 0.35rem;
    --ndt-transition: all 0.2s ease-in-out;
  }

  body {
    font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    background-color: var(--ndt-gray-100);
    color: var(--ndt-gray-800);
    overflow-x: hidden;
  }

  /* Header Section */
  .ndt-header-section {
    background-color: var(--ndt-white);
    padding: 1.5rem 1rem;
    box-shadow: var(--ndt-shadow);
    border-radius: var(--ndt-radius);
    margin-bottom: 1.5rem;
  }

  .ndt-welcome-heading {
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: var(--ndt-gray-800);
  }

  .ndt-user-name {
    color: var(--ndt-primary);
  }

  .ndt-date-display {
    color: var(--ndt-gray-600);
    margin-bottom: 0;
  }

  .ndt-action-btn {
    margin-left: 0.5rem;
    border-radius: var(--ndt-radius);
    transition: var(--ndt-transition);
  }

  .ndt-create-task-btn {
    background-color: var(--ndt-primary);
    color: var(--ndt-white);
    padding: 0.5rem 1rem;
  }

  .ndt-filter-btn {
    background-color: var(--ndt-white);
    color: var(--ndt-gray-700);
    border: 1px solid var(--ndt-gray-300);
    padding: 0.5rem 1rem;
  }

  .ndt-user-profile-mini {
    position: relative;
    margin-left: 1rem;
  }

  .ndt-user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--ndt-gray-200);
  }

  .ndt-notification-indicator {
    position: absolute;
    top: 0;
    right: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: var(--ndt-danger);
    border: 2px solid var(--ndt-white);
  }

  /* Metric Cards */
  .ndt-metric-card {
    border-radius: var(--ndt-radius);
    box-shadow: var(--ndt-shadow);
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: var(--ndt-transition);
  }

  .ndt-metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
  }

  .ndt-card-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: var(--ndt-white);
  }

  .ndt-card-success {
    background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    color: var(--ndt-white);
  }

  .ndt-card-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    color: var(--ndt-white);
  }

  .ndt-card-danger {
    background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
    color: var(--ndt-white);
  }

  .ndt-card-body {
    padding: 1.5rem;
    display: flex;
    align-items: center;
  }

  .ndt-card-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    opacity: 0.8;
  }

  .ndt-card-content {
    flex: 1;
  }

  .ndt-card-value {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
  }

  .ndt-card-label {
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    opacity: 0.8;
  }

  .ndt-trend-indicator {
    font-size: 0.75rem;
    display: flex;
    align-items: center;
  }

  .ndt-trend-indicator i {
    margin-right: 0.25rem;
  }

  /* Chart Cards */
  .ndt-card {
    background-color: var(--ndt-white);
    border-radius: var(--ndt-radius);
    box-shadow: var(--ndt-shadow);
    margin-bottom: 1.5rem;
    overflow: hidden;
  }

  .ndt-card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--ndt-gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .ndt-card-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: var(--ndt-gray-800);
  }

  .ndt-card-subtitle {
    font-size: 0.875rem;
    color: var(--ndt-gray-600);
    margin-bottom: 0;
  }

  .ndt-time-filter .ndt-btn-outline {
    border: 1px solid var(--ndt-gray-300);
    color: var(--ndt-gray-700);
    background-color: transparent;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
  }

  .ndt-time-filter .ndt-btn-outline.active {
    background-color: var(--ndt-primary);
    color: var(--ndt-white);
    border-color: var(--ndt-primary);
  }

  .ndt-chart-legend {
    display: flex;
    flex-wrap: wrap;
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--ndt-gray-200);
  }

  .ndt-legend-item {
    display: flex;
    align-items: center;
    margin-right: 1.5rem;
    margin-bottom: 0.5rem;
  }

  .ndt-legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
    margin-right: 0.5rem;
  }

  .ndt-legend-label {
    font-size: 0.875rem;
    color: var(--ndt-gray-700);
    margin-right: 0.5rem;
  }

  .ndt-legend-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ndt-gray-800);
  }

  /* Team Workload */
  .ndt-team-workload {
    padding: 0.5rem 0;
  }

  .ndt-team-member {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--ndt-gray-200);
  }

  .ndt-team-member:last-child {
    border-bottom: none;
  }

  .ndt-member-info {
    display: flex;
    align-items: center;
  }

  .ndt-member-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 1rem;
  }

  .ndt-member-name {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--ndt-gray-800);
  }

  .ndt-member-role {
    font-size: 0.8rem;
    color: var(--ndt-gray-600);
    margin-bottom: 0;
  }

  .ndt-workload-bar {
    display: flex;
    align-items: center;
    width: 50%;
  }

  .ndt-progress {
    flex: 1;
    height: 8px;
    margin-bottom: 0;
    margin-right: 1rem;
  }

  .ndt-workload-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ndt-gray-800);
    min-width: 40px;
    text-align: right;
  }

  /* Todo List */
  .ndt-todo-card {
    height: calc(100% - 1.5rem);
  }

  .ndt-todo-list {
    padding: 0.5rem 0;
  }

  .ndt-todo-item {
    display: flex;
    align-items: flex-start;
    padding: 1rem 0;
    border-bottom: 1px solid var(--ndt-gray-200);
    position: relative;
  }

  .ndt-todo-item:last-child {
    border-bottom: none;
  }

  .ndt-todo-item.ndt-priority-high::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 0;
    bottom: 0;
    width: 4px;
    background-color: var(--ndt-danger);
  }

  .ndt-todo-item.ndt-priority-medium::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 0;
    bottom: 0;
    width: 4px;
    background-color: var(--ndt-warning);
  }

  .ndt-todo-item.ndt-priority-low::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 0;
    bottom: 0;
    width: 4px;
    background-color: var(--ndt-info);
  }

  .ndt-todo-checkbox {
    margin-right: 1rem;
    padding-top: 0.25rem;
  }

  .ndt-checkbox {
    display: none;
  }

  .ndt-checkbox-label {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid var(--ndt-gray-400);
    border-radius: 4px;
    position: relative;
    cursor: pointer;
    transition: var(--ndt-transition);
  }

  .ndt-checkbox:checked+.ndt-checkbox-label {
    background-color: var(--ndt-primary);
    border-color: var(--ndt-primary);
  }

  .ndt-checkbox:checked+.ndt-checkbox-label::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: var(--ndt-white);
    font-size: 0.75rem;
  }

  .ndt-todo-content {
    flex: 1;
  }

  .ndt-todo-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--ndt-gray-800);
  }

  .ndt-checkbox:checked~.ndt-todo-content .ndt-todo-title {
    text-decoration: line-through;
    color: var(--ndt-gray-500);
  }

  .ndt-todo-details {
    font-size: 0.875rem;
    color: var(--ndt-gray-600);
    margin-bottom: 0.5rem;
  }

  .ndt-todo-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
  }

  .ndt-todo-due {
    font-size: 0.75rem;
    color: var(--ndt-gray-600);
    margin-right: 1rem;
    display: flex;
    align-items: center;
  }

  .ndt-todo-due i {
    margin-right: 0.25rem;
  }

  .ndt-todo-tag {
    font-size: 0.7rem;
    padding: 0.15rem 0.5rem;
    border-radius: 12px;
    font-weight: 600;
    margin-right: 0.5rem;
  }

  .ndt-tag-design {
    background-color: rgba(230, 126, 34, 0.15);
    color: #e67e22;
  }

  .ndt-tag-development {
    background-color: rgba(52, 152, 219, 0.15);
    color: #3498db;
  }

  .ndt-tag-meeting {
    background-color: rgba(155, 89, 182, 0.15);
    color: #9b59b6;
  }

  /* Activity Timeline */
  .ndt-activity-timeline {
    padding: 0.5rem 0;
  }

  .ndt-timeline-item {
    display: flex;
    padding: 0.75rem 0;
    position: relative;
  }

  .ndt-timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 2.5rem;
    left: 1rem;
    bottom: 0;
    width: 2px;
    background-color: var(--ndt-gray-200);
  }

  .ndt-timeline-icon {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    z-index: 1;
  }

  .ndt-icon-primary {
    background-color: rgba(78, 115, 223, 0.15);
    color: var(--ndt-primary);
  }

  .ndt-icon-success {
    background-color: rgba(28, 200, 138, 0.15);
    color: var(--ndt-success);
  }

  .ndt-icon-warning {
    background-color: rgba(246, 194, 62, 0.15);
    color: var(--ndt-warning);
  }

  .ndt-icon-danger {
    background-color: rgba(231, 74, 59, 0.15);
    color: var(--ndt-danger);
  }

  .ndt-icon-info {
    background-color: rgba(54, 185, 204, 0.15);
    color: var(--ndt-info);
  }

  .ndt-timeline-content {
    flex: 1;
  }

  .ndt-timeline-title {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--ndt-gray-800);
  }

  .ndt-timeline-text {
    font-size: 0.875rem;
    color: var(--ndt-gray-600);
    margin-bottom: 0.25rem;
  }

  .ndt-timeline-time {
    font-size: 0.75rem;
    color: var(--ndt-gray-500);
  }

  /* Project Timeline */
  .ndt-project-timeline {
    padding: 1rem 0;
  }

  .ndt-timeline-header {
    margin-bottom: 1.5rem;
  }

  .ndt-timeline-dates {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
  }

  .ndt-timeline-dates span {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ndt-gray-700);
  }

  .ndt-timeline-project {
    display: flex;
    margin-bottom: 1.5rem;
  }

  .ndt-project-info {
    width: 200px;
    padding-right: 1.5rem;
  }

  .ndt-project-name {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--ndt-gray-800);
  }

  .ndt-project-status {
    font-size: 0.8rem;
    margin-bottom: 0;
    display: inline-block;
    padding: 0.15rem 0.5rem;
    border-radius: 12px;
  }

  .ndt-project-timeline {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    grid-gap: 0.5rem;
    align-items: center;
  }

  .ndt-timeline-bar {
    background-color: var(--ndt-gray-200);
    height: 30px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  .ndt-timeline-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--ndt-gray-800);
    z-index: 1;
  }

  .ndt-status-complete {
    background-color: rgba(28, 200, 138, 0.2);
    border-left: 4px solid var(--ndt-success);
  }

  .ndt-status-progress {
    background-color: rgba(78, 115, 223, 0.2);
    border-left: 4px solid var(--ndt-primary);
  }

  .ndt-status-delayed {
    background-color: rgba(231, 74, 59, 0.2);
    border-left: 4px solid var(--ndt-danger);
  }

  /* Responsive Styles */
  @media (max-width: 1199.98px) {
    .ndt-project-info {
      width: 150px;
    }
  }

  @media (max-width: 991.98px) {
    .ndt-welcome-section {
      text-align: center;
      margin-bottom: 1rem;
    }

    .ndt-quick-actions {
      justify-content: center;
    }

    .ndt-workload-bar {
      width: 40%;
    }

    .ndt-project-timeline {
      display: none;
    }

    .ndt-timeline-project {
      flex-direction: column;
    }

    .ndt-project-info {
      width: 100%;
      margin-bottom: 0.5rem;
    }
  }

  @media (max-width: 767.98px) {
    .ndt-card-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .ndt-card-actions {
      margin-top: 1rem;
      align-self: flex-end;
    }

    .ndt-team-member {
      flex-direction: column;
      align-items: flex-start;
    }

    .ndt-workload-bar {
      width: 100%;
      margin-top: 0.75rem;
    }
  }

  @media (max-width: 575.98px) {
    .ndt-metric-card .ndt-card-body {
      flex-direction: column;
      text-align: center;
    }

    .ndt-card-icon {
      margin-right: 0;
      margin-bottom: 0.75rem;
    }

    .ndt-todo-item {
      flex-direction: column;
    }

    .ndt-todo-checkbox {
      margin-bottom: 0.75rem;
    }

    .ndt-todo-actions {
      position: absolute;
      top: 1rem;
      right: 0;
    }
  }

  /* Navbar Styling for Goel Industries */
  .main-header {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    border: none;
    position: relative;
    z-index: 10;
  }

  .navbar {
    background: #700a0a !important;
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(248, 195, 0, 0.2);
    padding: 0.8rem 1rem;
  }

  .navbar-light .navbar-nav .nav-link {
    color: rgba(255, 255, 255, 0.8) !important;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: 0.5px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
  }

  .navbar-light .navbar-nav .nav-link:hover,
  .navbar-light .navbar-nav .nav-link:focus {
    color: #f8c300 !important;
    text-shadow: 0 0 8px rgba(248, 195, 0, 0.4);
  }

  .navbar-light .navbar-nav .nav-link i {
    font-size: 1.2rem;
  }

  /* Search bar styling */
  .form-control-navbar {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
    border-radius: 8px 0 0 8px !important;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2) inset;
  }

  .form-control-navbar:focus {
    box-shadow: 0 0 0 2px rgba(248, 195, 0, 0.3) !important;
    border-color: rgba(248, 195, 0, 0.5) !important;
  }

  .form-control-navbar::placeholder {
    color: rgba(255, 255, 255, 0.5);
  }

  .btn-navbar {
    background: rgba(248, 195, 0, 0.2) !important;
    border: 1px solid rgba(248, 195, 0, 0.3) !important;
    color: #f8c300 !important;
    border-radius: 0 8px 8px 0 !important;
    transition: all 0.3s ease;
  }

  .btn-navbar:hover {
    background: rgba(248, 195, 0, 0.3) !important;
    color: #ffffff !important;
  }

  /* Badge styling */
  .badge-danger {
    background-color: #ff3e3e !important;
    font-family: 'Montserrat', sans-serif;
    font-weight: 500;
    box-shadow: 0 0 10px rgba(255, 62, 62, 0.5);
  }

  .badge-warning {
    background-color: #f8c300 !important;
    color: #072e63 !important;
    font-family: 'Montserrat', sans-serif;
    font-weight: 500;
    box-shadow: 0 0 10px rgba(248, 195, 0, 0.5);
  }

  .navbar-badge {
    font-size: 0.6rem;
    padding: 3px 5px;
    right: 3px;
    top: 5px;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .navbar-nav {
      padding: 0.5rem 0;
    }

    .form-inline {
      margin: 0.5rem 0;
    }
  }
</style>


<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block"><a href="./" class="nav-link">Home</a></li>
  </ul>
  <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" name="search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </form>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown"><a class="nav-link" href="#messages"><i class="far fa-comments"></i><span
          class="badge badge-danger navbar-badge">2</span></a></li>
    <li class="nav-item dropdown"><a class="nav-link" href="#notifications"><i class="far fa-bell"></i><span
          class="badge badge-warning navbar-badge">5</span></a></li>
  </ul>
</nav>

<div class="main-header" style="padding: 0px 10px; background-color: #f4f6f9; border-bottom: none !important;">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?= $pageTitle ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <?php foreach ($breadcrumbItems as $item): ?>
            <li class="breadcrumb-item <?= $item['url'] === '#' ? 'active' : '' ?>">
              <?= $item['url'] === '#' ? $item['title'] : "<a href='{$item['url']}'>{$item['title']}</a>" ?>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>
</div>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="./" class="brand-link">
    <img src="./src/images/goel-industries-logo-e1733293856597 (1).png" alt="Admin Panel Logo" class="brand-image img-square elevation-4">
    <span class="brand-text font-weight-bold" style="font-size: 17px !important;">Goel Industries</span>

  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image"><img src="./src/images/default.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info"><a href="./" class="d-block">Iqbolshoh Ilhomjonov</a></div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item" onclick="">
          <a href="dashboard.php" class="nav-link <?= $currentPage === $activePage ? 'active' : '' ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Home</p>
          </a>
        </li>
        <!-- <li class="nav-item" onclick="">
                    <a href="index.php" class="nav-link <?= $currentPage === $activePage ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Admin</p>
                    </a>
                </li>
                <li class="nav-item" onclick="">
                    <a href="index.php" class="nav-link <?= $currentPage === $activePage ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>User</p>
                    </a>
                </li> -->



        <?php
        $user_id = $_SESSION['user_id'];
        $sql = "select * from users where id = $user_id ";
        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result);
        //  echo $permission;
        $permission = explode(",", $row['permission']);

        //                 print_r($permission);
        // exit;
        foreach ($menuItems as $menuItem): ?>

          <?php
          // print_r($menuItem['menuTitle']);
          // exit;
          if (in_array($menuItem['menuTitle'], $permission)) {
          ?>
            <li class="nav-item has-treeview <?= $menuItem === $activeMenu ? 'menu-open' : '' ?>">
              <a class="nav-link <?= $menuItem === $activeMenu ? 'active' : '' ?>" href="#">
                <i class="nav-icon <?= $menuItem['icon'] ?>"></i>
                <p><?= $menuItem['menuTitle'] ?>
                  <?= !empty($menuItem['pages']) ? '<i class="right fas fa-angle-left"></i>' : '' ?>
                </p>
              </a>
              <?php if (!empty($menuItem['pages'])): ?>
                <ul class="nav nav-treeview">
                  <?php foreach ($menuItem['pages'] as $page): ?>
                    <li class="nav-item">
                      <a href="<?= $page['url'] ?>" class="nav-link <?= $page === $activePage ? 'active' : '' ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?= $page['title'] ?></p>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </li>
          <?php
          }
          ?>



        <?php endforeach; ?>
        <!-- <li class="nav-item" onclick="">
                    <a href="truckReport.php" class="nav-link <?= $currentPage === $activePage ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Truck Reprot</p>
                    </a>
                </li> -->
        <li class="nav-item" onclick="logout()">
          <a href="javascript:void(0);" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function logout() {
    Swal.fire({
      title: 'Are you sure?',
      text: "You will be logged out!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, log me out!'
    }).then((result) => {
      if (result.value) {
        window.location.href = './backend/logout.php';
      }
    });
  }
</script>