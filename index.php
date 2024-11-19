<?php

require ('Base_Meta/_metaPages/Meta_links.php');
require ('Base_Meta/_metaPages/Main.Page.php');

if(isset($_POST['ConfirmOui']))
    Error($_POST['ConfirmOui']);



if(isset($_POST['ConfirmOui']))
    Error($_POST['ConfirmOui']);

echo($headersLinks);
echo '
<div class="container-scroller" id="mainPageDiv">';
echo($navBar);
?>
<div id="mainSubPageDiv" style="margin: 50px;"></div>
<?php
echo '
</div>';
echo($footersLinks);
?>
<script>
    $(document).ready(function(){
        document.body.style.cursor = 'wait';
            getPage('1');
        document.body.style.cursor = 'default';
    })
    function getPage(pageID){
        document.body.style.cursor = 'wait';
        $.ajax({
            url:"Base_app/app.main.php",
            type:"POST",
            data: {page: pageID},
            success: function (data) {
                $('#mainSubPageDiv').html(data);
                document.body.style.cursor = 'default';
            },
            error: function (err) {
                swal.fire({
                    title: 'Error',
                    html: err,
                    icon: 'error'
                })
                document.body.style.cursor = 'default';
            }
        });
    }

    function getPage_record(pageID, record){document.body.style.cursor = 'wait';
        $.ajax({
            url:"Base_app/app.main.php",
            type:"POST",
            data: {page: pageID, record: record},
            success: function (data) {
                $('#mainSubPageDiv').html(data);
            },
            error: function (err) {
                swal.fire({
                    title: 'Error',
                    html: err,
                    icon: 'error'
                })
                document.body.style.cursor = 'default';
            }
        });
    }

    function getUriParams(name){
        const param = new URLSearchParams(window.location.search);
        return param.get(name);
    }

    function updtPageID(value){
        window.location.href = '?page='+value;
    }

    function updatePage(value, isUpdatable){
        if (isUpdatable=='true')
            $('#mainSubPageDiv').html(value);
    }
    function submitFormBtn(formId, IdPage, actionname) {

        $("#formPage" + formId).submit(function (event) {
            // Empêcher le rechargement de la page lors de la soumission
            event.preventDefault();

            // Récupérer les données du formulaire
            var record = $(this).serializeArray();


            $.ajax({
                url:"Base_app/app.main.php",
                type:"POST",
                data: {
                    record:record,
                    PageID: IdPage,
                    page: IdPage,
                    PageActionName: actionname
                },
                success: function (data, textStatus, xhr) {
                    if(data.length>0) {
                        const updatable = xhr.getResponseHeader('updatable');
                        updatePage(data,updatable);
                    }
                },
                error: function (err) {
                    swal.fire({
                        title: "Error",
                        html: err,
                        icon: "error"
                    })
                }
            })
        });
        $("#formPage" + formId).submit();
    }


    function submitFormList(formId, IdPage, actionname,rowData) {


        $("#formPage" + formId).submit(function (event) {
            // Empêcher le rechargement de la page lors de la soumission
            document.body.style.cursor = 'wait';
            event.preventDefault();

            $.ajax({
                url:"Base_app/app.main.php",
                type:"POST",
                data: {
                    record:rowData,
                    PageID: IdPage,
                    page: IdPage,
                    PageActionName: actionname
                },
                success: function (data, textStatus, xhr) {
                    if(data.length>0) {
                        const updatable = xhr.getResponseHeader('updatable');
                        updatePage(data,updatable);
                    }

                    document.body.style.cursor = 'default';
                },
                error: function (err) {
                    swal.fire({
                        title: "Error",
                        html: err,
                        icon: "error"
                    })
                    document.body.style.cursor = 'default';
                }
            })
        });
        $("#formPage" + formId).submit();
    }

    function submitForm(formId, pageField, pageFieldname, tableId, tableName, groupeName) {
        //alert('Ok');
        $("#formPage" + formId).submit(function (event) {
            // Empêcher le rechargement de la page lors de la soumission
            event.preventDefault();

            // Récupérer les données du formulaire
            var record = $(this).serializeArray();


            $.ajax({
                type: "POST",
                url: "Base_app/app.main.php",  // Remplacez par votre URL serveur
                data: {
                    record:record,
                    PageField:pageField,
                    pageFieldname:pageFieldname,
                    tableId:tableId,
                    tableName:tableName,
                    page:formId,
                    groupeName: groupeName
                },
                success: function (response, textStatus, xhr) {

                    if(response.length>0) {
                        const updatable = xhr.getResponseHeader('updatable');
                        updatePage(response,updatable);
                    }
                },
                error: function (xhr, status, error) {
                    swal.fire({
                        html: error
                    });
                }
            });
        });

        $("#formPage" + formId).submit();
    }


</script>
