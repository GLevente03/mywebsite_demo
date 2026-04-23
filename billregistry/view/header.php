
<header>
    <!-- LEFT SECTION OF MENU -->
    <div class="left-section">
        <a href="/index.php">
            <img src="/images/logo.png" alt="Levi around the world logo" class="logo">
        </a>
    </div>
    <!-- MIDDLE SECTION OF MENU -->
    <div class="middle-section">
        <button class="about-me-button">
            About me
        </button>
        <button class="my-trips-button">
            My Trips
        </button>
        <button class="portfolio-button">
            Portfolio
        </button>
        <button class="contact-button">
            Contact
        </button>
    </div>
    <!-- RIGHT SECTION OF MENU -->
    <div class="right-section">
        <button class="language-change-button hu"></button>
        <?php 
            if(isset($_SESSION["userid"]))
            {
        ?>
            <li class="profile-btn">
                <a href="/profile.php">
                    <div class="profile-flex">
                        <span class="material-symbols-outlined">account_circle</span><?php echo htmlspecialchars($_SESSION["username"]); ?>
                    </div>
                </a>
            </li>
            <li class="logout-btn">
                <a href="/controller/logout.conr.php">
                    <div class="logout-flex">
                        <span class="material-symbols-outlined">logout</span><div>LOGOUT</div>
                    </div>
                </a>
            </li>

        <?php
            }
            else
            {
        ?>
            <li class="logout-btn">
                <a href="/signup.php">
                    <div class="login-flex">
                        <span class="material-symbols-outlined">person_add</span>SIGN UP
                    </div>
                </a>
            </li>
            <li class="login-btn">
                <a href="/login.php">
                    <div class="login-flex">
                        <span class="material-symbols-outlined">login</span>LOG IN
                    </div>
                </a>
            </li>
        <?php
            }
        ?>
    </div>
</header>
