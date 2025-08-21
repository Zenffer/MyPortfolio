<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My Portfolio">
    <title>My Portfolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#about">About</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="about">
            <h1>About Me</h1>
            <p>Welcome to my portfolio! Here you can learn more about me and my work.</p>
        </section>

        <section id="projects">
            <h2>Projects</h2>
            <p>Check out some of my recent projects below.</p>
        </section>

        <section id="contact">
            <h2>Contact</h2>
            <p>Feel free to reach out to me for any inquiries or collaborations.</p>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>
</body>
</html>