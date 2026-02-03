@extends('layouts.app')

@section('content')
<div class="flex h-[calc(100vh-64px)] bg-white dark:bg-gray-950 overflow-hidden w-full relative">

    <div id="side-panel" class="w-full md:w-80 lg:w-96 flex-shrink-0 border-r border-gray-100 dark:border-gray-800 flex flex-col bg-white dark:bg-gray-900 z-20 transition-all duration-300 h-full">
        <div class="p-4 border-b border-gray-50 dark:border-gray-800 bg-white dark:bg-gray-900 flex-shrink-0">
            <h1 class="text-2xl font-bold text-green-600 mb-4">Messages</h1>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="search-conversations" onkeyup="window.filterUsers()" placeholder="Rechercher..."
                    class="w-full pl-10 pr-4 py-2 bg-gray-100 dark:bg-gray-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-green-500 dark:text-gray-200 shadow-sm">
            </div>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar bg-white dark:bg-gray-900">
            <div id="user-list" class="divide-y divide-gray-50 dark:divide-gray-800/50">
                @forelse ($users as $user)
                    @php
                        $avatarUrl = $user->avatar 
                            ? 'https://university-platform.infinityfreeapp.com/storage/app/public/' . $user->avatar 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name) . '&background=random&color=fff';
                    @endphp
                    <div class="flex items-center p-4 cursor-pointer hover:bg-green-50/50 dark:hover:bg-gray-800/50 transition-all user-item group"
                        onclick="window.onUserClick(this)"
                        data-user-id="{{ $user->id }}"
                        data-user-name="{{ $user->first_name }} {{ $user->last_name }}"
                        data-avatar-url="{{ $avatarUrl }}">
                        
                        <div class="relative">
                            <img src="{{ $avatarUrl }}" class="rounded-full w-12 h-12 object-cover shadow-sm ring-2 ring-transparent group-hover:ring-green-500 transition-all">
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full"></div>
                        </div>
                        <div class="ml-3 flex-1 overflow-hidden">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate user-full-name">{{ $user->first_name }} {{ $user->last_name }}</h3>
                            <p class="text-[11px] text-gray-500 truncate italic">Cliquer لفتح المحادثة</p>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-400 text-sm">Aucun contact trouvé</div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="chat-panel" class="hidden md:flex flex-1 flex flex-col bg-gray-50 dark:bg-gray-950 h-full relative overflow-hidden">
        
        <div id="chat-header" class="hidden h-16 flex-shrink-0 flex items-center px-4 md:px-6 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 shadow-sm z-30">
            <button onclick="window.backToList()" class="md:hidden mr-3 p-2 text-gray-500 hover:text-green-500 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </button>
            <img id="chat-user-avatar" src="" class="rounded-full w-10 h-10 object-cover mr-3 border dark:border-gray-700 shadow-sm">
            <div>
                <h2 id="chat-user-name" class="font-bold text-sm dark:text-white leading-tight"></h2>
                <div class="flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                    <span class="text-[10px] text-green-500 font-bold uppercase tracking-wider">En ligne</span>
                </div>
            </div>
        </div>

        <div id="chat-box" class="flex-1 overflow-y-auto p-4 custom-scrollbar flex flex-col relative bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-repeat bg-fixed">
            <div id="no-chat" class="m-auto text-gray-400 flex flex-col items-center">
                <div class="w-20 h-20 bg-green-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-comments text-3xl text-green-500 opacity-50"></i>
                </div>
                <p class="text-sm font-semibold tracking-wide">Sélectionnez une conversation</p>
                <p class="text-xs mt-1 opacity-70">Commencez à discuter maintenant</p>
            </div>
            <div id="messages-container" class="hidden w-full max-w-3xl mx-auto flex flex-col space-y-4 pb-6">
                </div>
        </div>

        <div id="chat-input-area" class="hidden p-4 md:p-6 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 z-40">
            <div class="max-w-4xl mx-auto flex items-center bg-gray-50 dark:bg-gray-800 rounded-2xl p-1.5 pr-2 border border-green-500/20 focus-within:border-green-500/50 shadow-sm transition-all duration-300">
                <input type="text" id="message-input" placeholder="Rédiger votre message..." autocomplete="off"
                    class="flex-1 px-4 py-2.5 bg-transparent border-none text-sm dark:text-white focus:ring-0 outline-none">
                
                <button type="button" id="send-button" onclick="window.sendMessage()" 
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-green-500 hover:bg-green-600 text-white shadow-md active:scale-95 transition-all">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* منع السكرول العام */
    html, body { height: 100%; overflow: hidden; margin: 0; }
    
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b98144; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #10b981; }

    /* أنيميشن الرسائل */
    .msg-pop { animation: msgPop 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    @keyframes msgPop { from { opacity: 0; transform: scale(0.9) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }

    /* Responsive Logic */
    @media (max-width: 768px) {
        .mobile-chat-open #side-panel { display: none; }
        .mobile-chat-open #chat-panel { display: flex; width: 100%; position: absolute; inset: 0; z-index: 50; }
    }
</style>

<script>
(function () {
    const AUTH_ID = {{ auth()->id() }};
    let selectedUserId = null;
    let chatInterval = null;

    // للرجوع في الهاتف
    window.backToList = function() {
        document.body.classList.remove('mobile-chat-open');
        if (chatInterval) clearInterval(chatInterval);
    };

    window.filterUsers = function() {
        let input = document.getElementById('search-conversations').value.toLowerCase();
        let items = document.querySelectorAll('.user-item');
        items.forEach(item => {
            let name = item.querySelector('.user-full-name').textContent.toLowerCase();
            item.style.display = name.includes(input) ? "flex" : "none";
        });
    }

    window.onUserClick = function (el) {
        selectedUserId = Number(el.dataset.userId);
        document.body.classList.add('mobile-chat-open');
        
        // إظهار العناصر
        document.getElementById('no-chat').classList.add('hidden');
        document.getElementById('chat-header').classList.remove('hidden');
        document.getElementById('messages-container').classList.remove('hidden');
        const inputArea = document.getElementById('chat-input-area');
        inputArea.classList.remove('hidden');
        inputArea.style.display = 'block'; 
        
        document.getElementById('chat-user-name').textContent = el.dataset.userName;
        document.getElementById('chat-user-avatar').src = el.dataset.avatarUrl;
        document.getElementById('messages-container').innerHTML = '';

        if (chatInterval) clearInterval(chatInterval);
        loadMessages(selectedUserId);
        chatInterval = setInterval(() => loadMessages(selectedUserId), 3000); 

        setTimeout(() => document.getElementById('message-input').focus(), 350);
    };

    async function loadMessages(userId) {
        const container = document.getElementById('messages-container');
        try {
            const res = await fetch(`/get-m/${userId}`);
            const data = await res.json();
            
            if (data.messages && data.messages.length !== container.children.length) {
                container.innerHTML = '';
                data.messages.forEach(m => {
                    const isMine = m.sender_id == AUTH_ID;
                    const div = document.createElement('div');
                    div.className = `flex ${isMine ? 'justify-end' : 'justify-start'} w-full msg-pop`;
                    
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `max-w-[85%] md:max-w-[70%] px-4 py-2.5 rounded-2xl text-[13px] md:text-sm shadow-sm ${
                        isMine ? 'bg-green-500 text-white rounded-br-none' 
                               : 'bg-white dark:bg-gray-800 dark:text-white rounded-bl-none border border-gray-100 dark:border-gray-700'
                    }`;
                    messageDiv.textContent = m.message;
                    
                    div.appendChild(messageDiv);
                    container.appendChild(div);
                });
                scrollDown();
            }
        } catch (err) { console.error("Error loading messages"); }
    }

    window.sendMessage = async function () {
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        if (!message || !selectedUserId) return;

        const fd = new FormData();
        fd.append('receiver_id', selectedUserId);
        fd.append('message', message);
        fd.append('_token', '{{ csrf_token() }}');

        try {
            const response = await fetch('/send-m', { method: 'POST', body: fd });
            if (response.ok) {
                input.value = '';
                loadMessages(selectedUserId);
            }
        } catch (err) { console.error("Error sending message"); }
    };

    function scrollDown() {
        const box = document.getElementById('chat-box');
        box.scrollTo({ top: box.scrollHeight, behavior: 'smooth' });
    }

    document.getElementById('message-input').addEventListener('keydown', (e) => {
        if(e.key === 'Enter') { e.preventDefault(); window.sendMessage(); }
    });
})();
</script>
@endsection
