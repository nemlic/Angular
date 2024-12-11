<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationReceipt;

class DonationController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'charity_id' => 'required|exists:charities,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $donation = Donation::create([
            'user_id' => auth()->id(),
            'charity_id' => $request->charity_id,
            'amount' => $request->amount,
        ]);

        // Send receipt email
        Mail::to(auth()->user()->email)->send(new DonationReceipt($donation));
        
        // Send notification
        $donation->charity->user->notify(new DonationReceived($donation));

        return response()->json($donation, 201);
    }

    public function index() {
        return Donation::where('user_id', auth()->id())->get();
    }

    public function show($id) {
        $donation = Donation::findOrFail($id);
        return response()->json($donation);
    }
}
