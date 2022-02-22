<?php

namespace App\Nova\Invokables;

use Illuminate\Http\Request;

class DocumentFile
{
    /**
     * Store the incoming file upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return array
     */
    public function __invoke(Request $request, $model)
    {
        return [
            'file' => $request->file->store('/documents'),
            'type' => $request->file->getClientOriginalExtension(),
        ];
    }
}
