

<header class="site-header">

    <div class="header-container">

        <a href="<?= $basePath ?>index.php" class="brand">
            <img
                src="<?= $basePath ?>assets/images/logo.jpeg"
                alt="Miracle of Salvation Church Logo"
                class="site-logo"
            >

            <div class="brand-name">
                <span>MIRACLE OF</span>
                <span>SALVATION</span>
                <span>CHURCH</span>
            </div>
        </a>

        <button class="menu-toggle"
                id="menuToggle"
                type="button"
                aria-label="Open navigation menu"
                aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="main-navigation" id="mainNavigation">

            <ul class="nav-links">

                <!-- HOME: NO DROPDOWN -->
                <li>
                    <a href="<?= $basePath ?>index.php">HOME</a>
                </li>

                <!-- ABOUT US -->
                <li class="has-dropdown">
                    <a href="<?= $basePath ?>about/church-profile.php">ABOUT US</a>
                    <ul class="dropdown">
                        <li><a href="<?= $basePath ?>about/vision-bearer.php">vision bearer</a></li>
                        <li><a href="<?= $basePath ?>about/church-profile.php">church profile</a></li>
                        <li><a href="<?= $basePath ?>about/leadership.php">leadership</a></li>
                    </ul>
                </li>

                <!-- EVENTS -->
                <li class="has-dropdown">
                    <a href="<?= $basePath ?>events/upcoming-events.php">EVENTS</a>
                    <ul class="dropdown">
                        <li><a href="<?= $basePath ?>events/church-programs.php">church programs</a></li>
                        <li><a href="<?= $basePath ?>events/upcoming-events.php">upcoming events</a></li>
                        <li><a href="<?= $basePath ?>events/community-outreach.php">community outreach</a></li>
                        <li><a href="<?= $basePath ?>events/missions.php">missions</a></li>
                    </ul>
                </li>

                <!-- MINISTRIES -->
                <li class="has-dropdown">
                    <a href="<?= $basePath ?>ministries/youth.php">MINISTRIES</a>
                    <ul class="dropdown">
                        <li><a href="<?= $basePath ?>ministries/youth.php">youth ministry</a></li>
                        <li><a href="<?= $basePath ?>ministries/children.php">children's ministry</a></li>
                        <li><a href="<?= $basePath ?>ministries/fathers-mothers.php">fathers and mothers ministry</a></li>
                        <li><a href="<?= $basePath ?>ministries/gallery.php">church gallery</a></li>
                    </ul>
                </li>

                <!-- LIVESTREAM -->
                <li class="has-dropdown">
                    <a href="<?= $basePath ?>livestream/watch-live.php">LIVESTREAM</a>
                    <ul class="dropdown">
                        <li><a href="<?= $basePath ?>livestream/watch-live.php">watch live</a></li>
                        <li><a href="<?= $basePath ?>livestream/sermons.php">sermons archive</a></li>
                        <li><a href="<?= $basePath ?>livestream/videos.php">videos</a></li>
                    </ul>
                </li>

                <!-- CONTACT -->
                <li>
                    <a href="<?= $basePath ?>contact/index.php">CONTACT</a>
                </li>

                <!-- GIVE -->
                <li>
                    <a href="<?= $basePath ?>give.php" class="give-link">GIVE</a>
                </li>

            </ul>

        </nav>

    </div>

</header>
