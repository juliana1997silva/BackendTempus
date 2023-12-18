<?php

namespace App\Http\Controllers;

use App\Http\Requests\NonBusinessHourRequest;
use App\Models\NonBusinessHours;
use App\Repositories\NonBusinessHoursRepository;

class NonBusinessHourController extends Controller
{
    public function update(NonBusinessHourRequest $request, $id)
    {
        try {
            $result = (object)$request->handle();
            //dd($result->id);
            NonBusinessHours::find($id)->update([
                'entry_time'            => $result->entry_time,
                'lunch_entry_time'      => $result->lunch_entry_time,
                'lunch_out_time'        => $result->lunch_out_time,
                'out_time'              => $result->out_time,
            ]);

            $nonbusiness = NonBusinessHours::find($id);

            return response()->json($nonbusiness,  200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e], 500);
        }
    }
}
