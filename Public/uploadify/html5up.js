/**
 * Created by dormo on 2015/11/16.
 */

onmessage =function (evt){
    var d = evt.data;//ͨ��evt.data��÷�����������
    var file = evt.data['file'];
    var type = evt.data['type'];
    postMessage( file );//����ȡ�������ݷ��ͻ����߳�
}
//var name = file.name;
//var size = file.size;
//var shardSize = 5 * 1024 * 1024;    //��2MBΪһ����Ƭ
//var shardCount = Math.ceil(size / shardSize);  //��Ƭ��
//var chunk = 0;
//if(size > shardSize){
//    chunk = 1;
//}
//NProgress.start();
//for(var i = 0;i < shardCount;++i) {
//    var start = i * shardSize;
//    var end = Math.min(size, start + shardSize);
//    var form_data = new FormData();
//    form_data.append('timestamp', "<{$time}>");
//    form_data.append('token', '<{:md5("unique_salt".$time)}>');
//    form_data.append("filetype", type);
//    form_data.append("data", file.slice(start,end));  //slice���������г��ļ���һ����
//    form_data.append("name", name);
//    form_data.append("total", shardCount);  //��Ƭ��
//    form_data.append("index", i + 1);        //��ǰ�ǵڼ�Ƭ
//    form_data.append("chunk",chunk);
//    $.ajax({
//        url: '__APP__/Upload/upload',
//        type: 'POST',
//        // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
//        async:false,
//        processData: false,
//        contentType: false,
//        data: form_data
//    })
//        .done(function (data) {
//            // alert(data);
//            NProgress.done();
//
//            if (!data.status) {
//                return false;
//            }
//            if (type = "x_p_yywj") {
//                yywj[yywj.length] = data.savepath + data.savename;
//            }
//            put_img(data.savepath, data.savename, type);//���ͼƬ��img_box
//            console.log("success");
//        })
//        .fail(function () {
//            console.log("error");
//        })
//        .always(function () {
//            console.log("complete");
//        });
//}