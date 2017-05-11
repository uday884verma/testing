    function add_main_question()
	{
		var html='';
        cnt++;
        main_cnt++;
                
	    $.ajax({
            type: "POST",
            data: { cnt: cnt, main_cnt: main_cnt },
            url: base_url+"/home/add_main_question",
            dataType : 'html',
            cache: false,
            success : function(html){
                $('#main').append(html);
                $("#cnt").val(cnt);
                $("#main_cnt").val(cnt);
            }
        });
    }

    function add_sub_question(id)
    {
        var id=id; 
        var str = id.substring(0, id.length-5);

        var html='';
        cnt++;
                
        $.ajax({
            type: "POST",
            data: { cnt: cnt, strdiv: str },
            url: base_url+"/home/add_sub_question",
            dataType : 'html',
            cache: false,
            success : function(html){
                if(str.indexOf('single') != -1)
                {
                    $('#'+str).after(html);
                }
                else
                {
                    $('#'+str+"_div").after(html);
                }
                
                $("#cnt").val(cnt);
            }
        });
    }

    function change_answer_options(id)
    {
        var id = id;
        var value = $("#"+id).val();
        if(value=="single_choice")
        {
            $("#multiline_"+id).hide();
            $("#multi_"+id).hide();
            $("#multi_"+id+"_sub").hide();
            $("#single_"+id).show();
            $("#type_"+id).val('single_choice');
        }
        else if(value=="multi_choice")
        {
            $("#multiline_"+id).hide();
            $("#single_"+id).hide();
            $("#single_"+id+"_sub").hide();
            $("#multi_"+id).show();
            $("#type_"+id).val('multi_choice');
        }
        else if(value=="multi_line")
        {
            $("#multi_"+id).hide();
            $("#single_"+id).hide();
            $("#single_"+id+"_sub").hide();
            $("#multi_"+id+"_sub").hide();
            $("#multiline_"+id).show();
            $("#type_"+id).val('multi_line');
        }
    }

    $(document).ready(function () {
        $("#cancel").click(function () {
            window.location.reload();
        });

         $("#home_form").validate({
    
                submitHandler: function(form) {
                form.submit();
            }
        });

         
    });