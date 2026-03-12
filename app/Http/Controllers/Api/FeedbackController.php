<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    /**
     * CREATE Feedback
     */
    public function store(Request $request)
    {
        $request->validate([
            'complaint_id' => 'required|exists:complaints,complaint_id',
            'customer_id'  => 'required|exists:users,user_id',
            'rating'       => 'required|integer|min:1|max:5',
            'comment'      => 'nullable|string'
        ]);

        $feedback = Feedback::create([
            'complaint_id'  => $request->complaint_id,
            'customer_id'   => $request->customer_id,
            'rating'        => $request->rating,
            'comment'       => $request->comment,
            'feedback_date' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Feedback submitted successfully',
            'data' => $feedback
        ], 201);
    }

    /**
     * UPDATE Feedback
     */
    public function update(Request $request, $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json([
                'status' => false,
                'message' => 'Feedback not found'
            ], 404);
        }

        $request->validate([
            'rating'  => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $feedback->update($request->only(['rating', 'comment']));

        return response()->json([
            'status' => true,
            'message' => 'Feedback updated successfully',
            'data' => $feedback
        ]);
    }

    /**
     * DELETE Feedback
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json([
                'status' => false,
                'message' => 'Feedback not found'
            ], 404);
        }

        $feedback->delete();

        return response()->json([
            'status' => true,
            'message' => 'Feedback deleted successfully'
        ]);
    }

    /**
     * VIEW ALL Feedback
     */
    public function index()
    {
        $feedback = Feedback::all();

        return response()->json([
            'status' => true,
            'data' => $feedback
        ]);
    }

    /**
     * VIEW Feedback by ID
     */
    public function show($id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json([
                'status' => false,
                'message' => 'Feedback not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $feedback
        ]);
    }
}
