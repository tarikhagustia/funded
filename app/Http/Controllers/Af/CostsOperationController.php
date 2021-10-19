<?php

namespace App\Http\Controllers\Af;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AfOperational;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\AfCommissionService;
use App\DataTables\Af\CostsRequestTable;
use App\DataTables\Af\CostsApprovalTable;
use Symfony\Component\HttpFoundation\Response;
use App\Services\WalletService;

class CostsOperationController extends Controller
{
    public function request(CostsRequestTable $table)
    {
        return $table->with([

        ])->render('af.operations.request.index');
    }

    public function approval(CostsApprovalTable $table)
    {
        return $table->with([

        ])->render('af.operations.approval.index');
    }

    public function create(AfOperational $model)
    {
        return view('af.operations.create', compact('model'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'date' => 'required',
        ]);

        // Validate jika AF tersebut bukan level_on_group 4 maka af tidak bisa request
        $parent = auth()->user()->parent;
        if ($parent && $parent->level_on_group != 4) {
            // return abort(Response::HTTP_FORBIDDEN);
        }elseif(!$parent){
            return redirect()->route($request->type)->with(['message_failed' => __('Failed Creating Record')]);
        }

        $request['af_id'] = auth()->id();
        $request['approval_af_id'] = $parent->id;

        // Pending, Approved, Rejected
        $request['status'] = "Pending";

        DB::beginTransaction();

        try{

            $new = AfOperational::create($request->only(['af_id','title', 'date','status','total','approval_af_id']));

            $new->items()->createMany($request['items']);

            $new->total = $new->items->sum('amount');

            $new->save();

            DB::commit();

            return redirect()->route($request->type)->with(['message_success' => __('Success Creating Record')]);

        }catch(\Exception $e){
            DB::rollback();
        }

        return redirect()->route($request->type)->with(['message_failed' => __('Failed Creating Record')]);

    }

    public function edit(AfOperational $model)
    {
        return view('af.operations.edit', compact('model'));
    }

    public function view(AfOperational $model)
    {
        return view('af.operations.view', compact('model'));
    }


    function updateStatus(Request $request, AfOperational $model, WalletService $walletService){
        DB::beginTransaction();

        try{
            // Store to wallet
            if($request->input('status')) {
                $walletService->credit($model->agent, $model->total, WalletService::OPERATIONAL, "Operational Cost #{$model->id}");
            }
            $model->update($request->only(['status']));

            DB::commit();

            return redirect()->route('costs-operation.approval')->with(['message_success' => __('Success '.$request->status.' Record')]);

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('costs-operation.approval')->with(['message_failed' => __('Failed '.$request->status.' Record')]);
        }
    }

    public function update(Request $request, AfOperational $model)
    {
        $this->validate($request, [
            'title' => 'required',
            'date' => 'required',
        ]);

        DB::beginTransaction();

        try{

            $updated = $model->update($request->only(['title', 'date']));
            $updated = AfOperational::find($model->id);

            foreach($request['items'] as $item){
                $updated->items()->updateOrCreate($item);
            }

            $updated->total = $updated->items->sum('amount');

            $updated->save();

            DB::commit();

            return redirect()->route($request->type)->with(['message_success' => __('Success Updating Record')]);

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route($request->type)->with(['message_failed' => __('Failed Updating Record')]);
        }

    }

    public function destroy(AfOperational $model)
    {
        $model->delete();
        return redirect()->route('costs-operation.request')->with(['message_success' => __('Success Deleting Record')]);
    }
}
