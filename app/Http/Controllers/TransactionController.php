<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->transactions()->with('category');
        
        if ($request->has('month') && $request->month != 'all') {
            $month = $request->month;
            $query->whereMonth('date', $month + 1);
        }
        
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }
        
        $transactions = $query->orderBy('date', 'desc')->get();
        $categories = Category::all();
        
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        $balance = $income - $expenses;
        
        return view('transactions.index', compact(
            'transactions', 
            'categories', 
            'income', 
            'expenses', 
            'balance'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        Auth::user()->transactions()->create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transação registrada com sucesso!');
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transação atualizada com sucesso!');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transação excluída com sucesso!');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->with('category')->orderBy('date', 'desc')->get();
        $categories = Category::all();
    
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        $balance = $income - $expenses;
        
        $monthlyData = $this->getMonthlyData($transactions);
        $categoryData = $this->getCategoryData($transactions);
        
        return view('dashboard', compact(
            'transactions', 
            'categories', 
            'income', 
            'expenses', 
            'balance',
            'monthlyData',
            'categoryData'
        ));
    }

    private function getMonthlyData($transactions)
    {
        $monthlyData = [];
        $months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        
        foreach ($months as $index => $month) {
            $monthNumber = $index + 1;
            
            $monthTransactions = $transactions->filter(function ($transaction) use ($monthNumber) {
                return date('n', strtotime($transaction->date)) == $monthNumber;
            });
            
            $income = $monthTransactions->where('type', 'income')->sum('amount');
            $expenses = $monthTransactions->where('type', 'expense')->sum('amount');
            
            if ($income > 0 || $expenses > 0) {
                $monthlyData[] = [
                    'month' => $month,
                    'income' => $income,
                    'expenses' => $expenses,
                ];
            }
        }
        
        return $monthlyData;
    }

    private function getCategoryData($transactions)
    {
        $expenses = $transactions->where('type', 'expense');
        $categoryTotals = [];
        
        foreach ($expenses as $expense) {
            $categoryName = $expense->category->name;
            if (!isset($categoryTotals[$categoryName])) {
                $categoryTotals[$categoryName] = 0;
            }
            $categoryTotals[$categoryName] += $expense->amount;
        }
        
        $totalExpenses = $expenses->sum('amount');
        $categoryData = [];
        
        foreach ($categoryTotals as $category => $amount) {
            $percentage = $totalExpenses > 0 ? round(($amount / $totalExpenses) * 100, 1) : 0;
            $categoryData[] = [
                'category' => $category,
                'amount' => $amount,
                'percentage' => $percentage,
            ];
        }
        
        return $categoryData;
    }
}