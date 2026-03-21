@extends('layouts.app')

@section('title', 'Chat with Support')

@section('content')
<div class="py-5" style="background: #0a0f1a; min-height: calc(100vh - 200px);">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 24px;">
                    <i class="bi bi-chat-dots me-2" style="color: #d4af37;"></i>Chat with Support
                </h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; overflow: hidden;">
                    <!-- Chat Header -->
                    <div class="chat-header" style="background: #0a192f; padding: 16px 20px; border-bottom: 1px solid #1d3557; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #d4af37, #b8962e); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-headset" style="color: #0a0f1a; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h6 style="color: #fff; margin-bottom: 2px;">NJ Car Rentals Support</h6>
                                <small style="color: #10b981;"><i class="bi bi-circle-fill me-1" style="font-size: 0.6rem;"></i>Online</small>
                            </div>
                        </div>
                        <button onclick="loadMessages()" class="btn btn-sm" style="background: #1d3557; color: #fff; border: none;">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                    
                    <!-- Chat Messages -->
                    <div id="chatMessages" class="chat-messages" style="height: 400px; overflow-y: auto; padding: 20px; background: #0a192f;">
                        <div id="messagesContainer">
                            <!-- Messages will be loaded here -->
                        </div>
                    </div>
                    
                    <!-- Chat Input -->
                    <div class="chat-input" style="background: #0a192f; padding: 16px 20px; border-top: 1px solid #1d3557;">
                        <form id="chatForm" class="d-flex gap-2">
                            @csrf
                            <input type="text" id="messageInput" class="form-control" 
                                   placeholder="Type your message..." 
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
    let lastMessageCount = 0;
    
    // Load messages
    function loadMessages() {
        fetch('{{ route("customer.chat.messages") }}')
            .then(response => response.json())
            .then(messages => {
                const container = document.getElementById('messagesContainer');
                
                if (messages.length === 0) {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="bi bi-chat-square-text" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p style="margin-top: 12px;">No messages yet. Start a conversation!</p>
                        </div>
                    `;
                    return;
                }
                
                let html = '';
                messages.forEach(msg => {
                    const isSent = msg.sender === 'user';
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
                const chatMessages = document.getElementById('chatMessages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                lastMessageCount = messages.length;
            })
            .catch(error => console.error('Error loading messages:', error));
    }
    
    // Send message
    document.getElementById('chatForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const input = document.getElementById('messageInput');
        const message = input.value.trim();
        
        if (!message) return;
        
        fetch('{{ route("customer.chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            input.value = '';
            loadMessages();
        })
        .catch(error => console.error('Error sending message:', error));
    });
    
    // Poll for new messages every 3 seconds
    setInterval(loadMessages, 3000);
    
    // Initial load
    loadMessages();
</script>
@endsection

