<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Html\Builder;
use DataTables;

class HomeController extends Controller
{
    //protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->authLayout = 'admin.auth.';
        $this->pageLayout = '';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Builder $builder, Request $request)
    {
        $users = User::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($users->get())
            ->addIndexColumn()
        //     ->editColumn('image', function (User $users) {
        //         if($users->avatar === "default.png"){
        //             return '<img class="img-thumbnail" src="' . asset('storage/avatar/default.png').'" width="60px">';
        //         }else{
        //             return '<img class="img-thumbnail" src="' . asset('storage/avatar') . '/' . @$users->avatar . '" width="60px">';
        //         }
        //     })
        //     ->editColumn('status', function (User $operator) {
        //       if ($operator->status == "active") {
        //         return '<span class="label label-success">Active</span>';
        //     } else {
        //         return '<span class="label label-danger">Block</span>';
        //     }
        // })
        //     ->editColumn('user_type',function(User $users){
        //         if($users->user_type == 'superadmin'){
        //             return '<span class="label label-primary">Super Admin</span>';
        //         }
        //     })
        //     ->editColumn('action', function (User $users) {
        //         $action = '';

        //         $action .='<a href='.route('admin.edit',[$users->id]).'><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;';
        //         $action .='<a class="m-l-10 deleteuser" data-id ="'.$users->id.'" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
        //         if($users->status == "active"){
        //             $action .= '<a href="javascript:void(0)" data-value="1"   data-toggle="tooltip" title="Active" class="ml-2 mr-2 changeStatusRecord" data-id="'.$users->id.'"><i class="fa fa-unlock"></i></a>';
        //         }else{
        //             $action .= '<a href="javascript:void(0)" data-value="0"  data-toggle="tooltip" title="Block" class="ml-2 mr-2 changeStatusRecord" data-id="'.$users->id.'"><i class="fa fa-lock" ></i></a>';
        //         }

        //         return $action;
        //     })
        //     ->rawColumns(['action','image','status','user_type'])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'Sr no','width'=>'5%',"orderable" => false, "searchable" => false],
            //['data' => 'image', 'name'    => 'avatar', 'title' => 'Avatar','width'=>'10%',"orderable" => false, "searchable" => false],
            ['data' => 'name', 'name'    => 'name', 'title' => 'Name','width'=>'15%'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email','width'=>'15%'],
            // ['data' => 'user_type', 'name' => 'user_type', 'title' => 'User','width'=>'10%'],
            // ['data' => 'status', 'name' => 'status', 'title' => 'Status','width'=>'5%'],
            // ['data' => 'action', 'name' => 'action', 'title' => 'Action','width'=>'8%',"orderable" => false, "searchable" => false],
        ])
        ->parameters([
            "processing"=> true,
            "language"=> [
                'processing' => '<img src="https://www.odyssea.eu/data/img/pie-chart-blue-loading.gif" height="100px" width="100px" alt="Loading">',
            ],
            'order' =>[],
            'paging'      => true,
            'info'        => false,
            'searchDelay' => 350,
            'searching'   => true,
            'dom' => 'Bflrtip',
            "lengthMenu" => [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            'buttons' => [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
            ],

        ]);
        
        return view($this->pageLayout.'home',compact('html'));
    }
}
