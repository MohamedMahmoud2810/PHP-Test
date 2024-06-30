<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        Log::info('Store order request received', $request->all());

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
        ]);

        Log::info('Validation passed', $validated);

        // Create the order
        Order::create([
            'user_id' => $validated['user_id'],
            'product' => $validated['product'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
        ]);

        Log::info('Order created successfully');

        return redirect()->route('orders.create')->with('success', 'Order created successfully!');
    }

    public function searchUsers(Request $request)
    {
        $term = $request->term;

        $users = User::where('name', 'like', '%'.$term.'%')
                    ->limit(10)
                    ->get(['id', 'name']);

        return response()->json($users);
    }

    public function userOrderStats()
    {
        $users = DB::select("
            SELECT 
                users.name AS user_name,
                users.created_at AS user_registration_time,
                COUNT(orders.id) AS number_of_purchases,
                MAX(orders.created_at) AS last_purchase_date,
                CASE 
                    WHEN COUNT(orders.id) >= 5 THEN 'Active' 
                    ELSE 'Inactive' 
                END AS status
            FROM 
                users
            LEFT JOIN 
                orders ON users.id = orders.user_id
            GROUP BY 
                users.id
            ORDER BY 
                number_of_purchases DESC
        ");

        return view('orders.user_order_stats', ['users' => $users]);
    }
}
