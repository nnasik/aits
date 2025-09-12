<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training: {{ $training->course->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        const trainingId = {{ $training-> id }};
    </script>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Signature canvas styling */
        #signatureCanvas {
            background-color: #fff8b0;
            /* light yellow */
            border: 2px solid #ccc;
            width: 100%;
            height: 400px;
            touch-action: none;
            /* prevent scrolling while drawing */
        }

        /* Mobile-friendly Add Photo button */
        .photo-btn-wrapper {
            position: relative;
            display: inline-block;
        }

        .photo-btn-wrapper input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h2 class="mb-4">Training: <b>{{ $training->course->name }}</b></h2>
        <h2 class="mb-4">Date: <b>{{ $training->scheduled_date }}</b></h2>
        <h2 class="mb-4">Company Name: <b>{{ $training->job->company->name }}</b></h2>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center" colspan="4">
                        Trainee Details
                    </th>
                </tr>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Trainee Photo</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>

                @foreach($training->trainees as $index => $trainee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $trainee->name }}</td>

                    {{-- Photo --}}
                    <td>
                        @if($trainee->pivot->photo)
                        <img src="{{ asset('storage/'.$trainee->pivot->photo) }}" alt="Photo" height="50">
                        @else
                        <form action="{{ route('training.trainee.photo', [$training->id, $trainee->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="photo" onchange="this.form.submit()" style="display:none;"
                                id="photoInput{{ $trainee->id }}">
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('photoInput{{ $trainee->id }}').click();">
                                Add Photo
                            </button>
                        </form>
                        @endif
                    </td>

                    {{-- Signature --}}
                    <td>
                        @if($trainee->pivot->signature)
                        <img src="{{ '/storage/'.$trainee->pivot->signature}}" alt="Signature" height="100">
                        @else
                        <button class="btn btn-sm btn-success"
                            onclick="openSignatureModal({{ $trainee->pivot->id }}, '{{ $trainee->name }}')">
                            Add Sign
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Signature Modal -->
    <div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="signatureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signatureModalLabel">Sign: <span id="traineeName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <canvas id="signatureCanvas"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="clearBtn">Clear</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="saveBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let canvas, ctx, drawing = false;
        let pivotId = null;

        function openSignatureModal(id, name) {
            pivotId = id;
            document.getElementById('traineeName').textContent = name;

            const modalEl = document.getElementById('signatureModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            // Wait until modal is fully shown
            modalEl.addEventListener('shown.bs.modal', function () {
                canvas = document.getElementById('signatureCanvas');
                ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // Resize canvas to fit modal width
                canvas.width = canvas.offsetWidth;
                canvas.height = 400;

                ctx.lineWidth = 6;
                ctx.lineCap = "round"; // ✅ smoother lines
                ctx.strokeStyle = "#000";

                // Mouse events
                canvas.onmousedown = () => drawing = true;
                canvas.onmouseup = () => { drawing = false; ctx.beginPath(); };
                canvas.onmousemove = draw;

                // Touch events
                canvas.ontouchstart = (e) => {
                    drawing = true;
                    draw(e.touches[0]);
                };
                canvas.ontouchend = () => { drawing = false; ctx.beginPath(); };
                canvas.ontouchmove = (e) => {
                    draw(e.touches[0]);
                    e.preventDefault();
                };
            }, { once: true });
        }

        function draw(e) {
            if (!drawing) return;
            const rect = canvas.getBoundingClientRect();
            ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
        }

        // Clear button
        document.getElementById('clearBtn').addEventListener('click', () => {
            if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
        });

        // Save button
        document.getElementById('saveBtn').addEventListener('click', () => {
            if (!pivotId) { alert('Trainee not selected!'); return; }

            const dataUrl = canvas.toDataURL('image/png');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/public/training/signature/${trainingId}/${pivotId}`;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            const sigInput = document.createElement('input');
            sigInput.type = 'hidden';
            sigInput.name = 'signature';
            sigInput.value = dataUrl;
            form.appendChild(sigInput);

            document.body.appendChild(form);
            form.submit();
        });


    </script>
</body>

</html>