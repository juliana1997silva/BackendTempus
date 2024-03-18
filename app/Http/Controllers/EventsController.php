<?php

namespace App\Http\Controllers;

use App\Helpers\Tempus;
use App\Http\Requests\EventsRequest;
use App\Models\Events;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        if ($user->admin === 1) {
            $events = Events::all();
        } else if ($user->manager === 1) {
            $users = Users::where('team_id', $user->team_id)->get();
            foreach ($users as $value) {
                $events = Events::where('user_id', $value['id'])->get();
            }
        } else {
            $events = Events::where('user_id', $user->id)->get();
        }

        return response()->json($events, 200);
    }

    public function create(EventsRequest $request)
    {
        $result = (object)$request->handle();

        $user = Auth::user();

        Events::create([
            'id'                    => Tempus::uuid(),
            'user_id'               => $user->id,
            'title'                 => $result->title,
            'start'                 => $result->start,
            'end'                   => $result->end,
            'backgroundColor'       => isset($result->backgroundColor) ? $result->backgroundColor : "#00BCD4",
            'allDay'                => $result->allDay,
        ]);

        return response()->json("Evento criado com sucesso", 200);
    }

    public function update($id, EventsRequest $request)
    {
        $result = (object)$request->handle();

        $events = Events::find($id);

        $events->update([
            'title'                 => $result->title,
            'start'                 => $result->start,
            'end'                   => $result->end,
            'backgroundColor'       => $result->backgroundColor,
            'allDay'                => $result->allDay
        ]);

        return response()->json("Atualizado com sucesso", 200);
    }
}
