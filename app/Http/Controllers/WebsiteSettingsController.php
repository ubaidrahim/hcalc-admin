<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use App\Traits\ImageStore;

class WebsiteSettingsController extends Controller
{
    use ImageStore;
    public function index()
    {
        $countries = [
            "Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia",
            "Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium",
            "Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria",
            "Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Central African Republic","Chad",
            "Chile","China","Colombia","Comoros","Congo (Congo-Brazzaville)","Costa Rica","Croatia","Cuba","Cyprus",
            "Czechia (Czech Republic)","Democratic Republic of the Congo","Denmark","Djibouti","Dominica",
            "Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini",
            "Ethiopia","Fiji","Finland","France","Gabon","Gambia","Georgia","Germany","Ghana","Greece","Grenada",
            "Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Holy See","Honduras","Hungary","Iceland","India",
            "Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya",
            "Kiribati","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein",
            "Lithuania","Luxembourg","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands",
            "Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Morocco",
            "Mozambique","Myanmar (Burma)","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger",
            "Nigeria","North Korea","North Macedonia","Norway","Oman","Pakistan","Palau","Palestine State","Panama",
            "Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda",
            "Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino",
            "Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore",
            "Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain",
            "Sri Lanka","Sudan","Suriname","Sweden","Switzerland","Syria","Tajikistan","Tanzania","Thailand",
            "Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda",
            "Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan",
            "Vanuatu","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"
        ];
        $timezones = \DateTimeZone::listIdentifiers();
        $today = now();
        $formats = [
            'd M, Y'     => $today->format('d M, Y'),       // 17 May, 2019
            'jS M, Y'    => $today->format('jS M, Y'),      // 17th May, 2019
            'Y-m-d'      => $today->format('Y-m-d'),        // 2019-05-17
            'm/d/Y'      => $today->format('m/d/Y'),        // 05/17/2019
            'd/m/Y'      => $today->format('d/m/Y'),        // 17/05/2019
            'D, d M Y'   => $today->format('D, d M Y'),     // Fri, 17 May 2019
            'l, jS F Y'  => $today->format('l, jS F Y'),    // Friday, 17th May 2019
        ];
        return view('website.index',get_defined_vars());
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $content = WebsiteSetting::where('key',$key)->first();
            if(!$content)
            {
                $content = new WebsiteSetting();
                $content->key = $key;
            }
            if($request->hasFile($key))
            {
              $content->value = $this->saveImage($value);  
            }
            else{
                $content->value = $value ?? '';
            }
            $content->save();
        }
        return response()->json(['success' => true, 'message' => 'Settings Saved', 'goto' => route('settings.website.index')]);
    }

    public function updateImages(Request $request){
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $content = WebsiteSetting::where('key',$key)->first();
            $path = $this->saveImage($value);
            updateWebsiteSetting($key,$path,1);
        }
        return response()->json(['success' => true, 'message' => 'Image Updated.']);
    }
    public function removeSetting(Request $request){
        $data = $request->name;
        if($data){
            updateWebsiteSetting($data,'',1);
            return response()->json(['success' => true, 'message' => 'Setting Removed.']);
        }else{
            return response()->json(['success' => false, 'msg' => 'Something went wrong!']);
        }
    }
}
