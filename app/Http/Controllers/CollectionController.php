<?php

namespace App\Http\Controllers;


class CollectionController extends Controller
{
    public function Index(): \Illuminate\Http\JsonResponse
    {
        $collections = \App\Models\Collection::take(env("DEFAULT_LIST_TAKE"))
            ->get()->toArray();

        foreach ($collections as &$collection) {
            if ($collection['icon'] != ''){
                $collection['icon'] = env("NFT_STORAGE_URL") . $collection['icon'];
            } else {
                $collection['icon'] = "default URl.";//TODO
            }
        }

        return response()->json($collections);
    }

    public function Show($id): \Illuminate\Http\JsonResponse
    {
        //TODO only on list
        //TODO start page end page

        $collection = \App\Models\Collection::where('slug',$id)->first();
        if (!$collection) {
            try {
                $collection = \App\Models\Collection::where('collection_id',$id)->first();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Collection not found'], 404);
            }
        }


        if (!$collection) {
            return response()->json(['error' => 'Collection not found'], 404);
        }


//        $tokens = \App\Models\Token::join('lists','lists.token_id','tokens.token_id')
//            ->select('tokens.*','lists.seller_value','lists.list_type','lists.list_id')
//            ->where('lists.list_type', 'listed')
//            ->where('tokens.collection_id', $collection->collection_id)
//            ->get()
//            ->toArray();

        $tokens = \App\Models\Token::leftjoin('lists','lists.token_id','tokens.token_id')
            ->select('tokens.*','lists.seller_value','lists.list_type','lists.list_id')
            ->where('tokens.collection_id', $collection->collection_id)
            ->orderBy('lists.seller_value', 'asc')
            ->orderBy('tokens.updated_at', 'desc')
            ->take(env("DEFAULT_LIST_TAKE"))
            ->get()
            ->toArray();

        foreach ($tokens as &$token) {
            if ($token['image'] != ''){
                $token['image'] = env("NFT_STORAGE_URL") . $token['image'];
            } else if ($token['metadata_uri'] != ''){
                $token['image'] = $token['metadata_uri'];
            } else{
                $token['image'] = "default URl.";//TODO
            }
        }

        $collection->tokens= $tokens;
        return response()->json($collection);
    }

    public function Detail($id): \Illuminate\Http\JsonResponse
    {
        $tokens = \App\Models\Token::where('token_id', $id)->first()->toArray();
        if (!$tokens) {
            return response()->json(['error' => 'nft not found'], 404);
        }
        //TODO take offer
        //TODO take sell price
        return response()->json($tokens);
    }

    public function New(): \Illuminate\Http\JsonResponse
    {
        $collections = \App\Models\Collection::orderBy('created_at')->take(50)
            ->get()->toArray();
        return response()->json($collections);
    }
}
