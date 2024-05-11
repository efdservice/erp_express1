{!! Form::open(['route' => ['loans.destroy', $id], 'method' => 'delete','id'=>'formajax']) !!}
<div class='btn-group'>
    @can('loan_view')
    <a  href="javascript:void(0);" data-size="sm" data-title="Upload Document"
    data-action="{{ url('attach_file/'.$id) }}"  class='btn btn-success btn-sm show-modal'>
        <i class="fa fa-file"></i>
    </a>
    @endcan
    @can('loan_view')
    <a href="{{ route('loans.show', $id) }}" target="_blank" class='btn btn-default btn-sm'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can('loan_edit')

    <a  href="javascript:void(0);"  data-title="Edit"
    data-action="{{ route('loans.edit', $id) }}" data-size="lg" class='btn btn-default btn-sm show-modal'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can('loan_delete')

    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-sm',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
