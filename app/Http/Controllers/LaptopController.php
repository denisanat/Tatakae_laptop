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
        $filters = [10 => 'page_score', 11 => 'user_score', 12 => 'price', 1 => 'processor', 2 => 'graphics_card', 3 => 'memory', 4 => 'storage', 5 => 'display'];

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
            $request->memory,
            function($query) use ($request) {
                $query->where('memory', '=', $request->memory);
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

        )->when(
            $request->sort,
            function($query) use ($request, $filters) {
                $query->where($filters[$request->sort], '!=', NULL);
                $query->orderByDesc($filters[$request->sort]);
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
            $props['memory_cards'] = Hardware::where('hardware_type', 4)->get();
            $props['storages'] = Hardware::where('hardware_type', 5)->get();
            $props['displays'] = Hardware::where('hardware_type', 6)->get();
        }

        return Inertia::render('Home', $props);
    }


    public function show($id)
    {
        $laptop = Laptop::findOrFail($id);

        // Laptop components
        $laptop->model = $this->getHardwareName($laptop->model);
        $laptop->processor = $this->getHardwareName($laptop->processor);
        $laptop->graphics_card = $this->getHardwareName($laptop->graphics_card);
        $laptop->memory = $this->getHardwareName($laptop->memory);
        $laptop->storage = $this->getHardwareName($laptop->storage);
        $laptop->display = $this->getHardwareName($laptop->display);
        $laptop->battery = $this->getHardwareName($laptop->battery);

        // Recomended laptops
        $recomended = array();
        $cont = 0;
        while ( count($recomended) < 4 && $cont < 30 ) {
            $randomId = rand(0, 100);
            $recomendedLaptop = Laptop::find($randomId);

            if ( $recomendedLaptop != null && $randomId != $id )
                array_push($recomended, $recomendedLaptop);

            $cont++;
        }

        // Comments
        $messages = Message::where('target_id', '=', $id)->where('is_response', '=', false)->get();

        return Inertia::render('Laptop', [
            'laptop' => $laptop,
            'recomended' => $recomended,
            'userScore' => $laptop['user_score'],
            'messages' => $messages
        ]);
    }

    private function getHardwareName($idHardware)
    {
        $component = Hardware::find($idHardware);

        if ( $component == NULL )
            return 'MissingNo';

        return $component->name;
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

        $userRatings = UserScore::where('laptop_id', '=', $laptop)->get()->toArray();

        $mean = 0;
        foreach( $userRatings as $rating )
            $mean += $rating['score'];

        $mean = $mean / count($userRatings);
        
        Laptop::where('id', '=', $laptop)->update([
            'id' => $laptop,
            'user_score' => $mean
        ]);

        return back();
    }


    public function comment(Request $request, $laptop)
    {
        Message::updateOrCreate([
            'user_id' => auth()->id(),
            'is_response' => FALSE,
            'target_id' => $laptop,
            'message' => $request->comment
        ]);

        return back();
    }


    public function reply(Request $request, $id)
    {
        Message::updateOrCreate([
            'user_id' => auth()->id(),
            'is_response' => TRUE,
            'target_id' => $id,
            'message' => $request->comment
        ]);

        return back();
    }


    public function getAnswers(Request $request, $id)
    {
        $answers = Message::where('is_response', true)
            ->where('target_id', $id)
            ->get();

        return response()->json($answers);
    }

    public function goCreate(Request $request)
    {
        $props = [
            'models' => Hardware::where('hardware_type', 1)->get(),
            'processors' => Hardware::where('hardware_type', 2)->get(),
            'graphic_cards' => Hardware::where('hardware_type', 3)->get(),
            'memory_cards' => Hardware::where('hardware_type', 4)->get(),
            'storages' => Hardware::where('hardware_type', 5)->get(),
            'displays' => Hardware::where('hardware_type', 6)->get(),
        ];

        return Inertia::render('Create', $props);
    }

    public function createLaptop(Request $request)
    {
        $score = $this->getHardwareScore($request->model);
        $score += $this->getHardwareScore($request->processor);
        $score += $this->getHardwareScore($request->graphic_card);
        $score += $this->getHardwareScore($request->memory);
        $score += $this->getHardwareScore($request->storage);
        $score += $this->getHardwareScore($request->display);
        $score = $score / 6;

        $score = number_format((float)$score, 1);
        $score = floatval($score);

        Laptop::create([
            'name' => $request->name,
            'price' => $request->price,
            'release_date' => $request->release_date,
            'buying_link' => $request->site_link,
            'image_link' => $request->image_link,
            'page_score' => $score,
            
            'model' => $request->model,
            'processor' => $request->processor,
            'graphics_card' => $request->graphic_card,
            'memory' => $request->memory,
            'storage' => $request->storage,
            'display' => $request->display,
        ]);

        return back();
    }

    private function getHardwareScore($idHardware)
    {
        $component = Hardware::find($idHardware);

        if ( $component == NULL )
            return 0;

        return $component->score;
    }

    public function createHardware(Request $request)
    {
        if ( $request->score == NULL )
            $request->score = rand(1, 5);

        Hardware::create([
            'name' => $request->name,
            'hardware_type' => $request->type,
            'score' => $request->score,
        ]);

        return back();
    }
}
