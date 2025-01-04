<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\CreateEventJob;
use App\Models\Event;
use Carbon\Carbon;
use App\Jobs\SendEventNotificationJob;

class CalendarController extends Controller
{
    public function index(){
        $events = Event::all();

        //return $events;
        return view('calendar.index', compact('events'));
    }

    
    public function store(Request $request)
{
    \Log::debug($request->all());
    
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date_format:Y-m-d H:i:s',
            'category' => 'required|string',
        ]);

        $event = Event::create([
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'category' => $validated['category'],
        ]);

        // Enviar o Job para a fila
        SendEventNotificationJob::dispatch($event); // Aqui você passa o evento completo
        \Log::info('Notificação disparada');
        // Retorna a resposta JSON para o frontend
        return response()->json([
            'message' => 'Novo evento criado e notificação em processo de envio!',
            'event' => $event,
        ], 202); // 202 indica que a requisição foi aceita para processamento
    } catch (\Exception $e) {
        \Log::error('Erro ao adicionar evento: ' . $e->getMessage());
        return response()->json(['error' => 'Erro ao adicionar evento'], 500);
    }
}



public function update(Request $request, $id)
{
    \Log::debug($request->all());

    $event = Event::find($id);  // Encontre o evento com o ID passado

    if (!$event) {
        return response()->json(['error' => 'Evento não encontrado'], 404);  // Retorna 404 caso o evento não exista
    }
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date_format:Y-m-d H:i:s',
            'category' => 'required|string',
        ]);
        // Atualiza os dados do evento
        $event->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'event_date' => $validated['event_date'],
        ]);
        return response()->json($event); // Retorna JSON
    } catch (\Exception $e) {
        \Log::error('CONTROLLER: Erro ao atualizar evento: ' . $e->getMessage());
        return response()->json(['error' => 'CONTROLLER: Erro ao atualizar evento'], 500); // Retorna JSON de erro
    }
    
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

    if (!$event) {
        return response()->json(['success' => false, 'message' => 'Evento não encontrado'], 404);
    }

    $event->delete();

    return response()->json(['success' => true, 'message' => 'Evento excluído com sucesso'], 200);
}




}
