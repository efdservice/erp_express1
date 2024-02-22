{!! Form::open(['route' => ['vouchers.destroy', $trans_code], 'method' => 'delete','id'=>'formajax']) !!}
<div class='btn-group'>
    <a href="{{ route('vouchers.show', $trans_code) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a>
    <a  href="javascript:void(0);" data-size="xl" data-title="Edit"
    data-action="{{ route('vouchers.edit', $trans_code) }}" class='btn btn-default btn-xs show-modal'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
