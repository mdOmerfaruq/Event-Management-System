<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link rel="stylesheet" href="chatbot.css">
</head>
<body>
    <div class="chatbot-container">
        <div class="chat-header">Chatbot</div>
        <div class="chat-body" id="chatBody">
            <div class="chat-message bot">
                <div class="message">Hi there! How can I help you?</div>
            </div>
        </div>
        <div class="chat-footer">
            <input type="text" id="userInput" placeholder="Type a message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
    <script src="chatbot.js"></script>
</body>
</html