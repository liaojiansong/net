/**
 * 删除操作
 * @param $url
 * ajax请求url
 * @param $id
 * 要删除的id
 * @param $_obj
 * 当前对象
 */
function deleteAlert($url,$id,$_obj) {
    swal({
        title: '确定要删除？',
        text: "真的真的真的要删除它吗",
        icon: 'warning',
        buttons: {
            delete: '删除',
            cancel: '取消'
        }
    }).then((value) => {
        switch (value) {
            case 'delete':
                $.ajax({
                    url: $url,
                    data: {'id':$id},
                    type: 'get',
                    dataType: 'json',
                    success: function (info) {
                        if (info.flag === true) {
                            swal("删除成功！", info.msg, "success").then(function () {
                                deleteOneTr($_obj);
                            });
                        } else {
                            swal("WTF", info.msg, "error");
                        }
                    },
                    error: function () {
                        swal("WTF", "删除失败了", "error");
                    }
                });
            case 'cancel':
                swal.close();
        }
    });
}

/**
 * 删除某一行
 * @param $_obj
 */
function deleteOneTr($_obj) {
    $_obj.closest('tr').remove();
}