<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * CREATE FAQ (Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'question'   => 'required|string|max:255',
            'answer'     => 'required|string',
            'created_by' => 'required|exists:users,user_id'
        ]);

        $faq = Faq::create([
            'question'   => $request->question,
            'answer'     => $request->answer,
            'created_by' => $request->created_by
        ]);

        return response()->json([
            'status' => true,
            'message' => 'FAQ created successfully',
            'data' => $faq
        ], 201);
    }

    /**
     * UPDATE FAQ (Admin)
     */
    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'status' => false,
                'message' => 'FAQ not found'
            ], 404);
        }

        $request->validate([
            'question' => 'sometimes|required|string|max:255',
            'answer'   => 'sometimes|required|string'
        ]);

        $faq->update($request->only(['question', 'answer']));

        return response()->json([
            'status' => true,
            'message' => 'FAQ updated successfully',
            'data' => $faq
        ]);
    }

    /**
     * DELETE FAQ (Admin)
     */
    public function destroy($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'status' => false,
                'message' => 'FAQ not found'
            ], 404);
        }

        $faq->delete();

        return response()->json([
            'status' => true,
            'message' => 'FAQ deleted successfully'
        ]);
    }

    /**
     * VIEW ALL FAQs (Public)
     */
    public function index()
    {
        $faqs = Faq::orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $faqs
        ]);
    }

    /**
     * VIEW FAQ by ID
     */
    public function show($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'status' => false,
                'message' => 'FAQ not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $faq
        ]);
    }
}
