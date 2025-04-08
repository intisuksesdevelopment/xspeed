<?php
namespace App\Services;

use Log;
use App\Models\Contact;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ContactService
{
    public function get(Request $request, $supplierId)
    {
        // Log the request for debugging purposes (optional)
        Log::info("Fetching contact for supplier ID: {$supplierId}");

        $supplier = Supplier::where('uuid', $supplierId)->first();

        $contacts = Contact::where('ref', 'supplier')
        ->where('ref_id', $supplier['id']??0)->get();
        

        if (!$contacts || $contacts->isEmpty()) {
            $contacts = Contact::where('uuid', $supplierId)->get();
            if (! $contacts) {
                return response()->json([
                    'message' => "No contact found for supplier ID: {$supplierId}",
                ], 404);
            }
        }else{
            foreach ($contacts as $contact) {
                $contact['supplier_name'] = $supplier['name'];
                $contact['supplier_address'] = $supplier['address'];
            }
        }

        return $contacts;
    }

    public static function getDetail($code)
    {
        $customer = Contact::where('uuid', $code)->first();
        if (! $customer) {
            throw new NotFoundException("code : " . $code);
        }
        return $customer;
    }
}
