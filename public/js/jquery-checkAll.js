/*
 基于jQuery的全选控制插件
 吾爱 <carlton.cheng@foxmail.com>
 https://github.com/keepeye/jquery-checkAll
 */
(function($){
    $.fn.checkAll = function(slaves,options){
        var $master = $(this);
        var $slaves = $(slaves);
        var checkedList = new Array();

        options = $.extend({
            onSlaveClick : function(){},
            onMasterClick : function(){},
            onChecked : function(data){}
        },options);

        function updateCheckedList()
        {
            checkedList = $slaves.filter(':checked');
            options.onChecked && options.onChecked(checkedList)
        }

        $master.on("click",function(){
            options.onMasterClick.call(this);
            $slaves.prop("checked",$master.prop("checked"));
            updateCheckedList()
        });

        $slaves.on('click',function(){
            options.onSlaveClick.call(this);
            updateCheckedList();
        });
    }
})(jQuery);