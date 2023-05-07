<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function Index(Request $request,$wallet): \Illuminate\Http\JsonResponse
    {
        $tokens = \App\Models\Token::leftjoin('lists','tokens.owner_address','lists.token_id')
            ->select('tokens.*','lists.seller_value','lists.list_type','lists.list_id')
            ->where('tokens.owner_address', $wallet)
            ->take(20)
            ->get()
            ->toArray();

        return response()->json($tokens);
    }

    public function Listed(Request $request,$wallet): \Illuminate\Http\JsonResponse
    {
        $tokens = \App\Models\Listed::join('tokens','tokens.token_id','lists.token_id')
            ->select('tokens.*','lists.seller_value','lists.list_type','lists.list_id')
            ->where('lists.seller_address', $wallet)
            ->where('lists.list_type', 'listed')
            ->take(100)
            ->get()
            ->toArray();

        return response()->json($tokens);
    }
}
