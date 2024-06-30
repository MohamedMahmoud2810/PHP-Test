<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->get('term');
        $users = User::where('name', 'LIKE', '%' . $term . '%')->get();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'value' => $user->id,
                'label' => $user->name
            ];
        }

        return response()->json($data);
    }
}
