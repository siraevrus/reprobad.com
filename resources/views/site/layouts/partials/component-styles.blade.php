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
    #openChatBtn { position: fixed;bottom: 160px;right: 20px;background: var(--mandarin);color: white;border: none;padding: 10px 16px;border-radius: 12px;cursor: pointer;font-weight: bold;font-size: 85%;display: none;z-index: 90; }
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

#floating-banner-desktop,
    #floating-banner-mobile {
        z-index: 1000;
        width: calc(100% - 40px);
    }
    #floating-banner-desktop a:hover,
    #floating-banner-mobile a:hover {
        opacity: 1 !important;
    }
    #floating-banner-desktop,
    #floating-banner-mobile {
        pointer-events: none;
    }
    #floating-banner-desktop a {
        display: block;
        overflow: hidden;
        aspect-ratio: 1024 / 86;
        width: 100%;
        position: relative;
        pointer-events: auto;
    }
    #floating-banner-mobile a {
        display: block;
        overflow: hidden;
        aspect-ratio: 780 / 192;
        width: 100%;
        position: relative;
        pointer-events: auto;
    }
    .floating-banner-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }
    #floating-banner-desktop,
    #floating-banner-mobile {
        position: fixed;
        left: 0;
        right: 0;
        margin: auto;
        transition: bottom 0.3s ease, visibility 0.3s ease;
    }
    #floating-banner-desktop .close,
    #floating-banner-mobile .close {
        pointer-events: auto;
    }
    #floating-banner-desktop .close,
    #floating-banner-mobile .close {
        position: absolute;
        top: -50px;
        right: 15px;
        font-size: 40px;
        height: 40px;
        width: 40px;
        cursor: pointer;
        line-height: 80%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #floating-banner-desktop .close img,
    #floating-banner-mobile .close img {
        filter: invert(1);
        opacity: .5;
    }

.modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
        justify-content: center;
        align-items: center;
        background-color: rgb(0, 0, 0, .6);
    }
    .modal .map-search {
        width: calc(100% - 40px);
        margin: 0 20px 15px 20px;
    }
    .modal.show {
        display: flex;
    }
    .modal .wrap {
        background: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border-radius: 12px;
        max-width: 400px;
        width: 90%;
        max-height: 70vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .modal-title {
        padding: 20px 24px 16px;
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin: 0;
        flex-shrink: 0;
    }
    .modal-content .cities-list {
        flex: 1;
        overflow-y: auto;
        padding: 8px 20px;
        max-height: 40vh;
    }
    .modal-content label input {
        display: none;
    }
    .modal-content label {
        display: block;
        padding: 12px 24px;
        color: #333;
        text-decoration: none;
        font-size: 16px;
        transition: all 0.2s ease;
        cursor: pointer;
        border-radius: 6px;
        margin: 2px 0;
    }
    .modal-content label:hover {
        background-color: #f8f9fa;
        color: var(--mandarin);
    }
    .modal-content label input:checked + span {
        color: var(--mandarin);
        font-weight: 600;
    }
    .modal-content label:has(input:checked) {
        background-color: #fff3e0;
        color: var(--mandarin);
    }
    .modal-content button {
        width: calc(100% - 40px);
        margin: 20px;
        transition: all 0.2s ease;
    }
    .modal-content button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .no-results {
        padding: 20px;
        text-align: center;
        color: #6b7280;
        font-style: italic;
    }
    .modal-content .cities-list::-webkit-scrollbar {
        width: 6px;
    }
    .modal-content .cities-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .modal-content .cities-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .modal-content .cities-list::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    @media (max-width: 480px) {
        .modal-content {
            max-height: 80vh;
        }
        .modal-title {
            padding: 16px 20px 12px;
            font-size: 16px;
        }
        .modal-content a {
            padding: 10px 20px;
            font-size: 15px;
        }
        .modal-content button {
            margin-left: 20px;
            background-color: var(--mandarin);
            color: #fff;
        }
    }

.article-icon-image {
    mask-image: url('https://cdn.prod.website-files.com/67040316492967a9326aebb1/6704f8b64f300dd6400349c8_big-news-icon.svg');
    mask-size: contain;
    mask-repeat: no-repeat;
    mask-position: center;
}
</style>
