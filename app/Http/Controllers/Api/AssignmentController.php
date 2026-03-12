<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Complaint;

class AssignmentController extends Controller
{
    /**
     * ASSIGN Complaint to Agent
     */
    public function store(Request $request)
    {
        $request->validate([
            'complaint_id' => 'required|exists:complaints,complaint_id',
            'agent_id'     => 'required|exists:users,user_id',
            'assigned_by'  => 'required|exists:users,user_id'
        ]);
         // Optional: update complaint status
        Complaint::where('complaint_id', $request->complaint_id)
            ->update(['status' => 'in_progress']);

        $assignment = Assignment::create([
            'complaint_id' => $request->complaint_id,
            'agent_id'     => $request->agent_id,
            'assigned_by'  => $request->assigned_by,
            'assigned_at'  => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Complaint assigned successfully',
            'data' => $assignment
        ], 201);
    }

    /**
     * UPDATE Assignment (change agent)
     */
    public function update(Request $request, $id)
    {
        $assignment = Assignment::find($id);

        if (!$assignment) {
            return response()->json([
                'status' => false,
                'message' => 'Assignment not found'
            ], 404);
        }

        $request->validate([
            'agent_id' => 'required|exists:users,user_id'
        ]);

        $assignment->update([
            'agent_id' => $request->agent_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Assignment updated successfully',
            'data' => $assignment
        ]);
    }

    /**
     * DELETE Assignment
     */
    public function destroy($id)
    {
        $assignment = Assignment::find($id);

        if (!$assignment) {
            return response()->json([
                'status' => false,
                'message' => 'Assignment not found'
            ], 404);
        }

        $assignment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Assignment deleted successfully'
        ]);
    }

    /**
     * VIEW ALL Assignments
     */
    public function index($id)
    {
        $assignments = Assignment::with(['complaint', 'agent'])->get();

        return response()->json([
            'status' => true,
            'data' => $assignments
        ]);
    }

    /**
     * VIEW Assignment by ID
     */
    public function show($id)
    {
        $assignment = Assignment::where('agent_id', $id)
            ->with(['complaint', 'agent'])
            ->get();

        if (!$assignment) {
            return response()->json([
                'status' => false,
                'message' => 'Assignment not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $assignment
        ]);
    }
}
