<?php

namespace Database\Seeders;

use App\Models\ProjectInput;
use App\Models\Proyecto;
use App\Models\Requirement;
use App\Models\Sprint;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\UserStory;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if (! $user) {
            return;
        }

        Proyecto::factory()->count(3)->activo()->create(['user_id' => $user->id]);
        Proyecto::factory()->count(1)->completado()->create(['user_id' => $user->id]);
        Proyecto::factory()->count(1)->create([
            'user_id' => $user->id,
            'estado'  => 'pausado',
        ]);

        $this->seedProyectoDemo($user);
    }

    private function seedProyectoDemo(User $user): void
    {
        if (Proyecto::where('nombre', 'Sistema de Gestión de Inventario')->exists()) {
            return;
        }

        $statuses = TaskStatus::orderBy('orden')->pluck('id', 'nombre');

        $proyecto = Proyecto::create([
            'user_id'     => $user->id,
            'nombre'      => 'Sistema de Gestión de Inventario',
            'descripcion' => 'Sistema web para controlar entradas, salidas y stock de productos en bodega.',
            'estado'      => 'activo',
        ]);

        // Insumos
        ProjectInput::create([
            'proyecto_id' => $proyecto->id,
            'tipo'        => 'entrevista',
            'titulo'      => 'Entrevista con jefe de bodega',
            'contenido'   => 'El jefe de bodega necesita visualizar el stock en tiempo real y recibir alertas cuando un producto baje del mínimo.',
        ]);
        ProjectInput::create([
            'proyecto_id' => $proyecto->id,
            'tipo'        => 'documento',
            'titulo'      => 'Manual de procesos internos de bodega',
            'contenido'   => 'Documento proporcionado por la empresa que describe el flujo de recepción y despacho de mercadería.',
        ]);
        ProjectInput::create([
            'proyecto_id' => $proyecto->id,
            'tipo'        => 'reunion',
            'titulo'      => 'Reunión de kickoff con stakeholders',
            'contenido'   => 'Se acordó que el sistema debe integrarse con el ERP existente vía API REST.',
        ]);

        // Requerimientos
        $req1 = Requirement::create([
            'proyecto_id' => $proyecto->id,
            'codigo'      => 'REQ-001',
            'titulo'      => 'Registro de productos',
            'descripcion' => 'El sistema debe permitir crear, editar y eliminar productos con código, nombre, categoría y stock mínimo.',
            'tipo'        => 'funcional',
            'prioridad'   => 'alta',
        ]);
        $req2 = Requirement::create([
            'proyecto_id' => $proyecto->id,
            'codigo'      => 'REQ-002',
            'titulo'      => 'Control de movimientos',
            'descripcion' => 'El sistema debe registrar entradas y salidas de inventario con fecha, cantidad y responsable.',
            'tipo'        => 'funcional',
            'prioridad'   => 'alta',
        ]);
        $req3 = Requirement::create([
            'proyecto_id' => $proyecto->id,
            'codigo'      => 'REQ-003',
            'titulo'      => 'Rendimiento bajo carga',
            'descripcion' => 'El sistema debe responder en menos de 2 segundos con hasta 100 usuarios concurrentes.',
            'tipo'        => 'no_funcional',
            'prioridad'   => 'media',
        ]);

        // Historias de usuario
        $us1 = UserStory::create([
            'requirement_id' => $req1->id,
            'titulo'         => 'Crear producto',
            'descripcion'    => 'Como administrador quiero registrar nuevos productos para mantener el catálogo actualizado.',
            'criterios'      => 'Dado que ingreso código, nombre y stock mínimo, cuando guardo, entonces el producto aparece en el listado.',
            'prioridad'      => 'alta',
            'puntos'         => 3,
        ]);
        $us2 = UserStory::create([
            'requirement_id' => $req1->id,
            'titulo'         => 'Editar producto',
            'descripcion'    => 'Como administrador quiero modificar los datos de un producto existente.',
            'criterios'      => 'Dado que selecciono un producto, cuando edito sus datos y guardo, entonces los cambios se reflejan de inmediato.',
            'prioridad'      => 'media',
            'puntos'         => 2,
        ]);
        $us3 = UserStory::create([
            'requirement_id' => $req2->id,
            'titulo'         => 'Registrar entrada de inventario',
            'descripcion'    => 'Como bodeguero quiero registrar la recepción de mercadería para mantener el stock actualizado.',
            'criterios'      => 'Dado que selecciono un producto e ingreso la cantidad, cuando confirmo la entrada, entonces el stock aumenta.',
            'prioridad'      => 'alta',
            'puntos'         => 5,
        ]);
        $us4 = UserStory::create([
            'requirement_id' => $req2->id,
            'titulo'         => 'Registrar salida de inventario',
            'descripcion'    => 'Como bodeguero quiero registrar el despacho de productos para descontar del stock disponible.',
            'criterios'      => 'Dado que hay stock suficiente, cuando registro la salida, entonces el sistema descuenta la cantidad y registra el movimiento.',
            'prioridad'      => 'alta',
            'puntos'         => 5,
        ]);

        // Sprints
        $sprint1 = Sprint::create([
            'proyecto_id' => $proyecto->id,
            'nombre'      => 'Sprint 1 — Catálogo de productos',
            'objetivo'    => 'Implementar el CRUD completo de productos.',
            'fecha_inicio' => '2025-01-06',
            'fecha_fin'    => '2025-01-17',
            'estado'       => 'completado',
        ]);
        $sprint2 = Sprint::create([
            'proyecto_id' => $proyecto->id,
            'nombre'      => 'Sprint 2 — Movimientos de inventario',
            'objetivo'    => 'Registrar entradas y salidas con trazabilidad completa.',
            'fecha_inicio' => '2025-01-20',
            'fecha_fin'    => '2025-01-31',
            'estado'       => 'completado',
        ]);
        $sprint3 = Sprint::create([
            'proyecto_id' => $proyecto->id,
            'nombre'      => 'Sprint 3 — Reportes y ajustes',
            'objetivo'    => 'Generar reportes exportables y corregir detalles de UX.',
            'fecha_inicio' => '2025-02-03',
            'fecha_fin'    => '2025-02-14',
            'estado'       => 'en_progreso',
        ]);

        $hecho    = $statuses['Hecho']        ?? null;
        $enCurso  = $statuses['En curso']     ?? null;
        $porHacer = $statuses['Por hacer']    ?? null;
        $revision = $statuses['En revisión']  ?? null;

        // Tareas
        Task::create([
            'proyecto_id'    => $proyecto->id,
            'sprint_id'      => $sprint1->id,
            'user_story_id'  => $us1->id,
            'task_status_id' => $hecho,
            'titulo'         => 'Crear migración de productos',
            'descripcion'    => 'Definir tabla products con campos requeridos.',
            'fecha_limite'   => '2025-01-10',
        ]);
        Task::create([
            'proyecto_id'    => $proyecto->id,
            'sprint_id'      => $sprint1->id,
            'user_story_id'  => $us1->id,
            'task_status_id' => $hecho,
            'titulo'         => 'Implementar formulario de creación',
            'descripcion'    => 'Vista y controlador para crear producto.',
            'fecha_limite'   => '2025-01-14',
        ]);
        Task::create([
            'proyecto_id'    => $proyecto->id,
            'sprint_id'      => $sprint1->id,
            'user_story_id'  => $us2->id,
            'task_status_id' => $hecho,
            'titulo'         => 'Implementar formulario de edición',
            'descripcion'    => 'Vista y controlador para editar producto.',
            'fecha_limite'   => '2025-01-17',
        ]);
        Task::create([
            'proyecto_id'    => $proyecto->id,
            'sprint_id'      => $sprint2->id,
            'user_story_id'  => $us3->id,
            'task_status_id' => $hecho,
            'titulo'         => 'Crear migración de movimientos',
            'descripcion'    => 'Tabla inventory_movements con tipo, cantidad, producto y usuario.',
            'fecha_limite'   => '2025-01-22',
        ]);
        Task::create([
            'proyecto_id'    => $proyecto->id,
            'sprint_id'      => $sprint2->id,
            'user_story_id'  => $us3->id,
            'task_status_id' => $hecho,
            'titulo'         => 'Registrar entrada de stock',
            'descripcion'    => 'Controlador y vista para registrar recepción de mercadería.',
            'fecha_limite'   => '2025-01-28',
        ]);
        Task::create([
            'proyecto_id'    => $proyecto->id,
            'sprint_id'      => $sprint2->id,
            'user_story_id'  => $us4->id,
            'task_status_id' => $revision,
            'titulo'         => 'Registrar salida de stock',
            'descripcion'    => 'Controlador y vista para registrar despacho con validación de stock disponible.',
            'fecha_limite'   => '2025-01-31',
        ]);
        Task::create([
            'proyecto_id'    => $proyecto->id,
            'sprint_id'      => $sprint3->id,
            'user_story_id'  => null,
            'task_status_id' => $enCurso,
            'titulo'         => 'Exportar movimientos a CSV',
            'descripcion'    => 'Generar reporte descargable de movimientos filtrado por fecha.',
            'fecha_limite'   => '2025-02-07',
        ]);
        Task::create([
            'proyecto_id'    => $proyecto->id,
            'sprint_id'      => $sprint3->id,
            'user_story_id'  => null,
            'task_status_id' => $porHacer,
            'titulo'         => 'Ajustes de UX en listado de productos',
            'descripcion'    => 'Mejorar la tabla de productos con búsqueda y paginación.',
            'fecha_limite'   => '2025-02-14',
        ]);
    }
}
