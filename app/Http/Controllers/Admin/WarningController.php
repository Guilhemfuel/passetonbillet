<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminWarning;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WarningController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware( 'auth.admin' );
    }

    /**
     * Displays all warnings
     */
    public function index()
    {

        $warnings = AdminWarning::whereNull( 'done_at' )->get();
        $pastWarnings = AdminWarning::whereNotNull( 'done_at' )->limit( 50 )->latest()->get();

        return view( 'admin.unique.warnings.index' )->with( [
            'warnings'     => $warnings,
            'pastWarnings' => $pastWarnings
        ] );

    }

    /**
     * Mark warning as done
     */
    public function markAsDone( AdminWarning $warning )
    {
        $warning->done_at = Carbon::now();
        $warning->done_by_id = Auth::id();
        $warning->save();

        flash()->success('Warning marked as done.');

        return redirect()->route('warnings.index');
    }
}
