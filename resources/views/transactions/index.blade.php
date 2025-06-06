<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transações') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nova Transação
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtros</h3>
                    
                    <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
                            <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos</option>
                                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Receitas</option>
                                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Despesas</option>
                            </select>
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Categoria</label>
                            <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todas</option>
                                @foreach(['Salário', 'Freelance', 'Moradia', 'Alimentação', 'Transporte', 'Lazer', 'Saúde', 'Educação', 'Outros'] as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700">De</label>
                            <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700">Até</label>
                            <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="md:col-span-4 flex justify-end space-x-3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Filtrar
                            </button>
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Limpar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Todas as Transações
                        @if(isset($transactions))
                            <span class="text-sm text-gray-500">({{ $transactions->total() }} encontradas)</span>
                        @endif
                    </h3>

                    @if(isset($transactions) && $transactions->count() > 0)
                        <div class="space-y-3">
                            @foreach($transactions as $transaction)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                    <div class="flex items-center">
                                        <div class="p-2 {{ $transaction->type === 'income' ? 'bg-green-100' : 'bg-red-100' }} rounded-full mr-4">
                                            <svg class="w-5 h-5 {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($transaction->type === 'income')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                                @endif
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $transaction->description }}</p>
                                            <div class="flex items-center space-x-3 mt-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">
                                                    {{ $transaction->category }}
                                                </span>
                                                <span class="text-sm text-gray-500">{{ $transaction->date->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-lg font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                        </span>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" 
                                                  onsubmit="return confirm('Tem certeza que deseja excluir esta transação?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($transactions->hasPages())
                            <div class="mt-6">
                                {{ $transactions->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma transação encontrada</h3>
                            <p class="text-gray-500 mb-4">Comece adicionando sua primeira transação</p>
                            <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Criar Transação
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>