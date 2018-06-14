$(function(){
    var button = $('.ajaxUpload'), interval;
    var confirmdiv = button.parents('.input-group').find('.uploadmsg');
    var fileType = "fileType",fileNum = "one"; 
    new AjaxUpload(button,{
        action: fileUploadPath,
        name: 'userfile',
        onSubmit : function(file, ext){
            if(fileType == "fileType")
            {   
                if (ext && /^(jpg|png|jpeg|gif|zip|rar|xlsx|xls|doc|docx|pdf|psd)$/i.test(ext)){
                    this.setData({
                        'info': '类型格式正确'
                    });
                } else {
                    confirmdiv.text('文件格式错误，请上传格式为.png .jpg .jpeg .zip .rar xlsx的文件');
                    return false;               
                }
            }
                        
            confirmdiv.text('文件上传中');
            if(fileNum == 'one')
                this.disable();
            interval = window.setInterval(function(){
                var text = confirmdiv.text();
                if (text.length < 14){
                    confirmdiv.text(text + '.');                    
                } else {
                    confirmdiv.text('文件上传中');             
                }
            }, 200);
        },
        onComplete: function(file, response){
            response = eval('('+response+')');
            if(response.state == 1){
                //上传成功
                confirmdiv.text('上传成功');
                button.parents('.input-group').find('input').val(response.info);
            }else{
                // 上传失败
                confirmdiv.text(response.info);
                button.parents('.input-group').find('input').val('');
            }
            window.clearInterval(interval);
            this.enable();
        }
    },'json');
});