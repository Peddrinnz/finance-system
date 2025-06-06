<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('transactions.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nova Transação') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('transactions.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label class="text-base font-medium text-gray-900">Tipo da transação</label>
                            <fieldset class="mt-4">
                                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                    <div class="flex items-center">
                                        <input id="income" name="type" type="radio" value="income" 
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                               {{ old('type', 'expense') == 'income' ? 'checked' : '' }}>
                                        <label for="income" class="ml-3 block text-sm font-medium text-gray-700">
                                            <span class="text-green-600 font-semibold">Receita</span> - Dinheiro que entra
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="expense" name="type" type="radio" value="expense" 
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                               {{ old('type', 'expense') == 'expense' ? 'checked' : '' }}>
                                        <label for="expense" class="ml-3 block text-sm font-medium text-gray-700">
                                            <span class="text-red-600 font-semibold">Despesa</span> - Dinheiro que sai
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Valor (R$)')" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">R$</span>
                                </div>
                                <x-text-input id="amount" class="pl-12" type="number" step="0.01" name="amount" 
                                              :value="old('amount')" placeholder="0,00" required />
                            </div>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category" :value="__('Categoria')" />
                            <select id="category" name="category" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    required>
                                <option value="">Selecionar categoria</option>
                                @foreach(['Salário', 'Freelance', 'Moradia', 'Alimentação', 'Transporte', 'Lazer', 'Saúde', 'Educação', 'Outros'] as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Descrição')" />
                            <textarea id="description" name="description" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                      placeholder="Descrição da transação">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="date" :value="__('Data')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" 
                                          :value="old('date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('transactions.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <x-primary-button>
                                {{ __('Salvar Transação') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>