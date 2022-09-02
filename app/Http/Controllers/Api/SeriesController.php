<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Series;
use \App\Http\Requests\SeriesFormRequest;
use App\Repositories\EloquentSeriesRepository;

class SeriesController extends Controller
{
    public function __construct(private EloquentSeriesRepository $seriesRepository)
    { }

    public function index()
    {
        return Series::all();
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

    public function destroy(int $series)
    {
        Series::destroy($series);
        return response()->json(['msg' => 'Série apagada com sucesso'], 204);   
    }
}
