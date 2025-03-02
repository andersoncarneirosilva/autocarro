<?php

namespace App\Http\Controllers;

use App\Jobs\SendEventNotificationJob;
use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::all();

        // return $events;
        return view('calendar.index', compact('events'));
    }

    public function store(Request $request)
    {
        \Log::debug($request->all());

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'event_date' => 'required|date',
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
            \Log::error('Erro ao adicionar evento: '.$e->getMessage());

            return response()->json(['error' => 'Erro ao adicionar evento'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        \Log::debug('Requisição recebida para atualizar evento:', $request->all());

        // Tenta encontrar o evento pelo ID
        $event = Event::find($id);

        if (! $event) {
            \Log::warning('Evento não encontrado. ID:', ['id' => $id]);

            return response()->json(['error' => 'Evento não encontrado'], 404);
        }

        try {
            // Valida os dados da requisição
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

            \Log::info('Evento atualizado com sucesso:', ['id' => $event->id]);

            // Dispara o evento de broadcast
            // Enviar o Job para a fila
            SendEventNotificationJob::dispatch($event); // Aqui você passa o evento completo

            // Retorna o evento atualizado como resposta JSON
            return response()->json($event);
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar evento:', ['id' => $id, 'error' => $e->getMessage()]);

            return response()->json(['error' => 'Erro ao atualizar evento'], 500);
        }
    }

    public function getEvents()
    {
        // Busca todos os eventos
        $events = Event::all();
        // return $events;

        // Retorna os eventos em formato JSON
        return response()->json($events);
    }

    // Método destroy
    public function destroy($id)
    {
        $event = Event::find($id);

        if (! $event) {
            return response()->json(['success' => false, 'message' => 'Evento não encontrado'], 404);
        }

        $event->delete();

        return response()->json(['success' => true, 'message' => 'Evento excluído com sucesso'], 200);
    }
}
