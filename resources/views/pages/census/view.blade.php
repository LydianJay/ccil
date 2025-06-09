<x-basecomponent>

    
    <div class="bg-white rounded h-100 p-4">
        <h6 class="mb-4">Census Data</h6>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Household No.</th>
                        <th scope="col">Family No.</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Family Role</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Household Role</th>
                        <th scope="col">Age</th>
                        <th scope="col">IPs/ICCs</th>
                        <th scope="col">Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($individuals as $i)
                        <tr>
                            <td>{{ $i->household_id }}</td>
                            <td>{{ $i->family_id }}</td>
                            <td>{{ "$i->fname $i->mname $i->lname, $i->ext" }}</td>
                            <td>{{ ucfirst($i->family_role)}}</td>
                            <td>{{ ucfirst($i->gender) }}</td>
                            <td class="text-center"> 
                                @if ($i->household_head_id != null)
                                    <span class="bg-primary text-white p-1 rounded-2"> HEAD </span>
                                @else
                                    <span class="bg-secondary text-white p-1 rounded-2"> MEMBER </span>
                                @endif
                            </td>
                            <td> {{ $i->age }} </td>
                            <td class="{{ $i->ip_name == 'Non IP' ? 'text-danger' : '' }}"> {{ $i->ip_name }} </td>
                            <td> {{ $i->address }} </td>
                        </tr>                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    


    <script>
        document.addEventListener('DOMContentLoaded', () => {

          
        });
    </script>

</x-basecomponent>