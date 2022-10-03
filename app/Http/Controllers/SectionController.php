<?php

namespace App\Http\Controllers;

use App\Models\Sections;


/**
 *
 */
class SectionController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return Sections::orderBy('id', 'ASC')->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Sections::findOrFail($id));
    }

}
