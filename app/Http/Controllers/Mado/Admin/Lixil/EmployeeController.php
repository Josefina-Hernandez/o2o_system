<?php

namespace App\Http\Controllers\Mado\Admin\Lixil;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Lixil\ShopRequest;
use App\Mail\AdminShopCreate;
use App\Models\{
    Employee,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Mail,
    Session,
    Storage
};

class EmployeeController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        // すべてのショップを読み込む
        $employees = Employee::paginate(20);
        return view(
            'mado.admin.lixil.employee.index',
            [
                'employees' => $employees,
            ]
        );
    }
}
