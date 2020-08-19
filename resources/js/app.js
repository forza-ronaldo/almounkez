require('./bootstrap');
$(document).ready(function () {
    $('.select_table_type').change(function(){
        $('#form_table_type').submit();
    });
    $('.checkbox_edit').change(function(){
        $('#form_edit_permission'+$(this).data('user_id')+$(this).data('permission_id')).submit();
    });
    $("#pdf").click(function () {
        window.print();
    })
    // $('.dropdown .dropdown-menu .dropdown-item').click(function(){
    //    $(this).closest('.dropdown-toggle').html($(this).find('a').html());
    //    alert($(this).closest('.dropdown-toggle').html())
    //     alert($(this).find('a').html())
    // });
    // $(document).ready(function (){
    //     alert('sadasd');
    // });
    var doc = new jsPDF();

    doc.text(20, 20, );

    // Add new page
    // Save the PDF
    doc.save('document.pdf');
})
