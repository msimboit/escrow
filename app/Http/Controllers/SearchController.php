<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
   public function index()
    {
        return view('transactions.create');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $users=DB::table('users')->where('first_name','LIKE','%'.$request->search."%")->get();
            if($users)
            {
                foreach ($users as $key => $user) {
                $output.='<tr>'.
                '<td>'.$user->first_name.'</td>'.
                '<td>'.$user->last_name.'</td>'.
                '<td value="{{$user->phone_number}}">'.$user->phone_number.'</td>'.
                '<td>'.$user->email.'</td>'.
                '<td><a href=# class="btn btn-primary" id="client">Select</a></td>'.
                '</tr>';
            }
            return Response($output);
            }
        }
    }
}