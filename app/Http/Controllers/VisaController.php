<?php

namespace App\Http\Controllers;

use App\Visa;
use App\User;
use Illuminate\Http\Request;

class VisaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('god')->only(['drop']);
        $this->middleware('spectator')->only(['store','update','drop','create','store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visas = Visa::orderBy('nationality','ASC')
                ->where('status','available')
                ->groupBy('nationality','interior','app_num','occupation','gender','visa_expiry_date','year')
                ->select(\DB::raw('count(*) as total'), 'nationality','interior','app_num','occupation','gender','visa_expiry_date','year')
                ->get();
        $nats = $this->getNat();
        return view('dashboard.visas', compact('visas','nats'));
    }

    public function used()
    {
        $visas = Visa::orderBy('nationality','ASC')
                ->where('status','used')
                ->groupBy('nationality','interior','app_num','occupation','gender','visa_expiry_date','year')
                ->select(\DB::raw('count(*) as total'), 'nationality','interior','app_num','occupation','gender','visa_expiry_date','year')
                ->get();
        $nats = $this->getNat();
        return view('dashboard.visas-used', compact('visas','nats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nats = $this->getNat();
        $years = $this->getYears();
        return view('dashboard.visa-add',compact('nats','years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'interior' => 'required',
            'app_num' => 'required',
            'year' => 'required',
            'visa_expiry_date' => 'required',
            'gender' => 'required',
            'occupation' => 'required',
            'nationality' => 'required',
            'nums' => 'required'
        ]);
        
        $data['interior'] = $request->input('interior');
        $data['app_num'] = $request->input('app_num');
        $data['gender'] = $request->input('gender');
        $data['occupation'] = $request->input('occupation');
        $data['nationality'] = $request->input('nationality');
        $data['year'] = $request->input('year');
        $data['visa_expiry_date'] = $request->input('visa_expiry_date');
        $nums = $request->input('nums');

        for($x=1;$x<=$nums;$x++){
            Visa::create($data);
        }

        flash(($x-1).' visas have been successfully saved.')->success();
        return redirect('visa');
    }

    public function search(Request $request)
    {
        $genOperator = $request->input('gender')?'=':'!=';
        $occOperator = $request->input('occupation')?'=':'!=';
        $natOperator = $request->input('nationality')?'=':'!=';

        $gender = $request->input('gender');
        $occupation = $request->input('occupation');
        $nationality = $request->input('nationality');

        $nats = $this->getNat();

        $visas = Visa::where('gender',$genOperator,$gender)
                ->where('occupation',$occOperator,$occupation)
                ->where('nationality',$natOperator,$nationality)
                ->where('status','available')
                ->groupBy('nationality','interior','app_num','occupation','gender','visa_expiry_date','year')
                ->select(\DB::raw('count(*) as total'), 'nationality','interior','app_num','occupation','gender','visa_expiry_date','year')
                ->orderBy('nationality','ASC')
                ->get();

        return view('dashboard.visa-search',compact('visas','nats','gender','occupation','nationality'));
    }

    public function usedSearch(Request $request)
    {
        $genOperator = $request->input('gender')?'=':'!=';
        $occOperator = $request->input('occupation')?'=':'!=';
        $natOperator = $request->input('nationality')?'=':'!=';

        $gender = $request->input('gender');
        $occupation = $request->input('occupation');
        $nationality = $request->input('nationality');

        $nats = $this->getNat();

        $visas = Visa::where('gender',$genOperator,$gender)
                ->where('occupation',$occOperator,$occupation)
                ->where('nationality',$natOperator,$nationality)
                ->where('status','used')
                ->groupBy('nationality','interior','app_num','occupation','gender','visa_expiry_date','year')
                ->select(\DB::raw('count(*) as total'), 'nationality','interior','app_num','occupation','gender','visa_expiry_date','year')
                ->orderBy('nationality','ASC')
                ->get();

        return view('dashboard.visa-used-search',compact('visas','nats','gender','occupation','nationality'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visa  $visa
     * @return \Illuminate\Http\Response
     */
    public function show(Visa $visa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visa  $visa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visa = Visa::findOrFail($id);
        $years = $this->getYears();
        $nats = $this->getNat();
        $emps = User::sort()->orderBy('emp_id','ASC')->get();
        return view('dashboard.visa-edit',compact('visa','years','nats','emps'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visa  $visa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $visa = Visa::findOrFail($id);

        $this->validate($request,[
            'interior' => 'required',
            'app_num' => 'required',
            'year' => 'required',
            'visa_expiry_date' => 'required',
            'gender' => 'required',
            'occupation' => 'required',
            'nationality' => 'required',
        ]);
        
        $visa->interior = $request->input('interior');
        $visa->app_num = $request->input('app_num');
        $visa->gender = $request->input('gender');
        $visa->occupation = $request->input('occupation');
        $visa->nationality = $request->input('nationality');
        $visa->year = $request->input('year');
        $visa->visa_expiry_date = $request->input('visa_expiry_date');
       
        if($request->input('status')){
            $visa->status = 'used';
            $visa->emp_id = $request->input('status');
        }

        $visa->save();

        flash('Successfully updated.')->success();
        return redirect('visa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visa  $visa
     * @return \Illuminate\Http\Response
     */
    public function drop($id)
    {
        $visa = Visa::findOrFail($id);
        $visa->delete();
        flash('Visa successfully deleted.')->success();
        return redirect()->back();
    }

    public function expand(Request $request)
    {
        $visas = Visa::orderBy('nationality','ASC')->where('status',$request->input('status'))->get();
        $vs = [];
        foreach($visas as $visa){
            $vs[] = ['interior' => $visa->interior,
                    'app_num' => $visa->app_num,
                    'year' => $visa->year,
                    'visaExpiry' => $visa->visa_expiry_date->format('F d, Y'),
                    'gender' => $visa->gender,
                    'occupation' => $visa->occupation,
                    'nationality' => $visa->nationality,
                    'id' => $visa->id,];
        }

        echo json_encode($vs);
    }

    public function searchExpand(Request $request)
    {
        $genOperator = $request->input('gender')?'=':'!=';
        $occOperator = $request->input('occupation')?'=':'!=';
        $natOperator = $request->input('nationality')?'=':'!=';

        $gender = $request->input('gender');
        $occupation = $request->input('occupation');
        $nationality = $request->input('nationality');

        $visas = Visa::where('gender',$genOperator,$gender)
                ->where('occupation',$occOperator,$occupation)
                ->where('nationality',$natOperator,$nationality)
                ->where('status',$request->input('status'))
                ->orderBy('nationality','ASC')
                ->get();

        $vs = [];
        foreach($visas as $visa){
            $vs[] = ['interior' => $visa->interior,
                    'app_num' => $visa->app_num,
                    'year' => $visa->year,
                    'visaExpiry' => $visa->visa_expiry_date->format('F d, Y'),
                    'gender' => $visa->gender,
                    'occupation' => $visa->occupation,
                    'nationality' => $visa->nationality,
                    'id' => $visa->id,];
        }

        echo json_encode($vs);
    }

    public function getYears(){
        $years = [];
        for($x = intval(date('Y')); $x >= 2000; $x--){
            $years[$x] = $x;
        }

        return $years;
    }

    public function getNat(){
        return ["" => "--Select Nationality--",
        "afghan" => "Afghan",
      "albanian" => "Albanian",
      "algerian" => "Algerian",
      "american" => "American",
      "andorran" => "Andorran",
      "angolan" => "Angolan",
      "antiguans" => "Antiguans",
      "argentinean" => "Argentinean",
      "armenian" => "Armenian",
      "australian" => "Australian",
      "austrian" => "Austrian",
      "azerbaijani" => "Azerbaijani",
      "bahamian" => "Bahamian",
      "bahraini" => "Bahraini",
      "bangladeshi" => "Bangladeshi",
      "barbadian" => "Barbadian",
      "barbudans" => "Barbudans",
      "batswana" => "Batswana",
      "belarusian" => "Belarusian",
      "belgian" => "Belgian",
      "belizean" => "Belizean",
      "beninese" => "Beninese",
      "bhutanese" => "Bhutanese",
      "bolivian" => "Bolivian",
      "bosnian" => "Bosnian",
      "brazilian" => "Brazilian",
      "british" => "British",
      "bruneian" => "Bruneian",
      "bulgarian" => "Bulgarian",
      "burkinabe" => "Burkinabe",
      "burmese" => "Burmese",
      "burundian" => "Burundian",
      "cambodian" => "Cambodian",
      "cameroonian" => "Cameroonian",
      "canadian" => "Canadian",
      "cape verdean" => "Cape Verdean",
      "central african" => "Central African",
      "chadian" => "Chadian",
      "chilean" => "Chilean",
      "chinese" => "Chinese",
      "colombian" => "Colombian",
      "comoran" => "Comoran",
      "congolese" => "Congolese",
      "costa rican" => "Costa Rican",
      "croatian" => "Croatian",
      "cuban" => "Cuban",
      "cypriot" => "Cypriot",
      "czech" => "Czech",
      "danish" => "Danish",
      "djibouti" => "Djibouti",
      "dominican" => "Dominican",
      "dutch" => "Dutch",
      "east timorese" => "East Timorese",
      "ecuadorean" => "Ecuadorean",
      "egyptian" => "Egyptian",
      "emirian" => "Emirian",
      "equatorial guinean" => "Equatorial Guinean",
      "eritrean" => "Eritrean",
      "estonian" => "Estonian",
      "ethiopian" => "Ethiopian",
      "fijian" => "Fijian",
      "filipino" => "Filipino",
      "finnish" => "Finnish",
      "french" => "French",
      "gabonese" => "Gabonese",
      "gambian" => "Gambian",
      "georgian" => "Georgian",
      "german" => "German",
      "ghanaian" => "Ghanaian",
      "greek" => "Greek",
      "grenadian" => "Grenadian",
      "guatemalan" => "Guatemalan",
      "guinea-bissauan" => "Guinea-Bissauan",
      "guinean" => "Guinean",
      "guyanese" => "Guyanese",
      "haitian" => "Haitian",
      "herzegovinian" => "Herzegovinian",
      "honduran" => "Honduran",
      "hungarian" => "Hungarian",
      "i-kiribati" => "I-Kiribati",
      "icelander" => "Icelander",
      "indian" => "Indian",
      "indonesian" => "Indonesian",
      "iranian" => "Iranian",
      "iraqi" => "Iraqi",
      "irish" => "Irish",
      "israeli" => "Israeli",
      "italian" => "Italian",
      "ivorian" => "Ivorian",
      "jamaican" => "Jamaican",
      "japanese" => "Japanese",
      "jordanian" => "Jordanian",
      "kazakhstani" => "Kazakhstani",
      "kenyan" => "Kenyan",
      "kittian and nevisian" => "Kittian and Nevisian",
      "kuwaiti" => "Kuwaiti",
      "kyrgyz" => "Kyrgyz",
      "laotian" => "Laotian",
      "latvian" => "Latvian",
      "lebanese" => "Lebanese",
      "liberian" => "Liberian",
      "libyan" => "Libyan",
      "liechtensteiner" => "Liechtensteiner",
      "lithuanian" => "Lithuanian",
      "luxembourger" => "Luxembourger",
      "macedonian" => "Macedonian",
      "malagasy" => "Malagasy",
      "malawian" => "Malawian",
      "malaysian" => "Malaysian",
      "maldivan" => "Maldivan",
      "malian" => "Malian",
      "maltese" => "Maltese",
      "marshallese" => "Marshallese",
      "mauritanian" => "Mauritanian",
      "mauritian" => "Mauritian",
      "mexican" => "Mexican",
      "micronesian" => "Micronesian",
      "moldovan" => "Moldovan",
      "monacan" => "Monacan",
      "mongolian" => "Mongolian",
      "moroccan" => "Moroccan",
      "mosotho" => "Mosotho",
      "motswana" => "Motswana",
      "mozambican" => "Mozambican",
      "namibian" => "Namibian",
      "nauruan" => "Nauruan",
      "nepalese" => "Nepalese",
      "new zealander" => "New Zealander",
      "nicaraguan" => "Nicaraguan",
      "nigerian" => "Nigerian",
      "nigerien" => "Nigerien",
      "north korean" => "North Korean",
      "northern irish" => "Northern Irish",
      "norwegian" => "Norwegian",
      "omani" => "Omani",
      "palestinian" => "Palestinian",
      "pakistani" => "Pakistani",
      "palauan" => "Palauan",
      "panamanian" => "Panamanian",
      "papua new guinean" => "Papua New Guinean",
      "paraguayan" => "Paraguayan",
      "peruvian" => "Peruvian",
      "polish" => "Polish",
      "portuguese" => "Portuguese",
      "qatari" => "Qatari",
      "romanian" => "Romanian",
      "russian" => "Russian",
      "rwandan" => "Rwandan",
      "saint lucian" => "Saint Lucian",
      "salvadoran" => "Salvadoran",
      "samoan" => "Samoan",
      "san marinese" => "San Marinese",
      "sao tomean" => "Sao Tomean",
      "saudi" => "Saudi",
      "scottish" => "Scottish",
      "senegalese" => "Senegalese",
      "serbian" => "Serbian",
      "seychellois" => "Seychellois",
      "sierra leonean" => "Sierra Leonean",
      "singaporean" => "Singaporean",
      "slovakian" => "Slovakian",
      "slovenian" => "Slovenian",
      "solomon islander" => "Solomon Islander",
      "somali" => "Somali",
      "south african" => "South African",
      "south korean" => "South Korean",
      "spanish" => "Spanish",
      "sri lankan" => "Sri Lankan",
      "sudanese" => "Sudanese",
      "surinamer" => "Surinamer",
      "swazi" => "Swazi",
      "swedish" => "Swedish",
      "swiss" => "Swiss",
      "syrian" => "Syrian",
      "taiwanese" => "Taiwanese",
      "tajik" => "Tajik",
      "tanzanian" => "Tanzanian",
      "thai" => "Thai",
      "togolese" => "Togolese",
      "tongan" => "Tongan",
      "trinidadian/tobagonian" => "Trinidadian/Tobagonian",
      "tunisian" => "Tunisian",
      "turkish" => "Turkish",
      "tuvaluan" => "Tuvaluan",
      "ugandan" => "Ugandan",
      "ukrainian" => "Ukrainian",
      "uruguayan" => "Uruguayan",
      "uzbekistani" => "Uzbekistani",
      "venezuelan" => "Venezuelan",
      "vietnamese" => "Vietnamese",
      "welsh" => "Welsh",
      "yemenite" => "Yemenite",
      "zambian" => "Zambian",
      "zimbabwean" => "Zimbabwean"];
    }
}
