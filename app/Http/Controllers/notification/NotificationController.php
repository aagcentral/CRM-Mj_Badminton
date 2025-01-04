<?php

namespace App\Http\Controllers\notification;

use App\Models\Location;
use App\Models\Registration;
use App\Models\PaymentDetails;
use App\Models\Enquiry;
use App\Models\DistributedStock;
use App\Models\Stock;
use App\Models\LeadStatusTracker;
use App\Models\RegisterStatusTracker;
use App\Models\PackageUpdateTrack;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    public function notifications_list()
    {
        $name = Registration::latest()->get();
        $leads = Enquiry::latest()->get();
        $dstocks = DistributedStock::with(['register', 'products'])->latest()->get();
        $lowStockItems = Stock::with(['products'])->where('quantity', '<', 50)->latest()->get(['id', 'quantity', 'product_id']);
        $expiredItems = Stock::with(['products'])
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [now(), now()->addDays(10)])
            ->latest()
            ->get(['id', 'expiry_date', 'product_id']);

        $payment = PaymentDetails::with('registration')->whereNotNull(['upcoming_date', 'submitted_amt'])->orderBy('upcoming_date', 'asc')
            ->get(['id', 'registration_no', 'submitted_amt', 'total_amt', 'upcoming_date', 'status']);
        $RegisterStatusTracker = RegisterStatusTracker::with(['Trackerpackage', 'Traintype', 'Registration'])->latest()->get();
        $PackageUpdateTrack = PackageUpdateTrack::with(['Trackerpackage', 'Traintype', 'Registration'])->latest()->get();
        $statusLabels = [
            '0' => 'New',
            '1' => 'Assigned',
            '2' => 'In Process',
            '3' => 'Converted',
            '4' => 'Dead',
            '5' => 'Recycle',
        ];
        $leadsStatus = LeadStatusTracker::with('enquiry')->latest()->get(['enquiry_Id', 'leads_status']);


        return view('pages.notifications.notifications', compact('name', 'leads', 'payment', 'RegisterStatusTracker', 'PackageUpdateTrack', 'leadsStatus', 'statusLabels', 'dstocks', 'lowStockItems', 'expiredItems'));
    }


    // $user = Auth::user();
    // $notifications = $user->notifications()->get();

    // foreach ($notifications as $notification) {
    //     $locationID = $notification->data['locationID'] ?? null;

    //     if ($locationID) {
    //         $location = Location::where('location_id', $locationID)->first();
    //         $locationName = $location ? $location->location : 'Unknown Location';
    //     } else {
    //         $locationName = 'No Location Assigned';
    //     }

    //     $notification->update([
    //         'data' => array_merge($notification->data, ['locationName' => $locationName])
    //     ]);
    // }
    // Get the current location from the session
    public function markNotificationRead(Request $request)
    {
        // Get the current notifications from session or initialize an empty array
        $notifications = session()->get('notifications', []);

        // Generate the notification key using the type and index (this makes it unique)
        $notificationKey = $request->type . '-' . $request->notificationKey;

        // Mark the notification as read by adding it to the session
        $notifications[$request->type][$notificationKey] = true;

        // Store the updated notification status in the session
        session()->put('notifications', $notifications);

        // Return a success response
        return response()->json(['status' => 'success']);
    }


    public function markasrednotification($id)
    {
        if ($id) {

            $notification = auth()->user()->unreadnotifications()->find($id);
            if ($notification) {
                $notification->markAsRead();
            }
        }
        return back();
    }
}
