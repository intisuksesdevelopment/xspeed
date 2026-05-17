<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public static function getActive(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE); // Default to 10 per page if not provided

        // Construct the raw SQL query as a string
        $sql = 'SELECT * FROM `payment_methods` WHERE `status` = 0 ORDER BY `index` ASC';

        // Execute the query and get the results
        $paymentMethods = DB::select($sql);

        $paymentMethodsArray = json_decode(json_encode($paymentMethods), true);

        return $paymentMethodsArray;
    }

    /**
     * Create installment schedule for credit payment methods
     */
    public static function createInstallmentSchedule($orderId, $paymentMethodId, $installmentPeriod, $totalAmount, $dpAmount, $startDate)
    {
        try {
            $paymentMethod = PaymentMethod::find($paymentMethodId);
            
            if (!$paymentMethod) {
                throw new \Exception("Payment method not found");
            }

            // Calculate remaining amount after DP
            $remainingAmount = $totalAmount - $dpAmount;
            $installmentAmount = $remainingAmount / $installmentPeriod;

            $payments = [];
            $startDate = Carbon::parse($startDate);

            // Determine interval based on payment method name
            $interval = 'month'; // default
            if (stripos($paymentMethod->name, 'daily') !== false) {
                $interval = 'day';
            } elseif (stripos($paymentMethod->name, 'monthly') !== false) {
                $interval = 'month';
            } elseif (stripos($paymentMethod->name, 'annual') !== false) {
                $interval = 'year';
            }

            // Create payment records for each installment
            for ($i = 1; $i <= $installmentPeriod; $i++) {
                // Calculate due date
                $dueDate = clone $startDate;
                if ($interval === 'day') {
                    $dueDate->addDays($i);
                } elseif ($interval === 'month') {
                    $dueDate->addMonths($i);
                } elseif ($interval === 'year') {
                    $dueDate->addYears($i);
                }

                $payment = new Payment();
                $payment->trx_id = 'PAY-' . time() . '-' . $i;
                $payment->ref = 'order';
                $payment->ref_id = $orderId;
                $payment->type = "Cicilan ke-{$i} dari {$installmentPeriod}";
                $payment->desc = "Pembayaran cicilan {$paymentMethod->name} periode ke-{$i}";
                $payment->expired_date = $dueDate->format('Y-m-d');
                $payment->payment_date = null;
                $payment->sub_total = $totalAmount;
                $payment->disc_percent = 0;
                $payment->disc_total = 0;
                $payment->tax_percent = 0;
                $payment->tax_total = 0;
                $payment->dp_total = $i === 1 ? $dpAmount : 0;
                $payment->final_total = $installmentAmount;
                $payment->payment_total = 0;
                $payment->payment_method_id = $paymentMethodId;
                $payment->payment_data = json_encode([
                    'installment_number' => $i,
                    'total_installments' => $installmentPeriod,
                    'interval' => $interval
                ]);
                $payment->created_by = Auth::check() ? Auth::user()->username : 'system';
                $payment->status = 0; // 0=unpaid
                $payment->save();

                $payments[] = $payment;

                Log::info("Payment installment created", [
                    'payment_id' => $payment->id,
                    'order_id' => $orderId,
                    'installment' => "{$i}/{$installmentPeriod}",
                    'due_date' => $dueDate->format('Y-m-d'),
                    'amount' => $installmentAmount
                ]);
            }

            return $payments;

        } catch (\Exception $e) {
            Log::error("Failed to create installment schedule: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get upcoming payments (due within specified days)
     */
    public static function getUpcomingPayments($days = 7)
    {
        $today = Carbon::today();
        $futureDate = Carbon::today()->addDays($days);

        return Payment::where('status', 0)
            ->whereBetween('expired_date', [$today, $futureDate])
            ->with('paymentMethod')
            ->orderBy('expired_date', 'asc')
            ->get();
    }

    /**
     * Get overdue payments
     */
    public static function getOverduePayments()
    {
        return Payment::where('status', 0)
            ->where('expired_date', '<', Carbon::today())
            ->with('paymentMethod')
            ->orderBy('expired_date', 'asc')
            ->get();
    }
}
