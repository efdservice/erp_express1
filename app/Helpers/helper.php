<?php
namespace App\Helpers;

use App\Models\Accounts\ServiceProvidor;
use App\Models\Accounts\Transaction;
use App\Models\Item;
use App\Models\RiderItemPrice;
use App\Models\RoomType;
use App\Models\TransactionAccount;
use App\Models\VendorItemPrice;
use Carbon\Carbon;
use DB;
use Spatie\Permission\Models\Permission;
use Auth;

class CommonHelper
{

    public static function gender()
    {
        $list = '';
        $array = [1 => 'Male', 2 => 'Female', 3 => 'Other'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    //@passenger type adult, child, infant
    public static function pax_type()
    {
        $list = '';
        $array = [1 => 'Adult', 2 => 'Child', 3 => 'Infant'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    public static function martial_status()
    {
        $list = '';
        $array = [1 => 'Married', 2 => 'Single'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    //@emloyment status
    public static function emp_status()
    {
        $list = '';
        $array = [1 => 'Full Time', 2 => 'Part Time', 3 => 'Contrct'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    //@all service which uotrips offers
    public static function services()
    {
        $list = '';
        $array = [1 => 'Ticket', 2 => 'Hotel', 3 => 'Car', 'Bus', 'Umrah', 'Visa', 'Packages', 'Insurance', 'Hajh'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    //get services
    public static function get_services($ser)
    {
        $list = '';
        $array = [
            1 => 'Ticket',
            2 => 'Hotel',
            3 => 'Car',
            4 => 'Bus',
            5 => 'Umrah',
            6 => 'Visa',
            7 => 'Packages',
            8 => 'Insurance',
            9 => 'Hajh'
        ];
        foreach ($array as $key => $val) {
            if (in_array($key, $ser)) {
                $list .= $val . ', ';
            }
        }
        return rtrim($list, ', ');
    }
    //@all sources of query
    public static function query_source()
    {
        $list = '';
        $array = [
            'Personal',
            'Referral',
            'Telephone',
            'Client Meeting',
            'Email Marketing',
            'Waht\'s App',
            'Olx',
            'Other',
            'Agent'
        ];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . ($key + 1) . '">' . $val . '</option>';
        }
        return $list;
    }
    public static function get_query_source($source)
    {
        $array = [
            'Personal',
            'Referral',
            'Telephone',
            'Client Meeting',
            'Email Marketing',
            'Waht\'s App',
            'Olx',
            'Other',
            'Agent'
        ];
        foreach ($array as $key => $val) {
            if ($source == $key && $source != null) {
                return $val;
            } else {
                return 'online';
            }
        }
    }
    //@lead status
    public static function lead_status($status)
    {
        if ($status == 0) {
            return '<span class="badge bg-warning rounded-0">pending</span>';
        } elseif ($status == 1) {
            return '<span class="badge bg-info rounded-0">Taken Over</span>';
        } elseif ($status == 2) {
            return '<span class="badge bg-blue rounded-0">Process</span>';
        } elseif ($status == 3) {
            return '<span class="badge bg-success rounded-0">Successful</span>';
        } elseif ($status == 4) {
            return '<span class="badge bg-danger rounded-0">Unsuccessful</span>';
        }
    }
    //@serial number with 00 dsn=double serial numebr
    public static function dsn($no)
    {
        if ($no < 10) {
            return '00' . $no;
        } else {
            return $no;
        }
    }
    //@room type dropdown
    public static function room_type($id = 0)
    {
        return RoomType::dropdown($id);
    }
    //@visa types dropdown
    public static function visa_type()
    {
        $list = '';
        $array = [1 => 'visit', 2 => 'Hajh', 3 => 'Umrah', 4 => 'Ziyarat', 5 => 'Student', 6 => 'Employment'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    public static function get_visa_type($type)
    {
        $list = '';
        $array = [1 => 'visit', 2 => 'Hajh', 3 => 'Umrah', 4 => 'Ziyarat', 5 => 'Student', 6 => 'Employment'];
        foreach ($array as $key => $val) {
            if ($type == $key) {
                return $val;
            }
        }
    }

    //@vehicle types
    public static function vehicle_types($id = 0)
    {
        $list = '';
        $array = [
            1 => 'Coaster',
            2 => 'Gmc',
            3 => 'H1',
            4 => 'Limousine',
            5 => 'Private Car',
            6 => 'Sedan Car',
            7 => 'Sharing Bus',
            8 => 'SUV Car',
            9 => 'Haramain Train'
        ];
        foreach ($array as $key => $val) {
            $list .= '<option ' . (($key == $id) ? 'selected' : '') . ' value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    //@sale types
    public static function sale_types()
    {
        $list = '';
        $array = [1 => 'Ticket', 2 => 'Hotel', 3 => 'Visa', 4 => 'Transport', 5 => 'Other', 6 => 'Tour'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    //@get sale types form the current list
    public static function get_sale_type($type)
    {
        $list = '';
        $array = [1 => 'Ticket', 2 => 'Hotel', 3 => 'Visa', 4 => 'Transport', 5 => 'Other', 6 => 'Tour'];
        foreach ($array as $key => $val) {
            if ($type == $key) {
                return $val;
            }
        }
    }
    //@document types
    public static function doc_type()
    {
        $list = '';
        $array = [1 => 'passport', 2 => 'Id Card', 3 => 'Picture', 4 => 'Visa', 5 => 'Other'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }

    public static function get_warehouse($id = 0)
    {
        $array = [
            'Active' => 'Active',
            'Impound' => 'Impound',
            'City Garage' => 'City Garage',
            'Clutch Garage' => 'Clutch Garage',
            'Express Garage' => 'Express Garage',
            'Al Sama Garage' => 'Al Sama Garage',
            'Easy Lease Garage' => 'Easy Lease Garage',
            'Theft' => 'Theft',
            'Total Loss' => 'Total Loss',
            'Return' => 'Return'
        ];
        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }

    public static function get_sim_status($id = 0)
    {
        $array = ['Active' => 'Active', 'Office' => 'Office'];
        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }

    public static function get_supervisor($id = 0)
    {
        $array = [
            'Rusbeel Yousaf' => 'Rusbeel Yousaf',
            'Kaleem' => 'Kaleem',
            'Shakeel' => 'Shakeel',
            'Waqas Mehmood' => 'Waqas Mehmood',
            'Bashir Ahmad' => 'Bashir Ahmad',
            'Aysha Madam' => 'Aysha Madam',
            'Rithik Ram Naresh' => 'Rithik Ram Naresh',
            'Zuhair Iftikhar' => 'Zuhair Iftikhar'
        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }

    public static function get_passport_handover($id = 0)
    {
        $array = [
            'NON' => 'NON',
            'EFDS' => 'EFDS'
        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }
    public static function get_Ethnicity($id = 0)
    {
        $array = [
            'Muslim' => 'Muslim',
            'non-Muslim' => 'non-Muslim'
        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }

    public static function EmiratesHub($id = 0)
    {
        $array = [
            'DXB' => 'DXB',
            'AUH' => 'AUH',
            'UAQ' => 'UAQ',
            'RAK' => 'RAK',
            'SHJ' => 'SHJ',
            'FUJ' => 'FUJ',
            'AJM' => 'AJM'
        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }

    public static function Designations($id = 0)
    {
        $array = [
            'Rider' => 'Rider',
            'Staff' => 'Staff',
            'Driver' => 'Driver',
            'Mechanic' => 'Mechanic'
        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }
    public static function SalaryModel($id = 0)
    {
        $array = [
            '3000 Fix Salary' => '3000 Fix Salary',
            '3200 Fix Salary' => '3200 Fix Salary',
            '3500 Fix Salary' => '3500 Fix Salary',
            'Commission' => 'Commission'
        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }
    public static function WPS($id = 0)
    {
        $array = [
            'NON/WPS' => 'NON/WPS',
            'WPS' => 'WPS'
        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }
    public static function C3Card($id = 0)
    {
        $array = [
            'Cash' => 'Cash',
            'Active' => 'Active',
            'Block' => 'Block',
            'Pending' => 'Pending'
        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }
    public static function VisaStatus($id = 0)
    {
        $array = [
            'Express Fast Visa' => 'Express Fast Visa',
            'Temp Labour Card' => 'Temp Labour Card',
            'Pending Labor Card' => 'Pending Labor Card'
        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }

    public static function get_PaymentReason($id = 0)
    {
        $array = [
            'Monthly Salary' => 'Monthly Salary',
            'Advance Salary' => 'Advance Salary'


        ];

        $list = '';
        foreach ($array as $key => $value) {
            $list .= '<option ' . ($id == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return $list;

    }
    //@dropdown hotel start
    public static function hotel_star($id = 0)
    {
        $list = '';
        $array = [1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    //title
    public static function pax_title()
    {
        $list = '';
        $array = [1 => 'Mr', 2 => 'Miss', 3 => 'Mrs', 4 => 'Dr', 5 => 'His Excellency', 6 => 'His Royal Highness'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    public static function get_pax_title($title)
    {
        $array = [1 => 'Mr', 2 => 'Miss', 3 => 'Mrs', 4 => 'Dr', 5 => 'His Excellency', 6 => 'His Royal Highness'];
        foreach ($array as $key => $val) {
            if ($title == $key) {
                return $val;
            }
        }
    }
    //get vechile type
    public static function get_veh_types($id = 0)
    {
        $array = [
            1 => 'Coaster',
            2 => 'Gmc',
            3 => 'H1',
            4 => 'Limousine',
            5 => 'Private Car',
            6 => 'Sedan Car',
            7 => 'Sharing Bus',
            8 => 'SUV Car'
        ];
        foreach ($array as $key => $val) {
            if ($id == $key) {
                return $val;
            }

        }
    }
    //@room type dropdown
    public static function getroom_type($type)
    {
        $array = [
            1 => 'Single',
            2 => 'Double',
            3 => 'Triple',
            4 => 'Quad',
            5 => 'Quint',
            6 => '6 Bed',
            7 => '7 Bed',
            8 => '8 Bed',
            9 => '9 Bed',
            10 => '10 Bed',
            11 => 'Sharing',
            12 => 'Twin Bed',
            13 => 'Suit Room'
        ];
        foreach ($array as $key => $val) {
            if ($type == $key) {
                return $val;
            }
        }
    }
    //Mehram Relation
    public static function mehram_relation()
    {
        $list = '';
        $array = [
            1 => 'Son',
            2 => 'Father',
            3 => 'Brother',
            4 => 'Husband',
            5 => 'GrandFather',
            6 => 'Nephew',
            7 => 'Niece',
            8 => 'Women Group',
            9 => 'Grand Son',
            10 => 'Uncle (Mother side)',
            11 => 'Uncle (Father Side)',
            11 => 'Son In Law',
            12 => 'Step Father',
            13 => 'Father In Law',
            14 => 'Safe Companion'
        ];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    //passport type
    public static function passport_type()
    {
        $list = '';
        $array = [1 => 'Normal', 2 => 'Diplomatic', 3 => 'UN Passport', 4 => 'Other'];
        foreach ($array as $key => $val) {
            $list .= '<option value="' . $key . '">' . $val . '</option>';
        }
        return $list;
    }
    public static function get_passport_type($no)
    {
        $array = [1 => 'Normal', 2 => 'Diplomatic', 3 => 'UN Passport', 4 => 'Other'];
        foreach ($array as $key => $val) {
            if ($no == $key) {
                return $val;
            }
        }
    }
    //ground services additional informtion dropdown
    public static function additional_services()
    {
        $array = [
            'Baby Sitter',
            'Female Companion',
            'Male Companion',
            'Umrah Guidnace',
            'Wheel Chair',
            'Wheel Chair with Assistant',
            'Meet & Assist',
            'Tour Guide'
        ];
        $list = '';
        foreach ($array as $val) {
            $list .= '<option value="' . $val . '">' . $val . '</option>';
        }
        return $list;
    }
    //calculate age from date of birth
    public static function age($birth_date)
    {
        $birthDate = date('d-m-Y', strtotime($birth_date));
        $currentDate = date("d-m-Y");
        $diff = date_diff(date_create($birthDate), date_create($currentDate));
        return $diff->format('%y');
    }
    //count minutes from current time
    public static function count_minutes($time)
    {
        $startTime = Carbon::parse(date('Y-m-d h:i:s'));
        $endTime = Carbon::parse($time);

        $totalDuration = $endTime->diffForHumans($startTime);
        return $totalDuration;
    }
    /*
     * fetch visa detils agaist visa number
     */
    public static function get_visa_no($pn = '')
    {
        $visa_no = DB::table('agent_umrah_visitors')->where('passport', $pn)->value('visa');
        return $visa_no;
    }
    //print headers
    public static function print_header($title = '')
    {
        $html = '';
        $html .= '
            <div class="print-header" style="display: none">
                <h1 style="font-size: 16px;text-align: center">HUSSAIN INTERNATIONAL TRAVEL & TOURS</h1>
                <div style="text-align: center">
                    101, 1st Floor Trade Tower Abdullah Haroon Road, Saddar, Karachi<br>
                    Phone: 4298765432</br>
                    Email: sales@uotrips.co
                </div>
                <br>
                <table width="100%" style="font-family: sans-serif;line-height: 0.9">
                    <tr>
                        <td width="33.33%" style="text-align: left;"></td>
                        <td width="33.33%" style="text-align: center;">
                            <h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 14px;">
                                <span style="border-bottom:double">' . $title . '</span>
                            </h4>
                        </td>
                        <td width="33.33%" style="text-align: right;">
                            <img src="' . url('public/dist/img/hussain-logo.jpeg') . '" width="100" />
                        </td>
                    </tr>
                </table><br>
            </div>
        ';
        return $html;
    }
    //access left sidebar on the base of service providor
    public static function sp_access()
    {
        $result = ServiceProvidor::where('UID', Auth::user()->id)->first();
        return compact('result');
    }
    /*
     * find vendor item price
     */
    public static function vendorItemPrice($VID, $itemID)
    {
        $res = VendorItemPrice::where('VID', $VID)->where('item_id', $itemID)->first();
        if ($res && $res->price > 0) {
            return $res->price;
        } else {
            $res = Item::where('id', $itemID)->first();
            return $res->pirce;
        }
    }
    /*
     * find rider item price
     */
    public static function riderItemPrice($RID, $itemID)
    {
        $res = RiderItemPrice::where('RID', $RID)->where('item_id', $itemID)->first();
        if ($res && $res->price > 0) {
            return $res->price;
        } else {
            return Item::where('id', $itemID)->value('pirce');
        }
    }
    public static function inv_sch($inv, $date)
    {
        $df = date('ym', strtotime($date));
        $inv = self::dsn($inv);
        $str = 'inv-' . $df . '-' . $inv;
        return $str;
    }

    public static function file_types($id = null)
    {

        $types = [

            1 => 'Emirates ID',
            2 => 'Passport',
            3 => 'Visa',
            4 => 'Rider Contract',
            5 => 'Health Insurance',
            7 => 'RTA Road Permit',
            8 => 'CNIC (Pakistani)',
            9 => 'Driving License',
            10 => 'Labor Card',
            11 => 'NOC (Employer)'
        ];
        if ($id) {
            return $types[$id];
        } else {
            return $types;
        }

    }

    public static function RiderStatus($status = null)
    {
        $result = [
            1 => 'Active',
            2 => 'Vacation',
            3 => 'Terminate',
            4 => 'Theft',
            5 => 'Absconded',
            6 => 'Stop Salary',
            7 => 'Coming'

        ];

        if ($status != null) {
            return $result[$status];
        } else {
            return $result;
        }
    }


    public static function getBalance($trans_acc_id)
    {
        $dr = Transaction::where('trans_acc_id', $trans_acc_id)->where('dr_cr', 1)->sum('amount');
        $cr = Transaction::where('trans_acc_id', $trans_acc_id)->where('dr_cr', 2)->sum('amount');
        return number_format($cr - $dr, 2);
    }

    public static function BillingMonth($month = null)
    {
        for ($i = 0; $i <= 11; $i++) {
            $value = date("M-Y", strtotime(date('Y-m-01') . " -$i months"));
            $key = date("Y-m-01", strtotime(date('Y-m-01') . " -$i months"));
            $months[$key] = $value;
        }
        if ($month) {
            return $months[$month];
        } else {
            return $months;

        }
    }

    public static function VoucherType($type = null)
    {
        $result = [
            3 => 'Journal Voucher',
            5 => 'Invoice Voucher',
            9 => 'Vendor Voucher',
            10 => 'Bike Rent Voucher',
            11 => 'Fuel Voucher',
            8 => 'RTA Fine Voucher',
            12 => 'Advance/Loan Voucher',
            /*             13 => 'Advance Repay Voucher',
             */
            14 => 'Expense Voucher',
            15 => 'Maintenance Voucher',
            16 => 'COD Voucher',
        ];

        if ($type) {
            return $result[$type];
        } else {
            return $result;

        }
    }
    public static function ImportVoucherType($type = null)
    {
        $result = [
            /* 3 => 'Journal Voucher',
            5 => 'Invoice Voucher', */
            9 => 'Vendor Voucher',
            /* 10 => 'Bike Rent Voucher', */
            11 => 'Fuel Voucher',
            8 => 'RTA Fine Voucher',
            /*  12 => 'Advance/Loan Voucher', */
            /*             13 => 'Advance Repay Voucher',
             */
            /*  14 => 'Expense Voucher', */
            15 => 'Maintenance Voucher',
        ];

        if ($type) {
            return $result[$type];
        } else {
            return $result;

        }
    }

    public static function LoanTerms($type = null)
    {
        $result = [
            'Monthly' => 'Monthly',
            'Weekly' => 'Weekly'
        ];

        if ($type) {
            return $result[$type];
        } else {
            return $result;

        }
    }

}
