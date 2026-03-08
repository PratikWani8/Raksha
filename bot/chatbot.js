function toggleChat() {
try {
    const chat = document.getElementById("chat-container");

    if (!chat) {
        console.error("Chat container not found");
        return;
    }

    if (chat.style.display === "flex") {
        chat.style.display = "none";
    } else {
        chat.style.display = "flex";
    }
} catch (error) {
    console.error("Error in toggleChat:", error);
}
}


async function sendMessage() {
try {

    const input = document.getElementById("user-input");
    const chatBox = document.getElementById("chat-box");

    if (!input || !chatBox) {
        console.error("Input or ChatBox element not found");
        return;
    }

    const message = input.value.trim();
    if (message === "") return;

    const userMsg = document.createElement("div");
    userMsg.className = "msg user-msg";
    userMsg.innerText = message;
    chatBox.appendChild(userMsg);

    input.value = "";
    chatBox.scrollTop = chatBox.scrollHeight;

    const typing = document.createElement("div");
    typing.className = "msg bot-msg typing";
    typing.innerHTML = "Raksha AI is thinking<span class='dots'>...</span>";
    chatBox.appendChild(typing);

    chatBox.scrollTop = chatBox.scrollHeight;

    const response = await fetch("../ai/ollama_chat.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            message: message
        })
    });

    if (!response.ok) {
        throw new Error("Server response was not OK");
    }

    const data = await response.json();

    typing.remove();

    const botMsg = document.createElement("div");
    botMsg.className = "msg bot-msg";

    const reply = data.reply || "Sorry, I couldn't understand that.";

    chatBox.appendChild(botMsg);
    typeWriter(botMsg, reply, 20);

    chatBox.scrollTop = chatBox.scrollHeight;

} catch (error) {

    console.error("Chat Error:", error);

    const chatBox = document.getElementById("chat-box");
    if (chatBox) {
        const errorMsg = document.createElement("div");
        errorMsg.className = "msg bot-msg";
        errorMsg.innerText = "⚠️ Raksha AI is currently unavailable. Please try again.";
        chatBox.appendChild(errorMsg);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

}
}


function typeWriter(element, text, speed) {
try {

    let i = 0;

    function typing() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(typing, speed);
        }
    }

    typing();

} catch (error) {
    console.error("TypeWriter Error:", error);
}
}


function startVoiceInput() {
try {

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
        alert("Speech Recognition not supported in this browser");
        return;
    }

    const recognition = new SpeechRecognition();

    recognition.lang = "en-US";
    recognition.start();

    recognition.onresult = function (event) {
        const transcript = event.results[0][0].transcript;

        const input = document.getElementById("user-input");

        if (input) {
            input.value = transcript;
            sendMessage();
        }
    };

    recognition.onerror = function (event) {
        console.error("Voice recognition error:", event.error);
        alert("Voice recognition failed. Please try again.");
    };

} catch (error) {
    console.error("Voice Input Error:", error);
}
}