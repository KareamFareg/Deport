<?php

namespace App\Traits;

trait GeneralTrait
{


    
    public function returnError($errNum, $msg)
    {
        return response()->json([
            'code' => 200,
            'status' => "error",
            'message' => $msg,
            'data' => [],
        ]);
    }


    public function returnSuccessMessage($msg = "", $errNum = "S000")
    {
        return [
            'code' => 200,
            'status' => "success",
            'message' => $msg,
            'data' => [],
        ];
    }

    public function returnData($key, $value, $msg = "")
    {
        return response()->json([
            'code' => "S000",
            'status' => "success",
            'message' => $msg,
            'data' =>  [$key => $value]
        ]);
    }


    //////////////////
    public function returnValidationError($code, $validator)
    {
        return $this->returnError($code, $validator->errors()->first());
    }


    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }


    public static function getErrorCode($input)
    {
        if ($input == 2)
            return 'NotFound';

        else if ($input == 3)
            return 'Not Authorized';

        else if ($input == 5)
            return 'Invalid Credential';

        else if ($input == 7)
            return 'Identity Type Id Required';

        else if ($input == 8)
            return 'Id Number Required';

        else if ($input == 9)
            return 'Date Of Birth Required';

        else if ($input == 10)
            return 'Registration Date Required';

        else if ($input == 11)
            return 'Mobile Required';

        else if ($input == 12)
            return 'Region Id Required';

        else if ($input == 13)
            return 'City Id Required';

        else if ($input == "min_degree")
            return 'E011';

        else if ($input == 14)
            return 'Car Type Required';

        else if ($input == 15)
            return 'Car Number Required';

        else if ($input == 16)
            return 'Invalid Nationality Id';

        else if ($input == 17)
            return 'Invalid Identity Type Id';

        else if ($input == 18)
            return 'Invalid Region Id';

        else if ($input == 19)
            return 'Invalid City Id';

        else if ($input == 20)
            return 'Invalid Id Number';

        else if ($input == 21)
            return 'Invalid Driver Id ';

        else if ($input == 22)
            return 'City Doesnt Belong To Region ';

        else if ($input == 23)
            return 'Number Required';

        else if ($input == 24)
            return 'Authority Id Required';

        else if ($input == 25)
            return 'Category Id Required';

        else if ($input == 26)
            return 'Delivery Time Required';

        else if ($input == 27)
            return 'Invalid Authority Id';

        else if ($input == 28)
            return 'Invalid Category Id';

        else if ($input == 29)
            return 'Invalid Order Id';

        else if ($input == 36)
            return 'Empty Entries';

        else if ($input == 37)
            return 'Invalid Cancellation Reason Id';

        else if ($input == 38)
            return 'Coordinates Required';

        else if ($input == 39)
            return 'Payment Method Id Required';

        else if ($input == 40)
            return 'Price Required';

        else if ($input == 42)
            return 'Invalid Payment Method Id';

        else if ($input == 44)
            return 'MoiInvalidIdentity';

        else if ($input == 45)
            return 'Invalid Car Type Id';

        else if ($input == 47)
            return 'Driver Already Exist';

        else if ($input == 48)
            return 'Validate Duplicate Error';

        else if ($input == 49)
            return 'Nationality And IdNumber And Identity Type Cannot Be Changed';

        else if ($input == 50)
            return 'StoretNamed Required';

        else if ($input == 51)
            return 'Store Location Required';

        else if ($input == 52)
            return 'Order Can not Be Accepted';

        else if ($input == 53)
            return 'Order Cannot Be Canceled';

        else if ($input == 54)
            return 'Order Did not Accepted Yet ';

        else if ($input == 55)
            return 'Update Drivery Address Cannot Be Done';

        else if ($input == 56)
            return 'Refrence Code Required';

        else if ($input == 57)
            return 'Driver Must Be Assigned First ';

        else if ($input == 58)
            return 'Order Number Already Created Today';

        else if ($input == 59)
            return 'Invalid Order Number';

        else if ($input == 60)
            return 'Mobile Number Take Only 10 Digits';

        else if ($input == 61)
            return 'Date Of Birth Doesnt Match NICRecords';

        else if ($input == 62)
            return 'Identity Schema Validation Error ';

        else if ($input == 65)
            return 'Date Of Birth Must Be 8 Digits';

        else if ($input == 66)
            return 'Order Date Required';

        else if ($input == 67)
            return 'Acceptance Date Wrong ';

        else if ($input == 68)
            return 'Excution Time Wrong';
        else if ($input == 69)
            return 'Order Cannot Be Created Exceded Time Limits';
        else if ($input == 70)
            return 'Oder CanNot Be Executed More Than Once';

        else if ($input == 71)
            return 'Only Accepted Orders Can Be Executed ';

        else if ($input == 72)
            return 'Assigned Drivers Can Be Done Only For Accepted Order';
        else if ($input == 73)
            return 'Execution Time Cannot Be Earlier Than Order Date';

        else if ($input == 74)
            return 'Driver Already Assigned To This Order';
        else if ($input == 75)
            return 'Execution Time Must Be Greater Than Assigning Time';
       else if ($input == 76)
            return 'Driver Is Pending Approval';
        else if ($input == 77)
            return 'Order Cannot Be Rejected';
        else if ($input == 79)
            return 'Acceptance Date Time Cannot Be Earlier Than Order Date';
        else if ($input == 80)
            return 'Id NUmber Expired ';
        else if ($input == 81)
            return 'Invalid Birth date Format';
      else if ($input == 82)
            return 'Driver younger than 18';
        else if ($input == 83)
            return 'Covid19 Active';
        else if ($input == 84)
            return 'Driver Not Healthy';
        else if ($input == 85)
            return 'Vehicle Sequence Number Required';
        else if ($input == 86)
            return 'Invalid Vehicle Sequence Number';
       else if ($input == 87)
            return 'Vehicle License Is Expired ';
        else if ($input == 88)
            return 'Vehicle MVPI Is Expired';
        else if ($input == 89)
            return 'Driver Is Not Authorized For Vehicle';
        else if ($input == 90)
            return 'Driving License Is Expired';
        else if ($input == 91)
            return 'Driver Is Accompanying';
       else if ($input == 92)
            return 'Prohibited Occupation';
        else if ($input == 93)
            return 'Order Has Been Closed';
        else if ($input == 94)
            return 'Not Vaccinated Against Covid19';
            if ($input == "name")
            return 'E0011';

        else if ($input == "password")
            return 'E002';

        else if ($input == "mobile")
            return 'E003';

        else if ($input == "id_number")
            return 'E004';

        else if ($input == "details")
            return 'E005';

        else if ($input == "year")
            return 'E006';

        else if ($input == "email")
            return 'E007';

        else if ($input == "semester")
            return 'E008';

        else if ($input == "max_degree")
            return 'E009';

        else if ($input == "image")
            return 'E010';

        else if ($input == "min_degree")
            return 'E011';

        else if ($input == "content")
            return 'E012';

        else if ($input == "id")
            return 'E013';

        else if ($input == "images")
            return 'E014';

        else if ($input == "section_id")
            return 'E015';

        else if ($input == "instructor")
            return 'E016';

        else if ($input == "subject")
            return 'E017';

        else if ($input == "specification_id")
            return 'E018';

        else if ($input == "importance")
            return 'E019';

        else if ($input == "type")
            return 'E020';

        else if ($input == "message")
            return 'E021';

        else if ($input == "reservation_no")
            return 'E022';

        else if ($input == "reason")
            return 'E023';

        else if ($input == "branch_no")
            return 'E024';

        else if ($input == "name_en")
            return 'E025';

        else if ($input == "name_ar")
            return 'E026';

        else if ($input == "gender")
            return 'E027';

        else if ($input == "nickname_en")
            return 'E028';

        else if ($input == "nickname_ar")
            return 'E029';

        else if ($input == "rate")
            return 'E030';

        else if ($input == "price")
            return 'E031';

        else if ($input == "information_en")
            return 'E032';

        else if ($input == "information_ar")
            return 'E033';

        else if ($input == "street")
            return 'E034';

        else if ($input == "branch_id")
            return 'E035';

        else if ($input == "insurance_companies")
            return 'E036';

        else if ($input == "photo")
            return 'E037';

        else if ($input == "logo")
            return 'E038';

        else if ($input == "working_days")
            return 'E039';

        else if ($input == "insurance_companies")
            return 'E040';

        else if ($input == "reservation_period")
            return 'E041';

        else if ($input == "nationality_id")
            return 'E042';

        else if ($input == "commercial_no")
            return 'E043';

        else if ($input == "nickname_id")
            return 'E044';

        else if ($input == "reservation_id")
            return 'E045';

        else if ($input == "attachments")
            return 'E046';

        else if ($input == "summary")
            return 'E047';

        else if ($input == "user_id")
            return 'E048';

        else if ($input == "mobile_id")
            return 'E049';

        else if ($input == "paid")
            return 'E050';

        else if ($input == "use_insurance")
            return 'E051';

        else if ($input == "doctor_rate")
            return 'E052';

        else if ($input == "provider_rate")
            return 'E053';

        else if ($input == "message_id")
            return 'E054';

        else if ($input == "hide")
            return 'E055';

        else if ($input == "checkoutId")
            return 'E056';

        else
            return "Successful transaction";
    }


}
