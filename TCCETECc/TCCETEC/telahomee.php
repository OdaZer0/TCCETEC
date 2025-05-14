<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTOMATIZA - Encontre Profissionais Autônomos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
      
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        
        .navbar {
            background-color: #007bff;
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-weight: 600;
        }

        .navbar a:hover {
            background-color: #0056b3;
            border-radius: 5px;
        }

        .navbar .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .hero {
            background: url('https://via.placeholder.com/1920x800/007bff/ffffff?text=Hero+Image') no-repeat center center/cover;
            color: white;
            padding: 100px 0;
            text-align: center;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 40px;
        }

        .hero .btn-primary {
            background-color: #ff6f61;
            color: white;
            padding: 12px 25px;
            font-size: 1.1rem;
            border-radius: 25px;
            text-decoration: none;
        }

        .hero .btn-primary:hover {
            background-color: #ff4a35;
        }

        /* ------------------- Services ------------------- */
        .services {
            padding: 60px 0;
            text-align: center;
            background-color: #ffffff;
        }

        .services h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .service-item {
            display: inline-block;
            width: 30%;
            padding: 30px;
            margin: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .service-item img {
            width: 60px;
            height: 60px;
            margin-bottom: 20px;
        }

        .service-item h4 {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .service-item p {
            font-size: 1rem;
        }

       
        .how-it-works {
            padding: 60px 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        .how-it-works h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .steps {
            display: flex;
            justify-content: center;
            gap: 30px;
            animation: slideIn 1.5s ease-out;
        }

        .step {
            width: 250px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .step img {
            width: 60px;
            height: 60px;
            margin-bottom: 20px;
        }

        .step h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .step p {
            font-size: 1rem;
        }

        @keyframes slideIn {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(0);
            }
        }

        
        .testimonials {
            padding: 60px 0;
            background-color: #ffffff;
            text-align: center;
        }

        .testimonials h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .testimonial-item {
            display: inline-block;
            width: 30%;
            margin: 0 15px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-style: italic;
            transition: transform 0.3s ease;
        }

        .testimonial-item:hover {
            transform: scale(1.05);
        }

        .testimonial-item p {
            font-size: 1.1rem;
        }

        .testimonial-item h4 {
            margin-top: 15px;
            font-weight: bold;
        }

        
        .cta {
            background-color: #ff6f61;
            color: white;
            padding: 80px 20px;
            text-align: center;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            border-radius: 10px;
            animation: fadeIn 2s ease;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .cta .btn {
            font-size: 1.2rem;
            padding: 15px 30px;
            border-radius: 25px;
            background-color: #ffffff;
            color: #ff6f61;
            text-decoration: none;
        }

        .cta .btn:hover {
            background-color: #ff4a35;
            color: white;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

 
        footer {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        footer p {
            font-size: 1rem;
        }

        footer a {
            color: white;
            text-decoration: none;
            font-weight: 600;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .social-links {
            margin-top: 20px;
        }

        .social-links a {
            color: white;
            margin: 0 15px;
            font-size: 1.5rem;
        }

        .social-links a:hover {
            color: #ff6f61;
        }

        
        @media (max-width: 768px) {
            .service-item {
                width: 45%;
            }

            .steps {
                flex-direction: column;
            }

            .step {
                width: 100%;
                margin-bottom: 20px;
            }

            .testimonial-item {
                width: 80%;
                margin: 10px 0;
            }

            .cta {
                bottom: 10px;
                right: 10px;
            }
        }

        @media (max-width: 480px) {
            .cta .btn {
                font-size: 1.1rem;
                padding: 12px 25px;
            }
        }
        .chatbot-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .chatbot-btn:hover {
            transform: scale(1.1);
        }

        .chatbot-btn img {
            width: 40px;
            height: 40px;
        }

     
            .chatbot-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .chatbot-btn:hover {
            transform: scale(1.1);
        }

        /* Adicionando para a imagem não distorcer */
        .chatbot-btn img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover; /* Isso vai fazer a imagem se ajustar ao botão sem distorcer */
        }

     
        .chatbot-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .chatbot-btn:hover {
            transform: scale(1.1);
        }

       
        .chatbot-btn img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover; 
        }

      
        .chatbot-btn:hover img {
            content: url('https://via.placeholder.com/70/ff6f61/ffffff?text=Chatbot'); 
        }

       
        .chatbot-popup {
            position: fixed;
            bottom: 100px;
            right: 20px;
            width: 300px;
            height: 400px;
            background-color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            display: none;
            flex-direction: column;
            z-index: 1001;
        }
        .chatbot-btn:hover img {
        content: url('Imagens/Fundo\ de\ Autônomo\ \(Ao\ passar\ o\ mouse\).png'); /* Substitua com a URL da imagem de hover */
    }

        .chatbot-popup-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            font-size: 1.2rem;
            font-weight: 600;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .chatbot-popup-messages {
            flex-grow: 1;
            padding: 10px;
            overflow-y: auto;
            background-color: #f9f9f9;
            font-size: 1rem;
            color: #333;
        }

        .chatbot-popup-footer {
            padding: 10px;
            background-color: #f1f1f1;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .chatbot-popup-footer input {
            width: 100%;
            padding: 8px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .chatbot-popup {
                width: 250px;
                height: 350px;
            }
        }

        @media (max-width: 480px) {
            .chatbot-popup {
                width: 200px;
                height: 300px;
            }
        }
    </style>
</head>

<body>

    <<?php include 'header.php'; ?>
  

    <!-- Hero Section -->
    <section class="hero">
        <h1>Encontre os Melhores Profissionais Autônomos</h1>
        <p>Contrate os melhores freelancers para seu projeto com facilidade e confiança.</p>
        <a href="#" class="btn-primary">Saiba Mais</a>
    </section>

    <!-- Serviços -->
    <section class="services">
        <h2>Serviços Oferecidos</h2>
        <div class="service-item">
            <img src="https://via.placeholder.com/50/007bff/ffffff?text=Design" alt="Design Gráfico">
            <h4>Design Gráfico</h4>
            <p>Criação de logotipos, branding, e materiais gráficos personalizados.</p>
        </div>
        <div class="service-item">
            <img src="https://via.placeholder.com/50/007bff/ffffff?text=Web" alt="Desenvolvimento Web">
            <h4>Desenvolvimento Web</h4>
            <p>Desenvolvimento de sites e lojas online, otimizados e responsivos.</p>
        </div>
        <div class="service-item">
            <img src="https://via.placeholder.com/50/007bff/ffffff?text=Consultoria" alt="Consultoria">
            <h4>Consultoria</h4>
            <p>Consultoria estratégica para empresas que buscam crescer e inovar.</p>
        </div>
    </section>

    <!-- Como Funciona -->
    <section class="how-it-works">
        <h2>Como Funciona</h2>
        <div class="steps">
            <div class="step">
                <img src="https://via.placeholder.com/60/007bff/ffffff?text=1" alt="Passo 1">
                <h4>Cadastre-se</h4>
                <p>Crie uma conta simples e cadastre seus serviços ou contrate freelancers.</p>
            </div>
            <div class="step">
                <img src="https://via.placeholder.com/60/007bff/ffffff?text=2" alt="Passo 2">
                <h4>Escolha o Profissional</h4>
                <p>Encontre o melhor profissional para o seu projeto entre os freelancers cadastrados.</p>
            </div>
            <div class="step">
                <img src="https://via.placeholder.com/60/007bff/ffffff?text=3" alt="Passo 3">
                <h4>Finalize o Projeto</h4>
                <p>Acompanhe o progresso e finalize o projeto com pagamento seguro.</p>
            </div>
        </div>
    </section>

    <!-- Testemunhos -->
    <section class="testimonials">
        <h2>O que dizem nossos clientes</h2>
        <div class="testimonial-item">
            <p>"Ótimo serviço! O profissional foi super competente e entregou o trabalho no prazo."</p>
            <h4>João Silva</h4>
        </div>
        <div class="testimonial-item">
            <p>"Plataforma fácil de usar e ótimos freelancers! Recomendo a todos."</p>
            <h4>Maria Oliveira</h4>
        </div>
        <div class="testimonial-item">
            <p>"Serviço excepcional. Sempre encontro profissionais qualificados aqui."</p>
            <h4>Carlos Souza</h4>
        </div>
    </section>
    <!-- Chatbot Button -->
    <div class="chatbot-btn" onclick="toggleChatbot()">
        <img src="Imagens/Fundo de Autônomo (Sem passar o mouse).png" alt="Chatbot">
    </div>

    <!-- Chatbot Popup -->
    <div class="chatbot-popup" id="chatbotPopup">
        <div class="chatbot-popup-header">Chat com a gente!</div>
        <div class="chatbot-popup-messages">
            <p><strong>Chatbot:</strong> Olá! Como posso te ajudar hoje?</p>
        </div>
        <div class="chatbot-popup-footer">
            <input type="text" placeholder="Digite sua mensagem...">
        </div>
    </div>
    <script>
        // Função para alternar visibilidade do chatbot
        function toggleChatbot() {
            const chatbotPopup = document.getElementById('chatbotPopup');
            chatbotPopup.style.display = chatbotPopup.style.display === 'flex' ? 'none' : 'flex';
        }
        
    </script>
    <?php include 'footer.php'; ?>

</body>

</html>
