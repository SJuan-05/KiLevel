@extends('layouts.app')

@section('content')
<style>
    :root {
        --f-gold: #ffc107;
        --f-gold-rgb: 255, 193, 7;
        --f-border: rgba(255, 255, 255, 0.1);
        --f-bg: rgba(0, 0, 0, 0.8);
    }

    /* --- HEADER DE FACCION --- */
    .f-header {
        position: relative;
        padding: 100px 0 60px;
        background: linear-gradient(180deg, rgba(var(--f-gold-rgb), 0.15) 0%, transparent 100%);
        border-bottom: 1px solid var(--f-border);
        overflow: hidden;
    }

    .f-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 50% 0%, rgba(var(--f-gold-rgb), 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .f-title-glow {
        font-size: 5rem;
        font-weight: 900;
        text-transform: uppercase;
        font-style: italic;
        color: #fff;
        text-shadow: 0 0 30px rgba(var(--f-gold-rgb), 0.5);
        letter-spacing: -3px;
        margin: 0;
    }

    .f-description {
        color: rgba(255,255,255,0.6);
        font-size: 1.1rem;
        max-width: 700px;
        margin: 20px auto;
        letter-spacing: 1px;
    }

    .f-stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        background: rgba(0,0,0,0.5);
        border: 1px solid var(--f-gold);
        padding: 10px 25px;
        margin-top: 30px;
        clip-path: polygon(5% 0, 100% 0, 95% 100%, 0 100%);
    }

    .f-stat-icon { color: var(--f-gold); font-size: 1.4rem; }
    .f-stat-value { font-weight: 900; letter-spacing: 2px; }

    /* --- CARDS DE MIEMBROS --- */
    .section-title {
        font-weight: 900;
        text-transform: uppercase;
        font-style: italic;
        color: #fff;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .section-title::after {
        content: '';
        height: 1px;
        flex: 1;
        background: linear-gradient(90deg, var(--f-border), transparent);
    }

    .member-grid-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--f-border);
        padding: 25px;
        position: relative;
        transition: 0.3s;
        height: 100%;
    }

    .member-grid-card:hover {
        background: rgba(var(--f-gold-rgb), 0.05);
        border-color: var(--f-gold);
        transform: translateY(-5px);
    }

    .member-avatar-ring {
        width: 70px;
        height: 70px;
        border: 2px solid currentColor;
        padding: 3px;
        border-radius: 50%;
        display: block;
        overflow: hidden;
    }

    .member-avatar-ring img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .member-rank-badge {
        position: absolute;
        top: 0; right: 0;
        padding: 5px 15px;
        font-size: 0.6rem;
        font-weight: 900;
        text-transform: uppercase;
        clip-path: polygon(0 0, 100% 0, 100% 100%, 15% 100%);
    }

    .rank-leader { background: var(--f-gold); color: #000; }
    .rank-commander { background: #e040fb; color: #fff; }
    .rank-veteran { background: #00e5ff; color: #000; }
    .rank-member { background: rgba(255,255,255,0.1); color: #fff; }

    .member-meta-name { font-weight: 900; font-size: 1.1rem; margin-top: 15px; }
    .member-meta-title { font-size: 0.7rem; color: var(--f-gold); opacity: 0.8; text-transform: uppercase; letter-spacing: 1px; }

    .rank-select {
        background: rgba(0,0,0,0.8);
        border: 1px solid var(--f-border);
        color: #fff;
        font-size: 0.7rem;
        padding: 5px;
        margin-top: 10px;
    }

    /* --- CHAT SECTION --- */
    .chat-container {
        background: rgba(0,0,0,0.6);
        border: 1px solid var(--f-border);
        margin-top: 60px;
        display: flex;
        flex-direction: column;
        height: 600px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    .chat-header {
        background: rgba(var(--f-gold-rgb), 0.1);
        padding: 20px 30px;
        border-bottom: 1px solid var(--f-border);
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--f-gold);
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .chat-message {
        max-width: 80%;
        padding: 15px 20px;
        border-radius: 4px;
        position: relative;
    }

    .message-own {
        align-self: flex-end;
        background: rgba(var(--f-gold-rgb), 0.1);
        border: 1px solid rgba(var(--f-gold-rgb), 0.3);
    }

    .message-other {
        align-self: flex-start;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--f-border);
    }

    .message-sender {
        font-size: 0.65rem;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 8px;
        display: block;
        letter-spacing: 1px;
    }

    .chat-input-area {
        padding: 25px;
        border-top: 1px solid var(--f-border);
        background: rgba(0,0,0,0.4);
    }

    .chat-input {
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--f-border);
        color: #fff;
        border-radius: 0;
        padding: 15px;
        font-size: 1rem;
    }

    .chat-input:focus {
        background: rgba(0,0,0,0.8);
        border-color: var(--f-gold);
        box-shadow: 0 0 20px rgba(var(--f-gold-rgb), 0.1);
        color: #fff;
    }

    .btn-chat-send {
        background: var(--f-gold);
        color: #000;
        font-weight: 900;
        border: none;
        padding: 0 35px;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: 0.3s;
    }

    .btn-chat-send:hover {
        background: #fff;
        transform: scale(1.05);
    }

    /* --- BOTONES ACCION --- */
    .btn-f-action {
        padding: 15px 40px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        border: none;
        transition: 0.3s;
        margin-top: 30px;
    }

    .btn-f-join {
        background: var(--f-gold);
        color: #000;
        clip-path: polygon(0 0, 100% 0, 90% 100%, 0 100%);
    }

    .btn-f-leave {
        background: rgba(255,255,255,0.05);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.1);
        clip-path: polygon(10% 0, 100% 0, 100% 100%, 0 100%);
    }

    .btn-f-action:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }
</style>

<div class="faction-page">
    <div class="f-header text-center">
        <div class="container">
            <h1 class="f-title-glow">{{ $faction->name }}</h1>
            <p class="f-description">{{ $faction->description ?? 'Sin un lema definido, este ejército avanza en silencio...' }}</p>
            
            <div class="f-stat-pill">
                <i class="bi bi-shield-shaded f-stat-icon"></i>
                <span class="f-stat-value text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Poder de Combate:</span>
                <span class="f-stat-value text-warning fs-4">{{ number_format($faction->total_power) }} K-XP</span>
            </div>

            <div class="f-action-zone">
                @if(Auth::user()->faction_id == $faction->id || Auth::id() == $faction->leader_id)
                    <form action="{{ route('factions.leave', $faction->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres abandonar este legado?');">
                        @csrf
                        <button type="submit" class="btn-f-action btn-f-leave">
                            <i class="bi bi-box-arrow-right me-2"></i> {{ Auth::id() == $faction->leader_id ? 'GESTIONAR / DISOLVER' : 'ABANDONAR' }}
                        </button>
                    </form>
                @elseif(!Auth::user()->faction_id)
                    <form action="{{ route('factions.join', $faction->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-f-action btn-f-join">
                            <i class="bi bi-lightning-fill me-2"></i> JURAR LEALTAD
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="container mt-5 pb-5">
        <h2 class="section-title">
            <i class="bi bi-person-lines-fill text-warning"></i> FORMACIÓN DE COMBATE
        </h2>

        <div class="row g-4">
            @php
                $rankWeights = ['leader' => 10, 'commander' => 5, 'veteran' => 3, 'member' => 1];
                $authWeight = $rankWeights[Auth::user()->faction_role] ?? 0;
            @endphp
            @foreach($faction->members as $member)
                @php
                    $roleClass = 'rank-'.$member->faction_role;
                    $roleName = match($member->faction_role) {
                        'leader' => 'Líder Supremo',
                        'commander' => 'Comandante',
                        'veteran' => 'Veterano',
                        default => 'Guerrero'
                    };
                    $roleColor = match($member->faction_role) {
                        'leader' => '#ffc107',
                        'commander' => '#e040fb',
                        'veteran' => '#00e5ff',
                        default => '#ffffff'
                    };
                    $targetWeight = $rankWeights[$member->faction_role] ?? 0;
                    $isFriend = Auth::user()->isAllyWith($member);
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="member-grid-card">
                        <div class="member-rank-badge {{ $roleClass }}">
                            {{ $roleName }}
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('profile.show', $member->id) }}" class="member-avatar-ring" style="color: {{ $roleColor }};">
                                @if($member->avatar)
                                    <img src="{{ asset('storage/' . $member->avatar) }}" alt="{{ $member->name }}">
                                @else
                                    <img src="https://i.imgur.com/8K6hS9p.png" alt="Avatar Default">
                                @endif
                            </a>

                            <div class="actions">
                                @if(Auth::id() != $member->id && !$isFriend)
                                    <form action="{{ route('social.add', $member->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-warning border-0 p-1" title="Solicitar Alianza">
                                            <i class="bi bi-person-plus-fill fs-5"></i>
                                        </button>
                                    </form>
                                @elseif($isFriend && Auth::id() != $member->id)
                                    <i class="bi bi-shield-check text-success fs-5"></i>
                                @endif
                            </div>
                        </div>

                        <div class="member-meta-name">
                            <a href="{{ route('profile.show', $member->id) }}" class="text-white text-decoration-none hover-gold">
                                {{ $member->name }}
                            </a>
                        </div>
                        <div class="member-meta-title">
                            {{ $member->current_title ?? 'Soldado' }}
                        </div>

                        @if($authWeight > $targetWeight)
                            <form action="{{ route('factions.updateRank', $member->id) }}" method="POST">
                                @csrf
                                <select name="rank" class="rank-select w-100" onchange="this.form.submit()">
                                    <option value="" disabled selected>Cambiar Rango</option>
                                    @if($authWeight > 5) <option value="commander">Comandante</option> @endif
                                    @if($authWeight > 3) <option value="veteran">Veterano</option> @endif
                                    @if($authWeight > 1) <option value="member">Guerrero</option> @endif
                                </select>
                            </form>
                        @endif

                        <div class="mt-3 pt-2 border-top border-white border-opacity-10 d-flex justify-content-end align-items-center">
                            <span class="text-white-50 small">{{ number_format($member->xp) }} XP</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CANAL DE FACCION --}}
        @if(Auth::user()->faction_id == $faction->id)
            <div class="mt-5 pt-5">
                <h2 class="section-title">
                    <i class="bi bi-chat-right-dots-fill text-warning"></i> CANAL DE FACCION
                </h2>
                
                <div class="chat-container">
                    <div class="chat-header">
                        <i class="bi bi-broadcast me-2 text-warning"></i> Enlace de Comunicaciones • {{ $faction->name }}
                    </div>
                    
                    <div class="chat-messages" id="clanChatMessages">
                        <div class="py-5 text-center text-white-50">
                            <div class="spinner-border spinner-border-sm text-warning me-2"></div>
                            Sincronizando canal táctico...
                        </div>
                    </div>
                    
                    <div class="chat-input-area">
                        <form id="clanChatForm" class="d-flex gap-2">
                            @csrf
                            <input type="text" id="clanMessageInput" class="form-control chat-input" placeholder="Transmitir instrucciones..." autocomplete="off">
                            <button type="submit" class="btn btn-chat-send">ENVIAR</button>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const messagesContainer = document.getElementById('clanChatMessages');
                    const currentUserId = {{ Auth::id() }};

                    function fetchMessages() {
                        fetch('{{ route('chat.clan.fetch') }}')
                            .then(response => response.json())
                            .then(messages => {
                                messagesContainer.innerHTML = '';
                                if (messages.length === 0) {
                                    messagesContainer.innerHTML = '<div class="text-center text-white-50 my-auto small text-uppercase" style="letter-spacing: 2px;">Canal despejado. Esperando reportes...</div>';
                                    return;
                                }
                                
                                messages.forEach(msg => {
                                    const isOwn = msg.sender_id === currentUserId;
                                    const avatarUrl = msg.sender.avatar ? `/storage/${msg.sender.avatar}` : 'https://i.imgur.com/8K6hS9p.png';
                                    const html = `
                                        <div class="d-flex ${isOwn ? 'flex-row-reverse' : 'flex-row'} gap-2 mb-3">
                                            <img src="${avatarUrl}" class="rounded-circle border border-warning" style="width: 35px; height: 35px; object-fit: cover; flex-shrink: 0;">
                                            <div class="chat-message ${isOwn ? 'message-own' : 'message-other'}">
                                                <span class="message-sender" style="color: ${isOwn ? 'var(--f-gold)' : '#00e5ff'}">
                                                    ${msg.sender.name}
                                                </span>
                                                <div class="text-white small">${msg.content}</div>
                                                <div class="text-white-50" style="font-size: 0.5rem; text-align: right; margin-top: 5px;">
                                                    ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    messagesContainer.insertAdjacentHTML('beforeend', html);
                                });
                                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                            })
                            .catch(error => console.error('Error fetching messages:', error));
                    }

                    document.getElementById('clanChatForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const messageInput = document.getElementById('clanMessageInput');
                        const content = messageInput.value.trim();
                        if (!content) return;

                        fetch('{{ route('chat.clan.send') }}', {
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
                                fetchMessages();
                            }
                        });
                    });

                    fetchMessages();
                    setInterval(fetchMessages, 3000);
                });
            </script>
        @endif
    </div>
</div>
@endsection
