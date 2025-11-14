<?php
 
namespace App\Http\Controllers;
 
use App\Models\Pos;
use App\Models\Bank;
use App\Models\Currency;
use Illuminate\Http\Request;
 
class PosController extends Controller
{
    public function index()
    {
        $poses = Pos::with(['bank', 'currency'])
            ->latest('id')
            ->paginate(10);
 
        return view('admin.pos.index', compact('poses'));
    }
 
    public function create()
    {
        return view('admin.pos.create', $this->lists());
    }
 
    public function store(Request $request)
    {
        Pos::create($request->validate($this->rules()));
 
        return redirect()
            ->route('pos.index')
            ->with('success', 'POS created successfully.');
    }
 
    public function show(Pos $pos)
    {
        $pos->load(['bank', 'currency']);
 
        return view('admin.pos.show', compact('pos'));
    }
 
    public function edit(Pos $pos)
    {
        return view('admin.pos.edit', ['po' => $pos] + $this->lists());
    }
 
    public function update(Request $request, Pos $pos)
    {
        $pos->update($request->validate($this->rules()));
 
        return redirect()
            ->route('pos.index')
            ->with('success', 'POS updated successfully.');
    }
 
    public function destroy(Pos $pos)
    {
        $pos->delete();
 
        return redirect()
            ->route('pos.index')
            ->with('success', 'POS deleted.');
    }
 
    private function rules(): array
    {
        return [
            'name'                  => 'required|string|max:255',
            'bank_id'               => 'required|exists:banks,id',
            'currency_id'           => 'required|exists:currencies,id',
            'status'                => 'required|in:0,1',
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'commission_fixed'      => 'required|numeric|min:0',
            'bank_fee'              => 'required|numeric|min:0',
            'settlement_day'        => 'required|integer|min:0',
        ];
    }
 
    private function lists(): array
    {
        return [
            'banks'      => Bank::orderBy('name')->get(['id', 'name']),
            'currencies' => Currency::orderBy('code')->get(['id', 'code', 'name']),
        ];
    }
}