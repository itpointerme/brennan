<form action="{{route('importExport')}}" method="post" id='form' enctype="multipart/form-data"  style="display: none;">
    <label class="btn btn-default">
        <input type="file" class="user-gender" value="导入excel" id='excel_to_import' name="file">导入excel
    </label>
</form>
    
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="javascript:;" class="btn btn-sm btn-facebook" id='importExcel'>
        <i class="fa fa-save"></i>&nbsp;&nbsp;excel导入
    </a>
</div>

<script type="text/javascript">
    $('#importExcel').on('click', function(){
        $('#excel_to_import').click();
        $('#excel_to_import').change(function(){
            $('#form').submit();
        });
    });
</script>