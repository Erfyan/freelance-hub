<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $data['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $data['project_id'] = $project->id;
        Transaction::create($data);

        return redirect()->route('projects.show', $project)->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function destroy(Transaction $transaction)
    {
        $project = $transaction->project;
        if ($transaction->payment_proof) {
            Storage::disk('public')->delete($transaction->payment_proof);
        }
        $transaction->delete();
        return redirect()->route('projects.show', $project)->with('success', 'Transaksi berhasil dihapus!');
    }
}