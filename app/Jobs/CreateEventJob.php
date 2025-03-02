<?php

namespace App\Jobs;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;  // Garantir que o Job implementa ShouldQueue

class CreateEventJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $title;

    protected $event_date;

    protected $category;

    public function __construct($title, $event_date, $category)
    {
        $this->title = $title;
        $this->event_date = $event_date;
        $this->category = $category;
    }

    public function handle()
    {
        try {
            $event = Event::create([
                'title' => $this->title,
                'event_date' => $this->event_date,
                'category' => $this->category,
            ]);

            \Log::info('Evento criado com sucesso: '.$event->id);

        } catch (\Exception $e) {
            \Log::error('Erro ao criar evento: '.$e->getMessage());
        }
    }
}
