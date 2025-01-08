@extends('pages.layouts.app')
@section('title')
Notification
@endsection
@section('css')

@endsection


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>All Notification Type</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    <li class="breadcrumb-item"><a href="{{route('panel.dashboard')}}">Dasboard</a></li>
                    <li class="breadcrumb-item active"> Notification</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row mt-4">
    @if ($errors->any())
    <div class="text-danger small">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<section class="section profile">
    <div class="row">
        <div class="col-xl-12">
            <div class="card mt-3" style="height: 700px;">
                <div class="card-body pt-3" style="overflow: auto; height: calc(100% - 40px);">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">All</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Enquiry-edit" aria-selected="false" role="tab" tabindex="-1">Enquiry Notification</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" role="tab" tabindex="-1">Registration Notification</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#fee-submissions" aria-selected="false" role="tab" tabindex="-1">Fee Submission</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" aria-selected="false" role="tab" tabindex="-1">Stock Notification</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">

                            <div class="pt-4">
                                <!-- Lead Enquiries -->
                                @foreach ($leads as $lead)
                                <div id="notification-{{ $loop->index }}-enquiry" class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                    data-location-id="{{ $lead->locationID }}" style="background-color: rgba(40, 167, 70, 0.16); border-left: 4px solid green; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <div>
                                        <strong>{{ $lead->name }}</strong> is a new enquiry added.
                                    </div>
                                    <div class="mark-status-container">
                                        <span class="mark-as-read-text" onclick="markAsReads('{{ $loop->index }}', 'enquiry')" style="cursor: pointer;">Mark as Read</span>
                                        <span class="marked-text" style="display: none;">Marked</span>
                                    </div>
                                </div>
                                @endforeach

                                <!-- Registrations -->
                                @foreach ($name as $names)
                                <div id="notification-{{ $loop->index }}-registration" class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                    data-location-id="{{ $names->locationID }}" style="background-color: rgba(40, 167, 70, 0.16); border-left: 4px solid green; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <div>
                                        <strong>{{ $names->name }}</strong> is a new registration added.
                                    </div>
                                    <div class="mark-status-container">
                                        <span class="mark-as-read-text" onclick="markAsReads('{{ $loop->index }}', 'registration')" style="cursor: pointer;">Mark as Read</span>
                                        <span class="marked-text" style="display: none;">Marked</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Lead Enquiry Tab -->
                        <div class="tab-pane fade Enquiry-edit pt-4" id="Enquiry-edit" role="tabpanel">
                            @foreach ($leads as $lead)
                            <div id="notification-{{ $loop->index }}-enquiry" class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                data-location-id="{{ $lead->locationID }}" style="background-color: rgba(40, 167, 70, 0.16); border-left: 4px solid green; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <div>
                                    <strong>{{ $lead->name }}</strong> is a new enquiry added.
                                </div>
                                <div class="mark-status-container">
                                    <span class="mark-as-read-text" onclick="markAsReads('{{ $loop->index }}', 'enquiry')" style="cursor: pointer;">Mark as Read</span>
                                    <span class="marked-text" style="display: none;">Marked</span>
                                </div>
                            </div>
                            @endforeach
                            @foreach ($leadsStatus as $status)
                            <div id="notification-{{ $loop->index }}-status"
                                class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                style="background-color: rgba(40, 167, 70, 0.16); border-left: 4px solid green; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <div>
                                    <strong>{{ $status->enquiry->name ?? 'Unknown' }}</strong>'s status has changed to
                                    <strong class="text-success">{{ $statusLabels[$status->leads_status] ?? 'Unknown' }}</strong>.
                                </div>
                                <div class="mark-status-container">
                                    <span class="mark-as-read-text" onclick="markAsReads('{{ $loop->index }}', 'status')" style="cursor: pointer;">Mark as Read</span>
                                    <span class="marked-text" style="display: none;">Marked</span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- registration Edit Tab -->
                        <div class="tab-pane fade profile-edit pt-4" id="profile-edit" role="tabpanel">
                            <div class="card mt-2">
                                @foreach ($name as $names)
                                <div id="notification-{{ $loop->index }}-registration" class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                    data-location-id="{{ $names->locationID }}" style="background-color: rgba(40, 167, 70, 0.16); border-left: 4px solid green; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <div>
                                        <strong>{{ $names->name }}</strong> is a new registration added.
                                    </div>
                                    <div class="mark-status-container">
                                        <span class="mark-as-read-text" onclick="markAsReads('{{ $loop->index }}', 'registration')" style="cursor: pointer;">Mark as Read</span>
                                        <span class="marked-text" style="display: none;">Marked</span>
                                    </div>
                                </div>
                                @endforeach

                                @foreach ($dstocks as $dstock)
                                <div id="notification-{{ $loop->index }}-dstock" class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                    data-location-id="{{ $dstock->locationID }}" style="background-color: rgba(167, 40, 150, 0.12); border-left: 4px solid pink; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <div>
                                        <strong>{{ $dstock->register->name ?? 'Unknown User' }}</strong> has been assigned the product
                                        <strong class="text-primary">{{ $dstock->products->product ?? 'Unknown Product' }}</strong>.
                                        Ensure proper usage and tracking.
                                    </div>

                                    <div class="mark-status-container">
                                        <span class="mark-as-read-text" onclick="markAsReads('{{ $loop->index }}', 'dstock')" style="cursor: pointer;">Mark as Read</span>
                                        <span class="marked-text" style="display: none;">Marked</span>
                                    </div>
                                </div>
                                @endforeach

                                <!-- Updated Packages or Training Programs -->
                                @foreach ($PackageUpdateTrack as $update)
                                <div id="notification-{{ $loop->index }}-update"
                                    class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                    style="background-color: rgba(99, 190, 255, 0.27); border-left: 4px solid #63beff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <div>
                                        <strong>{{ $update->Registration->name ?? ''  }}</strong> has Renewed:

                                        @if($update->Trackerpackage)
                                        <!-- Display package if available -->
                                        Category is <strong>{{ $update->Trackerpackage->package }}</strong>
                                        @else
                                        <!-- Handle case where Trackerpackage is null -->
                                        Category is <strong class="text-danger">not available</strong>
                                        @endif

                                        @if($update->Trackerpackage && $update->Traintype)
                                        <!-- If both package and training type exist, add 'and' -->
                                        and
                                        @endif

                                        @if($update->Traintype)
                                        <!-- Display training type if available -->
                                        Training Type is <strong>{{ $update->Traintype->add_program }}</strong>.
                                        @else
                                        <!-- Handle case where Traintype is null -->
                                        Training Type is <strong class="text-danger">not available</strong>.
                                        @endif
                                    </div>
                                    <div class="mark-status-container">
                                        <span class="mark-as-read-text"
                                            onclick="markAsReads('{{ $loop->index }}', 'update')"
                                            style="cursor: pointer;">Mark as Read</span>
                                        <span class="marked-text" style="display: none;">Marked</span>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>


                        <!-- @if(auth()->check())
                            @foreach(auth()->user()->unreadNotifications as $notification)
                            <div class="p-3 mb-3 d-flex justify-content-between align-items-center small" style="background-color: rgba(40, 167, 70, 0.16); border-left: 4px solid green;">

                                @if(isset($notification->data['name']))
                                <div>
                                    <strong>{{ $notification->data['name'] }}</strong> is a new Lead in Location

                                </div>
                                @else
                                <div class="p-2">Information unavailable.</div>
                                @endif

                                <a href="{{ route('notifications.markasread', $notification->id) }}" class=" ">Mark as read</a>
                            </div>
                            @endforeach
                            @else
                            <p>No notifications available or user not authenticated.</p>
                            @endif -->





                        <div class="tab-pane fade pt-3" id="fee-submissions" role="tabpanel">
                            <div class="card mt-2">
                                @if($payment->isNotEmpty())
                                @foreach ($payment as $pymnt)
                                <div id="notification-{{ $loop->index }}-fee"
                                    class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                    data-location-id="{{ $pymnt->locationID }}"
                                    style="background-color: rgba(167, 40, 40, 0.16); border-left: 4px solid red; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <div>
                                        <strong>{{ $pymnt->registration->name ?? 'Unknown' }}</strong> has an upcoming payment due on
                                        <strong class="text-danger">{{ \Carbon\Carbon::parse($pymnt->upcoming_date)->format('d-m-Y') }}</strong>.

                                    </div>
                                    <div class="mark-status-container">
                                        <span class="mark-as-read-text"
                                            onclick="markAsReads('{{ $loop->index }}', 'fee')"
                                            style="cursor: pointer;">Mark as Read</span>
                                        <span class="marked-text" style="display: none;">Marked</span>
                                    </div>
                                </div>
                                @endforeach
                                @endif


                                @if($payment->isNotEmpty())
                                @foreach ($payment as $pymnt)
                                <div id="notification-{{ $loop->index }}-submittedfee"
                                    class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                    data-location-id="{{ $pymnt->locationID }}"
                                    style="background-color: rgba(167, 40, 40, 0.16); border-left: 4px solid red; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <div>
                                        <strong>{{ $pymnt->registration->name ?? 'Unknown' }}</strong> has
                                        Submitted Amount: <strong class="text-success">{{ $pymnt->submitted_amt  }}</strong>
                                    </div>
                                    <div class="mark-status-container">
                                        <span class="mark-as-read-text"
                                            onclick="markAsReads('{{ $loop->index }}', 'submittedfee')"
                                            style="cursor: pointer;">Mark as Read</span>
                                        <span class="marked-text" style="display: none;">Marked</span>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                            </div>
                        </div>
                        <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                            @if ($lowStockItems->isNotEmpty())
                            @foreach ($lowStockItems as $stock)
                            <div id="notification-{{ $loop->index }}-low-stock"
                                class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                style="background-color: rgba(255, 193, 7, 0.2); border-left: 4px solid orange;">

                                <div>
                                    <strong>{{ $stock->products->product ?? 'Unknown Product' }}</strong> has low stock with only
                                    <strong class="text-danger">{{ $stock->quantity }}</strong> left.
                                </div>

                                <div class="mark-status-container">
                                    <span class="mark-as-read-text" onclick="markAsReads('{{ $loop->index }}', 'low-stock')" style="cursor: pointer;">Mark as Read</span>
                                    <span class="marked-text" style="display: none;">Marked</span>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <p class="text-muted">No low stock items to display.</p>
                            @endif
                            <!-- expiry notification -->
                            @if ($expiredItems->isNotEmpty())
                            @foreach ($expiredItems as $stock)
                            <div id="notification-{{ $loop->index }}-expiring-soon"
                                class="p-2 shadow mb-3 d-flex justify-content-between align-items-center small notification-item"
                                style="background-color: rgba(255, 165, 0, 0.2); border-left: 4px solid orange;">

                                <div>
                                    <strong>{{ $stock->products->product ?? 'Unknown Product' }}</strong> is expiring soon on
                                    <strong class="text-danger">{{ \Carbon\Carbon::parse($stock->expiry_date)->format('d-m-Y') }}</strong>.
                                </div>

                                <div class="mark-status-container">
                                    <span class="mark-as-read-text" onclick="markAsReads('{{ $loop->index }}', 'expiring-soon')" style="cursor: pointer;">Mark as Read</span>
                                    <span class="marked-text" style="display: none;">Marked</span>
                                </div>
                            </div>
                            @endforeach

                            @endif

                        </div>
                    </div>
                </div><!-- End Bordered Tabs -->

            </div>
        </div>

    </div>
    </div>
</section>


</div>


@endsection

@section('js')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark notification as read on click
        document.querySelectorAll('.notification-item').forEach(function(notification) {
            notification.addEventListener('click', function() {
                notification.style.backgroundColor = "rgba(211, 211, 211, 0.5)";
                notification.querySelector('.mark-as-read-text').style.display = 'none'; // Hide "Mark as Read" text
                notification.querySelector('.marked-text').style.display = 'inline'; // Show "Marked" text
            });
        });
    });

    function markAsReads(index, type) {
        // Generate a unique key for each notification (e.g., '0-enquiry' or '1-registration')
        const notificationKey = `${index}-${type}`;

        // Update the notification style when it's marked as read
        const notification = document.querySelector(`#notification-${notificationKey}`);

        // Apply the "read" styles to the notification
        notification.style.backgroundColor = "rgba(211, 211, 211, 0.5)"; // Light gray
        notification.style.borderLeft = "4px solid grey"; // Grey left border

        const markText = notification.querySelector('.mark-as-read-text');
        const markedText = notification.querySelector('.marked-text');

        if (markText && markedText) {
            markText.style.display = 'none'; // Hide the "Mark as Read" text
            markedText.style.display = 'inline'; // Show the "Marked" text
        }

        // Save the marked status in localStorage so it persists across page refreshes
        let markedNotifications = JSON.parse(localStorage.getItem('markedNotifications')) || {};
        markedNotifications[notificationKey] = true; // Mark this notification as read
        localStorage.setItem('markedNotifications', JSON.stringify(markedNotifications));
    }

    // On page load, check localStorage to restore the marked notifications
    window.onload = function() {
        let markedNotifications = JSON.parse(localStorage.getItem('markedNotifications')) || {};

        // Loop through all notifications and check if they were marked
        document.querySelectorAll('.notification-item').forEach(notification => {
            const notificationId = notification.id;
            const notificationKey = notificationId.split('-').slice(1).join('-'); // Extract the `index-type` from the ID

            // If this notification is marked, apply the marked styles
            if (markedNotifications[notificationKey]) {
                notification.style.backgroundColor = "rgba(211, 211, 211, 0.5)"; // Permanent gray background
                notification.style.borderLeft = "4px solid grey"; // Grey left border
                const markText = notification.querySelector('.mark-as-read-text');
                const markedText = notification.querySelector('.marked-text');
                if (markText && markedText) {
                    markText.style.display = 'none';
                    markedText.style.display = 'inline';
                }
            }
        });
    };
</script>



@endsection