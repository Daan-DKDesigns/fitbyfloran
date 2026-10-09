<?php
/**
 * Maintenance Page
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fit by Floran | Binnenkort live</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            background: #000;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
        }

        .maintenance {
            min-height: 100vh;
            min-height: 100svh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .maintenance__content {
            width: 100%;
            max-width: 700px;
            text-align: center;
        }

        .maintenance__logo {
            width: 100%;
            max-width: 500px;
            height: auto;
            display: block;
            margin: 0 auto 55px;
        }

        .maintenance__title {
            font-size: clamp(28px, 5vw, 46px);
            font-weight: 400;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .maintenance__line {
            width: 70px;
            height: 2px;
            background: #c9a15b;
            margin: 30px auto;
        }

        .maintenance__text {
            max-width: 520px;
            margin: 0 auto;
            color: #bdbdbd;
            font-size: clamp(16px, 2vw, 19px);
            line-height: 1.7;
        }

        .maintenance__brand {
            margin-top: 30px;
            color: #c9a15b;
            font-size: 13px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
        }

        @media (max-width: 600px) {

            .maintenance {
                padding: 30px 20px;
            }

            .maintenance__logo {
                max-width: 360px;
                margin-bottom: 40px;
            }

            .maintenance__title {
                letter-spacing: 0.05em;
            }

            .maintenance__text {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

<main class="maintenance">

    <div class="maintenance__content">

        <img
            class="maintenance__logo"
            src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.jpg'); ?>"
            alt="Fit by Floran"
        >

        <h1 class="maintenance__title">
            Binnenkort live
        </h1>

        <div class="maintenance__line"></div>

        <p class="maintenance__text">
            De nieuwe website van Fit by Floran is momenteel in ontwikkeling. test23adad
            Binnenkort kun je hier alles vinden over high performance
            fysiotherapie en persoonlijke begeleiding.
        </p>

        <div class="maintenance__line"></div>

        <p class="maintenance__brand">
            High Performance Physiotherapy
        </p>

    </div>

</main>

</body>
</html>