document.addEventListener("DOMContentLoaded", function () {
    let chatbox = document.getElementById("chatbox");

    // Fetch predefined questions from backend
    fetch("faqpre_db.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(q => {
                let questionDiv = document.createElement("div");
                questionDiv.classList.add("question");
                questionDiv.textContent = q.question;
                questionDiv.dataset.id = q.id;

                questionDiv.addEventListener("click", function () {
                    let userMessage = q.question;

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "faqchat_db.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                    xhr.onload = function () {
                        let botResponse = xhr.responseText;

                        // User message (Right side)
                        let userBubble = document.createElement("div");
                        userBubble.classList.add("message", "user-message");
                        userBubble.textContent = userMessage;
                        chatbox.appendChild(userBubble);

                        // Bot response (Left side)
                        let botBubble = document.createElement("div");
                        botBubble.classList.add("message", "bot-message");
                        botBubble.innerHTML = botResponse;  // Allows HTML rendering for links
                        chatbox.appendChild(botBubble);

                        // Auto scroll to the bottom
                        chatbox.scrollTop = chatbox.scrollHeight;
                    };

                    xhr.send("message=" + encodeURIComponent(userMessage));
                });

                chatbox.appendChild(questionDiv);
            });
        })
        .catch(error => console.error("Error fetching questions:", error));
});
