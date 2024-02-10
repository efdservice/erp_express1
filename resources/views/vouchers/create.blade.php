

            {!! Form::open(['route' => 'vouchers.store', 'id'=>'formajax']) !!}


                <div class=" p-3">
                    @include('vouchers.fields')
                </div>


            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
<script>
    $(document).ready(function(){
    getTotal();


});
   

</script>