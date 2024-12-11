<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Charity;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Fetch reports for admin
    public function index()
    {
        $charities = Charity::with('donations')->get();

        $reports = $charities->map(function ($charity) {
            return [
                'charity_name' => $charity->name,
                'total_donations' => $charity->donations->sum('amount'),
                'donation_count' => $charity->donations->count(),
            ];
        });

        return response()->json($reports);
    }

    // Fetch reports for a specific charity
    public function charityReport()
    {
        $charity = Auth::user()->charity;

        if (!$charity) {
            return response()->json(['error' => 'Not authorized'], 403);
        }

        $donations = $charity->donations()
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->get();

        $totalDonations = $donations->sum('amount');
        $donationCount = $donations->count();

        return response()->json([
            'total_donations' => $totalDonations,
            'donation_count' => $donationCount,
        ]);
    }

    // Fetch donation history and total donations for donors
    public function donorReport()
    {
        $donations = Auth::user()->donations()
            ->with('charity')
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->get();

        $totalDonations = $donations->sum('amount');

        return response()->json([
            'donations' => $donations,
            'total_donations' => $totalDonations,
        ]);
    }
}
