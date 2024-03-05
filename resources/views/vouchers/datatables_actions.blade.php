{!! Form::open(['route' => ['vouchers.destroy', $trans_code], 'method' => 'delete','id'=>'formajax']) !!}
<div class='btn-group'>
    @can('jv_view')
    <a  href="javascript:void(0);" data-size="sm" data-title="Upload Document"
    data-action="{{ url('attach_file/'.$id) }}"  class='btn btn-success btn-sm show-modal'>
        <i class="fa fa-file"></i>
    </a>
    @endcan
    @can('jv_view')
    <a href="{{ route('vouchers.show', $trans_code) }}" target="_blank" class='btn btn-default btn-sm'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can('jv_edit')

    <a  href="javascript:void(0);" data-size="xl" data-title="Edit"
    data-action="{{ route('vouchers.edit', $trans_code) }}" class='btn btn-default btn-sm show-modal'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can('jv_delete')

    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-sm',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
