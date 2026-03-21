@extends('layouts.app')

@section('title', 'Chat with Customers')

@section('content')
<div class="py-4" style="background: #0a0f1a; min-height: calc(100vh - 200px);">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 style="color: #fff; margin-bottom: 20px;">
                    <i class="bi bi-chat-dots me-2" style="color: #d4af37;"></i>Chat with Customers
                </h4>
            </div>
        </div>
        
        <div class="row">
            <!-- Conversations List -->
            <div class="col-md-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px; max-height: 500px; overflow-y: auto;">
                    <div class="card-header" style="background: #0a192f; border-bottom: 1px solid #1d3557; padding: 16px;">
                        <h6 style="color: #fff; margin: 0;">Conversations</h6>
                    </div>
                    <div class="list-group list-group-flush" id="conversationsList">
                        @forelse($conversations as $conv)
                        <a href="#" onclick="selectConversation({{ $conv->user_id }})" 
                           class="list-group-item conversation-item" 
                           style="background: #112240; border-bottom: 1px solid #1d3557; color: #fff; padding: 16px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #d4af37, #b8962e); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0a0f1a; font-weight: bold;">
                                    {{ strtoupper(substr($conv->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 500;">{{ $conv->user->name ?? 'Unknown User' }}</div>
                                    <small style="color: #6c757d;">{{ $conv->user->email ?? '' }}</small>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div style="padding: 20px; text-align: center; color: #6c757d;">
                            No conversations yet
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Chat Area -->
            <div class="col-md-8">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px; overflow: hidden;">
                    <!-- Chat Header -->
                    <div class="chat-header" style="background: #0a192f; padding: 16px 20px; border-bottom: 1px solid #1d3557; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div id="chatUserAvatar" style="width: 40px; height: 40px; background: linear-gradient(135deg, #d4af37, #b8962e); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0a0f1a; font-weight: bold;">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <h6 id="chatUserName" style="color: #fff; margin-bottom: 2px;">Select a conversation</h6>
                                <small id="chatUserStatus" style="color: #10b981;"><i class="bi bi-circle-fill me-1" style="font-size: 0.6rem;"></i>Online</small>
                            </div>
                        </div>
                        <button onclick="loadAdminMessages()" class="btn btn-sm" style="background: #1d3557; color: #fff; border: none;">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                    
                    <!-- Chat Messages -->
                    <div id="adminChatMessages" class="chat-messages" style="height: 350px; overflow-y: auto; padding: 20px; background: #0a192f;">
                        <div id="adminMessagesContainer">
                            <div style="text-align: center; padding: 40px; color: #6c757d;">
                                <i class="bi bi-chat-square-text" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p style="margin-top: 12px;">Select a conversation to start chatting</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chat Input -->
                    <div class="chat-input" id="chatInputArea" style="background: #0a192f; padding: 16px 20px; border-top: 1px solid #1d3557; display: none;">
                        <form id="adminChatForm" class="d-flex gap-2">
                            @csrf
                            <input type="hidden" id="selectedUserId" value="">
                            <input type="text" id="adminMessageInput" class="form-control" 
                                   placeholder="Type your reply..." 
                                   style="background: #112240; border: 2px solid #1d3557; border-radius: 12px; color: #fff; padding: 12px 16px;"
                                   autocomplete="off">
                            <button type="submit" class="btn btn-primary" style="padding: 12px 20px; border-radius: 12px;">
                                <i class="bi bi-send"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    .chat-messages::-webkit-scrollbar-track {
        background: #0a192f;
    }
    .chat-messages::-webkit-scrollbar-thumb {
        background: #1d3557;
        border-radius: 3px;
    }
    .conversation-item:hover {
        background: #1d3557 !important;
    }
    .message-bubble {
        max-width: 75%;
        padding: 12px 16px;
        border-radius: 16px;
        margin-bottom: 12px;
        word-wrap: break-word;
    }
    .message-sent {
        background: linear-gradient(135deg, #d4af37, #b8962e);
        color: #0a0f1a;
        margin-left: auto;
        border-bottom-right-radius: 4px;
    }
    .message-received {
        background: #1d3557;
        color: #fff;
        border-bottom-left-radius: 4px;
    }
    .message-time {
        font-size: 0.7rem;
        opacity: 0.7;
        margin-top: 4px;
    }
</style>

<script>
    let selectedUserId = null;
    
    function selectConversation(userId) {
        selectedUserId = userId;
        document.getElementById('selectedUserId').value = userId;
        document.getElementById('chatInputArea').style.display = 'block';
        
        // Update header
        const convItem = event.target.closest('.conversation-item');
        if (convItem) {
            const name = convItem.querySelector('div > div > div').textContent;
            document.getElementById('chatUserName').textContent = name;
            document.getElementById('chatUserAvatar').textContent = name.charAt(0).toUpperCase();
        }
        
        loadAdminMessages();
    }
    
    function loadAdminMessages() {
        if (!selectedUserId) return;
        
        fetch(`/admin/chat/messages?user_id=${selectedUserId}`)
            .then(response => response.json())
            .then(messages => {
                const container = document.getElementById('adminMessagesContainer');
                
                if (messages.length === 0) {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="bi bi-chat-square-text" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p style="margin-top: 12px;">No messages yet</p>
                        </div>
                    `;
                    return;
                }
                
                let html = '';
                messages.forEach(msg => {
                    const isSent = msg.sender === 'staff';
                    const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    
                    html += `
                        <div class="message-bubble ${isSent ? 'message-sent' : 'message-received'}" style="${isSent ? 'margin-left: auto;' : ''}">
                            <div>${msg.message}</div>
                            <div class="message-time">${time}</div>
                        </div>
                    `;
                });
                
                container.innerHTML = html;
                
                // Scroll to bottom
                const chatMessages = document.getElementById('adminChatMessages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            })
            .catch(error => console.error('Error loading messages:', error));
    }
    
    // Send message
    document.getElementById('adminChatForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const input = document.getElementById('adminMessageInput');
        const message = input.value.trim();
        const userId = document.getElementById('selectedUserId').value;
        
        if (!message || !userId) return;
        
        fetch('{{ route("admin.chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                message: message,
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            input.value = '';
            loadAdminMessages();
        })
        .catch(error => console.error('Error sending message:', error));
    });
    
    // Poll for new messages every 3 seconds
    setInterval(() => {
        if (selectedUserId) {
            loadAdminMessages();
        }
    }, 3000);
</script>
@endsection

