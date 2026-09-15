<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        // Enforce Login Check
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        $db = \Config\Database::connect();

        // 1. Total Users Count from 'account' table
        $totalUsers = $db->table('account')->countAllResults();

        // 2. Total & Status Counts from 'jobfair_activity_application'
        $appStats = $db->table('jobfair_activity_application')
            ->select("
                COUNT(id) AS totalApps,
                COALESCE(SUM(CASE WHEN LOWER(status) = 'Pending' THEN 1 ELSE 0 END), 0) AS pendingApps,
                COALESCE(SUM(CASE WHEN LOWER(status) = 'Approved' THEN 1 ELSE 0 END), 0) AS approvedApps,
                COALESCE(SUM(CASE WHEN LOWER(status) = 'Rejected' THEN 1 ELSE 0 END), 0) AS rejectedApps
            ")
            ->get()
            ->getRowArray();

        // 3. Monthly Approved Chart Data (0-11 index for JS)
        $chartData = array_fill(0, 12, 0);

        $monthlyApproved = $db->table('jobfair_activity_application')
            ->select("MONTH(proposed_date) as month, COUNT(id) as count")
            ->where('LOWER(status)', 'Approved')
            ->where("YEAR(proposed_date)", date('Y'))
            ->groupBy("MONTH(proposed_date)")
            ->get()
            ->getResultArray();

        foreach ($monthlyApproved as $row) {
            $monthIndex = ((int)$row['month']) - 1; // Convert Month 1-12 to Index 0-11
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $chartData[$monthIndex] = (int)$row['count'];
            }
        }

        // 4. Pass data to view
        $data = [
            'totalUsers'   => (int) $totalUsers,
            'totalApps'    => (int) ($appStats['totalApps'] ?? 0),
            'pendingApps'  => (int) ($appStats['pendingApps'] ?? 0),
            'approvedApps' => (int) ($appStats['approvedApps'] ?? 0),
            'chartData'    => $chartData
        ];

        return view('admin/dashboard', $data);
    }
}