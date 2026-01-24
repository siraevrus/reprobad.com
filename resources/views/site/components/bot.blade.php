<style>
    .chat-container { position: fixed;bottom: 160px;right: 20px;width: 360px;max-width: 100%;max-height: 500px;background: #fff;border-radius: 12px;box-shadow: 0 4px 12px rgba(0,0,0,0.2);display: flex;flex-direction: column;overflow: hidden;font-size: 14px;z-index: 9999; }
    .chat-header { background: var(--mandarin);color: white;padding: 12px;font-weight: bold;position: relative; }
    .chat-header button.close-btn { position: absolute;top: 8px;right: 12px;background: transparent;border: none;color: white;font-size: 18px;cursor: pointer; }
    .chat-header button.clear-btn { position: absolute;top: 8px;right: 40px;background: transparent;border: none;color: white;font-size: 14px;cursor: pointer;opacity: 0.8; }
    .chat-header button.clear-btn:hover { opacity: 1; }
    .chat-messages { flex: 1;padding: 10px;overflow-y: auto; }
    .chat-input { display: flex;border-top: 1px solid #ddd; }
    .chat-input input { flex: 1;padding: 10px;outline: none;height: 44px;border: none;border-radius: 0; }
    .chat-input button { background: var(--mandarin);color: white;border: none;padding: 10px 16px;cursor: pointer; }
    .chat-oper { text-align: center;margin-top: 10px;margin-bottom: 10px; }
    .chat-dev { margin-top: 15px;text-align: center;margin-bottom: 15px;font-size: 12px; }
    .chat-dev a { color: blue; }
    .message { font-size: 14px;margin-bottom: 8px;padding: 8px 12px;border-radius: 8px;line-height: 1.4;white-space: pre-line;word-wrap: break-word; }
    .message p { margin-bottom: 5px; }
    .message h1 { font-size: 20px; }
    .message h2 { font-size: 18px; }
    .message h3 { font-size: 16px; }
    .message h4 { font-size: 14px; }
    .message h5 { font-size: 12px; }
    .message h6 { font-size: 10px; }
    .message.user { background: #e0e7ff;text-align: right;margin-left: 30px; }
    .message.bot { background: #f3f4f6;align-self: flex-start;text-align: left;margin-right: 30px; }
    .typing { font-style: italic;color: #999;margin-bottom: 6px; }
    .message h1, .message h2, .message h3, .message h4, .message h5 { margin-bottom: 0; }
    .message ul, .message ol { padding-left: 20px;margin-top: 10px;margin-bottom: 10px; }
    .message br { display: none; }
    .message strong { font-weight: 500; }
    #openChatBtn { position: fixed;bottom: 160px;right: 20px;background: var(--mandarin);color: white;border: none;padding: 10px 16px;border-radius: 12px;cursor: pointer;font-weight: bold;display: none;z-index: 90; }
    #openChatBtn::before { content: "";position: absolute;top: 50%;left: 50%;width: 120%;height: 120%;background: rgba(79, 70, 229, 0.5);border-radius: 10px;transform: translate(-50%, -50%) scale(1);opacity: 0;animation: waveEffect 2.5s infinite;pointer-events: none;z-index: -1; }
    @keyframes waveEffect {
        0% { transform: translate(-50%, -50%) scale(0.7);opacity: 0.6; }
        70% { transform: translate(-50%, -50%) scale(1.8);opacity: 0; }
        100% { opacity: 0; } 
    }
    @media (max-width: 475px) {
        .chat-container { width: 320px }
        #openChatBtn { bottom: 115px;right: 15px; }
        jdiv { bottom: -100px;right: -32px; }
    }
</style>

<div class="chat-container" id="chatContainer">
    <div class="chat-header">
        ИИ-консультант РЕПРО
        <button class="close-btn" id="closeChatBtn" title="Закрыть чат">×</button>
    </div>
    <div class="chat-messages" id="chat">
        <div class="message bot">
            {{ config('bot_welcome_message') }}
        </div>
    </div>
    <!-- <div class="chat-oper">
        <a href="" id="oper" target="_blank">Написать оператору</a>
    </div> -->
    <div class="chat-input">
        <input type="text" id="messageInput" placeholder="Напишите сообщение..." />
        <button onclick="sendMessage()">Отправить</button>
    </div>

</div>

<button id="openChatBtn" title="Открыть чат">ИИ-консультант РЕПРО</button>

<script>
    const chat = document.getElementById('chat');
    const input = document.getElementById('messageInput');
    const chatContainer = document.getElementById('chatContainer');
    const closeChatBtn = document.getElementById('closeChatBtn');
    const openChatBtn = document.getElementById('openChatBtn');
    const operButton = document.getElementById('oper');
    const clearHistoryBtn = document.getElementById('clearHistoryBtn');

    function addMessage(text, sender = 'bot') {
        const div = document.createElement('div');
        div.className = 'message ' + sender;
        div.innerHTML = text;
        chat.appendChild(div);
        chat.scrollTop = chat.scrollHeight;
    }

    let typingDiv = null;
    let typingInterval = null;
    const sendBtn = document.querySelector('.chat-input button');

    function showTyping() {
        typingDiv = document.createElement('div');
        typingDiv.className = 'typing';
        typingDiv.textContent = 'Печатает';
        chat.appendChild(typingDiv);
        chat.scrollTop = chat.scrollHeight;

        let dots = 0;
        typingInterval = setInterval(() => {
            dots = (dots + 1) % 4;
            typingDiv.textContent = 'Печатает' + '.'.repeat(dots);
        }, 250);
        
        sendBtn.disabled = true;
        sendBtn.style.opacity = 0.5;
        sendBtn.style.cursor = 'not-allowed';
    }

    function removeTyping() {
        if (typingInterval) {
            clearInterval(typingInterval);
            pingInterval = null;
        }
        if (typingDiv) {
            chat.removeChild(typingDiv);
            typingDiv = null;
        }
        
        sendBtn.disabled = false;
        sendBtn.style.opacity = 1;
        sendBtn.style.cursor = 'pointer';
    }

    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;
    
        addMessage(text, 'user');
        input.value = '';
        showTyping();
    
        if (!localStorage.getItem('chat_user_id')) {
            localStorage.setItem('chat_user_id', 'user_' + Math.random().toString(36).substring(2, 10));
        }
        const userId = localStorage.getItem('chat_user_id');

        try {
            const res = await fetch('/bot/ask', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ message: text, user_id: userId })
            });
    
            const data = await res.json();
            removeTyping();
            
            // Проверяем специальные команды
            if(data.reply == 'вызвать человека' || data.reply.includes('оператор')) {
                if(typeof jivo_api !== 'undefined') {
                    jivo_api.open();
                    addMessage('Открываю чат с оператором...');
                } else {
                    addMessage('Для связи с оператором, пожалуйста, воспользуйтесь контактами на сайте.');
                }
                return;
            }
            
            if(data.reply == 'записаться') {
                const orderBtn = document.querySelector('[href="#order"]');
                if(orderBtn) {
                    orderBtn.click();
                    addMessage('Открываю форму записи...');
                } else {
                    addMessage('Для записи, пожалуйста, воспользуйтесь формой на сайте.');
                }
                return;
            }
            
            addMessage(data.reply || 'Сервис временно не доступен');
        } catch (err) {
            console.error('Chat error:', err);
            removeTyping();
            addMessage('Ошибка соединения с сервером. Попробуйте еще раз.');
        }
    }

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });
  
    if(localStorage.getItem('chat_closed') == 1) {
        chatContainer.style.display = 'none';
        openChatBtn.style.display = 'block';
    }

    closeChatBtn.addEventListener('click', () => {
        chatContainer.style.display = 'none';
        openChatBtn.style.display = 'block';
        localStorage.setItem('chat_closed', 1);
    });

    openChatBtn.addEventListener('click', () => {
        chatContainer.style.display = 'flex';
        openChatBtn.style.display = 'none';
        input.focus();
        localStorage.removeItem('chat_closed');
    });
    
    if(operButton) {
        operButton.addEventListener('click', function(e) {
            e.preventDefault();
            if(typeof jivo_api !== 'undefined') {
                jivo_api.open();
            }
        });
    }

    // Очистка истории
    clearHistoryBtn.addEventListener('click', async function() {
        if(!confirm('Очистить историю диалога? Бот забудет предыдущий контекст беседы.')) {
            return;
        }
        
        const userId = localStorage.getItem('chat_user_id') || 'guest';
        
        try {
            const res = await fetch('/bot/clear-history', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ user_id: userId })
            });
            
            const data = await res.json();
            
            if(data.status === 'success') {
                // Очищаем визуально чат (оставляем только приветствие)
                const messages = chat.querySelectorAll('.message');
                messages.forEach((msg, index) => {
                    if(index > 0) { // Оставляем первое приветственное сообщение
                        msg.remove();
                    }
                });
                addMessage('История диалога очищена. Можете начать новую беседу.');
            }
        } catch (err) {
            console.error('Clear history error:', err);
            addMessage('Не удалось очистить историю.');
        }
    });

</script>
