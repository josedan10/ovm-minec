<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTGuard;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as CountriesClient;
use App\Models\Client;
use App\Models\Institution;
use App\Models\Phone;
use App\Models\User;



class AuthController extends Controller
{


    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $countries = $this->json_country();
        return view('auth.registerClient', compact('countries'));
        
    }

    // public function api_countries()
    // {   
        
    //     $client_country = new CountriesClient(); //GuzzleHttp\Client
    //     $url = "https://restcountries.eu/rest/v2/all";
    //     //return $url;
        
    //     if (env('APP_ENV') === 'local') {
    //         $response = $client_country->request('GET', $url, [
    //             'verify'  => false,
      
    //         ]);
    //     } else {
    //         $response = $client_country->request('GET', $url, [
    //             'verify'  => true,
    //         ]);
    //     }

    //     return $countries = json_decode($response->getBody()->getContents());
    // }

    public function json_country(){
        $countriesList ='[
            { "value": "VE", "label": "Venezuela" },
            { "value": "DO", "label": "Rep\u00FAblica Dominicana" },
            { "value": "SV", "label": "El Salvador" },
            { "value": "HN", "label": "Honduras" },
            { "value": "GT", "label": "Guatemala" },
            { "value": "MX", "label": "M\u00E9xico" },
            { "value": "ES", "label": "Espa\u00F1a" },
            { "value": "US", "label": "Estados Unidos" },
            { "value": "AF", "label": "Afganist\u00E1n" },
            { "value": "AL",  "label": "DE", "label": "Alemania" },
            { "value": "AD", "label": "Andorra" },
            { "value": "AO", "label": "Angola" },
            { "value": "AI", "label": "Anguila" },
            { "value": "AQ", "label": "Ant\u00E1rtida" },
            { "value": "AG", "label": "Antigua y Barbuda" },
            { "value": "SA", "label": "Arabia Saud\u00ED" },
            { "value": "DZ", "label": "Argelia" },
            { "value": "AR", "label": "Argentina" },
            { "value": "AM", "label": "Armenia" },
            { "value": "AW", "label": "Aruba" },
            { "value": "AU", "label": "Australia" },
            { "value": "AT", "label": "Austria" },
            { "value": "AZ", "label": "Azerbaiy\u00E1n" },
            { "value": "BS", "label": "Bahamas" },
            { "value": "BD", "label": "Banglad\u00E9s" },
            { "value": "BB", "label": "Barbados" },
            { "value": "BH", "label": "Bar\u00E9in" },
            { "value": "BE", "label": "B\u00E9lgica" },
            { "value": "BZ", "label": "Belice" },
            { "value": "BJ", "label": "Ben\u00EDn" },
            { "value": "BM", "label": "Bermudas" },
            { "value": "BY", "label": "Bielorrusia" },
            { "value": "BO", "label": "Bolivia" },
            { "value": "BA", "label": "Bosnia y Herzegovina" },
            { "value": "BW", "label": "Botsuana" },
            { "value": "BR", "label": "Brasil" },
            { "value": "BN", "label": "Brun\u00E9i" },
            { "value": "BG", "label": "Bulgaria" },
            { "value": "BF", "label": "Burkina Faso" },
            { "value": "BI", "label": "Burundi" },
            { "value": "BT", "label": "But\u00E1n" },
            { "value": "CV", "label": "Cabo Verde" },
            { "value": "KH", "label": "Camboya" },
            { "value": "CM", "label": "Camer\u00FAn" },
            { "value": "CA", "label": "Canad\u00E1" },
            { "value": "IC", "label": "Canarias" },
            { "value": "BQ", "label": "Caribe neerland\u00E9s" },
            { "value": "QA", "label": "Catar" },
            { "value": "EA", "label": "Ceuta y Melilla" },
            { "value": "TD", "label": "Chad" },
            { "value": "CZ", "label": "Chequia" },
            { "value": "CL", "label": "Chile" },
            { "value": "CN", "label": "China" },
            { "value": "CY", "label": "Chipre" },
            { "value": "VA", "label": "Ciudad del Vaticano" },
            { "value": "CO", "label": "Colombia" },
            { "value": "KM", "label": "Comoras" },
            { "value": "CG", "label": "Congo" },
            { "value": "KP", "label": "Corea del Norte" },
            { "value": "KR", "label": "Corea del Sur" },
            { "value": "CR", "label": "Costa Rica" },
            { "value": "CI", "label": "C\u00F4te d\u2019Ivoire" },
            { "value": "HR", "label": "Croacia" },
            { "value": "CU", "label": "Cuba" },
            { "value": "CW", "label": "Curazao" },
            { "value": "DG", "label": "Diego Garc\u00EDa" },
            { "value": "DK", "label": "Dinamarca" },
            { "value": "DM", "label": "Dominica" },
            { "value": "EC", "label": "Ecuador" },
            { "value": "EG", "label": "Egipto" },
            { "value": "AE", "label": "Emiratos \u00C1rabes Unidos" },
            { "value": "ER", "label": "Eritrea" },
            { "value": "SK", "label": "Eslovaquia" },
            { "value": "SI", "label": "Eslovenia" },
            { "value": "EE", "label": "Estonia" },
            { "value": "SZ", "label": "Esuatini" },
            { "value": "ET", "label": "Etiop\u00EDa" },
            { "value": "PH", "label": "Filipinas" },
            { "value": "FI", "label": "Finlandia" },
            { "value": "FJ", "label": "Fiyi" },
            { "value": "FR", "label": "Francia" },
            { "value": "GA", "label": "Gab\u00F3n" },
            { "value": "GM", "label": "Gambia" },
            { "value": "GE", "label": "Georgia" },
            { "value": "GH", "label": "Ghana" },
            { "value": "GI", "label": "Gibraltar" },
            { "value": "GD", "label": "Granada" },
            { "value": "GR", "label": "Grecia" },
            { "value": "GL", "label": "Groenlandia" },
            { "value": "GP", "label": "Guadalupe" },
            { "value": "GU", "label": "Guam" },
            { "value": "GF", "label": "Guayana Francesa" },
            { "value": "GG", "label": "Guernsey" },
            { "value": "GN", "label": "Guinea" },
            { "value": "GQ", "label": "Guinea Ecuatorial" },
            { "value": "GW", "label": "Guinea-Bis\u00E1u" },
            { "value": "GY", "label": "Guyana" },
            { "value": "HT", "label": "Hait\u00ED" },
            { "value": "HU", "label": "Hungr\u00EDa" },
            { "value": "IN", "label": "India" },
            { "value": "ID", "label": "Indonesia" },
            { "value": "IQ", "label": "Irak" },
            { "value": "IR", "label": "Ir\u00E1n" },
            { "value": "IE", "label": "Irlanda" },
            { "value": "AC", "label": "Isla de la Ascensi\u00F3n" },
            { "value": "IM", "label": "Isla de Man" },
            { "value": "CX", "label": "Isla de Navidad" },
            { "value": "NF", "label": "Isla Norfolk" },
            { "value": "IS", "label": "Islandia" },
            { "value": "AX", "label": "Islas \u00C5land" },
            { "value": "KY", "label": "Islas Caim\u00E1n" },
            { "value": "CC", "label": "Islas Cocos" },
            { "value": "CK", "label": "Islas Cook" },
            { "value": "FO", "label": "Islas Feroe" },
            { "value": "GS", "label": "Islas Georgia del Sur y Sandwich del Sur" },
            { "value": "FK", "label": "Islas Malvinas" },
            { "value": "MP", "label": "Islas Marianas del Norte" },
            { "value": "MH", "label": "Islas Marshall" },
            { "value": "UM", "label": "Islas menores alejadas de EE. UU." },
            { "value": "PN", "label": "Islas Pitcairn" },
            { "value": "SB", "label": "Islas Salom\u00F3n" },
            { "value": "TC", "label": "Islas Turcas y Caicos" },
            { "value": "VG", "label": "Islas V\u00EDrgenes Brit\u00E1nicas" },
            { "value": "VI", "label": "Islas V\u00EDrgenes de EE. UU." },
            { "value": "IL", "label": "Israel" },
            { "value": "IT", "label": "Italia" },
            { "value": "JM", "label": "Jamaica" },
            { "value": "JP", "label": "Jap\u00F3n" },
            { "value": "JE", "label": "Jersey" },
            { "value": "JO", "label": "Jordania" },
            { "value": "KZ", "label": "Kazajist\u00E1n" },
            { "value": "KE", "label": "Kenia" },
            { "value": "KG", "label": "Kirguist\u00E1n" },
            { "value": "KI", "label": "Kiribati" },
            { "value": "XK", "label": "Kosovo" },
            { "value": "KW", "label": "Kuwait" },
            { "value": "LA", "label": "Laos" },
            { "value": "LS", "label": "Lesoto" },
            { "value": "LV", "label": "Letonia" },
            { "value": "LB", "label": "L\u00EDbano" },
            { "value": "LR", "label": "Liberia" },
            { "value": "LY", "label": "Libia" },
            { "value": "LI", "label": "Liechtenstein" },
            { "value": "LT", "label": "Lituania" },
            { "value": "LU", "label": "Luxemburgo" },
            { "value": "MK", "label": "Macedonia" },
            { "value": "MG", "label": "Madagascar" },
            { "value": "MY", "label": "Malasia" },
            { "value": "MW", "label": "Malaui" },
            { "value": "MV", "label": "Maldivas" },
            { "value": "ML", "label": "Mali" },
            { "value": "MT", "label": "Malta" },
            { "value": "MA", "label": "Marruecos" },
            { "value": "MQ", "label": "Martinica" },
            { "value": "MU", "label": "Mauricio" },
            { "value": "MR", "label": "Mauritania" },
            { "value": "YT", "label": "Mayotte" },
            { "value": "FM", "label": "Micronesia" },
            { "value": "MD", "label": "Moldavia" },
            { "value": "MC", "label": "M\u00F3naco" },
            { "value": "MN", "label": "Mongolia" },
            { "value": "ME", "label": "Montenegro" },
            { "value": "MS", "label": "Montserrat" },
            { "value": "MZ", "label": "Mozambique" },
            { "value": "MM", "label": "Myanmar (Birmania)" },
            { "value": "NA", "label": "Namibia" },
            { "value": "NR", "label": "Nauru" },
            { "value": "NP", "label": "Nepal" },
            { "value": "NI", "label": "Nicaragua" },
            { "value": "NE", "label": "N\u00EDger" },
            { "value": "NG", "label": "Nigeria" },
            { "value": "NU", "label": "Niue" },
            { "value": "NO", "label": "Noruega" },
            { "value": "NC", "label": "Nueva Caledonia" },
            { "value": "NZ", "label": "Nueva Zelanda" },
            { "value": "OM", "label": "Om\u00E1n" },
            { "value": "NL", "label": "Pa\u00EDses Bajos" },
            { "value": "PK", "label": "Pakist\u00E1n" },
            { "value": "PW", "label": "Palaos" },
            { "value": "PA", "label": "Panam\u00E1" },
            { "value": "PG", "label": "Pap\u00FAa Nueva Guinea" },
            { "value": "PY", "label": "Paraguay" },
            { "value": "PE", "label": "Per\u00FA" },
            { "value": "PF", "label": "Polinesia Francesa" },
            { "value": "PL", "label": "Polonia" },
            { "value": "PT", "label": "Portugal" },
            { "value": "XA", "label": "Pseudo-Accents" },
            { "value": "XB", "label": "Pseudo-Bidi" },
            { "value": "PR", "label": "Puerto Rico" },
            { "value": "HK", "label": "RAE de Hong Kong (China)" },
            { "value": "MO", "label": "RAE de Macao (China)" },
            { "value": "GB", "label": "Reino Unido" },
            { "value": "CF", "label": "Rep\u00FAblica Centroafricana" },
            { "value": "CD", "label": "Rep\u00FAblica Democr\u00E1tica del Congo" },
            { "value": "RE", "label": "Reuni\u00F3n" },
            { "value": "RW", "label": "Ruanda" },
            { "value": "RO", "label": "Ruman\u00EDa" },
            { "value": "RU", "label": "Rusia" },
            { "value": "EH", "label": "S\u00E1hara Occidental" },
            { "value": "WS", "label": "Samoa" },
            { "value": "AS", "label": "Samoa Americana" },
            { "value": "BL", "label": "San Bartolom\u00E9" },
            { "value": "KN", "label": "San Crist\u00F3bal y Nieves" },
            { "value": "SM", "label": "San Marino" },
            { "value": "MF", "label": "San Mart\u00EDn" },
            { "value": "PM", "label": "San Pedro y Miquel\u00F3n" },
            { "value": "VC", "label": "San Vicente y las Granadinas" },
            { "value": "SH", "label": "Santa Elena" },
            { "value": "LC", "label": "Santa Luc\u00EDa" },
            { "value": "ST", "label": "Santo Tom\u00E9 y Pr\u00EDncipe" },
            { "value": "SN", "label": "Senegal" },
            { "value": "RS", "label": "Serbia" },
            { "value": "SC", "label": "Seychelles" },
            { "value": "SL", "label": "Sierra Leona" },
            { "value": "SG", "label": "Singapur" },
            { "value": "SX", "label": "Sint Maarten" },
            { "value": "SY", "label": "Siria" },
            { "value": "SO", "label": "Somalia" },
            { "value": "LK", "label": "Sri Lanka" },
            { "value": "ZA", "label": "Sud\u00E1frica" },
            { "value": "SD", "label": "Sud\u00E1n" },
            { "value": "SS", "label": "Sud\u00E1n del Sur" },
            { "value": "SE", "label": "Suecia" },
            { "value": "CH", "label": "Suiza" },
            { "value": "SR", "label": "Surinam" },
            { "value": "SJ", "label": "Svalbard y Jan Mayen" },
            { "value": "TH", "label": "Tailandia" },
            { "value": "TW", "label": "Taiw\u00E1n" },
            { "value": "TZ", "label": "Tanzania" },
            { "value": "TJ", "label": "Tayikist\u00E1n" },
            { "value": "IO", "label": "Territorio Brit\u00E1nico del Oc\u00E9ano \u00CDndico"},
            { "value": "TF", "label": "Territorios Australes Franceses" },
            { "value": "PS", "label": "Territorios Palestinos" },
            { "value": "TL", "label": "Timor-Leste" },
            { "value": "TG", "label": "Togo" },
            { "value": "TK", "label": "Tokelau" },
            { "value": "TO", "label": "Tonga" },
            { "value": "TT", "label": "Trinidad y Tobago" },
            { "value": "TA", "label": "Trist\u00E1n de Acu\u00F1a" },
            { "value": "TN", "label": "T\u00FAnez" },
            { "value": "TM", "label": "Turkmenist\u00E1n" },
            { "value": "TR", "label": "Turqu\u00EDa" },
            { "value": "TV", "label": "Tuvalu" },
            { "value": "UA", "label": "Ucrania" },
            { "value": "UG", "label": "Uganda" },
            { "value": "UY", "label": "Uruguay" },
            { "value": "UZ", "label": "Uzbekist\u00E1n" },
            { "value": "VU", "label": "Vanuatu" },
            { "value": "VN", "label": "Vietnam" },
            { "value": "WF", "label": "Wallis y Futuna" },
            { "value": "YE", "label": "Yemen" },
            { "value": "DJ", "label": "Yibuti" },
            { "value": "ZM", "label": "Zambia" },
            { "value": "ZW", "label": "Zimbabue" }  
        ]';
        return json_decode($countriesList);
    }

    protected function storeClient(Request $request){
         
        /*$request->validate([
            //model client
            'username' => 'required',
            'email' => 'required|unique:clients',
            'role' => 'required',
            'password' => 'required',
            'name' => 'required',
            'dni' => 'required|unique:users',
            'nationality' => 'required',
            'domicile' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'mobile' => 'required',
            'fax' => 'required',
        ]);*/
        
        $usersData= new User;
        $usersData->name = $request->input('name');
        $usersData->dni = $request->input('dni');
        $usersData->nationality = $request->input('nationality');
        $usersData->domicile = $request->input('domicile');
        $usersData->address = $request->input('address');
        //$usersData->fax = $request->input('fax')
        $usersData->save();

        $role = $request->input('role');
         
        $client = new Client();
        $client->username = $request->input('username');
        $client->email = $request->input('email');
        $client->role = $role;
        $client->password = Hash::make($request->input('password'));
        $client->user_id = $usersData->id;
        $client->save();

        $phone1 = $request->input('phone1');
        $newPhone1 = new Phone();
        $newPhone1->number = $phone1;
        $newPhone1->save();

        $phone2 = $request->input('phone2');
        $newPhone2 = new Phone();
        $newPhone2->number = $phone2;
        $newPhone2->save();
        
        $usersData->phones()->sync([$newPhone1->id, $newPhone2->id]);
        
        if ($role === 'juridica' ) {
           
            $institution = new Institution();
            $institution->name = $request->input('institution_name');
            $institution->rif = $request->input('rif');
            $institution->institutional_email = $request->input('institutional_email');
            $institution->client_id = $client->id;
            $institution->save();
        
            
            $phoneInstitution = $request->input('phone_institution');
            $newPhoneInstitution = new Phone();
            $newPhoneInstitution->number = $phoneInstitution;
            $newPhoneInstitution->save();

            $institution->phones()->attach($newPhoneInstitution->id);
        }

        Log::info('Se a registrado un nuevo solicitante con el DNI: '.$request->input('dni').'| Se a registrado en el sistema desde la direccion: '. request()->ip());
        return $this->login($request);
       
    }           

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = $request->only(["email","password"]);
        if ($token = $this->guard()->attempt($credentials)) {
            return $this->sendLoginResponse($request, $token);
        }
           
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request, $token)
    {
        //$this->clearLoginAttempts($request);
        Log::info('El solicitante '.$this->guard()->user()->username.'| A ingresado al sistema desde la siguente direccion: '. request()->ip());
        return $this->authenticated($request, $this->guard()->user(), $token);
    }

    protected function authenticated(Request $request, $user, $token)
    {
        setcookie("jwt_token", $token);
        return redirect('solicitante/permissions/list');
        return response()->json([
            'token' => $token,
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        Log::error('Fallo de autentificacion desde la siguente direccion: '. request()->ip());
        
        return redirect()->back()->with('errors', 'todo mal');
       //return redirect('/loginPermissions')->withErrors(['las credenciales no concuerdan con nuestra data']);
        return response()->json(['message' => "not found",], 401);
    }

    public function user()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        Log::info('El solicitante con el dni '.$this->returnUser().' a salido del sistema desde la siguente direccion: '. request()->ip());
        $this->guard()->logout();
        return redirect('/');
    }

    public function returnUser(){
        $user = Client::with('user')->where('user_id', '=', $this->guard()->user()->id)->get();
        foreach ($user as  $us) {
            return $us->user->dni;
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
    */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 18000
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

}
