$('.delete').click(function (){
    let res = confirm('Вы уверены, что хотите удалить?') // Если кликает ДА, то в переменную попадает true
    if (!res) return false;
});


$('.sidebar-menu a').each(function (){
    let path = window.location.protocol + '//' + window.location.host + window.location.pathname;
    let link = this.href;

    if (link == path){
        $(this).parent().addClass('active')
        $(this).closest('.treeview').addClass('active')
    }
})

// CKEDITOR.replace('editor1');
$('#editor1').ckeditor();


$(".select2").select2({
    placeholder: "Начните вводить наименование товара",
    minimumInputLength: 3,
    cache: true,
    ajax: {
        url: adminpath + "/product/related-product",
        delay: 250,
        dataType: 'json',
        data: function (params) {
            return {
                q: params.term,
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data.items,
            };
        },
    },
});


var buttonSingle = $("#single"),
    buttonMulti = $("#multi"),
    file;
new AjaxUpload(buttonSingle, {
    action: adminpath + buttonSingle.data('url') + "?upload=1",
    data: {name: buttonSingle.data('name')},
    name: buttonSingle.data('name'),
    onSubmit: function(file, ext){
        if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
            alert('Ошибка! Разрешены только картинки');
            return false;
        }
        buttonSingle.closest('.file-upload').find('.overlay').css({'display':'block'});

    },
    onComplete: function(file, response){
        setTimeout(function(){
            buttonSingle.closest('.file-upload').find('.overlay').css({'display':'none'});

            response = JSON.parse(response);
            $('.' + buttonSingle.data('name')).html('<img src="/images/' + response.file + '" style="max-height: 150px;">');
        }, 1000);
    }
});

new AjaxUpload(buttonMulti, {
    action: adminpath + buttonMulti.data('url') + "?upload=1",
    data: {name: buttonMulti.data('name')},
    name: buttonMulti.data('name'),
    onSubmit: function(file, ext){
        if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
            alert('Ошибка! Разрешены только картинки');
            return false;
        }
        buttonMulti.closest('.file-upload').find('.overlay').css({'display':'block'});

    },
    onComplete: function(file, response){
        setTimeout(function(){
            buttonMulti.closest('.file-upload').find('.overlay').css({'display':'none'});

            response = JSON.parse(response);
            $('.' + buttonMulti.data('name')).append('<img src="/images/' + response.file + '" style="max-height: 150px;">');
        }, 1000);
    }
});