<?php
namespace App\Services;

use Log;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactService
{
    public function get(Request $request, $supplierId)
    {
        // Log the request for debugging purposes (optional)
        Log::info("Fetching contact for supplier ID: {$supplierId}");

                                    // Retrieve additional data from the request, if needed
        $filters = $request->all(); // Get all request data

        // Logic to fetch contact data (e.g., from a database)
        $contact = Contact::where('supplier_id', $supplierId)->first();

        // Check if contact exists
        if (! $contact) {
            return response()->json([
                'message' => "No contact found for supplier ID: {$supplierId}",
            ], 404);
        }

        // Return the contact data as JSON
        return response()->json([
            'message' => "Contact found successfully.",
            'data'    => $contact,
        ], 200);
    }

}
