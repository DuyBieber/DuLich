document.addEventListener("DOMContentLoaded", () => {
    const chatbotToggler = document.querySelector(".chatbot-toggler");
    const closeBtn = document.querySelector(".close-btn");
    const chatbox = document.querySelector(".chatbox");
    const chatInput = document.querySelector(".chat-input textarea");
    const sendChatBtn = document.querySelector(".chat-input span");

    if (!chatInput) {
        console.error("Phần tử chatInput không tồn tại trong DOM.");
        return;
    }

    let userMessage = null; // Variable to store user's message
    const inputInitHeight = chatInput.scrollHeight;

    // Lưu lịch sử chat vào localStorage
    const saveChatToLocalStorage = (chatHistory) => {
        localStorage.setItem("chatHistory", JSON.stringify(chatHistory));
    };

    // Tải lịch sử chat từ localStorage
    const loadChatFromLocalStorage = () => {
        const savedChat = localStorage.getItem("chatHistory");
        return savedChat ? JSON.parse(savedChat) : [];
    };

    // Hiển thị lịch sử chat từ localStorage
    const displayChatHistory = () => {
        const chatHistory = loadChatFromLocalStorage();
        chatHistory.forEach(chat => {
            const chatLi = createChatLi(chat.message, chat.type);
            chatbox.appendChild(chatLi);
        });
        chatbox.scrollTo(0, chatbox.scrollHeight);
    };

    // Thêm tin nhắn mới vào lịch sử chat và lưu lại
    const addMessageToChat = (message, type) => {
        const chatHistory = loadChatFromLocalStorage();
        chatHistory.push({ message, type });
        saveChatToLocalStorage(chatHistory);
    };

    const createChatLi = (message, className) => {
        const chatLi = document.createElement("li");
        chatLi.classList.add("chat", `${className}`);
        let chatContent = className === "outgoing" 
            ? `<p></p>` 
            : `<span class="material-symbols-outlined">smart_toy</span><p></p>`;
        chatLi.innerHTML = chatContent;
        chatLi.querySelector("p").textContent = message;
        return chatLi;
    };

    const generateResponse = (chatElement) => {
        const API_URL = "http://localhost:8001/chat";
        const messageElement = chatElement.querySelector("p");

        const requestOptions = {
            method: "POST",
            headers: {
                "accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                session_id: "string",
                chat_request: userMessage,
            })
        };

        fetch(API_URL, requestOptions)
            .then(res => res.json())
            .then(data => {
                messageElement.textContent = data.chat_response;
                // Lưu phản hồi vào lịch sử
                addMessageToChat(data.chat_response, "incoming");
            })
            .catch(() => {
                messageElement.classList.add("error");
                messageElement.textContent = "Xin lỗi! Hệ thống đang gặp sự cố. Bạn vui lòng thử lại sau.";
            })
            .finally(() => chatbox.scrollTo(0, chatbox.scrollHeight));
    };

    const handleChat = () => {
        userMessage = chatInput.value.trim();
        if (!userMessage) return;

        chatInput.value = "";
        chatInput.style.height = `${inputInitHeight}px`;

        // Lưu tin nhắn người dùng
        addMessageToChat(userMessage, "outgoing");

        chatbox.appendChild(createChatLi(userMessage, "outgoing"));
        chatbox.scrollTo(0, chatbox.scrollHeight);

        setTimeout(() => {
            const incomingChatLi = createChatLi("...", "incoming");
            chatbox.appendChild(incomingChatLi);
            chatbox.scrollTo(0, chatbox.scrollHeight);
            generateResponse(incomingChatLi);
        }, 600);
    };

    chatInput.addEventListener("input", () => {
        chatInput.style.height = `${inputInitHeight}px`;
        chatInput.style.height = `${chatInput.scrollHeight}px`;
    });

    chatInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
            e.preventDefault();
            handleChat();
        }
    });

    sendChatBtn.addEventListener("click", handleChat);
    closeBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
    chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));

    // Hiển thị lịch sử chat khi trang tải
    displayChatHistory();
});
