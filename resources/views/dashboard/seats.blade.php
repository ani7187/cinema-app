@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center pb-5">Seats for Movie: {{ $schedule->movie->title }}</h1>
        <h3 class="text-center">Start Time: {{ \Carbon\Carbon::parse($schedule->start_time)->format('M d, Y h:i A') }}</h3>

        <div class="d-flex justify-content-center mb-4">
            <div class="bg-dark text-white p-3 w-50 text-center rounded" style="font-size: 20px; font-weight: bold;">
                SCREEN
            </div>
        </div>

        <div class="row justify-content-center">
            @foreach($seats as $seat)
                <div class="col-md-2 mb-3">
                    @if($seat->isAvailableForSchedule($schedule->id))
                        <button class="btn btn-success w-100 seat-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#seatModal"
                                data-seat-id="{{ $seat->id }}"
                                data-schedule-id="{{ $schedule->id }}"
                                data-seat-row="{{ $seat->row }}"
                                data-seat-number="{{ $seat->seat }}">
                            Seat {{ $seat->row }}-{{ $seat->seat }}
                        </button>
                    @else
                        <button class="btn btn-danger w-100 seat-btn" disabled>
                            Seat {{ $seat->row }}-{{ $seat->seat }}
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="seatModal" tabindex="-1" aria-labelledby="seatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="seatModalLabel">Confirm Seat Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to book this seat?</p>
                    <p id="seatDetails" class="font-weight-bold"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmBooking">Confirm Booking</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#seatModal').on('show.bs.modal', function (event) {
            var btn = $(event.relatedTarget);
            var seatId = btn.data('seat-id');
            var seatRow = btn.data('seat-row');
            var seatNumber = btn.data('seat-number');
            var seatDetails = 'Row: ' + seatRow + ' | Seat: ' + seatNumber;
            var scheduleId = btn.data('schedule-id');
            var modal = $(this);

            modal.find('.modal-body #seatDetails').text(seatDetails);

            modal.data('seat-id', seatId);
            modal.data('schedule-id', scheduleId);
        });

        $('#confirmBooking').on('click', function () {
            var modal = $('#seatModal');
            var seatId = modal.data('seat-id');
            var scheduleId = modal.data('schedule-id');
            var btn = $(this);
            var triggerBtn = $('#seatModal').data('trigger-btn'); // The button that triggered the modal

            btn.attr('disabled', true);

            debugger
            triggerBtn.attr('disabled', true)
                .removeClass('btn-success')
                .addClass('btn-secondary')
                .removeAttr('data-bs-target');

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
                        triggerBtn.removeClass('btn-success')
                            .addClass('btn-danger')
                            .attr('disabled', true)
                            .removeAttr('data-bs-target');

                        $('#seatModal').modal('hide');
                    } else {
                        alert(response.message);
                        triggerBtn.attr('disabled', false)
                            .attr('data-bs-target', '#seatModal');
                    }
                },
                error: function () {
                    alert('An error occurred while booking the seat. Please try again.');
                    triggerBtn.attr('disabled', false)
                        .attr('data-bs-target', '#seatModal');
                },
            });
        });

        $('#seatModal').on('show.bs.modal', function (event) {
            var btn = $(event.relatedTarget);
            $('#seatModal').data('trigger-btn', btn);
        });
    </script>
@endsection
