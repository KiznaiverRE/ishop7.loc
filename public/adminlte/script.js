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