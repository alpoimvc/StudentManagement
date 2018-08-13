<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Illuminate\Support\Facades\Input;
use DB;

class EventController extends Controller
{
    public function index()
            {
                $events = [];
                $data = Event::all();
                //dd($data->all());
                if($data->count()) {
                    foreach ($data as $key => $value) {
                        $events[] = Calendar::event(
                            $value->title,
                            true,
                            new \DateTime($value->start_date),
                            new \DateTime($value->end_date),
                            null,
                            // Add color and link on event
                         [
                             'color' => '#ff0000',
                             'url' => 'pass here url and any route',
                         ]
                        );
                    }
                    dd($events);
                }
                $calendar = Calendar::addEvents($events);
                return view('fullcalendar', compact('calendar'));
            }

    public function inserir(Request $req)
    {
        //dd($req->all());
        $horario = new Event;
        $horario->title = $req->input('title');
        $horario->start_date = $req->input('start_date');
        $horario->end_date = $req->input('end_date');
        $horario = DB::insert('insert into events (title, start_date, end_date) values (?, ?, ?)',[$req->input('title'), $req->input('start_date'), $req->input('end_date')]);

        $calendar = Calendar::addEvents($horario);
    }
}
