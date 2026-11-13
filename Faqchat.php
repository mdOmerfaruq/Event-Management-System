<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link rel="stylesheet" href="faq.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <style>
        /* Navbar Styling */
        .navbar {
            background-color: #333;
            overflow: hidden;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
        }

        .navbar a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        .navbar .menu-icon {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: white;
        }

        .navbar-links {
            display: flex;
            gap: 10px;
        }

        @media screen and (max-width: 768px) {
            .navbar-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 50px;
                left: 0;
                width: 100%;
                background-color: #333;
                padding: 10px 0;
            }

            .navbar-links a {
                text-align: center;
                display: block;
                padding: 10px;
            }

            .navbar .menu-icon {
                display: block;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="#" class="navbar-brand">Chatbot</a>
        <div class="menu-icon" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="navbar-links" id="navbarLinks">
            <a href="home.php">Home</a>
            
        </div>
    </div>

    <div class="chat-container">
        <div class="chat-header">
            <h2>Chatbot</h2>
        </div>
        <div id="chatbox" class="chat-box">
            <p class="bot-message">Hello! Choose a section to get started.</p>
        </div>
        
        <div id="question-container" class="question-container">
            <button class="section-button" onclick="showSubsections('help')">Help</button>
            <button class="section-button" onclick="showSubsections('events')">Events</button>
            <button class="section-button" onclick="showSubsections('clubs')">Clubs</button>
        </div>
    </div>
    
    <script>
        function toggleMenu() {
            const menu = document.getElementById("navbarLinks");
            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        }

        function showSubsections(section) {
            const container = document.getElementById("question-container");
            container.innerHTML = "";

            const sections = {
                help: [
                    { label: "How to Login", value: "how_to_login" },
                    { label: "How to Register", value: "how_to_register" },
                    { label: "About Us", value: "about_us" },
                    { label: "Contact Us", value: "contact_us" }
                ],
                events: [
                    { label: "Upcoming Events", value: "upcoming_events" },
                    { label: "How to Register for Events", value: "how_to_register_events" }
                ],
                clubs: [
                    { label: "How to Join Clubs", value: "how_to_join_clubs" },
                    { label: "Available Clubs", value: "available_clubs" }
                ]
            };

            sections[section].forEach(item => {
                container.innerHTML += `<button class="subsection-button" onclick="fetchAnswer('${item.value}')">${item.label}</button>`;
            });

            container.innerHTML += `<button class="back-button" onclick="reloadSections()">Back</button>`;
        }
        
        function fetchAnswer(question) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "faqchat_db.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            
            xhr.onload = function () {
                const botResponse = xhr.responseText;
                const chatbox = document.getElementById("chatbox");
                
                chatbox.innerHTML += `<p class='user-message'>${formatQuestion(question)}</p>`;
                chatbox.innerHTML += `<p class='bot-message'>${botResponse}</p>`;
                chatbox.scrollTop = chatbox.scrollHeight;
            };
            
            xhr.send("message=" + encodeURIComponent(question));
        }
        
        function reloadSections() {
            const container = document.getElementById("question-container");
            container.innerHTML = `
                <button class="section-button" onclick="showSubsections('help')">Help</button>
                <button class="section-button" onclick="showSubsections('events')">Events</button>
                <button class="section-button" onclick="showSubsections('clubs')">Clubs</button>
            `;
        }

        function formatQuestion(question) {
            return question.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
        }
    </script>

</body>
</html>
