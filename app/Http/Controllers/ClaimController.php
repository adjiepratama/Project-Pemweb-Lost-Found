<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'claimer_name' => 'required',
            'claimer_nim' => 'required',
            'claimer_email'     => 'required|email',
            'claimer_phone' => 'required',
            'claim_description' => 'required',
            'claim_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($item->status == 'donated') {
            return redirect()->back()->withErrors(['error' => 'Maaf, barang ini sudah didonasikan dan tidak dapat diklaim lagi.']);
        }

        $proofPath = null;
        if ($request->hasFile('claim_proof')) {
            $file = $request->file('claim_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('proofs'), $filename);
            $proofPath = 'proofs/' . $filename;
        }

        Claim::create([
            'user_id' => Auth::id(), 
            'item_id' => $request->item_id,
            'claimer_name' => $request->claimer_name,
            'claimer_nim' => $request->claimer_nim,
            'claimer_email' => $request->claimer_email,
            'claimer_phone' => $request->claimer_phone,
            'claim_description' => $request->claim_description,
            'claim_proof' => $proofPath,
            'status' => 'pending' 
        ]);

        return redirect()->back()->with('success', 'Klaim berhasil diajukan! Tunggu verifikasi Admin.');
    }
}