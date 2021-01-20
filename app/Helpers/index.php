<?php
//For Login user Role and when create admin set role
use Illuminate\Support\Facades\File;

if (!function_exists('serviceGroup')) {
    function serviceGroup()
    {
        return ['Hourly', 'Daily', 'Tour Package', 'Airport Transfer', 'Inter District'];
    }
}

//For Payment type status
if (!function_exists('paymentType')) {
    function paymentType($key)
    {
        $array = [0 => 'Pending', 1 => 'Paid', 2 => 'Cancel', 3 => 'Fail'];
        return $array[$key];
    }
}

//For Login user Role and when create admin set role
if (!function_exists('timeOption')) {
    function timeOption()
    {
        $timeOption = [];
        for ($i = 0; $i < 24; $i++) {
            $amPM = ($i >= 12) ? 'PM' : 'AM';
            $h = ($i == 0) ? 12 : (($i > 12) ? ($i - 12) : $i);

            foreach (['00', '30'] as $j) {
                $timeOption[] = $h . ':' . $j . ' ' . $amPM;
            }
        }
        return $timeOption;
    }
}


//For Login user Role and when create admin set role
if (!function_exists('accountType')) {
    function accountType($key = null)
    {
        $array = ['2' => 'Administrator', '3' => 'Manager', '4' => 'Agent'];
        if ($key) {
            return (array_key_exists($key, $array)) ? $array[$key] : '-';
        }
        return $array;
    }
}

if (!function_exists('district')) {
    function district()
    {
        return [
            "Barisal" => ["Barguna", "Barisal", "Bhola", "Jhalokati", "Patuakhali", "Pirojpur"],
            "Chittagong" => ["Bandarban", "Brahmanbaria", "Chandpur", "Chittagong", "Comilla", "Cox's Bazar", "Feni", "Khagrachhari", "Lakshmipur", "Noakhali", "Rangamati"],
            "Dhaka" => ["Dhaka", "Faridpur", "Gazipur", "Gopalganj", "Kishoreganj", "Madaripur", "Manikganj", "Munshiganj", "Narayanganj", "Narsingdi", "Rajbari", "Shariatpur", "Tangail"],
            "Khulna" => ["Bagerhat", "Chuadanga", "Jessore", "Jhenaidah", "Khulna", "Kushtia", "Magura", "Meherpur", "Narail", "Satkhira"],
            "Mymensingh" => ["Jamalpur", "Mymensingh", "Netrakona", "Sherpur"],
            "Rajshahi" => ["Bogra", "Chapainawabganj", "Joypurhat", "Naogaon", "Natore", "Pabna", "Rajshahi", "Sirajganj"],
            "Rangpur" => ["Dinajpur", "Gaibandha", "Kurigram", "Lalmonirhat", "Nilphamari", "Panchagarh", "Rangpur", "Thakurgaon"],
            "Sylhet" => ["Habiganj", "Moulvibazar", "Sunamganj", "Sylhet"]
        ];
    }
}

if (!function_exists('roleAccess')) {
    function roleAccess($role)
    {
        return true;
    }
}

//Nice Print Array
if (!function_exists('dumpvar')) {
    function dumpvar($array)
    {
        echo '<pre>';
        print_r($array);
    }
}

//Delete existing file
if (!function_exists('deleteFile')) {
    function deleteFile($path, $name)
    {
        if ($name != '' && file_exists($path . '/' . $name)) {
            unlink($path . '/' . $name);
        }
    }
}

//Search string get and set an url
if (!function_exists('qString')) {
    function qString($query = null)
    {
        if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) {
            return '?' . $_SERVER['QUERY_STRING'] . $query;
        } else {
            if ($query) {
                return '?' . $query;
            }
        }
    }
}

//Make url slug
if (!function_exists('urlSlug')) {
    function urlSlug($text)
    {
        $text = str_replace(' ', '-', $text);
        $text = preg_replace('/[^A-Za-z0-9\-]/', '', $text);
        $text = trim($text);
        $text = str_replace('--', '-', $text);
        return strtolower($text);
    }
}

//Date View
if (!function_exists('dateFormat')) {
    function dateFormat($date, $time = null)
    {
        if ($time) {
            return date('d/M/Y h:i A', (strtotime($date)));
        } else {
            return date('d/M/Y', strtotime($date));
        }
    }
}

//Time View
if (!function_exists('timeFormat')) {
    function timeFormat($date)
    {
        return date('h:i A', (strtotime($date)));
    }
}

//Two Digit Number Format Function
if (!function_exists('numberFormat')) {
    function numberFormat($amount = 0, $coma = null)
    {
        if ($coma) {
            if ($amount == 0)
                return '-';
            else
                return number_format($amount, 2);
        } else {
            return number_format($amount, 2, '.', '');
        }
    }
}

//Two Digit Number Format Function
if (!function_exists('excerpt')) {
    function excerpt($text, $limit = 200)
    {
        if (strlen(strip_tags($text)) > $limit) {
            return substr(strip_tags($text), 0, $limit) . '...';
        } else {
            return strip_tags($text);
        }
    }
}

//For image view if image exists with lightbox (yes/no).
//['thumb' => 1, 'popup' => 1, 'class' => '', 'style' =>'', 'fakeimg' => 'avatar']
if (!function_exists('viewImg')) {
    function viewImg($path, $name, $array = null)
    {
        $thumb = (isset($array['thumb'])) ? 'thumb_' : '';
        $class = (isset($array['class'])) ? 'class="' . $array['class'] . '"' : '';
        $style = (isset($array['style'])) ? 'style="' . $array['style'] . '"' : '';
        $title = (isset($array['title'])) ? $array['title'] : '';

        if ($name != '' && Storage::exists('public/' . $path . '/' . $thumb . $name)) {
            $url = Storage::url('public/' . $path . '/' . $thumb . $name);
            if (isset($array['popup'])) {
                return '<a href="' . $url . '" data-fancybox="group" data-fancybox data-caption="' . $title . '" class="lytebox" data-lyte-options="group:vacation"><img src="' . $url . '" alt="' . $title . '" ' . $class . ' ' . $style . '></a>';
            } else {
                return '<img src="' . $url . '" alt="' . $title . '" ' . $class . ' ' . $style . '>';
            }
        } else {
            if (isset($array['fakeimg'])) {
                return '<img src="' . url('/admin-assets/img/' . $array['fakeimg']) . '.png" alt="' . $array['fakeimg'] . '" ' . $class . ' ' . $style . '>';
            } else {
                return '';
            }
        }
    }
}

//For file view
if (!function_exists('viewFile')) {
    function viewFile($path, $name)
    {
        if ($name != '' && file_exists($path . '/' . $name)) {
            $path = url('/' . $path) . '/';
            return '<a href="' . $path . $name . '" target="_blank">' . $name . '</a>';
        } else {
            return '';
        }
    }
}

//Default Text: (If Data not Found)
if (!function_exists('notFoundText')) {
    function notFoundText($text = null)
    {
        $text = ($text) ? $text : 'Data Not Found.';
        return '<div class="row">
            <div class="col-md-12 text-center"><strong><h3>' . $text . '</h3></strong></div>
        </div>';
    }
}

//List Action: (show, edit, delete, activity, custom)
if (!function_exists('listAction')) {
    function listAction($array = [])
    {
        if (!empty($array)) {
            echo '<div class="dropdown">
                <a class="btn btn-success btn-flat btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></a>
                <ul class="dropdown-menu border-0 shadow">';

            echo implode('', $array);

            echo '</ul>
            </div>';
        } else {
            echo '<div class="text-center">--</div>';
        }
    }

    function actionLi($url, $type, $access = 1, $array = [])
    {
        if ($access) {
            if ($type == 'show') {
                return '<li class="dropdown-item"><a href="' . $url . '"><i class="fas fa-eye"></i> Show</a></li>';
            } elseif ($type == 'edit') {
                return '<li class="dropdown-item"><a href="' . $url . '"><i class="fas fa-edit"></i> Edit</a></li>';
            } elseif ($type == 'delete') {
                return '<li class="dropdown-item"><a onclick="deleted(\'' . $url . '\')"><i class="fas fa-trash-alt"></i> Delete</a></li>';
            } elseif ($type == 'media') {
                return '<li class="dropdown-item"><a href="' . $url . '"><i class="fa fa-pencil"></i> Media Upload</a></li>';
            } elseif ($type == 'activity') {
                $actReturn = '';
                if ($array['status'] == 2 || $array['status'] == 0) {
                    $actReturn .= '<li class="dropdown-item"><a onclick="activity(\'' . $url . '/1\')"><i class="fa fa-check-square-o"></i> Active</a></li>';
                }

                if ($array['status'] == 1 || $array['status'] == 0) {
                    $actReturn .= '<li class="dropdown-item"><a onclick="activity(\'' . $url . '/2\')"><i class="fa fa-ban"></i> Inactive</a></li>';
                }
                return $actReturn;
            } elseif ($type == 'custom') {
                $link = (isset($array['onclick'])) ? 'onclick=' . $array['onclick'] . '(\'' . $url . '\')"' : 'href="' . $url . '"';
                return '<li class="dropdown-item"><a href="' . $url . '">' . $array['icon'] . '</a></li>';
            } elseif ($type == 'livewire') {
                $onClick = '';
                if (isset($array['emit'])) {
                    $onClick .= 'onclick="Livewire.emit(\'' . $array['emit']['event'] . '\'';
                    if (isset($array['emit']['params'])) {
                        $onClick .= ', ' .$array['emit']['params'];
                    }
                    $onClick .= ')"';
                }
                return '<li class="dropdown-item"><button class="livewire-btn" type="button" ' . $onClick . '>' . $array['icon'] . '</button></li>';
            }
        }
    }
}

if (!function_exists('numberToWord')) {
    function numberToWord($number)
    {
        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }
        $Gn = floor($number / 1000000);
        /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000);
        /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);
        /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);
        /* Tens (deca) */
        $n = $number % 10;
        /* Ones */
        $res = "";
        if ($Gn) {
            $res .= numberToWord($Gn) . "Million";
        }
        if ($kn) {
            $res .= (empty($res) ? "" : " ") . numberToWord($kn) . " Thousand";
        }
        if ($Hn) {
            $res .= (empty($res) ? "" : " ") . numberToWord($Hn) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= " and ";
            }
            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];
                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }
        if (empty($res)) {
            $res = "zero";
        }
        return $res;
    }
}

include 'format_datetime.php';
