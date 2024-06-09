<?php
include('connect.php');
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>CSD Learning Management System</title>
    <!--  *****   Link To Font Awsome Icons   *****  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="CSS/styles.css">
</head>

<body>
<section class="home" id="home">

<nav class="main-navbar">
<a href="#" class="logo">
        <img src="CSD.png" alt="Logo">
    </a>
    <ul class="nav-list">
        <li><a href="#home">Home</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#courses">Courses</a></li>
        <li><a href="#categories">Categories</a></li>
    </ul>
    <a href="signup.php" class="get-started-btn-container">
        <button class="get-started-btn btn">SIGN IN</button>
    </a>
    <div class="menu-btn">
        <span></span>
    </div>
</nav>
<!--   === Main Navbar Ends ===   -->

<div class="banner">
    
    <div class="banner-desc">
        <h2>Welcome CSD students,
            Learning starts here!</h2>
        <p>Welcome to the CSD E Learning Management System! Unlock a world of knowledge with our vast library of lesson and comprehensive file topics.
             Dive into engaging content curated by experts in various fields. Whether you're seeking to expand your skills or explore new interests, our platform offers the tools you need to succeed.</p>
    </div>

    <div class="banner-img">
        <div class="banner-img-container">
            <img src="courses/LandingPagePic.png">

            <div class="pattern">
                <img src="courses/pattern.png">
            </div>

        </div>
    </div>

</div>

</section>
<!--   *** Home Section Ends ***   -->


<!--   *** Services Section Starts ***   -->
<section class="services" id="services">

<header class="section-header">
    <h1>Why Choose Us</h1>
    <p>At CSD E Learning Management System, we recognize the importance of flexible timing, expert instruction in facilitating and Lesson sharing content and files to enrich and effective learning experiences.</p>
</header>

<div class="services-contents">

    <div class="service-box">
        <div class="service-icon">
            <i class="fa-solid fa-photo-film"></i>
        </div>
        <div class="service-desc">
            <h2>Files Sharing</h2>
            <p>Upload, share, and collaborate on documents securely.
            </p>
        </div>
    </div>

    <div class="service-box">
        <div class="service-icon">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="service-desc">
            <h2>Expert Instructors</h2>
            <p>Benefit from the guidance of seasoned experts and industry professionals who bring real-world experience and deep knowledge to their teaching.</p>
        </div>
    </div>

    <div class="service-box">
        <div class="service-icon">
            <i class="fa-solid fa-calendar"></i>
        </div>
        <div class="service-desc">
            <h2>Flexible Timing</h2>
            <p>Our flexible timing allows you to access courses and materials anytime, anywhere. Empower yourself to learn at your own pace and achieve your goals on your terms.</p>
        </div>
    </div>

</div>

</section>
<!--   *** Services Section Ends ***   -->

<!--   *** Courses Section Starts ***   -->
<section class="courses" id="courses">

<header class="section-header">
    <div class="header-text">
        <h1>Choose Your Favorite Programming Languages</h1>
        <p>The best programming language for you depends on your interests, career aspirations, and the specific requirements of your projects. It's also valuable to learn multiple languages over time to broaden your skills and adapt to different programming paradigms.</p>
    </div>
</header>

<!--   *** Courses Contents Starts ***   -->
<div class="course-contents">
    
    <div class="course-card">
        <img src="courses/HTML.png">
        <h2 class="course-title">Learn HTML: It's the code used to create and structure web pages.</h2>
    </div>

    <div class="course-card">
        <img src="courses/CSS.png">
        <h2 class="course-title">Learn CSS: It's the language used to make web pages look good. </h2>
    </div>

    <div class="course-card">
        <img src="courses/JS.png">
        <h2 class="course-title">Learn JavaScript: Used to make websites interactive and dynamic</h2>
    </div>

    <div class="course-card">
        <img src="courses/bootstrap-logo.png">
        <h2 class="course-title">Learn Bootstrap: Like a toolbox filled with pre-designed components, styles, and JavaScript plugins that you can use to quickly create professional-looking web projects.</h2>
    </div>

    <div class="course-card">
        <img src="courses/SQL.png">
        <h2 class="course-title">Learn SQL: Is a programming language used for managing and manipulating data in relational databases.</h2>
    </div>

    <div class="course-card">
        <img src="courses/c.png">
        <h2 class="course-title">Learn C: Strong foundation in programming, enables you to work closely with hardware and system resources.</h2>
    </div>

</div>

</section>
<!--   *** Courses Section Ends ***   -->

<!--   *** Courses Categories Section Starts ***   -->
<section class="categories" id="categories">

<header class="section-header">
    <h1>Offered Courses and Topics</h1>
    <p>Explore our courses! From programming, Developing and Designing, we have something for everyone. Our curated categories offer the perfect pathway to your learning goals.</p>
</header>


<div class="categories-contents">
    
    <div class="category-item">
        <div class="category-icon">
            <i class="fa-solid fa-palette"></i>
        </div>
        <div class="category-desc">
            <h3>Designing</h3>
            <p>Designing in programming is like architecting a blueprint for digital solutions. It's the creative process of crafting elegant structures and intuitive interfaces that seamlessly blend form and function</p>
        </div>
    </div>

    <div class="category-item">
        <div class="category-icon">
            <i class="fa-solid fa-code"></i>
        </div>
        <div class="category-desc">
            <h3>Development</h3>
            <p>Development in programming is the art of turning ideas into reality through code. It's the iterative process of building, refining, and optimizing software solutions to meet evolving needs. </p>
        </div>
    </div>

    <div class="category-item">
        <div class="category-icon">
            <i class="fa-solid fa-code"></i>
        </div>
        <div class="category-desc">
            <h3>Programming</h3>
            <p>Programming is the language of possibility, where lines of code transform imagination into action. It's the mastery of algorithms, logic, and syntax to create software that powers our digital world.</p>
        </div>
    </div>

    <div class="category-item">
        <div class="category-icon">
            <i class="fa-solid fa-database"></i>
        </div>
        <div class="category-desc">
            <h3>Photography</h3>
            <p>Database management is the backbone of digital organization, where data becomes knowledge and insights drive decisions. It's the meticulous design, implementation, and maintenance of structured repositories that store and retrieve information efficiently. </p>
        </div>
    </div>

</div>
</section>

<!--   *** Footer Section Starts ***   -->
<section class="footer" id="footer">
<div class="copy-rights">
    <p>Created By <b>CSD E Learning Management System</b> All Rights Reserved</p>
</div>
</section>

    <script src="script.js"></script>
</body>

</html>