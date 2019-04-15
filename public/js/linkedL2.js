 $('#section_id').change(function(){
        var sectionID = $(this).val();    
        if(sectionID){
            
            $.ajax({
               type:'GET',
               url: "{{url('/admin/kinds/create/getcategory')}}?section_id="+sectionID,
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
       