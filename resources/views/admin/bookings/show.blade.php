@extends('layouts.main')

@section('title', 'Bookings')

@section('content')
    <section class="content">
        <div class="container-fluid">

            <!-- Seat Status Filter -->
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <form method="GET" action="{{ route('admin.bookings.show', $schedule->id) }}">
                                <label for="filter">Filter Seats:</label>
                                <select name="filter" id="filter" class="select2 form-select"
                                        onchange="this.form.submit()">
                                    <option value="all" {{ request('filter') === 'all' ? 'selected' : '' }}>All</option>
                                    <option value="booked" {{ request('filter') === 'booked' ? 'selected' : '' }}>
                                        Booked
                                    </option>
                                    <option
                                        value="not_booked" {{ request('filter') === 'not_booked' ? 'selected' : '' }}>
                                        Not Booked
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
                                <p><strong>Available Seats</strong> (Green): These seats are available for booking.</p>
                                <p><strong>Unavailable Seats</strong> (Red): These seats are already booked.</p>
                            </div>

                            @foreach($seats as $seat)
                                <div class="col-md-4 mb-3 parent">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                                Row: {{ $seat->row }} | Seat: {{ $seat->seat }}
                                            </h6>
                                            <p class="card-text">
                                                {{ $seat->isAvailableForSchedule($schedule->id) ? 'Available for booking' : 'Already booked' }}
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
                                                    Mark as Book
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
                                                    Cancel Booking
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
        function showModalWithSeatDetails(event) {
            var button = $(event.relatedTarget);
            var seatId = button.data('seat-id');
            var seatRow = button.data('seat-row');
            var seatNumber = button.data('seat-number');
            var seatBookingID = button.data('seat-booking-id');
            var scheduleId = button.data('schedule-id');

            var seatDetails = 'Row: ' + seatRow + ' | Seat: ' + seatNumber;
            var innerText = seatBookingID
                ? 'Are you sure you want to cancel the booking for this seat?'
                : 'Are you sure you want to book this seat?';

            var modal = $('#seatModal');
            modal.find('.modal-body #question').text(innerText);
            modal.find('.modal-body #seatDetails').text(seatDetails);

            modal.data('seat-id', seatId);
            modal.data('schedule-id', scheduleId);
            modal.data('seat-booking-id', seatBookingID);
        }

        function handleBookingAction(seatId, scheduleId, seatBookingID) {
            if (seatBookingID) {
                cancelBooking(seatId, seatBookingID);
            } else {
                bookSeat(seatId, scheduleId);
            }
        }

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
                        updateSeatUI(seatId, 'btn-success', 'Mark as Book');
                        $('#seatModal').modal('hide');
                    } else {
                        alert(response.message);
                    }
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
                        updateSeatUI(seatId, 'btn-danger', 'Cancel Booking');
                        $('#seatModal').modal('hide');
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('An error occurred while booking the seat. Please try again.');
                }
            });
        }

        function updateSeatUI(seatId, buttonClass, buttonText) {
            let selectedFilter = document.getElementById('filter').value;

            console.log(selectedFilter);
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

        $('#seatModal').on('show.bs.modal', function (event) {
            showModalWithSeatDetails(event);
        });

        $('#confirmBooking').on('click', function () {
            var modal = $('#seatModal');
            var seatId = modal.data('seat-id');
            var scheduleId = modal.data('schedule-id');
            var seatBookingID = modal.data('seat-booking-id');

            handleBookingAction(seatId, scheduleId, seatBookingID);
        });

        $(document).ready(function () {
            $('#seatFilter').on('change', function () {
                var filterValue = $(this).val();

                $('.seat-item').each(function () {
                    var seatStatus = $(this).data('status');

                    if (filterValue === 'all' || seatStatus === filterValue) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
@endsection

