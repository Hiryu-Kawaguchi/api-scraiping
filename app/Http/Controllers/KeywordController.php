<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keyword;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keywords = Keyword::all();
        return view("keyword.list",['keywords' => $keywords]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("keyword.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $keyword = new Keyword();
        $keyword->keyword = $request['keyword'];
        $keyword->price_min = $request['price_min'];
        $keyword->price_max = $request['price_max'];
        $keyword->switch = $request['switch'];
        $keyword->save();
        $keywords = Keyword::all();
        return view("keyword.list",['keywords' => $keywords]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $keyword = Keyword::find($id);
        return view("keyword.edit",['keyword' => $keyword]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $keyword = Keyword::find($id);
        $keyword->keyword = $request['keyword'];
        $keyword->price_min = $request['price_min'];
        $keyword->price_max = $request['price_max'];
        $keyword->switch = $request['switch'];
        $keyword->save();
        $keywords = Keyword::all();
        return view("keyword.list",['keywords' => $keywords]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $keyword = Keyword::find($id);
        $keyword->delete();
        $keywords = Keyword::all();
        return view("keyword.list",['keywords' => $keywords]);

    }
}
