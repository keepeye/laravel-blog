<html>
    <head>
        <title>MessageBox</title>
        <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
        <style>
            body{font-size:14px;}
            a{text-decoration: none;}
            p{margin:0;padding:0;}
            .box{display:table;width:500px;height:100px;margin:100px auto;color:#31708f;background-color:#d9edf7;border:1px solid #bce8f1;}
            .success{color:#3c763d;background-color: #dff0d8;border-color:#d6e9c6;}
            .info{color:#31708f;background-color:#d9edf7;border-color: #bce8f1;}
            .error{color:#a94442;background-color: #f2dede;border-color:#ebccd1;}
            .msg{display: table-cell;vertical-align: middle;text-align: center;height:100px;width:500px;}
            .msg a{display: block;padding: 10px;}
            .msg a:hover{color:red;}
            @media screen and (max-width: 700px) {
                .box{width:100%;}
                .msg{width:100%;}
            }
        </style>
    </head>
    <body>
        <div class="<?=$type;?> box ">

            <div class="msg">
                <?=$msg;?>
                <a href="<?=$jumpUrl;?>">[ ok ]</a>
            </div>

        </div>
        <script>
            <?php if($timeout > 0 and $jumpUrl!=""): ?>
            setTimeout(function(){
                window.location.href = "<?=$jumpUrl;?>";
            },<?=$timeout*1000;?>);
            <?php endif;?>
        </script>
    </body>
</html>