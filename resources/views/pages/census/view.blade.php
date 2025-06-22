<x-basecomponent>

    <div class="card">
        <div class="card-header bg-white py-4">
            <h5 class="mb-4">Census Data</h5>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>There were some problems with your input:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('status'))
                <div class="alert {{session('status')['alert']}} alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('status')['msg'] }}
                </div>
            @endif
            <div class="row">
                <div class="col">
                    <form action="{{ route('census', array_merge(['search' => request('search')], request()->query())) }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search by name" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col">
                    <div class="d-flex flex-row justify-content-end">
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create_modal"><i class="fa-solid fa-user-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle text-nowrap table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>HH No.</th>
                            <th>Family No.</th>
                            <th>Full Name</th>
                            <th>Family Role</th>
                            <th>Gender</th>
                            <th>HH Role</th>
                            <th>Age</th>
                            <th>IPs/ICCs</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($individuals as $i)
                            <tr class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#individualModal" data-individual='@json($i)'>
                                <td class="fw-semibold">{{ $i->household_id }}</td>
                                <td class="fw-semibold">{{ $i->family_id }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ "$i->fname $i->mname $i->lname" }}</div>
                                    <small class="text-muted">{{ $i->ext }}</small>
                                </td>
                                <td>{{ ucfirst($i->family_role) }}</td>
                                <td>
                                    <span class="badge bg-{{ strtolower($i->gender) === 'male' ? 'info' : 'warning' }}">
                                        {{ ucfirst($i->gender) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($i->household_head_id != null)
                                        <span class="badge bg-primary">HEAD</span>
                                    @else
                                        <span class="badge bg-secondary">MEMBER</span>
                                    @endif
                                </td>
                                <td>{{ $i->age }}</td>
                                <td>
                                    <span class="{{ $i->ip_name === 'Non IP' ? 'text-danger fw-bold' : '' }}">
                                        {{ $i->ip_name }}
                                    </span>
                                </td>
                                <td style="max-width: 200px;">{{ $i->address }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            
            
        </div>
        <div class="card-footer">
            @if($page_count > 0)
                <div class="d-flex flex-row justify-cotent-between align-items-center px-1">

                    <div class="px-1">
                        <p class="fw-bold fs-7 opacity-7 text-nowrap">Page {{ $page }} of {{ $page_count }}</p>

                    </div>
                    <div class="container-fluid d-flex flex-row justify-content-end">
                        <a class="btn btn-outline-secondary mx-2 @if($page <= 1)  disabled @endif"
                            href="{{ route('census', array_merge(request()->query(), ['page' => $page - 1])) }}">Prev</a>
                        <a class="btn btn-outline-secondary mx-2 @if($page >= $page_count)  disabled @endif"
                            href="{{ route('census', array_merge(request()->query(), ['page' => $page + 1])) }}">Next</a>
                    </div>
                </div>
            @endif
        </div>
        
    </div>
    

    <div class="modal fade" id="individualModal" tabindex="-1" aria-labelledby="individualModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="individualModalLabel">Individual Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modal-avatar" src="" alt="Avatar" class="rounded-circle mb-3" width="100" height="100">
                    <h5 id="modal-fullname" class="fw-bold"></h5>
                    <p class="text-muted mb-4" id="modal-family-role"></p>
                
                    <div class="row text-start justify-content-center">
                        <div class="col-md-8">
                            <dl class="row">
                                <dt class="col-sm-5">Gender</dt>
                                <dd class="col-sm-7" id="modal-gender"></dd>
                
                                <dt class="col-sm-5">Household Role</dt>
                                <dd class="col-sm-7" id="modal-hh-role"></dd>
                
                                <dt class="col-sm-5">Age</dt>
                                <dd class="col-sm-7" id="modal-age"></dd>
                
                                <dt class="col-sm-5">IPs/ICCs</dt>
                                <dd class="col-sm-7" id="modal-ip"></dd>
                
                                <dt class="col-sm-5">Address</dt>
                                <dd class="col-sm-7" id="modal-address"></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('generate_id', ['id' => '']) }}" id="generate-id-link" class="btn btn-primary">Generate ID</a>
                </div>
            </div>
        </div>
    </div>
      
    

    <div class="modal fade" id="create_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('add_record') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="createModalLabel">Add New Individual</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
    
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="fname" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lname" required>
                            </div>
    
                            <div class="col-md-6">
                                <label class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="mname">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Name Extension</label>
                                <input type="text" class="form-control" name="ext" placeholder="Jr., Sr., III">
                            </div>
    
                            <div class="col-md-4">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" required>
                            </div>
    
                            <div class="col-md-4">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender" required>
                                    <option value="" disabled selected>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
    
                            <div class="col-md-4">
                                <label class="form-label">Family Role</label>
                                <select class="form-select"  name="family_role">
                                    <option value="">-- Select Role --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="col-md-6">
                                <label class="form-label">IP/ICC Group</label>
                                <select class="form-select" name="ip">
                                    <option value="">-- Select IP group --</option>
                                    @foreach ($ip_groups as $ip)
                                        <option value="{{ $ip->ip_group_id }}">{{ $ip->ip_name }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="col-md-6">
                                <label class="form-label">Is Family Head?</label>
                                <select class="form-select" id="is_head" name="is_head">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
    
                            <div class="col-md-12" id="head-selection" style="display: none;">
                                <label class="form-label">Select Existing Family Head</label>
                                <select class="form-select" name="household_head_id">
                                    <option value="">-- Select Head --</option>
                                    @foreach ($household_heads as $head)
                                        <option value="{{ $head->household_head_id }}">{{ $head->fname }} {{ $head->lname }} {{ $head->mname }} {{ $head->ext }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="2" required></textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Individual</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


      


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('individualModal');

            modal.addEventListener('show.bs.modal', function (event) {
                const row   = event.relatedTarget;
                const data  = JSON.parse(row.getAttribute('data-individual'));

                // Construct full name
                const fullName  = [data.fname, data.mname, data.lname, data.ext].filter(Boolean).join(' ');
                const gender    = data.gender.toLowerCase();
                const basepath  = '{{ asset('assets/img/avatars') }}';
                const avatar    = gender === 'male' ? basepath + "/male.png" : basepath + "/female.png";

                document.getElementById('modal-avatar').src                 = avatar;
                document.getElementById('modal-fullname').textContent       = fullName;
                document.getElementById('modal-family-role').textContent    = data.family_role;
                document.getElementById('modal-gender').textContent         = data.gender;
                document.getElementById('modal-hh-role').textContent        = data.household_head_id ? 'HEAD' : 'MEMBER';
                document.getElementById('modal-age').textContent            = data.age;
                document.getElementById('modal-ip').textContent             = data.ip_name;
                document.getElementById('modal-address').textContent        = data.address;
                document.getElementById('generate-id-link').href            = "{{ route('generate_id', ['id' => '']) }}" + data.id;
                document.getElementById('generate-id-link').onclick         = function() {
                                                                                window.open("{{ route('generate_id', ['id' => '']) }}" + data.id, "_blank");
                                                                                return false; // Prevent default link behavior
                                                                            };
            });


            const isHeadSelect = document.getElementById('is_head');
            const headSelection = document.getElementById('head-selection');

            isHeadSelect.addEventListener('change', function () {
                if (this.value === '0') {
                    headSelection.style.display = 'block';
                } else {
                    headSelection.style.display = 'none';
                }
            });

            // trigger once on load
            if (isHeadSelect.value === '0') {
                headSelection.style.display = 'block';
            }
        });
    </script>
    
    

</x-basecomponent>