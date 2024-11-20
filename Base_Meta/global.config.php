<?php

require('../Base_Meta/_metaObjects/Tables/Field/FieldType.enum.php');
require('../Base_Meta/_metaObjects/Tables/Table.class.php');
require('../Base_Meta/_metaObjects/Pages/Pagetype.enum.php');
require('../Base_Meta/_metaObjects/Controls/Control.class.php');
require('../Base_Meta/_metaObjects/Pages/Page.class.php');
require('../Base_Meta/_metaObjects/Controls/SubRepeater.class.php');
require('../Base_Meta/Database/Database.php');

$currentObject = null;



if(isset($_POST['page'])) {
    $page = $_POST['page'];
}else
    $page ='';

function Error($message){
    header('updatable: true');
    die( '
        <div class="modal fade ErrModals" id="ErrModal" tabindex="-1" aria-labelledby="ErrModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="ErrModalLabel"><i class="mdi mdi-close-circle-outline text-danger" style="font-size: 25px;"> Erreur</i></h5>
                <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
              </div>
              <div class="modal-body">'.
                $message
              .'</div>
              <div class="modal-footer">
                <button type="button" onclick="getPage('.$page.')" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
              </div>
            </div>
          </div>
        </div>
        <script>
            $("#ErrModal").modal("show");
        </script>
    ');
    //exit();
}
function Message($message){
    header('updatable: true');
echo ' 
        <div class="modal fade alertModals" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center">'.
                $message
              .'</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
              </div>
            </div>
          </div>
        </div>
        <script>
            $(".alertModals").modal("show");
        </script>
    ';
}


function Confirm($message){
    if(!isset(getallheaders()['updatable']))
        header('updatable: true');
    if(isset($_POST['ConfirmAnswer'])){
        if($_POST['ConfirmAnswer'] == "true"){
            return true;
        }else{
            return false;
        }
    }
    else {
        $html = '
                <div class="modal fade confimModals" id="confimModals" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">' .
            $message
            . '</div>
                            <div class="modal-footer">                                
                                <button type="button" id="ConfirmOui" name="ConfirmOui" class="btn btn-success" data-bs-dismiss="modal">Oui</button>
                                <button type="button" id="ConfirmNon" name="ConfirmNon" class="btn btn-danger" data-bs-dismiss="modal">Non</button>                                 
                            </div>
                        </div>
                    </div>
                </div>
            <script>
                $("#confimModals").modal("show");  
                ';
                if(isset($_POST['PageID']) && isset($_POST['PageActionName'])) {
                    $html .= '           
                        $("#ConfirmOui").on("click", function(clickEvent){                
                            $.ajax({
                                url:"Base_app/app.main.php",
                                type:"POST",
                                data: {
                                    //record:record,
                                    PageID: "' . $_POST['PageID'] . '",
                                    page: "' . $_POST['page'] . '",
                                    PageActionName: "' . $_POST['PageActionName'] . '",
                                    ConfirmAnswer:"true"
                                },
                                success: function (data, textStatus, xhr) {
                                    if(data.length>0){
                                        const updatable = xhr.getResponseHeader("updatable");
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
                    </script>
                ';
                }else if(isset($_POST['PageField']) && isset($_POST['tableId']) && isset($_POST['tableName']) && isset($_POST['pageFieldname']) && isset($_POST['groupeName'])){

                    $html .= '           
                        $("#ConfirmOui").on("click", function(clickEvent){                
                            $.ajax({
                                url:"Base_app/app.main.php",
                                type:"POST",
                                data: {
                                    //record:record,
                                    PageField: "' . $_POST['PageField'] . '",
                                    page: "' . $_POST['page'] . '",
                                    tableName: "' . $_POST['tableName'] . '",
                                    pageFieldname:"' . $_POST['pageFieldname'] . '",
                                    groupeName:"' . $_POST['groupeName'] . '",
                                    tableId:"' . $_POST['tableId'] . '",
                                    ConfirmAnswer:"true"
                                },
                                success: function (data, textStatus, xhr) {
                                    if(data.length>0){
                                        const updatable = xhr.getResponseHeader("updatable");
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
                        
                                   
                        $("#ConfirmNon").on("click", function(clickEvent){                
                            $.ajax({
                                url:"Base_app/app.main.php",
                                type:"POST",
                                data: {
                                    //record:record,
                                    PageField: "' . $_POST['PageField'] . '",
                                    page: "' . $_POST['page'] . '",
                                    tableName: "' . $_POST['tableName'] . '",
                                    pageFieldname:"' . $_POST['pageFieldname'] . '",
                                    groupeName:"' . $_POST['groupeName'] . '",
                                    tableId:"' . $_POST['tableId'] . '",
                                    ConfirmAnswer:"false"
                                },
                                success: function (data, textStatus, xhr) {
                                    if(data.length>0){
                                        const updatable = xhr.getResponseHeader("updatable");
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
                    </script>
                ';
                }



        echo $html;
    }
}



?>