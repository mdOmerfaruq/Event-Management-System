

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Event Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="owl.carousel.min.css">
    <link rel="stylesheet" href="owl.theme.default.min.css">
    <link rel="stylesheet" href="magnific-popup.css">
    <link rel="stylesheet" href="aos.css">
    <link rel="stylesheet" href="ionicons.min.css">
    <link rel="stylesheet" href="bootstrap-datepicker.css">
    <link rel="stylesheet" href="jquery.timepicker.css">
    <link rel="stylesheet" href="flaticon.css">
    <link rel="stylesheet" href="icomoon.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    
  <?php
session_start();

// Debug session data

?>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.html"><span></span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="#home" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
                <li class="nav-item"><a href="notification_user.php" class="nav-link">Favorite Clubs events</a></li>
                <li class="nav-item"><a href="All_event.php" class="nav-link">Event VIEW</a></li> 
                <li class="nav-item"><a href="join_club.php" class="nav-link">Join Clubs</a></li>
                <li class="nav-item"><a href="notifications.php" class="nav-link">Notifications</a></li>
                 <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
                <li class="nav-item"><a href="faqchat.php" class="nav-link">Live Chat</a></li>

                <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
                    <li class="nav-item text-black mt-2 mr-3">
                        Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Guest'); ?>!
                    </li>
                    <li class="nav-item cta mr-md-2"><a href="logout_db.php" class="nav-link">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item cta mr-md-2"><a href="login.php" class="nav-link">LOGIN</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


   
<!-- Home Section -->
<div id="home" class="hero-wrap js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
        <div class="col-xl-10 ftco-animate" data-scrollax="properties: { translateY: '70%' }">
          <h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Event<br><span>Avaliable 2025</span></h1>
          <p class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">United International University, Bangladesh</p>
      
        </div>
  <?php
// Set the correct timezone
date_default_timezone_set('Asia/Kolkata');  // Adjust as per your location

// Create database connection
$conn = new mysqli('localhost', 'root', '', 'event_management_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch events from the database
$sql = "SELECT event_name, start_date, image_url FROM events ORDER BY start_date ASC";
$result = $conn->query($sql);

// Check if events were found
if ($result->num_rows > 0) {
    // Store the fetched events into an array
    $events = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // If no events found, set $events to an empty array
    $events = [];
}

// Close the database connection
$conn->close();
?>

<!-- Displaying events in HTML -->
<section id="events" class="ftco-section">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-12 ftco-animate">
                <h2 class="heading">Favorite Events</h2>
                <p>Check out our upcoming events below:</p>
                <div class="row">
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $event): ?>
                            <div class="col-md-4">
                                <div class="event-item">
                                    <img src="<?php echo htmlspecialchars($event['image_url'] ? $event['image_url'] : 'path/to/placeholder.jpg'); ?>" 
                                         alt="<?php echo htmlspecialchars($event['event_name']); ?>" 
                                         class="img-fluid">
                                    <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
                                    <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['start_date'])); ?></p>
                                    <a href="All_event.php" class="btn btn-primary">See More</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No upcoming events found.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</section>



    <!-- About Section -->
    <section id="about" class="ftco-section bg-light">
      <div class="container">
        <div class="row d-flex">
          <div class="col-md-12 ftco-animate">
            <h2 class="heading">About the Conference</h2>
            <p>This project is an Event Management System designed to streamline the process of event registration and participation for faculty and students at a university. The system includes features such as event request submissions, faculty approvals by admin, and real-time status updates. The goal is to make event management efficient, ensuring that faculty and students can easily manage and track their event participations through an intuitive web interface.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Speakers Section -->
    <section id="speakers" class="ftco-section">
      <div class="container">
        <div class="row d-flex">
          <div class="col-md-12 ftco-animate">
            <h2 class="heading">Speakers</h2>
            <p>Meet the experts who will be sharing their insights at the conference. Our speakers are industry leaders in various fields of software development and technology.</p>
            <!-- Add a list of speakers here -->
            <div class="row">
              <div class="col-md-4">
                <div class="speaker-item">
                  <img src="images/speaker-1.jpg" alt="Speaker 1" class="img-fluid">
                  <h3>John Doe</h3>
                  <p>CEO at TechCorp</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="speaker-item">
                  <img src="images/speaker-2.jpg" alt="Speaker 2" class="img-fluid">
                  <h3>Jane Smith</h3>
                  <p>Lead Developer at WebWorks</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="speaker-item">
                  <img src="images/speaker-3.jpg" alt="Speaker 3" class="img-fluid">
                  <h3>Mark Johnson</h3>
                  <p>Software Engineer at DevCo</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Schedule Section -->
    <section id="schedule" class="ftco-section bg-light">
      <div class="container">
        <div class="row d-flex">
          <div class="col-md-12 ftco-animate">
            <h2 class="heading">Conference Schedule</h2>
            <p>Check out the full schedule for the conference, including sessions, workshops, and networking events.</p>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Time</th>
                  <th>Session</th>
                  <th>Speaker</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>9:00 AM - 10:00 AM</td>
                  <td>Keynote: The Future of Development</td>
                  <td>John Doe</td>
                </tr>
                <tr>
                  <td>10:30 AM - 12:00 PM</td>
                  <td>Workshop: Web Development Trends</td>
                  <td>Jane Smith</td>
                </tr>
                <tr>
                  <td>1:00 PM - 2:30 PM</td>
                  <td>Networking Lunch</td>
                  <td>All Participants</td>
                </tr>
                <tr>
                  <td>3:00 PM - 4:30 PM</td>
                  <td>Panel Discussion: AI in Software</td>
                  <td>Mark Johnson</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="ftco-section">
      <div class="container">
        <div class="row d-flex">
          <div class="col-md-12 ftco-animate">
            <h2 class="heading">Latest Blog Posts</h2>
            <p>Read our latest blog posts related to technology, software development, and insights from past conferences.</p>
            <!-- Add blog posts here -->
            <div class="row">
              <div class="col-md-4">
                <div class="blog-item">
                  <img src="images/blog-1.jpg" alt="Blog 1" class="img-fluid">
                  <h3>Emerging Technologies in 2025</h3>
                  <p>Explore the technologies that are shaping the future of software development...</p>
                  <a href="#" class="btn btn-primary">Read More</a>
                </div>
              </div>
              <div class="col-md-4">
                <div class="blog-item">
                  <img src="images/blog-2.jpg" alt="Blog 2" class="img-fluid">
                  <h3>How AI is Revolutionizing Development</h3>
                  <p>Artificial Intelligence is making waves in the software industry...</p>
                  <a href="#" class="btn btn-primary">Read More</a>
                </div>
              </div>
              <div class="col-md-4">
                <div class="blog-item">
                  <img src="images/blog-3.jpg" alt="Blog 3" class="img-fluid">
                  <h3>The Future of Web Development</h3>
                  <p>Discover the latest trends in web development...</p>
                  <a href="#" class="btn btn-primary">Read More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="ftco-section bg-light">
      <div class="container">
        <div class="row d-flex">
          <div class="col-md-12 ftco-animate">
            <h2 class="heading">Contact Us</h2>
            <p>If you have any questions or need more information, feel free to contact us. We're here to help!</p>
            <!-- Add contact form or details here -->
            <form action="feedback.php" method="post">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Your Name" name="name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Your Email" name="email" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <textarea class="form-control" placeholder="Your Message" name="message" required></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Send Message</button>
    </div>
</form>

          </div>
        </div>
      </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&sensor=false"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
