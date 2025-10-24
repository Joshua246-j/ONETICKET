<?php
// Assume 'includes/header.php' contains:
// 1. Bootstrap CSS link (e.g., v5.3)
// 2. Bootstrap Icons CSS link
// 3. AOS CSS link
// 4. Link to Google Fonts: Poppins (for body/tagline) and Montserrat (for headings/motto)
// 5. Link to your custom style.css file: <link rel="stylesheet" href="style.css">
include 'includes/header.php';
?>

<section class="hero-section position-relative">
    <video autoplay muted loop class="hero-video" preload="auto">
        <source src="https://cdn.pixabay.com/video/2019/09/09/26726-359604118_large.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="hero-overlay"></div>

    <div class="hero-content container position-relative z-3 text-center">
        <h1 class="hero-title display-2 fw-800" data-aos="fade-up" data-aos-duration="800">
            All Your Events.<br><span class="text-gradient">One Seamless Ticket.</span>
        </h1>
        <p class="hero-subtitle lead mt-4" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
            The easiest way to book the best in sports, cinema, music, and nightlife. Find your next moment, instantly.
        </p>
        <div class="hero-buttons mt-5" data-aos="fade-up" data-aos-delay="400" data-aos-duration="800">
            <a href="events.php" class="btn btn-hero-primary btn-lg">
                <i class="bi bi-search"></i> Discover Events
            </a>
            <a href="#featured" class="btn btn-hero-secondary btn-lg">
                <i class="bi bi-arrow-down"></i> Browse Featured
            </a>
        </div>
    </div>
</section>

<section class="category-section py-5">
    <div class="container">
        <h2 class="section-title text-center mb-2" data-aos="fade-up">Explore Our World of Events</h2>
        <p class="section-subtitle text-center" data-aos="fade-up" data-aos-delay="100">Find the perfect experience for
            every passion</p>

        <div class="row g-4 mt-3">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <a href="events.php?category=cinema" class="text-decoration-none">
                    <div class="category-card cinema-card"
                        style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSttvjzYD3nKoUKQ3mDEwwUnrv4XxBa5QFZIXiN6fNX7aDboaWOrrFU4GEQCkaDHxMJVrk&usqp=CAU');">
                        <div class="category-icon"> <i class="bi bi-film"></i> </div>
                        <h4 class="category-name">Cinema & Film</h4>
                        <p class="category-desc">Latest releases and classic screenings.</p>
                        <span class="category-link">Explore →</span>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <a href="events.php?category=sports" class="text-decoration-none">
                    <div class="category-card sports-card"
                        style="background-image: url('https://img.freepik.com/premium-photo/soccer-ball-grass-with-stars-it_916191-349245.jpg');">
                        <div class="category-icon"> <i class="bi bi-trophy"></i> </div>
                        <h4 class="category-name">Live Sports</h4>
                        <p class="category-desc">Cricket, Football, Tennis, & more action.</p>
                        <span class="category-link">Explore →</span>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <a href="events.php?category=concerts" class="text-decoration-none">
                    <div class="category-card concert-card"
                        style="background-image: url('https://images.unsplash.com/photo-1514525253161-7a46d19cd819?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0OTg3NjF8MHwxfHNlYXJjaHwxMnx8bGl2ZSUyMGNvbmNlcnR8ZW58MHx8fHwxNjk5NjE1OTgyfDA&ixlib=rb-4.0.3&q=80&w=500');">
                        <div class="category-icon"> <i class="bi bi-music-note-beamed"></i> </div>
                        <h4 class="category-name">Concerts & Music</h4>
                        <p class="category-desc">From massive festivals to intimate gigs.</p>
                        <span class="category-link">Explore →</span>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <a href="events.php?category=parties" class="text-decoration-none">
                    <div class="category-card party-card"
                        style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSy1_-CtaHKfJ4P5lrBXGx0OmVKg5EwqQKovg&s');">
                        <div class="category-icon"> <i class="bi bi-balloon-heart"></i> </div>
                        <h4 class="category-name">Parties & Nightlife</h4>
                        <p class="category-desc">The hottest club nights and celebrations.</p>
                        <span class="category-link">Explore →</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="featured-events py-5" id="featured">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <h2 class="section-title mb-2">Featured Events</h2>
                <p class="section-subtitle">Trending and must-see events this season</p>
            </div>
            <a href="events.php" class="btn btn-view-all">View All Events →</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="event-card">
                    <div class="card-image-wrapper">
                        <img src="https://static.wixstatic.com/media/e79a65_7dd1739f080c48198929bf37c0a55920~mv2.jpg/v1/fill/w_640,h_360,fp_0.50_0.50,q_80,usm_0.66_1.00_0.01,enc_auto/e79a65_7dd1739f080c48198929bf37c0a55920~mv2.jpg"
                            class="card-img" alt="Summer Music Festival">

                        <span class="event-tag trending-tag">
                            <i class="bi bi-fire"></i> TRENDING
                        </span>
                    </div>
                    <div class="event-card-content">
                        <div class="event-category-badge concert-badge">CONCERT</div>
                        <h5 class="event-title">Global Summer Festival</h5>
                        <div class="event-details">
                            <div class="detail-item">
                                <i class="bi bi-calendar3"></i>
                                <span>Dec 25, 2025</span>
                            </div>
                            <div class="detail-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Mumbai</span>
                            </div>
                        </div>
                        <p class="event-description">Top international and local artists performing live for three days.
                        </p>
                        <div class="event-footer">
                            <span class="event-price">₹1,499</span>
                            <!-- FIX APPLIED HERE -->
                            <a href="events.php" class="btn btn-book-event">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="event-card">
                    <div class="card-image-wrapper">
                        <img src="https://wallpapers.com/images/hd/inception-movie-poster-dream-is-real-9ei1rpyath620n92.jpg"
                            class="card-img" alt="Inception Remastered">
                        <span class="event-tag new-tag">
                            <i class="bi bi-star"></i> NEW
                        </span>
                    </div>
                    <div class="event-card-content">
                        <div class="event-category-badge cinema-badge">CINEMA</div>
                        <h5 class="event-title">Inception: 4K Re-release</h5>
                        <div class="event-details">
                            <div class="detail-item">
                                <i class="bi bi-calendar3"></i>
                                <span>Dec 20, 2025</span>
                            </div>
                            <div class="detail-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Delhi</span>
                            </div>
                        </div>
                        <p class="event-description">Christopher Nolan's masterpiece in stunning IMAX format.</p>
                        <div class="event-footer">
                            <span class="event-price">₹399</span>
                            <!-- FIX APPLIED HERE -->
                            <a href="events.php" class="btn btn-book-event">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="event-card">
                    <div class="card-image-wrapper">
                        <img src="https://i.ytimg.com/vi/cukmeaDXqd8/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLCpo8I8KGqlI7-gvSrWDiGq3NUHEQ"
                            class="card-img" alt="IPL Finals 2025">
                        <span class="event-tag live-tag">
                            <i class="bi bi-broadcast"></i> LIVE
                        </span>
                    </div>
                    <div class="event-card-content">
                        <div class="event-category-badge sports-badge">SPORTS</div>
                        <h5 class="event-title">Cricket League Finals 2026</h5>
                        <div class="event-details">
                            <div class="detail-item">
                                <i class="bi bi-calendar3"></i>
                                <span>Jan 5, 2026</span>
                            </div>
                            <div class="detail-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Bangalore</span>
                            </div>
                        </div>
                        <p class="event-description">Witness cricket's biggest showdown live at the stadium.</p>
                        <div class="event-footer">
                            <span class="event-price">₹2,999</span>
                            <!-- FIX APPLIED HERE -->
                            <a href="events.php" class="btn btn-book-event">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="event-card">
                    <div class="card-image-wrapper">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQt5nUKr_6KcWmoNY4I4JMH9l6Y8HQ96O0O5A&s"
                            class="card-img" alt="New Year Bash">
                        <span class="event-tag hot-tag">
                            <i class="bi bi-lightning"></i> HOT
                        </span>
                    </div>
                    <div class="event-card-content">
                        <div class="event-category-badge party-badge">PARTY</div>
                        <h5 class="event-title">The Grand New Year Bash</h5>
                        <div class="event-details">
                            <div class="detail-item">
                                <i class="bi bi-calendar3"></i>
                                <span>Dec 31, 2025</span>
                            </div>
                            <div class="detail-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Goa</span>
                            </div>
                        </div>
                        <p class="event-description">Ring in the new year with epic celebrations and live DJ sets on the
                            beach.</p>
                        <div class="event-footer">
                            <span class="event-price">₹899</span>
                            <!-- FIX APPLIED HERE -->
                            <a href="events.php" class="btn btn-book-event">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="event-card">
                    <div class="card-image-wrapper">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTkfxOi6v3TuBJOxtqsNrWeZdrknqcrtpUPPg0zMC32mNbFY8pPxmbS83pcEotmYv7ygM&usqp=CAU"
                            class="card-img" alt="Broadway Night">
                        <span class="event-tag popular-tag">
                            <i class="bi bi-hand-thumbs-up"></i> POPULAR
                        </span>
                    </div>
                    <div class="event-card-content">
                        <div class="event-category-badge concert-badge">THEATRE</div>
                        <h5 class="event-title">Broadway Opera Night</h5>
                        <div class="event-details">
                            <div class="detail-item">
                                <i class="bi bi-calendar3"></i>
                                <span>Jan 2, 2026</span>
                            </div>
                            <div class="detail-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Hyderabad</span>
                            </div>
                        </div>
                        <p class="event-description">World-class theatrical performances in a stunning historic venue.
                        </p>
                        <div class="event-footer">
                            <span class="event-price">₹1,299</span>
                            <!-- FIX APPLIED HERE -->
                            <a href="events.php" class="btn btn-book-event">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="event-card">
                    <div class="card-image-wrapper">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ1nuFSIxPVBmFLmJPKAvaOYlthWErO_u7I_OaOnnjfgPNsrCxH5ZR6D87OQNu4XSy4WNA&usqp=CAU"
                            class="card-img" alt="Tennis Grand Slam">
                        <span class="event-tag special-tag">
                            <i class="bi bi-star-fill"></i> SPECIAL
                        </span>
                    </div>
                    <div class="event-card-content">
                        <div class="event-category-badge sports-badge">SPORTS</div>
                        <h5 class="event-title">International Tennis Open</h5>
                        <div class="event-details">
                            <div class="detail-item">
                                <i class="bi bi-calendar3"></i>
                                <span>Jan 15, 2026</span>
                            </div>
                            <div class="detail-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Chennai</span>
                            </div>
                        </div>
                        <p class="event-description">International championship featuring top-ranked players worldwide.
                        </p>
                        <div class="event-footer">
                            <span class="event-price">₹1,599</span>
                            <!-- FIX APPLIED HERE -->
                            <a href="events.php" class="btn btn-book-event">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer py-5 mt-5" style="background-color: #1A1A1A; color: #fff;">
    <div class="container">
        <div class="row g-4 mb-4">
            <!-- Brand -->
            <div class="col-lg-3 col-md-6">
                <h5
                    style="font-family: 'Montserrat', sans-serif; color: #a3ff12; font-weight: 700; margin-bottom: 1rem;">
                    <i class="bi bi-ticket-perforated"></i> ONETICKET
                </h5>
                <p style="color: #ffffff;">Your one-stop solution for all event tickets. Book instantly, celebrate
                    endlessly.</p>
            </div>
            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6">
                <h6 style="font-family: 'Montserrat', sans-serif; font-weight: 700; color: #ffffff;">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="about.php" style="color: #ffffff; text-decoration: none;">About Us</a></li>
                    <li><a href="events.php" style="color: #ffffff; text-decoration: none;">Events</a></li>
                    <li><a href="contact.php" style="color: #ffffff; text-decoration: none;">Contact</a></li>
                </ul>
            </div>
            <!-- Support -->
            <div class="col-lg-3 col-md-6">
                <h6 style="font-family: 'Montserrat', sans-serif; font-weight: 700; color: #ffffff;">Support</h6>
                <ul class="list-unstyled">
                    <li><a href="#" style="color: #ffffff; text-decoration: none;">Help Center</a></li>
                    <li><a href="#" style="color: #ffffff; text-decoration: none;">Privacy Policy</a></li>
                    <li><a href="#" style="color: #ffffff; text-decoration: none;">Terms & Conditions</a></li>
                </ul>
            </div>
            <!-- Social -->
            <div class="col-lg-3 col-md-6">
                <h6 style="font-family: 'Montserrat', sans-serif; font-weight: 700; color: #ffffff;">Follow Us</h6>
                <div class="d-flex gap-3">
                    <a href="#" style="color: #ffffff; font-size: 1.25rem;" title="Facebook"><i
                            class="bi bi-facebook"></i></a>
                    <a href="#" style="color: #ffffff; font-size: 1.25rem;" title="Twitter"><i
                            class="bi bi-twitter-x"></i></a>
                    <a href="#" style="color: #ffffff; font-size: 1.25rem;" title="Instagram"><i
                            class="bi bi-instagram"></i></a>
                    <a href="#" style="color: #ffffff; font-size: 1.25rem;" title="LinkedIn"><i
                            class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>

        <hr style="border-color: #a3ff12;">

        <div class="text-center" style="color: #ffffff;">
            <p>&copy; 2025 ONETICKET. All rights reserved. | Designed with <i class="bi bi-heart-fill"
                    style="color: #ff4757;"></i> for ticket lovers</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 600,
        easing: 'ease-in-out',
        once: true,
        offset: 50
    });

</script>

</body>

</html>