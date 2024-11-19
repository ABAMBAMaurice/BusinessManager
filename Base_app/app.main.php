<?php

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    }else
        $page ='';

    require ('../Base_Meta/global.config.php');
    require ('Base_configs/meta.configs.php');

    require('API/main.api.php');

    if($page != '') {

?>

    <div class="container-fluid" id="MainBodyPage">
        <div class="row">
            <div class="content-wrapper" style="background-color: white">
                <div class="row">
                    <div class="row col-sm-12">
                            <?php
                                if (isset(Page::$_pageCollection[$page])) {
                                  Page::$_pageCollection[$page]->onOpenPage();
                                  echo(Page::$_pageCollection[$page]);
                                }
                                else
                                    die("Error 404: Page not found");
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

