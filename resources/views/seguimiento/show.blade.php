@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body { font-family: 'Inter', sans-serif; }
    .chart-container { position: relative; height: 250px; width: 100%; }
</style>

<div class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-gray-300 p-4 fixed h-full shadow-lg">
            <div class="text-white text-2xl font-bold mb-10 pl-2">NeuroLux</div>
            <nav class="space-y-2">
                <a href="{{ route('blog.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-home w-6 text-center"></i><span class="ml-4">Home</span>
                </a>
                <a href="{{ route('nosotros.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-users w-6 text-center"></i><span class="ml-4">Nosotros</span>
                </a>
                <a href="{{ route('seguimiento.index') }}" class="flex items-center px-4 py-3 rounded-lg bg-yellow-500 text-gray-900 font-bold transition-colors">
                    <i class="fas fa-chart-line w-6 text-center"></i><span class="ml-4">Seguimiento</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-cog w-6 text-center"></i><span class="ml-4">Configuración</span>
                </a>
            </nav>
        </aside>

        <!-- Main -->
        <main class="flex-1 ml-64 p-8">
            <div class="container mx-auto">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Dashboard de Seguimiento</h1>
                        <p class="text-gray-500">Visualizando a: <span class="font-bold">{{ $child->name }}</span></p>
                    </div>
                    <a href="{{ route('seguimiento.index') }}" class="text-sm font-semibold text-blue-600 hover:underline">
                        <i class="fas fa-arrow-left mr-2"></i>Volver a la lista
                    </a>
                </div>

                <!-- Grid de Contenido (Diseño Modificado) -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Columna Izquierda (Principal) -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Ficha del Niño -->
                        <div class="bg-white p-6 rounded-xl shadow-md flex items-center space-x-6">
                            <img src="{{ $child->photo_path ? asset('storage/' . $child->photo_path) : 'https://placehold.co/100x100/E2E8F0/4A5568?text=' . strtoupper(substr($child->name, 0, 1)) }}" alt="Foto de {{ $child->name }}" class="w-24 h-24 rounded-full object-cover">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-800">{{ $child->name }}</h2>
                                        <p class="text-gray-500">Diagnóstico: <span class="font-medium text-gray-600">{{ $child->diagnosis ?? 'No especificado' }}</span></p>
                                        <p class="text-gray-500">Especialista: <span class="font-medium text-gray-600">{{ $child->specialist->name ?? 'Dr. Asignado' }}</span></p>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-600 bg-gray-200 px-3 py-1 rounded-full">{{ $child->age ?? 'N/A' }} años</span>
                                </div>
                                <div class="mt-4">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-600">Progreso General</span>
                                        <span class="text-sm font-bold text-blue-600">{{ $child->overall_progress ?? 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $child->overall_progress ?? 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfica de progreso por áreas -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Progreso por Áreas</h3>
                            <div class="chart-container">
                                <canvas id="progressChart"></canvas>
                            </div>
                        </div>

                        <!-- Actividades recientes -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Actividades Recientes</h3>
                            <ul class="space-y-3">
                                @forelse($child->activities ?? [] as $activity)
                                    <li class="flex justify-between items-center border-b pb-2">
                                        <span>{{ $activity->name }}</span>
                                        <span class="text-sm text-gray-500">{{ $activity->created_at->format('d/m/Y') }}</span>
                                    </li>
                                @empty
                                    <p class="text-gray-500">No hay actividades registradas aún.</p>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Oraciones Formadas -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Oraciones Formadas</h3>
                            <ul class="space-y-2">
                                @forelse($child->sentences ?? [] as $sentence)
                                    <li class="border-b pb-2">{{ $sentence->content }}</li>
                                @empty
                                    <p class="text-gray-500">No hay oraciones formadas.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Columna Derecha (Secundaria) -->
                    <div class="space-y-8">
                        <!-- Rutinas -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Rutinas</h3>
                            <ul class="space-y-3">
                                @forelse($child->routines ?? [] as $routine)
                                    <li class="flex justify-between items-center border-b pb-2">
                                        <span>{{ $routine->title }}</span>
                                        <span class="text-sm text-gray-500">{{ ucfirst($routine->time_of_day) }}</span>
                                    </li>
                                @empty
                                    <p class="text-gray-500">No hay rutinas asignadas.</p>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Logros -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Logros Alcanzados</h3>
                            <ul class="space-y-3">
                                @forelse($child->achievements ?? [] as $achievement)
                                    <li class="flex items-center space-x-2">
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <span>{{ $achievement->title }}</span>
                                    </li>
                                @empty
                                    <p class="text-gray-500">Aún no hay logros registrados.</p>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Pictogramas -->
                         <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Pictogramas</h3>
                            <div class="grid grid-cols-3 gap-4">
                                @forelse($child->pictograms ?? [] as $pictogram)
                                    <div class="text-center p-2 border rounded">
                                        <img src="{{ asset('storage/' . $pictogram->image_path) }}" class="mx-auto w-16 h-16">
                                        <p class="text-sm mt-2">{{ $pictogram->name }}</p>
                                    </div>
                                @empty
                                    <p class="text-gray-500 col-span-3">No hay pictogramas.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Contenido Multimedia -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Contenido Multimedia</h3>
                            <ul class="space-y-3">
                                @forelse($child->multimedia ?? [] as $media)
                                    <li>
                                        <span>{{ $media->title }}</span>
                                        <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="text-blue-600 hover:underline ml-2">Ver</a>
                                    </li>
                                @empty
                                    <p class="text-gray-500">No hay contenido multimedia.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
const ctx = document.getElementById('progressChart').getContext('2d');
new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ['Comunicación', 'Actividades', 'Rutinas', 'Multimedia', 'Autonomía'],
        datasets: [{
            label: 'Progreso',
            data: [
                {{ $child->progress_communication ?? 65 }},
                {{ $child->progress_activities ?? 80 }},
                {{ $child->progress_routines ?? 75 }},
                {{ $child->progress_multimedia ?? 50 }},
                {{ $child->progress_autonomy ?? 90 }}
            ],
            backgroundColor: 'rgba(59, 130, 246, 0.2)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 2,
            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(59, 130, 246, 1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { 
            r: { 
                beginAtZero: true, 
                max: 100,
                angleLines: { color: 'rgba(0, 0, 0, 0.1)' },
                grid: { color: 'rgba(0, 0, 0, 0.1)' },
                pointLabels: { font: { size: 14 } },
                ticks: { backdropColor: 'rgba(255, 255, 255, 0.75)' }
            } 
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endsection
