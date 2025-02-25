<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    public function index()
    {
        $persons = Person::all();
        return view('index', ['persons' => $persons, 'success' => null]);
    }

    public function show($id)
    {
        $person = Person::find($id);
        return view('show', ['person' => $person]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        //Valide les données du formulaire
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'birth_name' => 'required',
            'middle_names' => 'nullable',
            'created_by' => 'required|exists:people,id'
        ]);

        //Formatage des données
        $request->first_name = ucfirst(strtolower($request->first_name));
        $request->last_name = ucfirst(strtolower($request->last_name));

        if (!empty($request->middle_names)) {
            // Séparer les prénoms par des virgules
            $middleNamesArray = explode(',', $request->middle_names);
        
            // Transformer chaque prénom
            $middleNamesArray = array_map(function($name) {
                return ucfirst(strtolower(trim($name)));
            }, $middleNamesArray);
        
            // Rejoindre les prénoms transformés en une seule chaîne, séparée par des virgules
            $request->middle_names = implode(',', $middleNamesArray);
        } else {
            // Si pas de prénoms renseignés, on assigne NULL
            $request->middle_names = null;
        }
        
        $request->birth_name = ucfirst(strtolower($request->birth_name)) ?? $request->last_name;
        $request->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth)) ?? null;

        //Crée une nouvelle personne
        $person = new Person();
        $person->first_name = $request->first_name;
        $person->last_name = $request->last_name;
        if ($request->has('middle_names')) {
            $person->middle_names = $request->middle_names;
        }
        $person->date_of_birth = $request->date_of_birth;
        $person->birth_name = $request->birth_name;
        $person->created_by = $request->created_by;
        if($person->save()) {
            return redirect()->route('index', ['success' => true]);
        } else {
            return redirect()->route('index', ['success' => false]);
        }
    }

    public function testParentiy(){
        DB::enableQueryLog();
        $timestart = microtime(true);
        $person = Person::findOrFail(84);
        $degree = $person->getDegreeWith(1265);
        // afficher le rÃ©sultat, le temps d'execution, et le nombre de requÃªtes SQL :
        var_dump(["degree"=>$degree, "time"=>microtime(true)-$timestart, "nb_queries"=>count(DB::getQueryLog())]);
    }
}
