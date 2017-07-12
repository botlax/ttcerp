<?php

namespace App\Http\Controllers;

use App\Cancel;
use App\User;
use Illuminate\Http\Request;

class CancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $emp = User::findOrFail($id);
        return view('dashboard.cancelForm',compact('emp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request,[
            'reason' => 'nullable',
            'cancel_date' => 'required|date'
        ]);

       $emp = User::findOrFail($id);

       $cancel = Cancel::create($request->all());
       $emp->cancel()->save($cancel);

       return redirect('cancelled');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function show(Cancel $cancel)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {   
        $emp = User::findOrFail($id);
        $cancel = $emp->cancel()->first();
        return view('dashboard.cancelEditForm',compact('cancel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'reason' => 'nullable',
            'cancel_date' => 'required|date'
        ]);


       $cancel = Cancel::findOrFail($id)->update($request->all());

       return redirect('cancelled');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cancel $cancel)
    {
        //
    }
}
