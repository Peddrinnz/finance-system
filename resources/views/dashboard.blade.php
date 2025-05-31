<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Financeiro</h1>
                    <p class="text-gray-600">Bem-vindo, {{ Auth::user()->name }}! Controle suas finanças de forma inteligente.</p>
                </div>
                <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nova Transação
                </a>
            </div>

            <!-- Cards de Resumo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Receitas</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div class="mt-2">
                            <div class="text-2xl font-bold text-green-600">R$ {{ number_format($income, 2, ',', '.') }}</div>
                            <p class="text-xs text-gray-500">
                                {{ $transactions->where('type', 'income')->count() }} transações
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Despesas</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                            </svg>
                        </div>
                        <div class="mt-2">
                            <div class="text-2xl font-bold text-red-600">R$ {{ number_format($expenses, 2, ',', '.') }}</div>
                            <p class="text-xs text-gray-500">
                                {{ $transactions->where('type', 'expense')->count() }} transações
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Saldo</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-2">
                            <div class="text-2xl font-bold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                R$ {{ number_format($balance, 2, ',', '.') }}
                            </div>
                            <p class="text-xs text-gray-500">
                                {{ $balance >= 0 ? 'Saldo positivo' : 'Saldo negativo' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtros
                    </h3>
                    <form action="{{ route('transactions.index') }}" method="GET" class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <select name="month" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="all">Todos os meses</option>
                                <option value="0" {{ request('month') == '0' ? 'selected' : '' }}>Janeiro</option>
                                <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>Fevereiro</option>
                                <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>Março</option>
                                <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>Abril</option>
                                <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>Maio</option>
                                <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>Junho</option>
                                <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>Julho</option>
                                <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>Agosto</option>
                                <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>Setembro</option>
                                <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>Outubro</option>
                                <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Novembro</option>
                                <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>Dezembro</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <select name="category" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="all">Todas as categorias</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Filtrar
                        </button>

                        @if(request('month') != 'all' || request('category') != 'all')
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Limpar Filtros
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Receitas vs Despesas</h3>
                        <div id="monthly-chart" style="height: 300px;"></div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Despesas por Categoria</h3>
                        <div id="category-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Transações Recentes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Transações Recentes</h3>
                        <a href="{{ route('transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                            Ver todas
                        </a>
                    </div>
                    
                    @if($transactions->isEmpty())
                        <div class="text-center py-8 text-gray-500">Nenhuma transação encontrada com os filtros aplicados.</div>
                    @else
                        <div class="space-y-3">
                            @foreach($transactions->take(5) as $transaction)
                                <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="text-lg font-semibold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->type == 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                            </span>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full" style="background-color: {{ $transaction->category->color }}20; color: {{ $transaction->category->color }};">
                                                {{ $transaction->category->name }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-600">{{ $transaction->description }}</div>
                                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ date('d/m/Y', strtotime($transaction->date)) }}
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Tem certeza que deseja excluir esta transação?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const monthlyData = @json($monthlyData);
        
        if (monthlyData.length > 0) {
            const monthlyOptions = {
                series: [
                    {
                        name: 'Receitas',
                        data: monthlyData.map(item => item.income)
                    },
                    {
                        name: 'Despesas',
                        data: monthlyData.map(item => item.expenses)
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 300,
                    stacked: false,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: monthlyData.map(item => item.month),
                },
                yaxis: {
                    title: {
                        text: 'R$'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return 'R$ ' + val.toFixed(2)
                        }
                    }
                },
                colors: ['#4CAF50', '#F44336']
            };

            const monthlyChart = new ApexCharts(document.querySelector("#monthly-chart"), monthlyOptions);
            monthlyChart.render();
        } else {
            document.querySelector("#monthly-chart").innerHTML = '<div class="flex items-center justify-center h-full text-gray-500">Sem dados suficientes para exibir o gráfico</div>';
        }

        const categoryData = @json($categoryData);
        
        if (categoryData.length > 0) {
            const categoryOptions = {
                series: categoryData.map(item => item.amount),
                chart: {
                    type: 'pie',
                    height: 300
                },
                labels: categoryData.map(item => `${item.category} (${item.percentage}%)`),
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                colors: ['#4CAF50', '#2196F3', '#9C27B0', '#FF9800', '#FFEB3B', '#E91E63', '#F44336', '#3F51B5', '#607D8B']
            };

            const categoryChart = new ApexCharts(document.querySelector("#category-chart"), categoryOptions);
            categoryChart.render();
        } else {
            document.querySelector("#category-chart").innerHTML = '<div class="flex items-center justify-center h-full text-gray-500">Sem dados suficientes para exibir o gráfico</div>';
        }
    </script>
    @endpush
</x-app-layout>