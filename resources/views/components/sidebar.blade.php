<div class="container-sm border rounded pt-2 bg-light">

<div class="list-group mb-4 ">

  <a href="/dashboard" class="list-group-item list-group-item-action">

    Dashboard

  </a>

</div>

<div class="list-group mb-2">

  <small class="text-secondary d-block mb-0">Master</small>

    <div class="list-group">

      <a class="list-group-item list-group-item-action dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Master Form
      </a>

      <ul class="dropdown-menu">

        <div class="list-group">
        
        <li><a href="{{ route('master.tables.create') }}" class="dropdown-item">Create</a></li>
        
        {{-- <li><a href="{{ route('master.tables.index') }}" class="dropdown-item">Table</a></li> --}}

        <li><a href="{{ route('master.forms.index') }}" class="dropdown-item">Form</a></li>
        </div>

      </ul>

    </div>

</div>

{{-- <div class="mb-2">

  <small class="text-secondary d-block mb-0">Form</small>

    <div class="list-group">

      <a class="list-group-item list-group-item-action dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Form
      </a>

      <ul class="dropdown-menu">

        <div class="list-group">
        
        <li><a href="{{ route('master.forms.create') }}" class="dropdown-item">Create</a></li>
        
        <li><a href="{{ route('master.forms.index') }}" class="dropdown-item">Form</a></li>

        </div>

      </ul>

    </div>

</div> --}}

</div>