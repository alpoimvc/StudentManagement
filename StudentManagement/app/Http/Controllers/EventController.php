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
                if($data->count()) {
                    foreach ($data as $key => $value) {
                        $events[] = Calendar::event(
                            $value->title,
                            true,
                            new \DateTime($value->start_date),
                            new \DateTime($value->end_date.' +1 day'),
                            null,
                            // Add color and link on event
                         [
                             'color' => '#ff0000',
                             'url' => 'pass here url and any route',
                         ]
                        );
                    }
                }
                $calendar = Calendar::addEvents($events);
                $aluno = DB::table("users")->select('name')->get();
                return view('fullcalendar', compact('calendar','aluno'));
            }
}