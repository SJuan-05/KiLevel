<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ShopController extends Controller
{
    private $items = [
        // --- CATEGORÍA: COMUNES ---
        [
            'id' => 'title_saiyan_elite',
            'name' => 'Élite Saiyan',
            'type' => 'title',
            'category' => 'Común',
            'price' => 500,
            'description' => 'Solo para los guerreros de clase alta.',
            'icon' => 'bi-star-fill'
        ],
        [
            'id' => 'title_warrior_hope',
            'name' => 'Guerrero de la Esperanza',
            'type' => 'title',
            'category' => 'Común',
            'price' => 600,
            'description' => 'Luchas por un futuro mejor para todos.',
            'icon' => 'bi-sun'
        ],
        [
            'id' => 'title_martial_artist',
            'name' => 'Artista Marcial',
            'type' => 'title',
            'category' => 'Común',
            'price' => 750,
            'description' => 'Dominas las bases del combate cuerpo a cuerpo.',
            'icon' => 'bi-hand-index-thumb'
        ],
        [
            'id' => 'title_desert_bandit',
            'name' => 'Bandido del Desierto',
            'type' => 'title',
            'category' => 'Común',
            'price' => 850,
            'description' => 'Experto en supervivencia en terrenos áridos.',
            'icon' => 'bi-wind'
        ],
        [
            'id' => 'title_turtle_student',
            'name' => 'Alumno Escuela Tortuga',
            'type' => 'title',
            'category' => 'Común',
            'price' => 1200,
            'description' => 'Entrenado bajo el estilo de Muten Roshi.',
            'icon' => 'bi-shield'
        ],
        [
            'id' => 'title_earth_protector',
            'name' => 'Protector de la Tierra',
            'type' => 'title',
            'category' => 'Común',
            'price' => 1500,
            'description' => 'Juraste defender este pequeño planeta azul.',
            'icon' => 'bi-shield-fill-check'
        ],
        
        // --- CATEGORÍA: RAROS (CIUDADANOS DEL UNIVERSO) ---
        [
            'id' => 'title_namek_warrior',
            'name' => 'Guerrero Namekiano',
            'type' => 'title',
            'category' => 'Raro',
            'price' => 2500,
            'description' => 'Poseedor de un espíritu sereno y gran poder regenerativo.',
            'icon' => 'bi-droplet-fill'
        ],
        [
            'id' => 'title_ginyu_candidate',
            'name' => 'Candidato Fuerzas Ginyu',
            'type' => 'title',
            'category' => 'Raro',
            'price' => 2800,
            'description' => 'Tienes las poses, ahora te falta el poder.',
            'icon' => 'bi-people-fill'
        ],
        [
            'id' => 'title_legendary_warrior',
            'name' => 'Guerrero Legendario',
            'type' => 'title',
            'category' => 'Raro',
            'price' => 3000,
            'description' => 'Tu nombre resonará en todas las galaxias.',
            'icon' => 'bi-trophy-fill'
        ],
        [
            'id' => 'title_android_proto',
            'name' => 'Prototipo de Androide',
            'type' => 'title',
            'category' => 'Raro',
            'price' => 3500,
            'description' => 'Cuerpo mejorado cibernéticamente para la batalla.',
            'icon' => 'bi-robot'
        ],
        [
            'id' => 'title_galactic_patrol',
            'name' => 'Patrullero Galáctico',
            'type' => 'title',
            'category' => 'Raro',
            'price' => 4000,
            'description' => 'Mantienes la ley y el orden en el sector espacial.',
            'icon' => 'bi-shield-lock'
        ],
        [
            'id' => 'title_space_mercenary',
            'name' => 'Mercenario Espacial',
            'type' => 'title',
            'category' => 'Raro',
            'price' => 4500,
            'description' => 'Has viajado por el universo cumpliendo misiones peligrosas.',
            'icon' => 'bi-rocket-takeoff'
        ],

        // --- CATEGORÍA: ÉPICOS (GUERREROS DE ÉLITE) ---
        [
            'id' => 'title_kaiomaster',
            'name' => 'Maestro Kaio',
            'type' => 'title',
            'category' => 'Épico',
            'price' => 5000,
            'description' => 'Has entrenado en el pequeño planeta de Emma-Sama.',
            'icon' => 'bi-lightning-charge-fill'
        ],
        [
            'id' => 'title_prince_pride',
            'name' => 'Príncipe del Orgullo',
            'type' => 'title',
            'category' => 'Épico',
            'price' => 8000,
            'description' => 'Nunca te rindes, tu orgullo es tu mayor arma.',
            'icon' => 'bi-gem'
        ],
        [
            'id' => 'title_ssj2',
            'name' => 'Super Saiyan 2',
            'type' => 'title',
            'category' => 'Épico',
            'price' => 9000,
            'description' => 'El poder que supera al Guerrero Dorado.',
            'icon' => 'bi-lightning-fill'
        ],
        [
            'id' => 'title_ultimate_warrior',
            'name' => 'Guerrero Definitivo',
            'type' => 'title',
            'category' => 'Épico',
            'price' => 11000,
            'description' => 'Tu potencial oculto ha sido liberado por completo.',
            'icon' => 'bi-gem'
        ],
        [
            'id' => 'title_perfect_being',
            'name' => 'Ser Perfecto',
            'type' => 'title',
            'category' => 'Épico',
            'price' => 12000,
            'description' => 'Has alcanzado la cima de la evolución biológica.',
            'icon' => 'bi-activity'
        ],
        [
            'id' => 'title_fusion_master',
            'name' => 'Maestro de la Fusión',
            'type' => 'title',
            'category' => 'Épico',
            'price' => 13500,
            'description' => 'Dos guerreros, un solo cuerpo indomable.',
            'icon' => 'bi-plus-circle-fill'
        ],

        // --- CATEGORÍA: DIVINOS ---
        [
            'id' => 'title_god_ki',
            'name' => 'Ki Divino',
            'type' => 'title',
            'category' => 'Divino',
            'price' => 15000,
            'description' => 'Tu poder rivaliza con los dioses de la destrucción.',
            'icon' => 'bi-sun-fill'
        ],
        [
            'id' => 'title_destruction_god',
            'name' => 'Dios de la Destrucción',
            'type' => 'title',
            'category' => 'Divino',
            'price' => 25000,
            'description' => 'Hakai. Todo lo que tocas desaparece.',
            'icon' => 'bi-fire'
        ],
        [
            'id' => 'title_angel_attendant',
            'name' => 'Asistente Angélico',
            'type' => 'title',
            'category' => 'Divino',
            'price' => 30000,
            'description' => 'Sereno, elegante y con un poder incomprensible.',
            'icon' => 'bi-stars'
        ],
        [
            'id' => 'title_destroyer_trainee',
            'name' => 'Destructor en Práctica',
            'type' => 'title',
            'category' => 'Divino',
            'price' => 35000,
            'description' => 'Estudias el arte de la aniquilación universal.',
            'icon' => 'bi-skull'
        ],
        [
            'id' => 'title_ultra_instinct',
            'name' => 'Instinto Supremo',
            'type' => 'title',
            'category' => 'Divino',
            'price' => 40000,
            'description' => 'Tu cuerpo reacciona solo. El estado definitivo.',
            'icon' => 'bi-eye-fill'
        ],
        [
            'id' => 'title_zeno_friend',
            'name' => 'Amigo de Zeno-Sama',
            'type' => 'title',
            'category' => 'Divino',
            'price' => 50000,
            'description' => 'El título más alto. Eres intocable en cualquier universo.',
            'icon' => 'bi-stars'
        ],
        [
            'id' => 'title_sovereign_all',
            'name' => 'Soberano de Todo',
            'type' => 'title',
            'category' => 'Divino',
            'price' => 100000,
            'description' => 'El universo entero se inclina ante tu mera presencia.',
            'icon' => 'bi-crown'
        ],

        // --- OTROS ---
        [
            'id' => 'coming_soon',
            'name' => 'Habilidad: Vuelo',
            'type' => 'locked',
            'category' => 'Habilidades',
            'price' => 99999,
            'description' => 'Dominio del vuelo táctico. Próximamente...',
            'icon' => 'bi-lock-fill'
        ]
    ];

    public function index()
    {
        return view('shop.index', [
            'items' => $this->items,
            'user' => Auth::user()
        ]);
    }

    public function buy(Request $request)
    {
        $itemId = $request->input('item_id');
        $item = collect($this->items)->firstWhere('id', $itemId);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Objeto no válido.']);
        }

        /** @var User $user */
        $user = Auth::user();

        // Verificar si ya lo tiene
        $unlocked = $user->unlocked_titles ?? [];
        if (in_array($item['name'], $unlocked)) {
            return response()->json(['success' => false, 'message' => 'Ya posees este título.', 'already_owned' => true]);
        }

        // Verificar Zeni
        if ($user->zeni < $item['price']) {
            return response()->json(['success' => false, 'message' => 'No tienes suficiente Zeni.']);
        }

        // Procesar compra
        $user->zeni -= $item['price'];
        
        // Añadir título
        if ($item['type'] === 'title') {
            $unlocked[] = $item['name'];
            $user->unlocked_titles = $unlocked;
        }

        $user->save();

        return response()->json(['success' => true, 'message' => '¡Compra realizada!', 'new_balance' => $user->zeni]);
    }

    public function equipTitle(Request $request)
    {
        $title = $request->input('title');
        /** @var User $user */
        $user = Auth::user();

        $unlocked = $user->unlocked_titles ?? [];

        if (!in_array($title, $unlocked)) {
            return response()->json(['success' => false, 'message' => 'No has desbloqueado este título.']);
        }

        $user->current_title = $title;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Título equipado.']);
    }
}
