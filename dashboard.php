<?php
require_once 'includes/dashboard_auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/dashboard_header.php'; ?>
</head>
<body>
    <!-- Main dashboard layout container -->
    <div class="dashboard-layout">
        <?php include 'includes/dashboard_sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <?php include 'includes/dashboard_topbar.php'; ?>

            <!-- Content Area -->
            <div class="content-area">
                <?php include 'includes/dashboard_content_management.php'; ?>
                <?php include 'includes/dashboard_profile.php'; ?>
                <?php include 'includes/dashboard_contact.php'; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/dashboard_modals.php'; ?>

    <!-- JavaScript dependencies and main script -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/js/dashboard/utils.js"></script>
    <script src="assets/js/dashboard/sidebar.js"></script>
    <script src="assets/js/dashboard/sections.js"></script>
    <script src="assets/js/dashboard/testimonials.js"></script>
    <script src="assets/js/dashboard/projects.js"></script>
    <script src="assets/js/dashboard/profile.js"></script>
    <script src="assets/js/dashboard/contact.js"></script>
    <script src="assets/js/dashboard/main.js"></script>
</body>
</html>
