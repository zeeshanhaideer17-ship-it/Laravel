<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    /**
     * CREATE Complaint
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,user_id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string',
            'priority'    => 'required|in:low,medium,high'
        ]);

        $complaint = Complaint::create([
            'customer_id' => $request->customer_id,
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'priority'    => $request->priority,
            'status'      => 'open'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Complaint registered successfully',
            'data' => $complaint
        ], 201);
    }

    /**
     * UPDATE Complaint
     */
    public function update(Request $request, $id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json([
                'status' => false,
                'message' => 'Complaint not found'
            ], 404);
        }

        $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'category'    => 'sometimes|required|string',
            'priority'    => 'sometimes|required|in:low,medium,high',
            'status'      => 'sometimes|required|in:open,in_progress,resolved,closed'
        ]);

        $complaint->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Complaint updated successfully',
            'data' => $complaint
        ]);
    }

    /**
     * DELETE Complaint
     */
    public function destroy($id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json([
                'status' => false,
                'message' => 'Complaint not found'
            ], 404);
        }

        $complaint->delete();

        return response()->json([
            'status' => true,
            'message' => 'Complaint deleted successfully'
        ]);
    }

    /**
     * LIST Complaints by Customer
     */
    public function customerComplaints($customerId)
    {
        $complaints = Complaint::where('customer_id', $customerId)->get();

        return response()->json([
            'status' => true,
            'data' => $complaints
        ]);
    }
    public function view()
    {
        $complaints = Complaint::all();

        return response()->json([
            'status' => true,
            'data' => $complaints
        ]);
    }
    
}
