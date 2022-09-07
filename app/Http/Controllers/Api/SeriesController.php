<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Series;
use \App\Http\Requests\SeriesFormRequest;
use App\Repositories\EloquentSeriesRepository;
use \Illuminate\Contracts\Auth\Authenticatable;

class SeriesController extends Controller
{
    public function __construct(private EloquentSeriesRepository $seriesRepository)
    { }

    public function index(Request $request)
    {
        $query = Series::query();

        if($request->has('nome'))
            $query->whereNome($request->nome);
        
        return $query->paginate(5);
    }

    public function store(SeriesFormRequest $request)
    {
        return response()
            ->json($this->seriesRepository->add($request), 201);
    }

    public function show(int $id)
    {
        // $series = Series::whereId($id)->with('seasons.episodes')->first();
        
        // $seriesModel = Series::with('seasons.episodes')->whereId($id)->first();

        $seriesModel = Series::with('seasons.episodes')->find($id);
        if($seriesModel === null)
            return response()->json(['message' => 'Série não encontrada'], 404);

        return $seriesModel;
    }


    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all())->save();
        return $series;
    }

    public function destroy(int $series, Authenticatable $user)
    {
        // dd($user->tokenCan('series:delete')); // true
        // dd($user->tokenCan('series:delete')); // false
        Series::destroy($series);
        return response()->json(['msg' => 'Série apagada com sucesso'], 204);   
    }
}
