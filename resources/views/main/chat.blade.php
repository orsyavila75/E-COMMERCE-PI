@extends('template.main-template')

@section('title', 'Chat - Kerajinan Nusantara')

@section('content')
<div class="container mx-auto px-4 py-8 h-[calc(100vh-100px)]">
    <div class="bg-white rounded-2xl shadow-xl border border-primary-100 overflow-hidden h-full flex">
        
        {{-- Sidebar Contacts --}}
        <div class="w-1/3 border-r border-primary-100 flex flex-col bg-gray-50">
            {{-- Header --}}
            <div class="p-4 border-b border-primary-100 bg-white">
                <h2 class="font-bold text-primary-900 text-lg mb-4">Pesan</h2>
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-primary-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input type="text" placeholder="Cari kontak..." class="w-full pl-10 pr-4 py-2 bg-gray-100 border-none rounded-xl focus:ring-2 focus:ring-primary-500/20 text-sm">
                </div>
            </div>

            {{-- Contact List --}}
            <div class="flex-1 overflow-y-auto p-2 space-y-1" id="contact-list">
                @foreach($contacts as $contact)
                    <button onclick="loadChat({{ $contact->id_user }}, '{{ $contact->name }}', '{{ $contact->role }}')" 
                            class="w-full p-3 flex items-center gap-3 rounded-xl hover:bg-white hover:shadow-sm transition-all text-left group focus:bg-white focus:shadow-md contact-item"
                            data-id="{{ $contact->id_user }}">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                {{ substr($contact->name, 0, 1) }}
                            </div>
                            @if($contact->unread_count > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold flex items-center justify-center rounded-full border-2 border-white">
                                    {{ $contact->unread_count }}
                                </span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5">
                                <h3 class="font-bold text-primary-900 truncate">{{ $contact->name }}</h3>
                                <span class="text-xs text-primary-400">{{ $contact->last_message_time ? \Carbon\Carbon::parse($contact->last_message_time)->format('H:i') : '' }}</span>
                            </div>
                            <p class="text-sm text-primary-500 truncate group-hover:text-primary-700 transition-colors">
                                {{ $contact->last_message }}
                            </p>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Chat Area --}}
        <div class="flex-1 flex flex-col bg-white relative">
            {{-- Empty State --}}
            <div id="empty-state" class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 bg-white z-10">
                <div class="w-24 h-24 bg-primary-50 rounded-full flex items-center justify-center mb-6 animate-pulse">
                    <i data-lucide="message-circle" class="w-12 h-12 text-primary-300"></i>
                </div>
                <h3 class="text-xl font-bold text-primary-900 mb-2">Mulai Percakapan</h3>
                <p class="text-primary-500 max-w-md">Pilih kontak di sebelah kiri untuk mulai mengobrol dengan penjual atau pembeli.</p>
            </div>

            {{-- Chat Header --}}
            <div id="chat-header" class="p-4 border-b border-primary-100 flex items-center justify-between bg-white shadow-sm z-20 hidden">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold shadow-md" id="chat-avatar">
                        A
                    </div>
                    <div>
                        <h3 class="font-bold text-primary-900" id="chat-name">Nama User</h3>
                        <p class="text-xs text-green-500 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Online
                        </p>
                    </div>
                </div>
                <button class="p-2 text-primary-400 hover:bg-primary-50 rounded-lg transition-colors">
                    <i data-lucide="more-vertical" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Messages Area --}}
            <div id="messages-area" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50/50 hidden scroll-smooth">
                {{-- Messages will be loaded here --}}
            </div>

            {{-- Input Area --}}
            <div id="input-area" class="p-4 border-t border-primary-100 bg-white hidden">
                <form id="message-form" class="flex items-end gap-2">
                    <button type="button" class="p-3 text-primary-400 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-colors">
                        <i data-lucide="paperclip" class="w-5 h-5"></i>
                    </button>
                    <div class="flex-1 relative">
                        <textarea id="message-input" rows="1" placeholder="Ketik pesan..." class="w-full pl-4 pr-12 py-3 bg-gray-50 border border-primary-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none max-h-32 transition-all"></textarea>
                        <button type="button" class="absolute right-3 bottom-2.5 p-1 text-primary-400 hover:text-primary-600 transition-colors">
                            <i data-lucide="smile" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <button type="submit" class="p-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 shadow-lg shadow-primary-500/30 transition-all transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i data-lucide="send" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let currentReceiverId = null;
    let pollingInterval = null;

    function loadChat(userId, userName, userRole) {
        currentReceiverId = userId;
        
        // Update Header
        $('#chat-name').text(userName);
        $('#chat-avatar').text(userName.charAt(0));
        
        // Show Chat UI
        $('#empty-state').addClass('hidden');
        $('#chat-header').removeClass('hidden');
        $('#messages-area').removeClass('hidden');
        $('#input-area').removeClass('hidden');
        
        // Highlight active contact
        $('.contact-item').removeClass('bg-primary-50 ring-1 ring-primary-100');
        $(`.contact-item[data-id="${userId}"]`).addClass('bg-primary-50 ring-1 ring-primary-100');

        // Load Messages
        fetchMessages();

        // Start Polling
        if (pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(fetchMessages, 3000); // Poll every 3 seconds
    }

    function fetchMessages() {
        if (!currentReceiverId) return;

        $.get(`/chat/messages/${currentReceiverId}`, function(messages) {
            const messagesArea = $('#messages-area');
            const wasAtBottom = messagesArea[0].scrollHeight - messagesArea[0].scrollTop === messagesArea[0].clientHeight;
            
            messagesArea.empty();
            
            let lastDate = null;

            messages.forEach(msg => {
                const isMe = msg.sender_id == {{ Auth::id() }};
                const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const date = new Date(msg.created_at).toLocaleDateString();

                // Date Divider
                if (date !== lastDate) {
                    messagesArea.append(`
                        <div class="flex justify-center my-4">
                            <span class="text-xs font-medium text-primary-400 bg-primary-50 px-3 py-1 rounded-full border border-primary-100">
                                ${date}
                            </span>
                        </div>
                    `);
                    lastDate = date;
                }

                messagesArea.append(`
                    <div class="flex ${isMe ? 'justify-end' : 'justify-start'}">
                        <div class="max-w-[70%] ${isMe ? 'bg-primary-600 text-white rounded-t-2xl rounded-bl-2xl' : 'bg-white border border-primary-100 text-primary-900 rounded-t-2xl rounded-br-2xl'} px-5 py-3 shadow-sm relative group">
                            <p class="text-sm leading-relaxed">${msg.message}</p>
                            <span class="text-[10px] ${isMe ? 'text-primary-100' : 'text-primary-400'} block text-right mt-1 font-medium">
                                ${time}
                                ${isMe ? (msg.is_read ? '<i data-lucide="check-check" class="w-3 h-3 inline ml-0.5"></i>' : '<i data-lucide="check" class="w-3 h-3 inline ml-0.5"></i>') : ''}
                            </span>
                        </div>
                    </div>
                `);
            });

            // Re-initialize icons for new elements
            lucide.createIcons();

            // Auto scroll to bottom if was at bottom or first load
            messagesArea.scrollTop(messagesArea[0].scrollHeight);
        });
    }

    $('#message-form').submit(function(e) {
        e.preventDefault();
        const message = $('#message-input').val().trim();
        if (!message || !currentReceiverId) return;

        // Optimistic UI Update (Optional, but makes it feel faster)
        // For now, let's just clear input and wait for AJAX response to append
        $('#message-input').val('');

        $.ajax({
            url: '{{ route("chat.send") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                receiver_id: currentReceiverId,
                message: message
            },
            success: function(response) {
                fetchMessages(); // Refresh immediately
            },
            error: function(err) {
                alert('Gagal mengirim pesan');
            }
        });
    });

    // Auto-resize textarea
    const tx = document.getElementsByTagName("textarea");
    for (let i = 0; i < tx.length; i++) {
        tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
        tx[i].addEventListener("input", OnInput, false);
    }

    function OnInput() {
        this.style.height = "auto";
        this.style.height = (this.scrollHeight) + "px";
    }
</script>
@endsection
