<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
class CalendarController extends Controller
{
    public function index(){
        $events = Event::all();

        //return $events;
        return view('calendar.index', compact('events'));
    }

    public function store(Request $request)
{
    // Log para depuração
    \Log::debug($request->all());

    // Validação dos dados recebidos
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'event_date' => 'required|date',
        'category' => 'required|string',
        'allDay' => 'required|boolean',
    ]);

    try {
        // Converte a data para o formato correto 'YYYY-MM-DD'
        $eventDate = Carbon::parse($validated['event_date'])->toDateString();

        // Criação do novo evento
        $event = new Event();
        $event->title = $validated['title'];
        $event->event_date = $eventDate;  // Usa a data formatada
        $event->category = $validated['category'];
        $event->all_day = $validated['allDay'];
        $event->save();

        return response()->json($event);
    } catch (\Exception $e) {
        // Log do erro
        \Log::error('Error saving event: ' . $e->getMessage());
        return response()->json(['error' => 'Error saving event'], 500);
    }
}

public function update(Request $request, $id)
{
    $event = Event::find($id);  // Encontre o evento com o ID passado

    
    if (!$event) {
        return response()->json(['error' => 'Evento não encontrado'], 404);  // Retorna 404 caso o evento não exista
    }
 

    // Validação dos dados do evento
    $validated = $request->validate([
        'title' => 'required|string',
        'category' => 'required|string',
        'event_date' => 'required|date',
        'allDay' => 'required|boolean',
    ]);



    // Atualize o evento
    $event->update($validated);

    return response()->json($event, 200);  // Retorna o evento atualizado
}

    public function getEvents()
    {
        // Busca todos os eventos
        $events = Event::all();
//return $events;

        // Retorna os eventos em formato JSON
        return response()->json($events);
    }



// Método destroy
public function destroy($id)
{
    $event = Event::find($id);

    if ($event) {
        $event->delete();  // Exclui o evento
        return response()->json(['message' => 'Event deleted successfully']);
    }

    return response()->json(['message' => 'Event not found'], 404);
}



}
