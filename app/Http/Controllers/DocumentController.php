<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;
use Storage;

use App\Document;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /**
         * Get all documents
         */
        $documents = Document::where('user_id', auth()->id())
                        ->when($request->q, function ($query) use ($request) {
                            return $query->where(function($query) use ($request){
                                $query->where('title', 'LIKE', "%$request->q%")
                                      ->orWhere('description','LIKE', "%$request->q%")
                                      ->orWhere('type','LIKE', "%$request->q%");
                            });
                        })
                        ->latest()
                        ->paginate(10);

        /**
         * Return view
         */
        return view('dashboard.documents.all', [
            'documents' => $documents,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Download the specified resource.
     *
     * @param  int  $id
     * @return Storage
     */
    public function download($id)
    {

        /**
         * Find Document
         */
        $document = Document::query()
                        ->where('user_id', auth()->id())
                        ->where('id', $id)
                        ->firstOrFail();

        /**
         * Generate Filename
         */
        $file_name = Str::slug($document->title, '_').'.'.$document->type;

        /**
         * Downlod File
         */
        return Storage::download($document->file, $file_name);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
