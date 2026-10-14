<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/classes/Database.php';

if (isLoggedIn()) {
    if (isAdmin()) {
        header("Location: admin/dashboard.php");
        exit;
    }

    if (isStudent()) {
        header("Location: student/dashboard.php");
        exit;
    }
}

$courseCount = 0;
$instructorCount = 0;
$departmentCount = 0;
$featuredCourses = [];

try {
    $database = new Database();
    $db = $database->getConnection();

    $result = $db->query(
        "SELECT COUNT(*) AS total FROM courses"
    );

    if ($result) {
        $courseCount = (int) $result->fetch_assoc()['total'];
    }

    $result = $db->query(
        "SELECT COUNT(*) AS total FROM instructors"
    );

    if ($result) {
        $instructorCount = (int) $result->fetch_assoc()['total'];
    }

    $result = $db->query(
        "SELECT COUNT(*) AS total FROM departments"
    );

    if ($result) {
        $departmentCount = (int) $result->fetch_assoc()['total'];
    }

    $stmt = $db->prepare(
        "SELECT
            c.id,
            c.course_code,
            c.course_name,
            c.credits,
            c.capacity,
            i.name AS instructor_name
         FROM courses c
         INNER JOIN instructors i
            ON c.instructor_id = i.id
         ORDER BY c.id ASC
         LIMIT 6"
    );

    if ($stmt) {
        $stmt->execute();

        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $featuredCourses[] = $row;
        }

        $stmt->close();
    }
} catch (Throwable $e) {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="UniTrack - Modern University Course Management System for Computer Science."
    >

    <title>UniTrack | Computer Science</title>

    <link
        rel="stylesheet"
        href="assets/css/home.css"
    >

</head>

<body>

<header class="site-header">

    <div class="container navbar">

        <a
            href="index.php"
            class="brand"
        >

            <div class="brand-icon">
                U
            </div>

            <div class="brand-info">

                <strong>
                    UniTrack
                </strong>

                <span>
                    Computer Science
                </span>

            </div>

        </a>

        <nav
            class="main-nav"
            aria-label="Main Navigation"
        >

            <a href="#home">
                Home
            </a>

            <a href="#courses">
                Courses
            </a>

            <a href="#features">
                Features
            </a>

            <a href="#about">
                About
            </a>

            <a
                href="login.php"
                class="login-link"
            >
                Sign In
            </a>

            <a
                href="register.php"
                class="register-link"
            >
                Get Started
            </a>

        </nav>

    </div>

</header>

<main>

<section
    class="hero"
    id="home"
>

    <div class="hero-background"></div>

    <div class="container hero-grid">

        <div class="hero-content">

            <div class="eyebrow">

                <span class="eyebrow-dot"></span>

                University Course Management System

            </div>

            <h1>

                Your academic journey,

                <span>
                    organized.
                </span>

            </h1>

            <p class="hero-description">

                Discover Computer Science courses, manage your
                enrollment, track your academic progress, and stay
                connected with your university journey through one
                modern platform.

            </p>

            <div class="hero-actions">

                <a
                    href="register.php"
                    class="primary-button"
                >

                    Create Student Account

                    <span>
                        →
                    </span>

                </a>

                <a
                    href="#courses"
                    class="secondary-button"
                >

                    Explore Courses

                    <span>
                        ↓
                    </span>

                </a>

            </div>

            <div class="hero-trust">

                <div class="trust-item">

                    <strong>
                        Secure
                    </strong>

                    <span>
                        Authentication
                    </span>

                </div>

                <div class="trust-divider"></div>

                <div class="trust-item">

                    <strong>
                        Smart
                    </strong>

                    <span>
                        Enrollment
                    </span>

                </div>

                <div class="trust-divider"></div>

                <div class="trust-item">

                    <strong>
                        Modern
                    </strong>

                    <span>
                        Experience
                    </span>

                </div>

            </div>

        </div>

        <div class="hero-visual">

            <div class="dashboard-window">

                <div class="window-top">

                    <div class="window-dots">

                        <span></span>
                        <span></span>
                        <span></span>

                    </div>

                    <div class="window-title">
                        UniTrack Dashboard
                    </div>

                    <div class="window-space"></div>

                </div>

                <div class="dashboard-preview">

                    <div class="preview-sidebar">

                        <div class="preview-logo">
                            U
                        </div>

                        <div class="sidebar-line active"></div>
                        <div class="sidebar-line"></div>
                        <div class="sidebar-line"></div>
                        <div class="sidebar-line"></div>

                    </div>

                    <div class="preview-main">

                        <div class="preview-heading">

                            <div>

                                <span>
                                    Student Dashboard
                                </span>

                                <strong>
                                    Academic Overview
                                </strong>

                            </div>

                            <div class="preview-avatar">
                                S
                            </div>

                        </div>

                        <div class="preview-stats">

                            <div class="preview-stat">

                                <small>
                                    Enrolled
                                </small>

                                <strong>
                                    Courses
                                </strong>

                                <span>
                                    Manage your schedule
                                </span>

                            </div>

                            <div class="preview-stat">

                                <small>
                                    Computer Science
                                </small>

                                <strong>
                                    Courses
                                </strong>

                                <span>
                                    Explore catalog
                                </span>

                            </div>

                        </div>

                        <div class="preview-course">

                            <div class="course-symbol">
                                CS
                            </div>

                            <div class="preview-course-info">

                                <small>
                                    Featured Course
                                </small>

                                <strong>
                                    Web Application Development
                                </strong>

                                <span>
                                    Computer Science
                                </span>

                            </div>

                            <div class="course-arrow">
                                →
                            </div>

                        </div>

                        <div class="preview-bars">

                            <div class="bar-row">

                                <span></span>
                                <i style="width: 82%;"></i>

                            </div>

                            <div class="bar-row">

                                <span></span>
                                <i style="width: 64%;"></i>

                            </div>

                            <div class="bar-row">

                                <span></span>
                                <i style="width: 73%;"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="floating-card floating-card-one">

                <div class="floating-icon">
                    ✓
                </div>

                <div>

                    <strong>
                        Enrollment
                    </strong>

                    <span>
                        Easily managed
                    </span>

                </div>

            </div>

            <div class="floating-card floating-card-two">

                <div class="floating-icon blue">
                    CS
                </div>

                <div>

                    <strong>
                        Computer Science
                    </strong>

                    <span>
                        Academic platform
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="stats-section">

    <div class="container stats-grid">

        <div class="stat-box">

            <div class="stat-icon">
                C
            </div>

            <div>

                <strong>
                    <?php echo $courseCount; ?>
                </strong>

                <span>
                    Available Courses
                </span>

            </div>

        </div>

        <div class="stat-box">

            <div class="stat-icon">
                I
            </div>

            <div>

                <strong>
                    <?php echo $instructorCount; ?>
                </strong>

                <span>
                    Instructors
                </span>

            </div>

        </div>

        <div class="stat-box">

            <div class="stat-icon">
                D
            </div>

            <div>

                <strong>
                    <?php echo $departmentCount; ?>
                </strong>

                <span>
                    Academic Department
                </span>

            </div>

        </div>

        <div class="stat-box">

            <div class="stat-icon">
                S
            </div>

            <div>

                <strong>
                    24/7
                </strong>

                <span>
                    Platform Access
                </span>

            </div>

        </div>

    </div>

</section>

<section
    class="courses-section"
    id="courses"
>

    <div class="container">

        <div class="section-header">

            <div>

                <span class="section-eyebrow">
                    Course Catalog
                </span>

                <h2>
                    Explore Computer Science
                </h2>

            </div>

            <p>
                Browse courses available through the
                Computer Science department.
            </p>

        </div>

        <div class="course-grid">

            <?php if (!empty($featuredCourses)): ?>

                <?php foreach ($featuredCourses as $course): ?>

                    <article class="premium-course-card">

                        <div class="course-card-top">

                            <span class="course-code">
                                <?php echo htmlspecialchars(
                                    $course['course_code']
                                ); ?>
                            </span>

                            <span class="credits">
                                <?php echo (int) $course['credits']; ?>
                                Credits
                            </span>

                        </div>

                        <div class="course-card-icon">
                            CS
                        </div>

                        <h3>
                            <?php echo htmlspecialchars(
                                $course['course_name']
                            ); ?>
                        </h3>

                        <p class="instructor">

                            <span>
                                Instructor
                            </span>

                            <?php echo htmlspecialchars(
                                $course['instructor_name']
                            ); ?>

                        </p>

                        <div class="course-card-footer">

                            <span>
                                Capacity:
                                <?php echo (int) $course['capacity']; ?>
                            </span>

                            <span class="course-status">
                                Available
                            </span>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty-courses">

                    <div class="empty-icon">
                        CS
                    </div>

                    <h3>
                        Courses are being prepared
                    </h3>

                    <p>
                        The course catalog will appear here when
                        courses are available.
                    </p>

                </div>

            <?php endif; ?>

        </div>

        <div class="courses-action">

            <a
                href="register.php"
                class="outline-button"
            >

                Explore Your Courses

                <span>
                    →
                </span>

            </a>

        </div>

    </div>

</section>

<section
    class="features-section"
    id="features"
>

    <div class="container">

        <div class="section-header centered">

            <span class="section-eyebrow">
                Platform Experience
            </span>

            <h2>

                Everything you need,

                <span>
                    in one place.
                </span>

            </h2>

            <p>
                UniTrack simplifies the essential parts of
                managing your university course journey.
            </p>

        </div>

        <div class="features-grid">

            <article class="feature-card">

                <div class="feature-number">
                    01
                </div>

                <div class="feature-icon-large">
                    ◇
                </div>

                <h3>
                    Discover Courses
                </h3>

                <p>
                    Search and explore Computer Science courses
                    with clear information about instructors,
                    credits, and capacity.
                </p>

            </article>

            <article class="feature-card featured">

                <div class="feature-number">
                    02
                </div>

                <div class="feature-icon-large">
                    +
                </div>

                <h3>
                    Manage Enrollment
                </h3>

                <p>
                    Enroll in courses and manage your selections
                    through a fast and responsive experience.
                </p>

            </article>

            <article class="feature-card">

                <div class="feature-number">
                    03
                </div>

                <div class="feature-icon-large">
                    ↗
                </div>

                <h3>
                    Track Progress
                </h3>

                <p>
                    Access your enrolled courses and academic
                    history from your personalized dashboard.
                </p>

            </article>

            <article class="feature-card">

                <div class="feature-number">
                    04
                </div>

                <div class="feature-icon-large">
                    ◉
                </div>

                <h3>
                    Secure by Design
                </h3>

                <p>
                    Authentication, authorization, password hashing,
                    CSRF protection, prepared statements, and encryption.
                </p>

            </article>

        </div>

    </div>

</section>

<section
    class="about-section"
    id="about"
>

    <div class="container about-grid">

        <div class="about-visual">

            <div class="about-main-card">

                <div class="about-card-header">

                    <span>
                        UniTrack
                    </span>

                    <span class="live-badge">
                        SYSTEM
                    </span>

                </div>

                <div class="about-big-text">
                    CS
                </div>

                <div class="about-card-title">
                    Computer Science
                </div>

                <div class="about-card-subtitle">
                    University Course Management
                </div>

                <div class="about-progress">

                    <div class="progress-heading">

                        <span>
                            Academic Journey
                        </span>

                        <span>
                            Organized
                        </span>

                    </div>

                    <div class="progress-track">

                        <div class="progress-fill"></div>

                    </div>

                </div>

            </div>

        </div>

        <div class="about-content">

            <span class="section-eyebrow">
                About UniTrack
            </span>

            <h2>

                Built around the

                <span>
                    student experience.
                </span>

            </h2>

            <p>
                UniTrack is a full-stack university course
                management system focused on Computer Science.
                It connects students, courses, instructors,
                and academic administration through one platform.
            </p>

            <div class="about-list">

                <div class="about-list-item">

                    <span>
                        ✓
                    </span>

                    <div>

                        <strong>
                            Student-focused
                        </strong>

                        <p>
                            Simple tools for discovering and
                            managing courses.
                        </p>

                    </div>

                </div>

                <div class="about-list-item">

                    <span>
                        ✓
                    </span>

                    <div>

                        <strong>
                            Administrator control
                        </strong>

                        <p>
                            Centralized management of courses,
                            instructors, departments, and students.
                        </p>

                    </div>

                </div>

                <div class="about-list-item">

                    <span>
                        ✓
                    </span>

                    <div>

                        <strong>
                            Secure architecture
                        </strong>

                        <p>
                            Designed with modern backend security
                            practices.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="cta-section">

    <div class="cta-glow"></div>

    <div class="container cta-container">

        <div class="cta-content">

            <span class="section-eyebrow">
                Get Started
            </span>

            <h2>
                Ready to organize
                your academic journey?
            </h2>

            <p>
                Create your student account and start exploring
                the Computer Science course catalog.
            </p>

        </div>

        <div class="cta-actions">

            <a
                href="register.php"
                class="cta-primary"
            >
                Create Account
                <span>→</span>
            </a>

            <a
                href="login.php"
                class="cta-secondary"
            >
                Sign In
            </a>

        </div>

    </div>

</section>

</main>

<footer class="site-footer">

    <div class="container footer-top">

        <div class="footer-brand">

            <a
                href="index.php"
                class="brand"
            >

                <div class="brand-icon">
                    U
                </div>

                <div class="brand-info">

                    <strong>
                        UniTrack
                    </strong>

                    <span>
                        Computer Science
                    </span>

                </div>

            </a>

            <p>
                A modern university course management
                experience built for Computer Science.
            </p>

        </div>

        <div class="footer-links">

            <div>

                <strong>
                    Platform
                </strong>

                <a href="#courses">
                    Courses
                </a>

                <a href="#features">
                    Features
                </a>

                <a href="#about">
                    About
                </a>

            </div>

            <div>

                <strong>
                    Account
                </strong>

                <a href="login.php">
                    Sign In
                </a>

                <a href="register.php">
                    Register
                </a>

            </div>

        </div>

    </div>

    <div class="container footer-bottom">

        <span>
            © <?php echo date('Y'); ?> UniTrack
        </span>

        <span>
            University Course Management System
        </span>

    </div>

</footer>

</body>

</html>