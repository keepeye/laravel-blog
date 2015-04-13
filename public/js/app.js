"use strict";
function highlightMenu(name)
{
    if (name=="") {
        return;
    }
    var menus = $("#menus");
    var menu = menus.find("li[data-menu-name='"+name+"']:first");
    menu.addClass('active');
    //如果是子菜单，向上寻找主菜单并高亮
    if (menu.parent('ul.dropdown-menu').length > 0) {
        menu.parent().parent().addClass('active');
    }
}

//textarea支持tab缩进
$("textarea").on('keydown',function(e){
    if(e.keyCode == 9){
        e.preventDefault();
        var indent = '    ';
        var start = this.selectionStart;
        var end = this.selectionEnd;
        var selected = window.getSelection().toString();
        selected = indent + selected.replace(/\n/g,'\n'+indent);
        this.value = this.value.substring(0,start) + selected + this.value.substring(end);
        this.setSelectionRange(start+indent.length,start+selected.length);
    }
});


//渐隐效果
$("[data-fadeout]").each(function(){
    var delay = $(this).attr('data-fadeout') || 1;
    var dom = $(this);
    setTimeout(function(){dom.fadeOut('slow');},delay*1000);
});
