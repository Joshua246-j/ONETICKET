<?php
// Includes header from the 'includes' folder
include 'includes/header.php';

// FIX: Correct path to the connection file
include 'db/connection.php';

/**
 * Helper function to determine event card styling and tag text based on category.
 */
function get_category_style($category, $is_featured)
{
    if ($is_featured == 1) {
        return ['tag_class' => 'tag-trending', 'btn_class' => 'btn-green', 'tag_text' => 'FEATURED'];
    }

    switch (strtoupper($category)) {
        case 'CONCERT':
        case 'PARTY':
            return ['tag_class' => 'tag-trending', 'btn_class' => 'btn-green', 'tag_text' => strtoupper($category)];
        case 'CINEMA':
        case 'THEATRE':
            return ['tag_class' => 'tag-new', 'btn_class' => 'btn-orange', 'tag_text' => strtoupper($category)];
        case 'SPORTS':
        default:
            return ['tag_class' => 'tag-live', 'btn_class' => 'btn-blue', 'tag_text' => strtoupper($category)];
    }
}

/**
 * Helper function to map the event name to a specific, unique Unsplash image URL.
 * NOTE: This function provides a unique image for all 15 events visible in your database screenshot.
 */
function get_image_source($event_name, $category)
{
    // Convert event name to lowercase for reliable matching
    $name = strtolower($event_name);

    // --- Assign SPECIFIC URLs based on Event NAME ---
    // (1) Global Summer Festival (CONCERT)
    if (strpos($name, 'global summer festival') !== false) {
        return 'https://wallpapercat.com/w/full/5/9/b/1161302-3840x2160-desktop-4k-concert-wallpaper.jpg';
    }
    // (2) Inception 4K Re-release (CINEMA)
    elseif (strpos($name, 'inception 4k re-release') !== false) {
        return 'https://wallpapercave.com/wp/wp11374646.jpg';
    }
    // (3) Cricket League Finals 2026 (SPORTS)
    elseif (strpos($name, 'cricket league finals') !== false) {
        return 'https://i.ytimg.com/vi/cukmeaDXqd8/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLCpo8I8KGqlI7-gvSrWDiGq3NUHEQ';
    }
    // (4) The Grand New Year Bash (PARTY)
    elseif (strpos($name, 'grand new year bash') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQt5nUKr_6KcWmoNY4I4JMH9l6Y8HQ96O0O5A&s';
    }
    // (5) Broadway Opera Night (THEATRE)
    elseif (strpos($name, 'broadway opera night') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTkfxOi6v3TuBJOxtqsNrWeZdrknqcrtpUPPg0zMC32mNbFY8pPxmbS83pcEotmYv7ygM&usqp=CAU';
    }
    // (6) International Tennis Open (SPORTS)
    elseif (strpos($name, 'international tennis open') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ1nuFSIxPVBmFLmJPKAvaOYlthWErO_u7I_OaOnnjfgPNsrCxH5ZR6D87OQNu4XSy4WNA&usqp=CAU';
    }
    // (7) Vintage Bollywood Film Screening (CINEMA)
    elseif (strpos($name, 'vintage bollywood film screening') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQqlcxu6Ox14opYC4GndP0lAKL3_WkJJKB1bg&s';
    }
    // (8) International Robotics Expo (THEATRE/EXPO)
    elseif (strpos($name, 'international robotics expo') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTzko8x_aiqRgZ94p1hAOpEFbXBKS2KCeNYsw&s';
    }
    // (9) Indie Rock Band Showcase (CONCERT)
    elseif (strpos($name, 'indie rock band showcase') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvVz4iMzIlpQA0XM5DKCNqNn2OrvEt81mCMA&s';
    }
    // (10) Mountain Biking Championship (SPORTS)
    elseif (strpos($name, 'mountain biking championship') !== false) {
        return 'https://assets.usacycling.org/prod/assets/_1200xAUTO_crop_center-center_none/2024-MTB-Worlds-How-to-Watch-1130x600.jpg';
    }
    // (11) Silent Disco Beach Party (PARTY)
    elseif (strpos($name, 'silent disco beach party') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-GdmfJcnj7eyNvYN7KAICzHo3MPWpKOdtFw&s';
    }
    // (12) National Debate Championship (THEATRE)
    elseif (strpos($name, 'national debate championship') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRjYMVL_6T-kk0nn0PtTADPNV-PkvNx-hN1Eg&s';
    }
    // (13) F1 Car Race Viewing Party (SPORTS)
    elseif (strpos($name, 'f1 car race viewing party') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwgfsxa_ncshivfwGLdUrVhmn6SfMkPcmh4Q&s';
    }
    // (14) Classic Horror Movie Night (CINEMA)
    elseif (strpos($name, 'classic horror movie night') !== false) {
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkw8Q-9FyTt0TatV8xT5Tp8Rkal3-MPM-vvA&s';
    }
    // (15) Sufi Music Night (CONCERT)
    elseif (strpos($name, 'sufi music night') !== false) {
        return 'https://www.ualberta.ca/en/botanic-garden/media-library/images/events/updated-sufi-picture-169.jpg';
    }
    // --- Fallback default if a new event is added and doesn't match above ---
    else {
        return 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&w=800&q=80';
    }
}
?>

<body style="background-color: #0B0B0B; color: #F5F5F5;">

    <section
        class="hero-section hero-full-screen position-relative text-center d-flex align-items-center justify-content-center">
        <div class="hero-overlay"></div>
        <div class="container position-relative z-1 py-5">
            <h1 class="display-2 fw-bolder" style="font-family: 'Montserrat', sans-serif;">FIND YOUR NEXT ADVENTURE</h1>
            <p class="lead mt-3 mx-auto" style="font-family: 'Inter', sans-serif; color: #E0E0E0; max-width: 600px;">
                Browse and book tickets for the best **Concerts, Sports, Cinema, and Theatre** events happening near
                you.
            </p>
            <a href="#events-grid-start" class="btn btn-lg btn-hero mt-4">EXPLORE ALL EVENTS</a>
        </div>
    </section>

    <section class="events-section py-5" id="events-grid-start">
        <div class="container">
            <div class="row g-4">

                <?php
                if (isset($conn) && $conn) {

                    $sql = "SELECT id, name, category, price, date, time, location, image_url, is_featured 
                            FROM events 
                            ORDER BY date ASC, time ASC";

                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($event = mysqli_fetch_assoc($result)) {

                            $styles = get_category_style($event['category'], $event['is_featured']);

                            // Format data
                            $display_date = date("M j, Y", strtotime($event['date']));
                            $display_time = date("g:i A", strtotime($event['time']));

                            // *** IMPORTANT: Fetching the unique image URL based on name and category ***
                            $image_src = get_image_source($event['name'], $event['category']);

                            $description = "Join the **" . htmlspecialchars($event['category']) . "** event in **" . htmlspecialchars($event['location']) . "** on " . $display_date . ".";
                            $display_price = '₹' . number_format($event['price']);

                            ?>

                            <div class="col-lg-4 col-md-6">
                                <div class="event-card">
                                    <div class="card-image-container">
                                        <img src="<?php echo htmlspecialchars($image_src); ?>" class="card-img-top"
                                            alt="<?php echo htmlspecialchars($event['name']); ?>">

                                        <span
                                            class="card-tag <?php echo htmlspecialchars($styles['tag_class']); ?>"><?php echo htmlspecialchars($styles['tag_text']); ?></span>
                                    </div>
                                    <div class="card-content">
                                        <div class="event-meta">
                                            <span><i class="bi bi-calendar3"></i> <?php echo htmlspecialchars($display_date); ?>
                                                (<?php echo htmlspecialchars($display_time); ?>)</span>
                                            <span><i class="bi bi-geo-alt-fill"></i>
                                                <?php echo htmlspecialchars($event['location']); ?></span>
                                        </div>
                                        <h5 class="event-title"><?php echo htmlspecialchars($event['name']); ?></h5>
                                        <p class="event-description">
                                            <?php echo $description; ?>
                                        </p>
                                        <div class="event-footer">
                                            <span class="event-price"><?php echo $display_price; ?></span>
                                            <a href="booking.php?event_id=<?php echo $event['id']; ?>"
                                                class="btn btn-book <?php echo htmlspecialchars($styles['btn_class']); ?>">Book
                                                Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="col-12"><p class="text-center lead mt-5">🎉 No upcoming events right now. Check back soon for new listings! 🎉</p></div>';
                    }

                    mysqli_close($conn);
                } else {
                    echo '<div class="col-12"><p class="text-center lead mt-5" style="color: #FF6347;">⚠️ Database connection error. Check your `db/connection.php` path. ⚠️</p></div>';
                }
                ?>

            </div>
        </div>
    </section>

    <style>
        /* HERO SECTION STYLES */
        .hero-full-screen {
            height: 80vh;
            min-height: 500px;
            background: url('https://media.istockphoto.com/id/1170930016/photo/photo-of-many-party-people-buddies-dancing-yellow-lights-confetti-flying-everywhere-nightclub.jpg?s=612x612&w=0&k=20&c=Jz5t9Beqa-8AIK3JQIQqE1HAsNWrfCBsLQqZC1D7N5U=') center center;
            background-size: cover;
            background-attachment: fixed;
            color: #F5F5F5;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            z-index: 0;
        }

        .btn-hero {
            background-color: #A3FF12;
            color: #0B0B0B;
            font-weight: bold;
            border-radius: 50px;
            padding: 12px 30px;
            transition: background-color 0.3s ease;
        }

        .btn-hero:hover {
            background-color: #8CDB10;
        }

        /* EVENT CARD STYLES */
        .event-card {
            background-color: #121212;
            border: 1px solid #222;
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .event-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.7);
            border-color: #333;
        }

        .card-image-container {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .card-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease, filter 0.3s ease;
            filter: brightness(85%);
            border-radius: 12px 12px 0 0;
        }

        .event-card:hover img {
            transform: scale(1.05);
            filter: brightness(100%);
        }

        .card-tag {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
        }

        .tag-trending {
            background-color: #A3FF12;
        }

        .tag-new {
            background-color: #FFA500;
        }

        .tag-live {
            background-color: #00BFFF;
        }

        .card-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .event-meta {
            font-size: 0.85rem;
            color: #CCCCCC;
            margin-bottom: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .event-meta i {
            margin-right: 5px;
        }

        .event-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #F5F5F5;
        }

        .event-description {
            font-size: 0.9rem;
            color: #CCCCCC;
            flex-grow: 1;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .event-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #222;
            padding-top: 15px;
            margin-top: auto;
        }

        .event-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #A3FF12;
        }

        .btn-book {
            color: #0B0B0B;
            font-weight: bold;
            border: none;
            border-radius: 20px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-book:hover {
            background-color: #7300ffff;
            opacity: 0.9;
            transform: scale(1.05);
            color: #000;
        }

        .btn-green {
            background-color: #A3FF12;
        }

        .btn-orange {
            background-color: #FFA500;
        }

        .btn-blue {
            background-color: #00BFFF;
        }
    </style>

</body>

<?php include 'includes/footer.php'; ?>