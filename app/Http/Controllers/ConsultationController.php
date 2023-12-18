<?php

namespace App\Http\Controllers;
use App\Http\Requests\ConsultationRequest;
use App\Models\Consultations;

class ConsultationController extends Controller
{
    public function update(ConsultationRequest $request, $id)
    {
        try {
            $result = (object)$request->handle();
            //dd($result->id);
            Consultations::find($id)->update([
                'queries'               => $result->queries,
                'description'           => $result->description,
            ]);

            $consults = Consultations::find($id);

            return response()->json($consults,  200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e], 500);
        }
    }
   
}
