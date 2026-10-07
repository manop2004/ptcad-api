@if($status == 1)
    <a href="{{ route('program.status',['id' => $id]) }}" class="btn btn-info btn-link btn-icon like"><i class="fa fa-eye-slash"></i></a>
@else
    <a href="{{ route('program.status',['id' => $id]) }}" class="btn btn-info btn-link btn-icon like"><i class="fa fa-eye"></i></a>
@endif
<a href="{{ route('program.edit',['id' => $id,'tab'=>'tab1']) }}" class="btn btn-warning btn-link btn-icon edit"><i class="fa fa-edit"></i></a>
<a class="btn btn-danger btn-link btn-icon remove" href="#" data-toggle="modal" data-target="#myDelete" onclick="deleteModal(this)" href="#" data-id="{{ $id }}" data-name="{{ $name }}"><i class="fa fa-times"></i></a>
