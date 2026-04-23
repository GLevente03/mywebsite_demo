<div class="overlay"></div>
<header>
    <!-- LEFT SECTION OF MENU -->
    <div class="left-section">
        <a href="/index.php">
            <img src="/images/logo.png" alt="Levi around the world logo" class="logo">
        </a>
    </div>
    <!-- MIDDLE SECTION OF MENU -->
    <div class="middle-section">
        <a href="/about_me.php">
            <button class="about-me-button">
                <?php echo $translations['about-me']; ?>
            </button>
        </a>
        <a href="/my_trips.php">
            <button class="about-me-button">
                <?php echo $translations['my-trips']; ?>
            </button>
        </a>
        <a href="/portfolio.php">
            <button class="about-me-button">
                <?php echo $translations['portfolio']; ?>
            </button>
        </a>
        <a href="/contact.php">
            <button class="contact-button">
                <?php echo $translations['contact']; ?>
            </button>
        </a>
    </div>
    <!-- RIGHT SECTION OF MENU -->
    <div class="right-section">
        <button class="language-change-button en"></button>
        <?php 
            if(isset($_SESSION["userid"]))
            {
        ?>
            <li class="profile-btn">
                <a href="/profile.php">
                    <div class="profile-flex">
                        <span class="material-symbols-outlined">account_circle</span><?php echo htmlspecialchars($_SESSION["fullName"]); ?>
                    </div>
                </a>
            </li>
            <li class="logout-btn">
                <a href="/controller/logout.conr.php">
                    <div class="logout-flex">
                        <span class="material-symbols-outlined">logout</span><div><?php echo $translations['log-out']; ?></div>
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
                        <span class="material-symbols-outlined">person_add</span><?php echo $translations['sign-up']; ?>
                    </div>
                </a>
            </li>
            <li class="login-btn">
                <a href="/login.php">
                    <div class="login-flex">
                        <span class="material-symbols-outlined">login</span><?php echo $translations['log-in']; ?>
                    </div>
                </a>
            </li>
        <?php
            }
        ?>
     <!-- HAMBURGER MENU WHEN SCREEN WIDTH <= 900 PX -->
        <div class="hamburger" onclick="toggleMenu(this)">
            <div class="bar bar1"></div>
            <div class="bar bar2"></div>
            <div class="bar bar3"></div>
        </div>
    </div>
    <div id="myMenu" class="menu">
        <?php 
            if(isset($_SESSION["userid"]))
            {
        ?>
            <li class="profile-btn-hamburger">
                <a href="/profile.php">
                    <div class="profile-flex-hamburger">
                        <span class="material-symbols-outlined">account_circle</span><?php echo htmlspecialchars($_SESSION["fullName"]); ?>
                    </div>
                </a>
            </li>
            <li class="logout-btn-hamburger">
                <a href="/controller/logout.conr.php">
                    <div class="logout-flex-hamburger">
                        <span class="material-symbols-outlined">logout</span><div><?php echo $translations['log-out']; ?></div>
                    </div>
                </a>
            </li>

        <?php
            }
            else
            {
        ?>
            <li class="logout-btn-hamburger">
                <a href="/signup.php">
                    <div class="login-flex-hamburger">
                        <span class="material-symbols-outlined">person_add</span><?php echo $translations['sign-up']; ?>
                    </div>
                </a>
            </li>
            <li class="login-btn-hamburger">
                <a href="/login.php">
                    <div class="login-flex-hamburger">
                        <span class="material-symbols-outlined">login</span><?php echo $translations['log-in']; ?>
                    </div>
                </a>
            </li>
        <?php
            }
        ?>
        <a class="menu-item" href="/about_me.php">
		<?php echo $translations['about-me']; ?>
	</a>
        <a class="menu-item" href="/my_trips.php">
		<?php echo $translations['my-trips']; ?>
	</a>
        <a class="menu-item" href="/portfolio.php">
		<?php echo $translations['portfolio']; ?>
	</a>
        <a class="menu-item" href="/contact.php">
		<?php echo $translations['contact']; ?>
	</a>
    </div>
</header>
