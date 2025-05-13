<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <style>
        /* Botão flutuante */
        .chatbot-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #ff6f61;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chatbot-btn img {
            width: 50px;
            height: 50px;
        }

        .chatbot-btn:hover {
            background-color: #ff4a35;
        }

        /* Janela do chatbot */
        .chatbot-window {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 300px;
            height: 400px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            z-index: 1000;
        }

        .chatbot-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chatbot-body {
            padding: 10px;
            flex-grow: 1;
            overflow-y: auto;
            max-height: calc(100% - 80px);
        }

        .chatbot-footer {
            display: flex;
            padding: 10px;
        }

        .chatbot-footer input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin-right: 10px;
        }

        .chatbot-footer button {
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            cursor: pointer;
        }

        .chatbot-footer button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-bottom: 15px;
        }

        .message.bot {
            text-align: left;
        }

        .message.user {
            text-align: right;
        }

        @media (max-width: 480px) {
            .chatbot-window {
                width: 100%;
                height: 100%;
                bottom: 0;
                right: 0;
                border-radius: 0;
            }

            .chatbot-btn {
                bottom: 10px;
                right: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Botão flutuante para abrir o chatbot -->
    <div class="chatbot-btn" onclick="toggleChatbot()">
        <img src="https://via.placeholder.com/50/007bff/ffffff?text=Chatbot" alt="Chatbot">
    </div>

    <!-- Janela do chatbot -->
    <div class="chatbot-window" id="chatbotWindow">
        <div class="chatbot-header">
            <span>Chat com o Bot</span>
            <button onclick="toggleChatbot()">X</button>
        </div>
        <div class="chatbot-body" id="chatbotBody">
            <!-- As mensagens serão inseridas aqui -->
        </div>
        <div class="chatbot-footer">
            <input type="text" id="userInput" placeholder="Digite uma mensagem..." onkeydown="checkEnter(event)">
            <button onclick="sendMessage()">Enviar</button>
        </div>
    </div>

    <script>
        let chatbotWindow = document.getElementById('chatbotWindow');
        let chatbotBody = document.getElementById('chatbotBody');
        let userInput = document.getElementById('userInput');

        // Função para alternar a visibilidade do chatbot
        function toggleChatbot() {
            if (chatbotWindow.style.display === 'none' || chatbotWindow.style.display === '') {
                chatbotWindow.style.display = 'flex';
            } else {
                chatbotWindow.style.display = 'none';
            }
        }

        // Função para enviar a mensagem
        function sendMessage() {
            let message = userInput.value.trim();
            if (message !== '') {
                // Adiciona a mensagem do usuário
                addMessage(message, 'user');
                userInput.value = '';

                // Simula uma resposta do bot com base na mensagem do usuário
                setTimeout(() => {
                    let botResponse = generateBotResponse(message);
                    addMessage(botResponse, 'bot');
                }, 1000);
            }
        }

        // Função para verificar o pressionamento da tecla "Enter" para enviar mensagem
        function checkEnter(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        // Função para adicionar uma mensagem no chat
        function addMessage(message, sender) {
            let messageDiv = document.createElement('div');
            messageDiv.classList.add('message', sender);
            messageDiv.textContent = message;
            chatbotBody.appendChild(messageDiv);
            chatbotBody.scrollTop = chatbotBody.scrollHeight; // Rola até a última mensagem
        }

        // Função para gerar uma resposta simples do bot (você pode melhorar isso)
        function generateBotResponse(userMessage) {
            const lowerMessage = userMessage.toLowerCase();

            if (lowerMessage.includes("olá") || lowerMessage.includes("oi")) {
                return "Olá! Como posso ajudar você hoje?";
            } else if (lowerMessage.includes("como vai")) {
                return "Estou bem, obrigado por perguntar! E você?";
            } else if (lowerMessage.includes("qual seu nome")) {
                return "Eu sou o Chatbot! Como posso assisti-lo?";
            } else {
                return "Desculpe, não entendi a sua pergunta. Pode reformular?";
            }
        }
    </script>

</body>

</html>
