<?php

namespace App\Http\Controllers;

use App\Models\PaymentAccount;
use Illuminate\Http\Request;

class AdminPaymentAccountController extends Controller
{
    public function index()
    {
        $paymentAccounts = PaymentAccount::query()
            ->orderByDesc('is_active')
            ->latest()
            ->paginate(15);

        return view('admin.payment_accounts.index', compact('paymentAccounts'));
    }

    public function create()
    {
        return view('admin.payment_accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        PaymentAccount::create($validated);

        return redirect()->route('admin.payment_accounts.index')->with('success', 'Rekening pembayaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $paymentAccount = PaymentAccount::findOrFail($id);
        return view('admin.payment_accounts.edit', compact('paymentAccount'));
    }

    public function update(Request $request, $id)
    {
        $paymentAccount = PaymentAccount::findOrFail($id);

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $paymentAccount->update($validated);

        return redirect()->route('admin.payment_accounts.index')->with('success', 'Rekening pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $paymentAccount = PaymentAccount::findOrFail($id);
        $paymentAccount->delete();

        return redirect()->route('admin.payment_accounts.index')->with('success', 'Rekening pembayaran berhasil dihapus.');
    }
}
