
<div class="chat-container" id="chatContainer">
    <div class="chat-header">
        ИИ-консультант РЕПРО
        <button type="button" class="clear-btn" id="clearHistoryBtn" title="Очистить историю">↺</button>
        <button type="button" class="close-btn" id="closeChatBtn" title="Закрыть чат">×</button>
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
            typingInterval = null;
        }
        if (typingDiv) {
            chat.removeChild(typingDiv);
            typingDiv = null;
        }
        
        sendBtn.disabled = false;
        sendBtn.style.opacity = 1;
        sendBtn.style.cursor = 'pointer';
    }

    const SLOW_RESPONSE_MSG = 'Нам требуется еще немного времени, что бы подготовить ответ';
    const SESSION_EXPIRED_MSG = 'Сессия истекла. Обновите страницу и попробуйте снова.';
    const CONNECTION_ERROR_MSG = 'Ошибка соединения с сервером. Попробуйте еще раз.';

    function isSlowResponseStatus(status) {
        return status === 408 || status === 502 || status === 503 || status === 504;
    }

    async function parseBotResponse(res) {
        const contentType = res.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
            return await res.json();
        }
        return null;
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
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ message: text, user_id: userId })
            });

            if (res.status === 419) {
                removeTyping();
                addMessage(SESSION_EXPIRED_MSG);
                return;
            }

            if (isSlowResponseStatus(res.status)) {
                removeTyping();
                addMessage(SLOW_RESPONSE_MSG);
                return;
            }

            const data = await parseBotResponse(res);
            removeTyping();

            if (!data) {
                addMessage(isSlowResponseStatus(res.status) ? SLOW_RESPONSE_MSG : CONNECTION_ERROR_MSG);
                return;
            }

            if (!res.ok) {
                addMessage(data.reply || data.message || CONNECTION_ERROR_MSG);
                return;
            }
            
            // Проверяем специальные команды
            if(data.reply == 'вызвать человека' || (data.reply && data.reply.includes('оператор'))) {
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
            addMessage(CONNECTION_ERROR_MSG);
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
    if (clearHistoryBtn) {
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
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ user_id: userId })
                });
                
                const data = await parseBotResponse(res);
                
                if(res.ok && data && data.status === 'success') {
                    const messages = chat.querySelectorAll('.message');
                    messages.forEach((msg, index) => {
                        if(index > 0) {
                            msg.remove();
                        }
                    });
                    addMessage('История диалога очищена. Можете начать новую беседу.');
                } else {
                    addMessage('Не удалось очистить историю.');
                }
            } catch (err) {
                console.error('Clear history error:', err);
                addMessage('Не удалось очистить историю.');
            }
        });
    }

</script>
