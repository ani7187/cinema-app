@extends('layouts.main')

@section('title', 'Bookings')

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <form method="GET" action="{{ route('admin.bookings.show', $schedule->id) }}">
                                <label for="filter">{{ __('Filter Seats:') }}</label>
                                <select name="filter" id="filter" class="select2 form-select"
                                        onchange="this.form.submit()">
                                    <option value="all" {{ request('filter') === 'all' ? 'selected' : '' }}>
                                        {{ __('All') }}
                                    </option>
                                    <option value="booked" {{ request('filter') === 'booked' ? 'selected' : '' }}>
                                        {{ __('Booked') }}
                                    </option>
                                    <option
                                        value="not_booked" {{ request('filter') === 'not_booked' ? 'selected' : '' }}>
                                        {{ __('Not Booked') }}
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="row justify-content-center p-5">
                            <div class="seat-info mb-4">
                                <p><strong>{{ __('Available Seats') }}</strong> {{ __('(Green): These seats are available for booking.') }}</p>
                                <p><strong>{{ __('Unavailable Seats') }}</strong>{{ __('(Red): These seats are already booked.') }} </p>
                            </div>

                            @if($seats->isEmpty())
                                <h4 class="text-danger">
                                    Data not found
                                </h4>
                            @endif

                            @foreach($seats as $seat)
                                <div class="col-md-4 mb-3 parent">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                                {{ __('Row') }} : {{ $seat->row }} | {{ __('Seat') }} : {{ $seat->seat }}
                                            </h6>
                                            <p class="card-text">
                                                {{ $seat->isAvailableForSchedule($schedule->id) ? __('Available for booking') : __('Already booked') }}
                                            </p>

                                            <!-- Button for booking or canceling -->
                                            @if($seat->isAvailableForSchedule($schedule->id))
                                                <button class="card-link btn btn-success w-100"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#seatModal"
                                                        data-seat-id="{{ $seat->id }}"
                                                        data-schedule-id="{{ $schedule->id }}"
                                                        data-seat-row="{{ $seat->row }}"
                                                        data-seat-number="{{ $seat->seat }}"
                                                        data-seat-booking-id="0">
                                                    {{ __('Book Seat') }}
                                                </button>
                                            @else
                                                <button class="btn btn-danger w-100 seat-button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#seatModal"
                                                        data-seat-id="{{ $seat->id }}"
                                                        data-schedule-id="{{ $schedule->id }}"
                                                        data-seat-row="{{ $seat->row }}"
                                                        data-seat-number="{{ $seat->seat }}"
                                                        data-seat-booking-id="{{ $seat->booking->id }}">
                                                    {{ __('Cancel Booking') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="pagination">
                                {{ $seats->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- Modal for Booking Confirmation -->
<div class="modal fade" id="seatModal" tabindex="-1" aria-labelledby="seatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="seatModalLabel">Change booking status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="question"></h5>
                <p id="seatDetails" class="font-weight-bold"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmBooking">Confirm
                </button>
            </div>
        </div>
    </div>
</div>


@section('scripts')
    <script>
        $(document).ready(function () {
            $('button[data-seat-id]').on('click', function() {
                var seatId = $(this).data('seat-id');
                var seatRow = $(this).data('seat-row');
                var seatNumber = $(this).data('seat-number');
                var seatBookingID = $(this).data('seat-booking-id');
                var scheduleId = $(this).data('schedule-id');

                // Update modal's data attributes before it opens
                var modal = $('#seatModal');
                modal.data('seat-id', seatId);
                modal.data('schedule-id', scheduleId);
                modal.data('seat-booking-id', seatBookingID);
                modal.data('seat-row', seatRow);
                modal.data('seat-number', seatNumber);
            });

            $('#seatModal').on('show.bs.modal', function (event) {
                var modal = $(this);

                var seatId = modal.data('seat-id');
                var seatRow = modal.data('seat-row');
                var seatNumber = modal.data('seat-number');
                var seatBookingID = modal.data('seat-booking-id');
                var scheduleId = modal.data('schedule-id');

                var seatDetails = 'Row: ' + seatRow + ' | Seat: ' + seatNumber;
                var innerText = seatBookingID
                    ? 'Are you sure you want to cancel the booking for this seat?'
                    : 'Are you sure you want to book this seat?';

                modal.find('.modal-body #question').text(innerText);
                modal.find('.modal-body #seatDetails').text(seatDetails);
            });

            // Handle the booking or cancellation logic when the button is clicked
            $('#confirmBooking').on('click', function () {
                var modal = $('#seatModal');
                var seatId = modal.data('seat-id');
                var scheduleId = modal.data('schedule-id');
                var seatBookingID = modal.data('seat-booking-id');

                if (seatBookingID) {
                    cancelBooking(seatId, seatBookingID);
                } else {
                    bookSeat(seatId, scheduleId);
                }
            });

            function cancelBooking(seatId, seatBookingID) {
                $.ajax({
                    url: '{{ route("admin.bookings.destroy", ":booking") }}'.replace(':booking', seatBookingID),
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        booking: seatBookingID,
                    },
                    success: function (response) {
                        if (response.success) {
                            $('button[data-seat-id="' + seatId + '"]').data('seat-booking-id', 0);

                            updateSeatUI(seatId, 'btn-success', 'Book Seat');
                            $('#seatModal').modal('hide');
                        }
                        alert(response.message);
                    },
                    error: function () {
                        alert('An error occurred while canceling the booking. Please try again.');
                    }
                });
            }

            function bookSeat(seatId, scheduleId) {
                $.ajax({
                    url: '{{ route("book.seat") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        seat_id: seatId,
                        schedule_id: scheduleId
                    },
                    success: function (response) {
                        if (response.success) {
                            $('button[data-seat-id="' + seatId + '"]').data('seat-booking-id', response.id);

                            updateSeatUI(seatId, 'btn-danger', 'Cancel Booking');
                            $('#seatModal').modal('hide');
                        }
                        alert(response.message);
                    },
                    error: function () {
                        alert('An error occurred while booking the seat. Please try again.');
                    }
                });
            }

            // Update seat button UI after booking or canceling
            function updateSeatUI(seatId, buttonClass, buttonText) {
                let selectedFilter = document.getElementById('filter').value;
                if (selectedFilter === 'all') {
                    $('button[data-seat-id="' + seatId + '"]')
                        .removeClass('btn-danger btn-success')
                        .addClass(buttonClass)
                        .text(buttonText)
                        .blur();
                } else {
                    $('button[data-seat-id="' + seatId + '"]').closest('.parent').remove();
                }
            }
        });
    </script>
@endsection

