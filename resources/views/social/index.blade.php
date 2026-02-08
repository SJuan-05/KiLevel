@extends('layouts.app')

@section('content')
<style>
    /* --- FONDO GLOBAL ADAPTADO --- */
    body {
        background-color: #050505;
        background-image: radial-gradient(circle at 50% 0%, #1a1a1a 0%, #050505 85%);
    }

    .social-hub { padding-bottom: 120px; }
    
    /* --- HEADERS TECH --- */
    .tech-header {
        font-weight: 900;
        text-transform: uppercase;
        font-style: italic;
        letter-spacing: 3px;
        color: #fff;
        text-shadow: 0 0 15px rgba(255, 193, 7, 0.3);
        margin-bottom: 30px;
        border-left: 4px solid #ffc107;
        padding-left: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .tech-header::after {
        content: '';
        height: 1px;
        flex: 1;
        background: linear-gradient(90deg, rgba(255,193,7,0.3), transparent);
    }

    /* --- BUSCADOR PREMIUM --- */
    .search-container {
        background: rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(255, 193, 7, 0.1);
        padding: 40px;
        position: relative;
        overflow: hidden;
        margin-bottom: 60px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        clip-path: polygon(0 0, 100% 0, 100% 85%, 95% 100%, 0 100%);
    }

    .search-container::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 2px;
        background: linear-gradient(90deg, transparent, #ffc107, transparent);
    }

    .input-cyber {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid #333;
        color: #fff;
        border-radius: 0;
        padding: 15px 25px;
        font-weight: bold;
        transition: 0.3s;
        font-size: 1.1rem;
    }

    .input-cyber:focus {
        background: rgba(0, 0, 0, 0.8);
        border-color: #ffc107;
        box-shadow: 0 0 20px rgba(255, 193, 7, 0.1);
        color: #fff;
        outline: none;
    }

    .btn-cyber-search {
        background: #ffc107;
        color: #000;
        border: none;
        border-radius: 0;
        padding: 0 40px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        clip-path: polygon(0 0, 100% 0, 100% 70%, 85% 100%, 0 100%);
        transition: 0.3s;
    }

    .btn-cyber-search:hover {
        background: #fff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
    }

    /* --- CARDS DE GUERREROS --- */
    .warrior-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        position: relative;
        padding: 25px;
        transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        align-items: center;
        gap: 20px;
        overflow: hidden;
    }

    .warrior-card::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,193,7,0.05), transparent);
        transition: 0.5s;
    }

    .warrior-card:hover {
        background: rgba(255, 193, 7, 0.03);
        border-color: rgba(255, 193, 7, 0.3);
        transform: scale(1.02);
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }

    .warrior-card:hover::before {
        left: 100%;
    }

    /* --- AVATAR HEXAGONAL --- */
    .warrior-avatar-wrap {
        position: relative;
        width: 80px;
        height: 80px;
        flex-shrink: 0;
    }

    .warrior-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background: #111;
        border: 2px solid rgba(255, 193, 7, 0.5);
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        transition: 0.3s;
    }

    .warrior-card:hover .warrior-avatar {
        border-color: #ffc107;
        box-shadow: 0 0 20px rgba(255, 193, 7, 0.4);
    }

    .lvl-tag {
        position: absolute;
        bottom: -5px;
        right: -5px;
        background: #ffc107;
        color: #000;
        font-size: 0.65rem;
        font-weight: 900;
        padding: 2px 8px;
        clip-path: polygon(10% 0, 100% 0, 100% 100%, 0 100%);
    }

    /* --- INFO GUERRERO --- */
    .warrior-name {
        font-weight: 900;
        color: #fff;
        font-size: 1.2rem;
        text-transform: uppercase;
        font-style: italic;
        text-decoration: none;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 2px;
        transition: 0.3s;
    }

    .warrior-name:hover { color: #ffc107; }

    .warrior-title {
        font-size: 0.7rem;
        color: #ffc107;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 0.8;
    }

    /* --- ACCIONES --- */
    .btn-action {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0;
        transition: 0.3s;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.05);
        color: #fff;
    }

    .btn-action:hover {
        background: #ffc107;
        color: #000;
        border-color: #ffc107;
        transform: translateY(-2px);
    }

    .btn-action.btn-danger-cyber:hover {
        background: #ff4444;
        border-color: #ff4444;
        color: #fff;
    }

    .btn-accept-cyber {
        background: #00ffcc;
        color: #000;
        font-weight: 900;
        font-size: 0.7rem;
        padding: 8px 15px;
        border: none;
        clip-path: polygon(0 0, 100% 0, 100% 70%, 85% 100%, 0 100%);
    }

    .btn-accept-cyber:hover {
        background: #fff;
        transform: scale(1.05);
    }

    /* --- ESTADOS VACÍOS --- */
    .scanner-empty {
        background: rgba(255, 255, 255, 0.01);
        border: 1px dashed rgba(255, 255, 255, 0.1);
        padding: 60px;
        text-align: center;
        color: rgba(255,255,255,0.2);
    }

    .scanner-empty i { font-size: 4rem; margin-bottom: 20px; display: block; opacity: 0.3; }

    /* DIRECT CHAT STYLES */
    .direct-chat-panel {
        position: fixed;
        right: -400px;
        top: 0;
        width: 400px;
        height: 100vh;
        background: rgba(0,0,0,0.95);
        border-left: 2px solid #ffc107;
        z-index: 2000;
        transition: 0.5s cubic-bezier(0.19, 1, 0.22, 1);
        display: flex;
        flex-direction: column;
        backdrop-filter: blur(20px);
        box-shadow: -20px 0 50px rgba(0,0,0,0.8);
    }

    .direct-chat-panel.active {
        right: 0;
    }

    .chat-panel-header {
        padding: 30px;
        background: rgba(255, 193, 7, 0.1);
        border-bottom: 1px solid rgba(255, 193, 7, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-panel-messages {
        flex: 1;
        overflow-y: auto;
        padding: 25px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .chat-panel-input {
        padding: 25px;
        background: rgba(0,0,0,0.5);
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    .btn-chat-trigger {
        background: rgba(0, 229, 255, 0.1);
        color: #00e5ff;
        border: 1px solid rgba(0, 229, 255, 0.3);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }

    .btn-chat-trigger:hover {
        background: #00e5ff;
        color: #000;
        transform: translateY(-2px);
    }

    .chat-message {
        max-width: 85%;
        padding: 12px 18px;
        border-radius: 10px;
        position: relative;
    }

    .message-own {
        align-self: flex-end;
        background: rgba(255, 193, 7, 0.15);
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    .message-other {
        align-self: flex-start;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .chat-input {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        border-radius: 0;
        padding: 12px;
    }

    .chat-input:focus {
        background: rgba(0,0,0,0.5);
        border-color: #ffc107;
        color: #fff;
        box-shadow: none;
    }

    .btn-chat-send {
        background: #ffc107;
        color: #000;
        font-weight: 900;
        border: none;
        padding: 0 20px;
    }
</style>

<div class="container social-hub py-5">
    
    <!-- TITULAR -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-3 fw-black text-white text-uppercase italic-font" style="letter-spacing: -3px; font-style: italic;">
                Centro <span class="text-warning">Táctico</span> Social
            </h1>
            <div class="d-flex justify-content-center align-items-center gap-3 mt-2">
                <span style="height: 1px; width: 50px; background: #ffc107;"></span>
                <p class="text-white-50 m-0 text-uppercase fw-bold small" style="letter-spacing: 4px;">Sincronización de Guerreros</p>
                <span style="height: 1px; width: 50px; background: #ffc107;"></span>
            </div>
        </div>
    </div>

    <!-- BUSCADOR -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="search-container">
                <form action="{{ route('social.search') }}" method="GET" class="row g-0">
                    <div class="col">
                        <input type="text" name="query" class="form-control input-cyber" 
                               placeholder="ESCANEAR FIRMA DE ENERGÍA (NOMBRE)..." value="{{ $searchQuery ?? '' }}">
                    </div>
                    <div class="col-auto d-flex">
                        <button type="submit" class="btn btn-cyber-search">
                            <i class="bi bi-cpu me-2"></i> ESCANEAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- RESULTADOS DE BÚSQUEDA -->
    @if(isset($results))
        <h3 class="tech-header">Registros Detectados: "{{ $searchQuery }}"</h3>
        <div class="row g-4 mb-5">
            @forelse($results as $res)
                <div class="col-md-6 col-lg-4">
                    <div class="warrior-card">
                        <div class="warrior-avatar-wrap">
                            <img src="{{ $res->avatar ? asset('storage/'.$res->avatar) : 'https://i.imgur.com/8K6hS9p.png' }}" 
                                 class="warrior-avatar" alt="Warrior">
                        </div>
                        <div class="flex-grow-1">
                            <a href="{{ route('profile.show', $res->id) }}" class="warrior-name">{{ $res->name }}</a>
                            <div class="warrior-title">{{ $res->current_title ?? 'Soldado' }}</div>
                        </div>
                        <div class="actions">
                            @if(in_array($res->id, $friendsIds))
                                <i class="bi bi-shield-check text-success fs-4" title="Aliado"></i>
                            @elseif(in_array($res->id, $sentIds))
                                <span class="badge bg-secondary opacity-50 px-3 py-2" style="font-size: 0.6rem;">PENDIENTE</span>
                            @elseif(in_array($res->id, $receivedIds))
                                <form action="{{ route('social.accept', $res->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-accept-cyber">ACEPTAR</button>
                                </form>
                            @else
                                <form action="{{ route('social.add', $res->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-action" title="Solicitar Alianza">
                                        <i class="bi bi-person-plus-fill"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="scanner-empty">
                        <i class="bi bi-radar"></i>
                        <p class="text-uppercase fw-bold m-0">No se encontraron firmas de energía.</p>
                        <small class="text-white-50">Intenta con otro identificador.</small>
                    </div>
                </div>
            @endforelse
        </div>
    @endif

    <!-- SOLICITUDES PENDIENTES -->
    @php
        $pendingCount = $requests ? $requests->count() : 0;
    @endphp
    @if($pendingCount > 0)
        <h3 class="tech-header text-info">Incursiones de Alianza ({{ $pendingCount }})</h3>
        <div class="row g-4 mb-5">
            @foreach($requests as $req)
                <div class="col-md-6 col-lg-4">
                    <div class="warrior-card border-info border-opacity-25" style="border-style: dashed;">
                        <div class="warrior-avatar-wrap">
                            <img src="{{ $req->avatar ? asset('storage/'.$req->avatar) : 'https://i.imgur.com/8K6hS9p.png' }}" 
                                 class="warrior-avatar border-info" alt="Request">
                        </div>
                        <div class="flex-grow-1">
                            <a href="{{ route('profile.show', $req->id) }}" class="warrior-name text-info">{{ $req->name }}</a>
                            <div class="small text-white-50 text-uppercase" style="font-size: 0.6rem; letter-spacing: 1px;">Solicitud Entrante</div>
                        </div>
                        <div class="d-flex gap-2">
                            <form action="{{ route('social.accept', $req->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-accept-cyber px-2" style="font-size: 0.6rem;">ACEPTAR</button>
                            </form>
                            <form action="{{ route('social.remove', $req->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-action btn-danger-cyber" title="Rechazar">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- LISTA DE AMIGOS -->
    <h3 class="tech-header">Aliados de Élite</h3>
    <div class="row g-4">
        @forelse($friends as $friend)
            <div class="col-md-6 col-lg-4">
                <div class="warrior-card">
                    <div class="warrior-avatar-wrap">
                        <img src="{{ $friend->avatar ? asset('storage/'.$friend->avatar) : 'https://i.imgur.com/8K6hS9p.png' }}" 
                             class="warrior-avatar border-warning" alt="Friend">
                    </div>
                    <div class="flex-grow-1">
                        <a href="{{ route('profile.show', $friend->id) }}" class="warrior-name text-warning">{{ $friend->name }}</a>
                        <div class="warrior-title opacity-50">{{ $friend->current_title ?? 'Aliado' }}</div>
                    </div>
                    <div class="actions d-flex gap-2">
                        {{-- Botón de CHAT DIRECTO --}}
                        <button class="btn btn-chat-trigger" onclick="openDirectChat({{ $friend->id }}, '{{ $friend->name }}')" title="Abrir Chat Táctico">
                            <i class="bi bi-chat-dots-fill"></i>
                        </button>
                        <form action="{{ route('social.remove', $friend->id) }}" method="POST" onsubmit="return confirm('¿Disolver alianza táctica?');">
                            @csrf
                            <button class="btn btn-action btn-danger-cyber" title="Eliminar Amigo">
                                <i class="bi bi-person-x-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="scanner-empty">
                    <i class="bi bi-people-fill"></i>
                    <p class="text-uppercase fw-bold m-0">Círculo de Poder Vacío</p>
                    <small class="text-white-50">Localiza nuevos guerreros para expandir tu influencia.</small>
                    <div class="mt-4">
                        <a href="{{ route('factions.index') }}" class="btn btn-sm btn-outline-warning text-uppercase px-4 rounded-0">
                            Explorar Facciones
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- PANEL DE CHAT DIRECTO (SLIDE-IN) -->
<div id="directChatPanel" class="direct-chat-panel">
    <div class="chat-panel-header">
        <div>
            <h5 class="text-white m-0 text-uppercase fw-black italic-font" style="font-style: italic;">Chat <span class="text-warning">Táctico</span></h5>
            <small class="text-warning fw-bold text-uppercase" id="chatFriendName" style="letter-spacing: 2px; font-size: 0.7rem;"></small>
        </div>
        <button class="btn btn-sm btn-outline-danger border-0" onclick="closeDirectChat()">
            <i class="bi bi-x-lg fs-4"></i>
        </button>
    </div>
    <div class="chat-panel-messages" id="directChatMessages">
        <!-- Mensajes -->
    </div>
    <div class="chat-panel-input">
        <form id="directChatForm" class="d-flex gap-2">
            @csrf
            <input type="hidden" id="chatFriendId">
            <input type="text" id="directMessageInput" class="form-control chat-input" placeholder="Transmitir mensaje..." autocomplete="off">
            <button type="submit" class="btn btn-chat-send">
                <i class="bi bi-send-fill"></i>
            </button>
        </form>
    </div>
</div>

<script>
    let chatInterval;
    const currentUserId = {{ Auth::id() }};

    function openDirectChat(friendId, friendName) {
        document.getElementById('chatFriendId').value = friendId;
        document.getElementById('chatFriendName').innerText = friendName;
        document.getElementById('directChatPanel').classList.add('active');
        fetchDirectMessages();
        
        if (chatInterval) clearInterval(chatInterval);
        chatInterval = setInterval(fetchDirectMessages, 3000);
    }

    function closeDirectChat() {
        document.getElementById('directChatPanel').classList.remove('active');
        if (chatInterval) clearInterval(chatInterval);
    }

    function fetchDirectMessages() {
        const friendId = document.getElementById('chatFriendId').value;
        if (!friendId) return;

        fetch(`/chat/direct/${friendId}`)
            .then(response => response.json())
            .then(messages => {
                const container = document.getElementById('directChatMessages');
                container.innerHTML = '';
                
                if (messages.length === 0) {
                    container.innerHTML = '<div class="text-center text-white-50 my-auto small text-uppercase" style="letter-spacing: 2px; opacity: 0.5;">No hay comunicaciones previas.</div>';
                    return;
                }

                messages.forEach(msg => {
                    const isOwn = msg.sender_id === currentUserId;
                    const html = `
                        <div class="chat-message ${isOwn ? 'message-own' : 'message-other'}">
                            <div class="text-white small">${msg.content}</div>
                            <div class="text-white-50" style="font-size: 0.5rem; text-align: right; margin-top: 5px;">
                                ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', html);
                });
                container.scrollTop = container.scrollHeight;
            });
    }

    document.getElementById('directChatForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const friendId = document.getElementById('chatFriendId').value;
        const messageInput = document.getElementById('directMessageInput');
        const content = messageInput.value.trim();
        if (!content) return;

        fetch(`/chat/direct/${friendId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                fetchDirectMessages();
            }
        });
    });

    // Soporte para abrir chat por URL
    window.addEventListener('load', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const chatWithId = urlParams.get('chat');
        if (chatWithId) {
            openDirectChat(chatWithId, 'Aliado');
        }
    });
</script>
@endsection

