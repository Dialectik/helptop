
    $('#section_id').change(function(){
        var sectionID = $(this).val();    
        if(sectionID){
            
            $.ajax({
               type:'GET',
               url: "{{url('/admin/services/index/getcategory')}}?section_id="+sectionID,
               success:function(res){               
                if(res){
                    $("#category_id").empty();
                    $("#category_id").append('<option>- выберете категорию -</option>');
                    $.each(res,function(key,value){
                        $("#category_id").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   $("#category_id").empty();
                }
               }
            });
        }else{
            $("#category_id").empty();
            $("#kind_id").empty();
        }      
       });
        
        $('#category_id').on('change',function(){
        var categoryID = $(this).val();    
        if(categoryID){
            $.ajax({
               type:"GET",
               url:"{{url('/admin/services/index/getkind')}}?category_id="+categoryID,
               success:function(res){               
                if(res){
                    $("#kind_id").empty();
                    $("#kind_id").append('<option>- выберете вид услуг -</option>');
                    $.each(res,function(key,value){
                        $("#kind_id").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   $("#kind_id").empty();
                }
               }
            });
        }else{
            $("#kind_id").empty();
        }

       });