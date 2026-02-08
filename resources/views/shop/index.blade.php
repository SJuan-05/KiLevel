@extends('layouts.app')

@section('content')
<style>
    /* --- FONDO GLOBAL --- */
    body {
        background-color: #050505;
        background-image: radial-gradient(circle at 50% 0%, #1a1a1a 0%, #050505 85%);
    }

    /* --- ESTILOS COMO EL DASHBOARD --- */
    .dashboard-header {
        padding: 40px 0;
        text-align: center;
        position: relative;
    }

    .dashboard-header::after {
        content: '';
        display: block;
        width: 100px;
        height: 4px;
        background: #ffc107;
        margin: 20px auto 0;
        box-shadow: 0 0 15px #ffc107;
        border-radius: 2px;
    }

    /* --- CARDS ESTILO DASHBOARD --- */
    .stat-card {
        background: rgba(10, 10, 10, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        background: rgba(20, 20, 20, 0.9);
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .stat-bg-icon {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 8rem;
        opacity: 0.05;
        color: #fff;
        transform: rotate(-15deg);
        z-index: 0;
    }

    /* Tipografías Stats */
    .stat-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 10px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #fff;
        line-height: 1;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .stat-subtext {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.4);
        position: relative;
        z-index: 1;
    }

    /* Variantes de Borde e Icono */
    .card-unlocked { border-bottom: 4px solid #00ff41; }
    .card-buyable { border-bottom: 4px solid #ffc107; }
    .card-locked { border-bottom: 4px solid #333; }

    /* Botones Consistente */
    .btn-action {
        z-index: 2;
        position: relative;
        width: 100%;
        font-weight: 800;
        text-transform: uppercase;
        border-radius: 8px;
        padding: 10px;
    }

</style>

<div class="container py-5">
    
    <!-- HEADER -->
    <div class="dashboard-header mb-5">
        <h1 class="display-4 fw-black text-white text-uppercase" style="text-shadow: 0 0 20px rgba(255,193,7,0.4);">
            Tienda Zeni
        </h1>
        <p class="text-white-50 fs-5">Intercambia tu esfuerzo por recompensas legendarias</p>
        
        <div class="d-inline-block mt-2 px-4 py-2 rounded-pill bg-dark border border-warning">
            <i class="bi bi-coin text-warning me-2"></i>
            <span class="fs-4 fw-bold text-white">{{ number_format($user->zeni ?? 0) }} Zeni</span>
        </div>
    </div>

    <!-- Alert Area -->
    <div id="shop-alert" class="alert d-none text-center fw-bold bg-black border-warning text-warning" style="border-style: dashed;"></div>





    <!-- ITEMS GRID BY CATEGORY -->
    @php
        $categories = collect($items)->groupBy('category');
    @endphp

    @foreach($categories as $categoryName => $catItems)
        <div class="category-section mt-5" id="cat-{{ $categoryName }}" data-category="{{ $categoryName }}">
            <h2 class="tech-header mb-4 category-header" style="border-left: 4px solid #ffc107; padding-left: 15px; text-transform: uppercase; font-style: italic; letter-spacing: 2px; color: #fff;">
                SECCIÓN: {{ $categoryName }}
            </h2>
            
            <div class="row g-4">
                @foreach($catItems as $item)
                    @php
                        $isUnlocked = in_array($item['name'], $user->unlocked_titles ?? []);
                        $isEquipped = $user->current_title === $item['name'];
                        $isLocked = $item['type'] === 'locked';
                        
                        $borderClass = 'card-buyable';
                        $rarityColor = '#ffc107'; // Común
                        
                        if ($categoryName === 'Raro') $rarityColor = '#00e5ff';
                        if ($categoryName === 'Épico') $rarityColor = '#e040fb';
                        if ($categoryName === 'Divino') $rarityColor = '#ffc107'; // Gold
                        if ($categoryName === 'Habilidades') $rarityColor = '#ff003c';

                        if ($isUnlocked) $borderClass = 'card-unlocked';
                        if ($isLocked) $borderClass = 'card-locked';
                    @endphp
                    
                    <div class="col-md-4 col-lg-3 shop-item" data-category="{{ $categoryName }}">
                        <div class="stat-card {{ $borderClass }}" style="border-bottom-color: {{ $rarityColor }};">
                            <!-- BG Icon -->
                            <i class="bi {{ $item['icon'] }} stat-bg-icon"></i>

                            <!-- Content Top -->
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                     <div class="stat-label" style="color: {{ $rarityColor }};">{{ strtoupper($item['category']) }}</div>
                                     @if($isUnlocked)
                                        <i class="bi bi-check-circle-fill text-success fs-5" title="Adquirido"></i>
                                     @endif
                                </div>
                                
                                <h4 class="text-white fw-bold text-uppercase mb-3" style="font-size: 1.3rem; letter-spacing: 1px;">
                                    {{ $item['name'] }}
                                </h4>
                                
                                <p class="stat-subtext mb-4" style="min-height: 50px; font-size: 0.85rem;">{{ $item['description'] }}</p>
                            </div>

                            <!-- Content Bottom (Price & Action) -->
                            <div>
                                @if(!$isLocked)
                                    <div class="mb-3">
                                        <span class="display-6 fw-bold {{ $isUnlocked ? 'text-white-50 text-decoration-line-through' : '' }}" style="color: {{ $isUnlocked ? 'inherit' : $rarityColor }}; font-size: 1.8rem;">
                                            {{ number_format($item['price']) }}
                                        </span>
                                        <small class="text-white-50 fw-bold">Z</small>
                                    </div>

                                    @if($isUnlocked)
                                        @if($isEquipped)
                                            <button class="btn btn-secondary btn-action disabled" disabled>
                                                <i class="bi bi-shield-check me-2"></i> EQUIPADO
                                            </button>
                                        @else
                                            <button class="btn btn-outline-light btn-action" onclick="equipTitle('{{ $item['name'] }}')">
                                                EQUIPAR
                                            </button>
                                        @endif
                                    @else
                                        <button class="btn btn-action text-black" style="background: {{ $rarityColor }}; border-color: {{ $rarityColor }};" onclick="buyItem('{{ $item['id'] }}')">
                                            COMPRAR
                                        </button>
                                    @endif
                                @else
                                    <div class="mb-3">
                                        <span class="display-6 fw-bold text-secondary" style="font-size: 1.8rem;">???</span>
                                    </div>
                                    <button class="btn btn-dark border-secondary btn-action text-white-50 disabled" disabled>
                                        BLOQUEADO
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<script>
    $(document).ready(function() {
        // --- 1. ANIMACIONES DE TARJETAS CON JQUERY ---
        // Al pasar el ratón, escalamos y añadimos sombra (efecto hover JS)
        $('.stat-card').hover(
            function() {
                $(this).stop().animate({
                    marginTop: "-10px",
                    opacity: 1
                }, 200).css('box-shadow', '0 15px 30px rgba(255, 193, 7, 0.3)');
            }, 
            function() {
                $(this).stop().animate({
                    marginTop: "0px",
                    opacity: 0.9
                }, 200).css('box-shadow', 'none');
            }
        );

        // Efecto de entrada inicial (FadeIn escalonado)
        $('.shop-item').hide().each(function(index) {
            $(this).delay(100 * index).fadeIn(500);
        });

        // --- 2. COMPRAR ITEM (AJAX JQUERY) ---
        window.buyItem = function(itemId) {
            $.ajax({
                url: "{{ route('shop.buy') }}",
                method: 'POST',
                data: {
                    item_id: itemId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        showFeedback(response.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showFeedback(response.message, 'danger');
                    }
                },
                error: function() {
                    showFeedback('Error de conexión', 'danger');
                }
            });
        };

        // --- 3. EQUIPAR TÍTULO (AJAX JQUERY) ---
        window.equipTitle = function(title) {
            $.ajax({
                url: "{{ route('shop.equip') }}",
                method: 'POST',
                data: {
                    title: title,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        showFeedback(response.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showFeedback(response.message, 'danger');
                    }
                },
                error: function() {
                    showFeedback('Error de conexión', 'danger');
                }
            });
        };

        // --- 4. SCROLL TO TOP (jQuery Event & Animate) ---
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('#scrollToTop').fadeIn();
            } else {
                $('#scrollToTop').fadeOut();
            }
        });

        $('#scrollToTop').click(function() {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });

        // --- 5. SMOOTH SCROLL NAV (jQuery Animate) ---
        $('.nav-link-jquery').click(function() {
            var target = $(this).data('target');
            if($(target).length) {
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 100 // -100 para offset del header
                }, 1000);
            }
        });

        // --- 6. PULSE EFFECT EN BOTONES DE COMPRA ---
        // Animamos el padding para crear un efecto de "latido" al pasar el ratón
        $('.btn-action').hover(
            function() {
                if(!$(this).prop('disabled')) {
                    $(this).stop().animate({ paddingLeft: "20px", paddingRight: "20px" }, 200);
                }
            },
            function() {
               if(!$(this).prop('disabled')) {
                    $(this).stop().animate({ paddingLeft: "10px", paddingRight: "10px" }, 200);
               }
            }
        );

        // --- FEEDBACK VISUAL ---
        function showFeedback(message, type) {
            const alertBox = $('#shop-alert');
            alertBox.removeClass('d-none bg-black border-success border-danger text-success text-danger');
            
            // Efecto SlideDown de jQuery
            alertBox.hide().removeClass('d-none');

            if (type === 'success') {
                alertBox.addClass('bg-black border border-success text-success');
                alertBox.html('<i class="bi bi-check-circle me-2"></i>' + message);
            } else {
                alertBox.addClass('bg-black border border-danger text-danger');
                alertBox.html('<i class="bi bi-exclamation-triangle me-2"></i>' + message);
            }

            alertBox.slideDown();

            setTimeout(() => {
                alertBox.slideUp();
            }, 3000);
        }
    });
</script>
@endsection
