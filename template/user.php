<section class="flex-container-center home-section">
    <div class="flex-item-center">
        <h1><?php  ?></h1>
        <p>
            Hey, <?php echo $_SESSION['user_name']; ?>. You are logged in.
            Try to close this browser tab and open it again. Still logged in!
        </p>
        <a href="index.php?logout">Logout</a>
    </div>
</section>