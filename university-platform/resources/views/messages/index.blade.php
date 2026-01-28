@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">

        <!-- Left Panel: Conversations List -->
        <div class="w-1/3 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col">

            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <div class="flex items-center space-x-3">
                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random&color=fff&size=40' }}"
                        class="rounded-full w-10 h-10" alt="Your Avatar">
                    <h1 class="text-lg font-semibold text-gray-800 dark:text-white">Chats</h1>
                </div>
            </div>

            <div class="p-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                    <input type="text" id="search-conversations" placeholder="Rechercher ou démarrer une discussion"
                        class="w-full pl-10 pr-10 py-2 bg-white dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent placeholder-gray-500 dark:placeholder-gray-400">
                </div>
            </div>

            <div class="flex-1 overflow-y-auto">
                <div id="user-list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($users as $user)
                        @php
                            $avatarUrl = $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) . '&background=random&color=fff&size=40';
                            $displayName = $user->first_name . ' ' . $user->last_name;
                        @endphp
                        <div class="flex flex-col items-center space-y-2 p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors user-item"
                            data-user-id="{{ $user->id }}"
                            data-user-name="{{ $displayName }}"
                            data-avatar-url="{{ $avatarUrl }}">
                            <div class="relative">
                                <img src="{{ $avatarUrl }}" class="rounded-full w-12 h-12" alt="">
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white text-center">{{ $displayName }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 text-center truncate" id="last-message-{{ $user->id }}">
                                @if($user->lastMessage)
                                    {{ Str::limit($user->lastMessage->message, 32) }}
                                @else
                                    No messages yet
                                @endif
                            </p>
                            <span class="text-xs text-gray-500 dark:text-gray-400" id="last-time-{{ $user->id }}">
                                @if($user->last_message_time)
                                    {{ $user->last_message_time->diffForHumans() }}
                                @endif
                            </span>
                            @if (($user->unread_count ?? 0) > 0)
                                <span id="unread-badge-{{ $user->id }}" class="min-w-[1.25rem] h-5 px-1.5 flex items-center justify-center bg-green-500 text-white text-xs font-semibold rounded-full">
                                    {{ $user->unread_count > 99 ? '99+' : $user->unread_count }}
                                </span>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-comments text-4xl mb-4 text-gray-300 dark:text-gray-500"></i>
                            <p class="text-gray-900 dark:text-white">No conversations yet</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Start a new chat to get connected!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Panel: Active Chat -->
        <div class="flex-1 flex flex-col h-full bg-gray-50 dark:bg-gray-800">

            <div id="chat-header" class="hidden flex-shrink-0 flex items-center justify-between p-4 bg-white dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                <div class="flex items-center space-x-3">
                    <img id="chat-user-avatar" src="" class="rounded-full w-10 h-10" alt="">
                    <div>
                        <h2 id="chat-user-name" class="font-semibold text-gray-900 dark:text-white"></h2>
                        <p id="chat-user-subtitle" class="text-sm text-gray-500 dark:text-gray-400">Online</p>
                    </div>
                </div>
            </div>

            <div id="chat-box" class="flex-1 overflow-y-auto p-4 min-h-0 flex flex-col">
                <div id="no-chat" class="flex-1 flex flex-col items-center justify-center text-center text-gray-500 dark:text-gray-400 mt-20">
                    <i class="fas fa-comments text-6xl mb-4 text-gray-300 dark:text-gray-500"></i>
                    <h3 class="text-xl font-light mb-2 text-gray-900 dark:text-white">Sélectionnez une conversation</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Choisissez un contact dans la liste pour commencer à discuter</p>
                </div>
                <div id="messages-container" class="hidden flex flex-col gap-3"></div>
            </div>

            <div id="chat-input-area" class="hidden flex-shrink-0 p-4 bg-gray-100 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                <div class="flex items-end space-x-3">
                    <button type="button" id="attachment-button" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-600 dark:text-gray-400">
                        <i class="fas fa-paperclip text-xl"></i>
                    </button>
                    <input type="file" id="attachment-input" class="hidden">
                    <div class="flex-1 relative">
                        <input type="text" id="message-input" placeholder="Taper un message" autocomplete="off"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent placeholder-gray-500 dark:placeholder-gray-400"
                            style="min-height: 44px;">
                    </div>
                    <button type="button" id="send-button" class="p-3 rounded-full bg-green-500 hover:bg-green-600 transition-colors text-white">
                        <i class="fas fa-paper-plane text-lg"></i>
                    </button>
                </div>
                <div id="attachment-preview" class="mt-2 hidden"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>
<script>
(function() {
'use strict';

const AUTH_ID = {{ Auth::id() }};
let selectedUserId = null;
let selectedUserName = null;
let selectedAvatarUrl = null;
let currentPage = 1;
let hasMoreMessages = true;
let isLoadingMessages = false;

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

@if(config('broadcasting.connections.reverb.key'))
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: '{{ config('broadcasting.connections.reverb.key') }}',
    wsHost: '{{ config('broadcasting.connections.reverb.options.host') }}',
    wsPort: {{ config('broadcasting.connections.reverb.options.port') ?? 443 }},
    wssPort: {{ config('broadcasting.connections.reverb.options.port') ?? 443 }},
    forceTLS: {{ (config('broadcasting.connections.reverb.options.scheme') ?? 'https') === 'https' ? 'true' : 'false' }},
    enabledTransports: ['ws', 'wss'],
});
@else
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '{{ config('broadcasting.connections.pusher.key') }}',
    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') ?? 'mt1' }}',
    forceTLS: true
});
@endif

function conversationChannel(a, b) {
    return 'conversation.' + [a, b].sort((x, y) => x - y).join('.');
}

function escapeHtml(s) {
    const div = document.createElement('div');
    div.textContent = s ?? '';
    return div.innerHTML;
}

function onUserClick(el) {
    selectedUserId = Number(el.dataset.userId);
    selectedUserName = el.dataset.userName;
    selectedAvatarUrl = el.dataset.avatarUrl || ('https://ui-avatars.com/api/?name=' + encodeURIComponent(selectedUserName) + '&background=random&color=fff&size=40');

    document.getElementById('chat-user-name').textContent = selectedUserName;
    document.getElementById('chat-user-avatar').src = selectedAvatarUrl;
    document.getElementById('chat-header').classList.remove('hidden');
    document.getElementById('chat-header').classList.add('flex');
    document.getElementById('chat-input-area').classList.remove('hidden');
    document.getElementById('no-chat').classList.add('hidden');
    document.getElementById('messages-container').classList.remove('hidden');
    document.getElementById('messages-container').classList.add('flex');

    document.querySelectorAll('.user-item').forEach(u => {
        u.classList.remove('bg-green-100', 'dark:bg-green-800', 'border-r-4', 'border-green-500');
    });
    el.classList.add('bg-green-100', 'dark:bg-green-800', 'border-r-4', 'border-green-500');

    const badge = document.getElementById('unread-badge-' + selectedUserId);
    if (badge) badge.remove();

    currentPage = 1;
    hasMoreMessages = true;
    showTypingIndicator(null, false);
    loadMessages(selectedUserId);
    subscribeToConversation(selectedUserId);
}

document.querySelectorAll('.user-item').forEach(item => {
    item.addEventListener('click', function() { onUserClick(this); });
});

function subscribeToConversation(userId) {
    window.Echo.leaveAllChannels();
    const channel = conversationChannel(AUTH_ID, userId);
    window.Echo.private(channel)
        .listen('MessageSent', e => {
            if (Number(e.message.sender_id) !== AUTH_ID) {
                appendMessage(e.message, false);
                updateLastMessagePreview(
                    e.message.sender_id,
                    e.message.message,
                    new Date(e.message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                );
            }
        })
        .listen('.typing', e => {
            if (Number(e.user.id) === userId) showTypingIndicator(e.user, e.is_typing);
        });
}

function loadMessages(userId, page, prepend) {
    if (isLoadingMessages) return;
    isLoadingMessages = true;
    page = page || 1;
    prepend = !!prepend;

    const container = document.getElementById('messages-container');
    const chatBox = document.getElementById('chat-box');
    const scrollHeightBefore = chatBox.scrollHeight;
    const scrollTopBefore = chatBox.scrollTop;

    window.axios.get('/chat/messages/' + userId, { params: { page } })
        .then(res => {
            if (!prepend) container.innerHTML = '';
            const frag = document.createDocumentFragment();
            res.data.messages.forEach(m => frag.appendChild(messageToNode(m)));
            if (prepend) {
                container.insertBefore(frag, container.firstChild);
                const delta = chatBox.scrollHeight - scrollHeightBefore;
                chatBox.scrollTop = scrollTopBefore + delta;
            } else {
                container.appendChild(frag);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            hasMoreMessages = res.data.has_more;
            currentPage = res.data.current_page;
            isLoadingMessages = false;
        })
        .catch(() => { isLoadingMessages = false; });
}

function messageToNode(msg) {
    const isMine = Number(msg.sender_id) === AUTH_ID;
    const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const text = escapeHtml(msg.message || '');
    const div = document.createElement('div');
    div.className = isMine ? 'flex justify-end' : 'flex justify-start';
    div.dataset.messageId = msg.id;
    let inner = '<div class="max-w-[75%] px-4 py-2 rounded-lg ';
    if (isMine) inner += 'bg-green-500 text-white">'; else inner += 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white">';
    inner += '<p class="text-sm break-words">' + text + '</p>';
    if (msg.attachment_path) {
        const url = msg.attachment_url || ('{{ url("/") }}/storage/' + escapeHtml(msg.attachment_path));
        inner += '<a href="' + escapeHtml(url) + '" target="_blank" rel="noopener" class="text-xs underline mt-1 block">Attachment</a>';
    }
    inner += '<span class="text-xs opacity-70 mt-1 block">' + time + '</span></div>';
    div.innerHTML = inner;
    return div;
}

function appendMessage(msg, scroll = true) {
    const container = document.getElementById('messages-container');
    const chatBox = document.getElementById('chat-box');
    const node = messageToNode(msg);
    container.appendChild(node);
    if (scroll) chatBox.scrollTop = chatBox.scrollHeight;
}

function sendMessage() {
    const input = document.getElementById('message-input');
    const message = (input.value || '').trim();
    if (!message || !selectedUserId) return;

    window.axios.post('/chat/send', { receiver_id: selectedUserId, message })
        .then(res => {
            input.value = '';
            appendMessage(res.data);
            const time = new Date(res.data.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            updateLastMessagePreview(selectedUserId, res.data.message, time);
        })
        .catch(() => {});
}

document.getElementById('send-button').addEventListener('click', sendMessage);
document.getElementById('message-input').addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
});

let typingTimeout;
document.getElementById('message-input').addEventListener('input', () => {
    if (!selectedUserId) return;
    window.axios.post('/chat/typing', { receiver_id: selectedUserId, is_typing: true });
    clearTimeout(typingTimeout);
    typingTimeout = setTimeout(() => {
        window.axios.post('/chat/typing', { receiver_id: selectedUserId, is_typing: false });
    }, 1200);
});

function showTypingIndicator(user, show) {
    let el = document.getElementById('typing-indicator');
    if (show && !el) {
        el = document.createElement('div');
        el.id = 'typing-indicator';
        el.className = 'flex justify-start text-sm text-gray-500 dark:text-gray-400 mb-2';
        const name = (user && (user.name || user.first_name)) ? (user.name || user.first_name) : 'Someone';
        el.textContent = name + ' is typing…';
        document.getElementById('messages-container').appendChild(el);
        document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
    }
    if (!show && el) el.remove();
}

function updateLastMessagePreview(userId, msg, time) {
    const limit = (s) => (s && s.length > 32) ? s.slice(0, 29) + '…' : (s || '');
    const lastMsg = document.getElementById('last-message-' + userId);
    const lastTime = document.getElementById('last-time-' + userId);
    if (lastMsg) lastMsg.textContent = limit(msg);
    if (lastTime) lastTime.textContent = time || '';
}

const chatBox = document.getElementById('chat-box');
chatBox.addEventListener('scroll', () => {
    if (!hasMoreMessages || isLoadingMessages || !selectedUserId) return;
    if (chatBox.scrollTop < 80) {
        loadMessages(selectedUserId, currentPage + 1, true);
    }
});

function filterUsers() {
    const searchTerm = document.getElementById('search-conversations').value.toLowerCase();
    const userItems = document.querySelectorAll('.user-item');

    userItems.forEach(item => {
        const userName = item.dataset.userName.toLowerCase();
        if (userName.includes(searchTerm)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

document.getElementById('search-conversations').addEventListener('input', filterUsers);
})();
</script>
@endsection
