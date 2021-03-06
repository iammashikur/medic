<?php

use App\Models\Agent;
use App\Models\AgentSetting;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorLocation;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\PatientTest;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;


function sendNotificationToSubsciber($title, $desc, $user_type, $p_cat_image = "")
{
    $content      = array(
        "en" => $desc,
    );
    $headings = array(
        "en" => $title,
    );

    $hashes_array = array();

    array_push($hashes_array, array(
        "id" => "like-button",
        "text" => "Like",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com"
    ));

    array_push($hashes_array, array());

    $fields = array(
        'app_id' => env('ONESIGNAL_APP_ID'), // env
        'included_segments' => array($user_type),
        // 'data' => array(
        //     "post_type" => "" ,
        //     "id" => "" ,
        // ),
        'contents' => $content,
        'headings' => $headings,
        'big_picture' => $p_cat_image

    );

    $fields = json_encode($fields);
    print("\nJSON sent:\n");




    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . env('ONESIGNAL_API_KEY') //env
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
}

function sendNotificationToUser($title, $desc, $user_type, $include_player_ids, $p_cat_image = "")
{
    $content      = array(
        "en" => $desc,
    );
    $headings = array(
        "en" => $title,
    );

    $hashes_array = array();

    array_push($hashes_array, array(
        "id" => "like-button",
        "text" => "Like",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com"
    ));

    array_push($hashes_array, array());

    $fields = array(
        'app_id' => env('ONESIGNAL_APP_ID'), // env
        'contents' => $content,
        'include_player_ids' => array($include_player_ids),
        'headings' => $headings,
        'big_picture' => $p_cat_image

    );

    $fields = json_encode($fields);
    print("\nJSON sent:\n");




    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . env('ONESIGNAL_API_KEY') //env
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
}



// Active Menu Button

function MenuActive($segment, $match)
{
    if (request()->segment($match) == $segment) {
        return 'active';
    }
}


function MakeImage(Request $request, $fileName, $path)
{
    /**
     * Image resizing and saving in defined dirs
     */
    if ($request->hasFile($fileName)) {
        $image = $request->file($fileName);
        // Extension
        $imageExt = $image->extension();
        // Changing the file name
        $FullImageName = time() . '-' . uniqid() . '.' . $imageExt;
        // intervention Make image
        $imageResize = Image::make($image->getRealPath());
        // local store path
        $fullPath = $path . $FullImageName;
        // saving image
        $imageResize->save($fullPath);

        return $FullImageName;
    }
}


function getName($type, $id)
{
    switch ($type) {
        case 'medic':
            return 'Medic';
            break;
        case 'agent':
            return Agent::find($id)->name;
            break;
        case 'patient':
            return Patient::find($id)->name;
            break;
        case 'doctor':
            return Doctor::find($id)->name;
            break;
        case 'hospital':
            return Hospital::find($id)->name;
            break;
    }
}

// Percentage
$percentToAmount = fn ($amount, $percent) => ($percent / 100) * $amount;


// Payment
function appointmentPay($appointmentId, $location, $agent = null)
{


    if ($agent !== null) {
        $agentCommission  = @Agent::find($agent)->commission ? @Agent::find($agent)->commission : AgentSetting::first()->default_commission;
    } else {
        $agentCommission = 0;
    }


    // test var
    $appointmentFee = @DoctorLocation::find($location)->consultation_fee ? @DoctorLocation::find($location)->consultation_fee : 0;
    $patientDiscount  = @Doctor::find(DoctorLocation::find($location)->doctor_id)->discount ? @Doctor::find(DoctorLocation::find($location)->doctor_id)->discount : 0;
    $medicCommission  = @Doctor::find(DoctorLocation::find($location)->doctor_id)->commission ? @Doctor::find(DoctorLocation::find($location)->doctor_id)->commission : 0;

    $q = ($appointmentFee * $medicCommission) / 10000;
    $x = floor($patientDiscount * $q);
    $amountToPay = $appointmentFee - $x;

    $agentGets = ceil($q * $agentCommission);
    $medicGets = ceil($q * 100) - $x - $agentGets;
    $doctorGets  = $amountToPay - ($medicGets + $agentGets);




    // Doctor to Medic
    $medicGetsInsert = new Wallet();
    $medicGetsInsert->amount = $medicGets;
    $medicGetsInsert->user_type = 'medic';
    $medicGetsInsert->account_holder = 'Medic';
    $medicGetsInsert->user_id = DoctorLocation::find($location)->doctor_id;
    $medicGetsInsert->transaction_type = '+';
    $medicGetsInsert->appointment_id = $appointmentId;
    $medicGetsInsert->status = 0;



    $medicGetsInsert->save();

    // Doctor
    $medicGetsInsert = new Wallet();
    $medicGetsInsert->amount = $doctorGets;
    $medicGetsInsert->user_type = 'doctor';
    $medicGetsInsert->user_id = DoctorLocation::find($location)->doctor_id;
    $medicGetsInsert->account_holder = Doctor::find(DoctorLocation::find($location)->doctor_id)->name;
    $medicGetsInsert->transaction_type = '+';
    $medicGetsInsert->appointment_id = $appointmentId;
    $medicGetsInsert->status = 0;
    $medicGetsInsert->save();

    // Patient Wallet
    $medicGetsInsert = new Wallet();
    $medicGetsInsert->amount = $appointmentFee - $amountToPay;
    $medicGetsInsert->user_type = 'patient';
    $medicGetsInsert->user_id = Appointment::find($appointmentId)->patient_id;
    $medicGetsInsert->account_holder = Patient::find(Appointment::find($appointmentId)->patient_id)->name;
    $medicGetsInsert->transaction_type = '+';
    $medicGetsInsert->appointment_id = $appointmentId;
    $medicGetsInsert->status = 0;
    $medicGetsInsert->save();


    if ($agentGets > 0) {
        $medicGetsInsert = new Wallet();
        $medicGetsInsert->amount = $agentGets;
        $medicGetsInsert->user_type = 'agent';
        $medicGetsInsert->user_id = $agent;
        $medicGetsInsert->account_holder = Agent::find($agent)->name;
        $medicGetsInsert->transaction_type = '+';
        $medicGetsInsert->appointment_id = $appointmentId;
        $medicGetsInsert->status = 0;
        $medicGetsInsert->save();
    }

    return [
        'main_price'   => $appointmentFee,
        'patient_paid' => $amountToPay,
        'doctor_earned' => $doctorGets,
        'medic_earned' => $medicGets,
        'agent_earned' => $agentGets,
    ];
}


// Payment
function testPay($testCategory, $test_price, $test_id, $agent = null)
{


    if ($agent !== null) {
        $agentCommission  = @Agent::find($agent)->commission ? @Agent::find($agent)->commission : AgentSetting::first()->default_commission;
    } else {
        $agentCommission = 0;
    }

    // test var
    $testFee = $test_price;
    $patientDiscount  = @$testCategory->discount ? $testCategory->discount : 0;
    $medicCommission  = @$testCategory->commission ? $testCategory->commission : 0;

    $q = ($testFee * $medicCommission) / 10000;
    $x = floor($patientDiscount * $q);
    $amountToPay = $testFee - $x;

    $agentGets = ceil($q * $agentCommission);
    $medicGets = ceil($q * 100) - $x - $agentGets;
    $hospitalGets  = $amountToPay - ($medicGets + $agentGets);

    //Test to Medic
    $medicGetsInsert = new Wallet();
    $medicGetsInsert->amount = $medicGets;
    $medicGetsInsert->user_type = 'medic';
    $medicGetsInsert->user_id = $testCategory->hospital_id;
    $medicGetsInsert->account_holder = 'Medic';
    $medicGetsInsert->transaction_type = '+';
    $medicGetsInsert->test_id = $test_id;
    $medicGetsInsert->status = 0;
    $medicGetsInsert->save();

    // Doctor
    $medicGetsInsert = new Wallet();
    $medicGetsInsert->amount = $hospitalGets;
    $medicGetsInsert->user_type = 'hospital';
    $medicGetsInsert->user_id = $testCategory->hospital_id;
    $medicGetsInsert->account_holder = Hospital::find($testCategory->hospital_id)->name;
    $medicGetsInsert->transaction_type = '+';
    $medicGetsInsert->test_id = $test_id;
    $medicGetsInsert->status = 0;
    $medicGetsInsert->save();

    // Patient
    $medicGetsInsert = new Wallet();
    $medicGetsInsert->amount = $x;
    $medicGetsInsert->user_type = 'patient';
    $medicGetsInsert->user_id = PatientTest::find($test_id)->patient_id;
    $medicGetsInsert->account_holder = Patient::find(PatientTest::find($test_id)->patient_id)->name;
    $medicGetsInsert->transaction_type = '+';
    $medicGetsInsert->test_id = $test_id;
    $medicGetsInsert->status = 0;
    $medicGetsInsert->save();




    if ($agentGets > 0) {
        $medicGetsInsert = new Wallet();
        $medicGetsInsert->amount = $agentGets;
        $medicGetsInsert->user_type = 'agent';
        $medicGetsInsert->user_id = $agent;
        $medicGetsInsert->account_holder = Agent::find($agent)->name;
        $medicGetsInsert->transaction_type = '+';
        $medicGetsInsert->test_id = $test_id;
        $medicGetsInsert->status = 0;
        $medicGetsInsert->save();
    }

    return [

        'main_price'   => $testFee,
        'patient_paid' => $amountToPay,
        'hospital_earned' => $hospitalGets,
        'medic_earned' => $medicGets,
        'agent_earned' => $agentGets,
    ];
}

function withdrawBalance($type, $id)
{
    return Wallet::where(['user_type' => $type, 'user_id' => $id, 'transaction_type' => '-', 'status' => 1])->sum('amount');
}

function alltimeBalance($type, $id)
{
    return Wallet::where(['user_type' => $type, 'user_id' => $id, 'transaction_type' => '+', 'status' => 1])->sum('amount');
}

function currentBalance($type, $id)
{

    $credit =  Wallet::where(['user_type' => $type, 'user_id' => $id, 'transaction_type' => '+', 'status' => 1])->sum('amount');
    $debit  =  Wallet::where(['user_type' => $type, 'user_id' => $id, 'transaction_type' => '-', 'status' => 1])->sum('amount');
    return $credit - $debit;
}

function medicBalance()
{
    return Wallet::where(['user_type' => 'medic', 'transaction_type' => '+', 'status' => 1])->sum('amount');
}


function doctorRevenue()
{
    return Wallet::where(['user_type' => 'doctor', 'transaction_type' => '+', 'status' => 1])->sum('amount');
}


function hospitalRevenue()
{
    return Wallet::where(['user_type' => 'hospital', 'transaction_type' => '+', 'status' => 1])->sum('amount');
}

function agentRevenue()
{
    return Wallet::where(['user_type' => 'agent', 'transaction_type' => '+', 'status' => 1])->sum('amount');
}
