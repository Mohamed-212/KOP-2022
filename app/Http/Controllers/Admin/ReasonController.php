<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeactivationReason;
use App\Traits\LogfileTrait;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    use LogfileTrait;

    public function index()
    {
        $reasons = DeactivationReason::all();

        $this->Make_Log('App\Models\DeactivationReason','view',1);

        return view('admin.reason.index', compact('reasons'));
    }

    public function create()
    {
        $reasons = DeactivationReason::all();
        if ($reasons->count() >= 5) {
            return redirect()->route('admin.reasons.index');
        }

        return view('admin.reason.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason_ar' => 'required|string',
            'reason_en' => 'required|string'
        ]);

        $reasons = DeactivationReason::all();
        if ($reasons->count() >= 5) {
            return redirect()->route('admin.reasons.index');
        }

        $r = DeactivationReason::create($request->all());

        $this->Make_Log('App\Models\DeactivationReason','create',$r->id);

        return redirect()->route('admin.reasons.index')->with([
            'type' => 'success',
            'message' => 'reason insert successfully'
        ]);
    }

    public function edit($id)
    {
        $reson = DeactivationReason::find($id);

        return view('admin.reason.edit', compact('reson'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reason_ar' => 'required|string',
            'reason_en' => 'required|string'
        ]);

        $reson = DeactivationReason::find($id);

        $reson->update($request->all());

        $this->Make_Log('App\Models\DeactivationReason','update',$reson->id);

        return redirect()->route('admin.reasons.index')->with([
            'type' => 'success',
            'message' => 'reason updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $reson = DeactivationReason::find($id);

        $reson->delete();

        $this->Make_Log('App\Models\DeactivationReason','delete',$reson->id);

        return redirect()->route('admin.reasons.index')->with([
            'type' => 'success',
            'message' => 'reason deleted successfully'
        ]);
    }
}
