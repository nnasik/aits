<div class="col-md-4 mx-auto m-2">
    <div class="profile-card bg-white rounded-4 shadow-sm p-4 text-center">



        <!-- Profile Avatar with Hover Camera Icon -->
        <div class="position-relative d-inline-block profile-avatar">
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{$loop->iteration}}
            </span>

            <img src="{{ $trainee_request->profile_pic ? asset('storage/'.$trainee_request->profile_pic) : asset('assets/images/user_placeholder.jpg') }}"
                alt="Profile Picture" class="rounded-circle" width="100" height="100">

            <!-- Camera Icon Overlay (hidden until hover) -->
            <div class="camera-overlay d-flex justify-content-center align-items-center" data-bs-toggle="modal"
                data-bs-target="#editProfilePicModal" onclick="changeProfilePic({{$trainee_request->id}})">
                <i class="bi bi-camera text-white" style="cursor:pointer;"></i>
            </div>
        </div>

        <p class="text-muted">
            Trainee Request ID :
            <span class="badge bg-dark">{{$trainee_request->id}}
            </span>
        </p>

        <table class="table table-borderless">
            <tr>
                <td style="text-align: left;">Name :</td>
                <td style="text-align: left;">
                    <div class="btn-group">
                        <span class="badge bg-dark">{{ $trainee_request->trainee_name }}</span>
                        <button class="badge btn btn-warning text-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#editNameModal" onclick="changeName({{ $trainee_request->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">EID :</td>
                <td style="text-align: left;">
                    <div class="btn-group">
                        <span class="badge bg-dark">{{ $trainee_request->eid_no }}</span>
                        <button class="badge btn btn-warning text-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#editEidModal" onclick="changeIDinEID({{ $trainee_request->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">Company Name <br>(in Certificate) :</td>
                <td style="text-align: left; white-space: normal; word-break: break-word;">
                    <div style="display: flex; flex-wrap: wrap;align-items: center;">
                        <span class="badge bg-dark" style="white-space: normal; word-break: break-word;">
                            {{ $trainee_request->company_name_in_certificate ?? 'Not Set' }}
                        </span>
                        <button class="badge btn btn-warning text-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#editCompanyNameModal"
                            onclick="editCompanyName({{ $trainee_request->id }}, '{{ $trainee_request->company_name_in_certificate }}')">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </td>


            </tr>
            <tr>
                <td style="text-align: left;">Certificate for :</td>
                <td style="text-align: left;">
                    <div class="btn-group">
                        <span class="badge bg-dark">{{ $trainee_request->course_title_in_certificate ?? 'Not Set'
                            }}</span>
                        <button class="badge btn btn-warning text-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#editCertificateTitle"
                            onclick="editCertificateTitle({{ $trainee_request->id }}, '{{ $trainee_request->course_title_in_certificate }}')">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align: left; white-space: normal; vertical-align: top;">
                    Certificate Date:
                </td>
                <td style="text-align: left; white-space: normal; vertical-align: top;">
                    <div class="btn-group">
                        <span class="badge bg-dark">{{ $trainee_request->certificate_date ?? 'Not Set' }}</span>
                        <button class="badge btn btn-warning text-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#editCertificateDateModal"
                            onclick="changeCertificateDate({{ $trainee_request->id }}, '{{ $trainee_request->certificate_date }}')">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </table>

        <div class="mt-1 d-flex justify-content-between align-items-center">
            <span>Certificate Hard Copy Needed</span>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" id="hardCopySwitch" {{
                    $trainee_request->is_certificate_hard_copy_needed ? 'checked' : '' }}
                onchange="updateSwitch({{ $trainee_request->id }}, 'is_certificate_hard_copy_needed', this.checked)">
            </div>
        </div>

        <div class="m-0 d-flex justify-content-between align-items-center">
            <span>ID Card Needed</span>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" id="idCardSwitch" {{ $trainee_request->is_id_card_needed
                ?
                'checked' : '' }}
                onchange="updateSwitch({{ $trainee_request->id }}, 'is_id_card_needed', this.checked)">
            </div>
        </div>


        <!-- Document List -->
        <ul class="list-group text-start mt-4">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @if($trainee_request->eid_front_pic)
                <a href="{{ '/storage/'.$trainee_request->eid_front_pic }}" target="_blank">
                    <span>📄 EID Front Pic</span>
                </a>
                @else
                <span>📄 EID Front Pic</span>
                @endif

                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#uploadEidFrontModal" data-trainee-id="{{ $trainee_request->id }}"
                    onclick="changeEidFront({{ $trainee_request->id }})">
                    Upload
                </button>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @if($trainee_request->eid_back_pic)
                <a href="{{ '/storage/'.$trainee_request->eid_back_pic }}" target="_blank">
                    <span>📄 EID Back Pic</span>
                </a>
                @else
                <span>📄 EID Back Pic</span>
                @endif

                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#uploadEidBackModal" data-trainee-id="{{ $trainee_request->id }}"
                    onclick="changeEidBack({{ $trainee_request->id }})">
                    Upload
                </button>

            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @if($trainee_request->visa_pic)
                <a href="{{ '/storage/'.$trainee_request->visa_pic}}" target="_blank">
                    <span>📄 Visa Document</span>
                </a>
                @else
                <span>📄 Visa Document</span>
                @endif

                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#uploadVisaModal" data-trainee-id="{{$trainee_request->id}}"
                    onclick="changeVisa({{$trainee_request->id}})">
                    Upload
                </button>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @if($trainee_request->passport_pic)
                <a href="{{ '/storage/'.$trainee_request->passport_pic }}" target="_blank">
                    <span>📄 Passport Pic</span>
                </a>
                @else
                <span>📄 Passport Pic</span>
                @endif

                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#uploadPassportModal" data-trainee-id="{{ $trainee_request->id }}"
                    onclick="changePassport({{ $trainee_request->id }})">
                    Upload
                </button>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @if($trainee_request->dl_pic)
                <a href="{{ '/storage/'.$trainee_request->dl_pic}}" target="_blank"><span>📄 Driving License
                        Pic</span></a>
                @else
                <span>📄 Driving License Pic</span>
                @endif

                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#uploadDlModal" data-trainee-id="{{$trainee_request->id}}"
                    onclick="changeDl({{$trainee_request->id}})">
                    Upload
                </button>
            </li>
        </ul>
    </div>
</div>
@if($training_request->job_request->request_status=='Created')
<script>
    function updateSwitch(traineeId, field, value) {
        fetch("{{ route('trainee.updateSwitch') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                trainee_id: traineeId,
                field: field,
                value: value ? 1 : 0
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message || 'Updated successfully!');
                } else {
                    showAlert('error', data.message || 'Failed to update!');
                }
            })
            .catch(err => {
                console.error(err);
                showAlert('error', 'Something went wrong!');
            });
    }

    function showAlert(type, message) {
        const container = document.querySelector('.position-fixed.top-0');
        if (!container) return;

        const alert = document.createElement('div');
        alert.className = `alert alert-close alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show shadow`;
        alert.role = "alert";
        alert.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
        container.appendChild(alert);

        setTimeout(() => {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000); // auto close after 5s
    }
</script>
@endif