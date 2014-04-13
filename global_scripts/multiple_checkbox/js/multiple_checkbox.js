$.fn.select_multi = function(options){
    var options = $.extend({
        show_only_first_match: false // показывать только первое соответствие при поиске
    },options);

    function select_tag_status_plus(object_id,id){
        var status = $(object_id).find(id).data('st');
        console.log(status);
        if (status==1){
            $(object_id).find(id).data('st','2').addClass('mi').removeClass('pl');
        } else {
            $(object_id).find(id).data('st','1').addClass('pl').removeClass('mi');
        }
    }

    function select_tag_add_chosen(object_id,el){
        var current_id = $(object_id).find(el).data('i');
        var current_name = $(object_id).find('.pb_'+current_id).html();
        var add_block = "<div class='sp sp_"+current_id+"' data-i='"+current_id+"'>"+current_name+"<div title='Отменить выбор' class='ds'>X</div></div>";
        $(object_id).find('.ch_el').show().html($(object_id).find('.ch_el').html()+add_block );
        $(object_id).find('.sfco_'+current_id).prop('selected',true);
        $(object_id).find('.scbfs'+current_id).attr('checked','checked').prop('checked',true).parent().addClass('scbx');
        $(object_id).find('.cbfs'+current_id).attr('checked','checked').prop('checked',true).parent().addClass('scbx');
        $(object_id).find(el).parent().addClass('scbx');

    }

    function select_tag_remove_chosen(object_id,current_id){
        $(object_id).find('.sp_'+current_id).remove();
        $(object_id).find('.sfco_'+current_id).removeAttr('selected');
        $(object_id).find('.cbfs'+current_id).removeAttr('checked').parent().removeClass('scbx');
        $(object_id).find('.scbfs'+current_id).removeAttr('checked').parent().removeClass('scbx');
        if ($.trim($(object_id).find('.ch_el').html()).length<=17){
            $(object_id).find('.ch_el').hide();
        }
    }

    function select_tag_change_list(object,st,list){
        if (st==1){
            $(list).show();
            $(object).find('.t_li').hide();
        } else {
            $(list).hide();
            $(object).find('.t_li').show();
        }
    }

    function select_tag_filter_list(object,header, list,show_only_first_match) {
        var form = $("<form>").attr({"class":"ff","action":""}),
            input = $("<input>").attr({"class":"fi","type":"text","placeholder":"Поиск по каталогу..."}),
            input2 = $("<input>").attr({"class":"fc","type":"button", "title":"Очистить поиск"}).val('X');
        $(form).append(input).append(input2).appendTo(header);

        $(input).change(function () {
            var filter = $(this).val();
            if(filter){
                select_tag_change_list(object,1,list);
                $matches = $.unique($(list).find('li:contains(' + filter + ')'));
                $('li', list).hide();
                var prev='';
                $matches.each(function(){
                    var cur_text = $(this).html();
                    cur_text = cur_text.replace(/<\/?[^>]+>/gi, '');
                    if (show_only_first_match==true){
                        if (prev.toString()!=cur_text.toString()){
                            select_tag_show_parent_in_search(object,this);
                            $(this).addClass('i_s').show();
                        }
                    } else{
                        select_tag_show_parent_in_search(object,this);
                        $(this).addClass('i_s').show();
                    }
                    prev = cur_text;
                });
            } else {
                $(list).find("li").removeClass('i_s').show();
                select_tag_change_list(object,2,list);

            }
            return false;
        }).keyup(function () {
                $(this).change();
            });
    }
    function select_tag_show_parent_in_search(object,el){
        var cur_parent_id = $(object).find(el).data('p');
        var cur_parent = $(object).find('li[data-i="'+cur_parent_id+'"]');
        $(cur_parent).show();
        if(cur_parent_id!='0'){
            select_tag_show_parent_in_search(object,cur_parent);
        }
    }

    function select_tag_ready(object_id,show_only_first_match){
        var body = "body";
        var cur_object_id = $(object_id).attr('id');
        $('[id*="child"]').hide();

        $(object_id).find('[class*="pb"]').click(function(){
            var id_block = $(this).data('i');
            select_tag_status_plus(object_id,'.pb'+id_block);
            $(object_id).find('.child_box_'+id_block).toggle(400);
        });

        $(body).on("change", "#"+cur_object_id+" .cbfs", function(){
            var current_id = $(this).data('i');
            if($(this).prop("checked")) {
                $(object_id).find('.pb'+current_id).data('st','2').addClass('mi').removeClass('pl');
                $(object_id).find('.child_box_'+current_id).slideDown(400);
                select_tag_add_chosen(object_id,this);
            } else {
                select_tag_remove_chosen(object_id,current_id);
            }
        });

        $(body).on("click", "#"+cur_object_id+" .fc", function(){
            $(this).prev('input.fi').val('');
            select_tag_change_list(object_id,2,$(object_id).find(".l_cbx"));
        });

        $(body).on("click",  "#"+cur_object_id+" .ds", function(){
            var current_id = $(this).parent().data('i');
            select_tag_remove_chosen(object_id,current_id);
            $(this).parent().remove();
        });

        $.expr[':'].contains = function(a,i,m){
            return (' '+a.textContent || ' '+a.innerText || " ").toUpperCase().indexOf(' '+m[3].toUpperCase())>=0;
        };

        $(function () {
            select_tag_filter_list($(object_id),$(object_id).find('.h_cbx'), $(object_id).find(".l_cbx"),show_only_first_match);
        });
    }
    return this.each(function() {
        select_tag_ready(this,options.show_only_first_match)

    });

};




$(document).ready(function(){
    $('.for_multi_select').select_multi({show_only_first_match:true});
});

