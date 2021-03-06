<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widget Calculator</title>
    <link rel="icon" href="/favicon.png">
    <style>
    @font-face {
        font-family: IBM Plex Sans;
        src: url("/fonts/plex-roman.woff2") format("woff2-variations");
        font-weight: 400 700;
        font-style: normal;
        unicode-range: U+0000-00A4, U+0020, U+00A0, U+2013-201E, U+2022, U+2026, U+00D7, U+2192;
    }

    :root {
        font-family: IBM Plex Sans, sans-serif;
        background-color: #fff;
        color: #1f292e;
        color-scheme: light;
        font-size: 16px;
    }

    body {
        max-width: 480px;
        margin: 0 auto;
        padding: 20px;
    }

    form {
        margin-top: 40px;
    }

    a {
        color: #2f9e8c;
    }

    h1 {
        font-size: calc(2.25rem);
    }

    h2 {
        font-size: calc(1.5rem);
    }

    @media (prefers-color-scheme: dark) {
        :root {
            background-color: #111618;
            color: #fff;
            color-scheme: dark;
        }

        a {
            color: #5cbcae;
        }
    }
    </style>
</head>
<body>
    <h1>Widget Calculator</h1>

    <p>
        A coding challenge. Rules and code at
        <a href="https://github.com/dalemartyn/widget-calculator">
            https://github.com/dalemartyn/widget-calculator
        </a>.
    </p>

    <?php
    if (isset($_GET['widgets'])) {
        $widgets = (int) filter_var($_GET['widgets'], FILTER_SANITIZE_NUMBER_INT);
        if ($widgets < 0) {
            $widgets = 0;
        } elseif ($widgets > 30000) {
            $widgets = 30000;
        }
    } else {
        $widgets = 0;
    }
    ?>

    <form action="/" method="GET">
        Number of widgets required:
        <input type="number" name="widgets" value="<?php echo $widgets; ?>" min="0" max="30000">
        <button type="submit">Submit</button>
    </form>
    <?php

    require('../vendor/autoload.php');

    use WallysWidgets\WidgetCalculator;

    if ($widgets > 0) {
        $calculator = new WidgetCalculator([
            250,
            500,
            1000,
            2000,
            5000
        ]);

        $packages = $calculator->calculatePackages($widgets);

        ?>

        <h2>Packs:</h2>

        <ul>
            <?php
            foreach ($packages as $package => $count) {
                echo '<li>' . $package . ' × ' . $count . '</li>';
            }
            ?>
        </ul>
        <?php
    }
    ?>
</body>
</html>
