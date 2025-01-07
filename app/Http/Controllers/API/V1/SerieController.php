<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Serie;
use App\Http\Resources\SerieCollection;
use App\Http\Resources\SerieResource;

class SerieController extends Controller
{
    public function index(Request $request){

        if($request->has('query')){
            return $this->search($request);
        }

        $series = Serie::orderBy('updated_at','desc')->paginate(10  );
        return new SerieCollection($series);
    }
    public function show(Serie $series){
        $series = $series->load('chapters','owner');
        return new SerieResource($series);
    }
    public function search(Request $request){
        $request->validate([
            'query'=>'required|string',
        ]);
        $searchTerm = $request->query('query');

        $series = Serie::where('title','LIKE','%'.$searchTerm.'%')->get();;
        return new SerieCollection($series);
    }
}
