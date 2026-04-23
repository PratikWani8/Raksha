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

function speak(text, langCode = "en") {
try {
    const utterance = new SpeechSynthesisUtterance(text);

    const langMap = {
        en: "en-IN",
        hi: "hi-IN",
        bn: "bn-IN",
        gu: "gu-IN",
        pa: "pa-IN",
        or: "or-IN",
        te: "te-IN",
        kn: "kn-IN",
        ml: "ml-IN",
        ta: "ta-IN",
        ur: "ur-IN"
    };

    utterance.lang = langMap[langCode] || "en-IN";

    const voices = speechSynthesis.getVoices();

    let selectedVoice =
        voices.find(v => v.lang === utterance.lang) ||
        voices.find(v => v.lang.startsWith(langCode)) ||
        voices[0];

    if (selectedVoice) {
        utterance.voice = selectedVoice;
    }

    speechSynthesis.cancel();
    speechSynthesis.speak(utterance);

} catch (error) {
    console.error("Speak Error:", error);
}
}

function detectLanguage(text) {
    if (/[\u0980-\u09FF]/.test(text)) return "bn";
    if (/[\u0A80-\u0AFF]/.test(text)) return "gu";
    if (/[\u0A00-\u0A7F]/.test(text)) return "pa";
    if (/[\u0B00-\u0B7F]/.test(text)) return "or";
    if (/[\u0C00-\u0C7F]/.test(text)) return "te";
    if (/[\u0C80-\u0CFF]/.test(text)) return "kn";
    if (/[\u0D00-\u0D7F]/.test(text)) return "ml";
    if (/[\u0B80-\u0BFF]/.test(text)) return "ta";
    if (/[\u0900-\u097F]/.test(text)) return "hi"; 
    if (/[\u0600-\u06FF]/.test(text)) return "ur";
    return "en";
}

function startVoiceInput() {
try {

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
        alert("Speech Recognition not supported in this browser");
        return;
    }

    const recognition = new SpeechRecognition();

    recognition.continuous = false;
    recognition.interimResults = false;

    recognition.lang = "en-IN";

    recognition.start();

    recognition.onresult = function (event) {

        const transcript = event.results[0][0].transcript;

        const input = document.getElementById("user-input");

        if (input) {
            input.value = transcript;

            const detectedLang = detectLanguage(transcript);

            recognition.lang = detectedLang + "-IN";

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

    const response = await fetch("../ai/groq_chatbot.php", {
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
    const lang = data.lang || "en"; 

    chatBox.appendChild(botMsg);
    typeWriter(botMsg, reply, 20);

    chatBox.scrollTop = chatBox.scrollHeight;

    
    setTimeout(() => {
        speak(reply, lang);
    }, reply.length * 20);

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