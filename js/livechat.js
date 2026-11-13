// Toggle chat visibility
function toggleChat() {
    const chatBox = document.getElementById("chatBox");
    chatBox.style.display = chatBox.style.display === "block" ? "none" : "block";
  }
  
  // Send a message
  function sendMessage() {
    const userMessage = document.getElementById("userMessage").value;
    const messages = document.getElementById("messages");
  
    if (userMessage.trim() !== "") {
      // Add user message to chat
      const userDiv = document.createElement("div");
      userDiv.className = "message user";
      userDiv.textContent = userMessage;
      messages.appendChild(userDiv);
  
      // Auto-reply from bot
      const botDiv = document.createElement("div");
      botDiv.className = "message bot";
      botDiv.textContent = "Thank you for your message. We'll get back to you shortly!";
      setTimeout(() => messages.appendChild(botDiv), 1000);
  
      // Clear input
      document.getElementById("userMessage").value = "";
      messages.scrollTop = messages.scrollHeight; // Auto-scroll
    }
  }
  