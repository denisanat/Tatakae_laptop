<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laptop;
use App\Models\Hardware;
use App\Models\UserScore;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class LaptopController extends Controller
{
    public function getLaptops(Request $request)
    {
        $page = Laptop::when(
            $request->search, 
            function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');  
            }

        )->when(
            $request->model,
            function($query) use ($request) {
                $query->where('model', '=', $request->model);
            }

        )->when(
            $request->processor,
            function($query) use ($request) {
                $query->where('processor', '=', $request->processor);
            }

        )->when(
            $request->graphics_card,
            function($query) use ($request) {
                $query->where('graphics_card', '=', $request->graphics_card);
            }

        )->when(
            $request->memory_card,
            function($query) use ($request) {
                $query->where('memory', '=', $request->memory_card);
            }

        )->when(
            $request->storage,
            function($query) use ($request) {
                $query->where('storage', '=', $request->storage);
            }

        )->when(
            $request->display,
            function($query) use ($request) {
                $query->where('display', '=', $request->display);
            }

        )->when(
            $request->power_supply,
            function($query) use ($request) {
                $query->where('power_supply', '=', $request->power_supply);
            }

        )->paginate(12)->withQueryString();

        $props = [
            'page' => $page,
            'searchTerm' => $request->search,
            'filters' => [
                'model' => $request->model,
                'processor' => $request->processor,
            ]
        ];

        if ( !$request->hasHeader('X-Inertia-Partial-Data') || in_array('processors', explode(',', $request->header('X-Inertia-Partial-Data'))) ) {
            $props['models'] = Hardware::where('hardware_type', 1)->get();
            $props['processors'] = Hardware::where('hardware_type', 2)->get();
            $props['graphics_cards'] = Hardware::where('hardware_type', 3)->get();
        }

        return Inertia::render('Home', $props);
    }


    public function show($id)
    {
        $laptop = Laptop::findOrFail($id);
        $recomended = Laptop::take(10)->get();

        // Laptop User Score
        $userScore = UserScore::where('laptop_id', '=', $id)->where('user_id', '=', auth()->id())->get();

        if ( count($userScore) > 0 )
            $userScore = $userScore[0]->score;

        else
            $userScore = 0;

        // Messages
        $messages = Message::where('id', '=', $id)->get();

        return Inertia::render('Laptop', [
            'laptop' => $laptop,
            'recomended' => $recomended,
            'userScore' => $userScore,
            'messages' => $messages
        ]);
    }


    public function rate(Request $request, $laptop)
    {
        $request->validate([
            'score' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        UserScore::updateOrCreate([
                'user_id' => auth()->id(),
                'laptop_id' => $laptop,
            ], [
                'score' => $request->score
            ]
        );

        return back();
    }

    public function comment(Request $request, $laptop)
    {
        Message::updateOrCreate([
            'user_id' => auth()->id(),
            'is_response' => $request->isResponse,
            'target_id' => $laptop,
            'message' => $request->comment
        ]);

        return back();
    }
}
