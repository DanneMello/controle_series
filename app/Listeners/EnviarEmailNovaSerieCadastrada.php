<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarEmailNovaSerieCadastrada implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NovaSerie  $event
     * @return void
     */
    public function handle(NovaSerie $event)
    {
        $nomeSerie     = $event->nomeSerie;
        $qtdTemporada  = $event->qtdTemporadas;
        $qtdEpisodios  = $event->qtdEpisodios;

        $usuarios = User::all();
        $multiplicador = 0;

        foreach($usuarios as $indice => $usuario)
        {
            $multiplicador += $indice;

            $email = new \App\Mail\NovaSerie($nomeSerie, $qtdTemporada, $qtdEpisodios);
            $email->subject = 'Nova série adicionada com sucesso! 🤖';

            # Seta o tempo até o próximo envio.
            $tempo = now()->addSecond($multiplicador * 5);
            \Illuminate\Support\Facades\Mail::to($usuario)->later($tempo, $email);
        }
    }
}
