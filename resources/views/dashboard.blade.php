<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nova Transação
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Receitas</p>
                                <p class="text-2xl font-semibold text-green-600">
                                    R$ {{ number_format($totalIncome ?? 0, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-2 bg-red-100 rounded-full">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Despesas</p>
                                <p class="text-2xl font-semibold text-red-600">
                                    R$ {{ number_format($totalExpenses ?? 0, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Saldo</p>
                                <p class="text-2xl font-semibold {{ ($balance ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    R$ {{ number_format($balance ?? 0, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Receitas vs Despesas</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Despesas por Categoria</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Transações Recentes</h3>
                        <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-800">Ver todas</a>
                    </div>
                    
                    @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentTransactions as $transaction)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="p-2 {{ $transaction->type === 'income' ? 'bg-green-100' : 'bg-red-100' }} rounded-full mr-3">
                                            <svg class="w-4 h-4 {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($transaction->type === 'income')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                                @endif
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $transaction->description }}</p>
                                            <p class="text-sm text-gray-500">{{ $transaction->category }} • {{ $transaction->date->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <span class="font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Nenhuma transação encontrada</p>
                            <a href="{{ route('transactions.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Criar primeira transação
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [
                    {
                        label: 'Receitas',
                        data: monthlyData.map(item => item.income),
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Despesas',
                        data: monthlyData.map(item => item.expenses),
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': R$ ' + context.parsed.y.toLocaleString('pt-BR');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                }
            }
        });

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.category),
                datasets: [{
                    data: categoryData.map(item => item.amount),
                    backgroundColor: [
                        '#3B82F6',
                        '#EF4444', 
                        '#10B981',
                        '#F59E0B',
                        '#8B5CF6',
                        '#EC4899',
                        '#14B8A6',
                        '#F97316'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = categoryData.reduce((sum, item) => sum + item.amount, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': R$ ' + context.parsed.toLocaleString('pt-BR') + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>