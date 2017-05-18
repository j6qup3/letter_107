<? include("inc/header.php"); ?>
    <? include("inc/navi.php"); ?>
        <? include("inc/sidebar.php"); ?>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <? include ("inc/page-header.php"); ?>
                        <form class="form-horizontal" role="form" name="form1" id="form1" action="" method="post" target="right">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="message">
                                </div>
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <font STYLE="font-family:微軟正黑體">輸入查詢條件</font>
                                    </div>
                                    <div class="panel-body">
                                      <div class='form-group'>
                                              <div class="row">
                    										         <div class="col-md-6">
                                                     <div class="col-xs-2 col-md-2">
                    												            <span>學號:</span>
                    											           </div>
                    											           <div class="col-xs-8 col-md-4">
                                                       <input type="text" class="form-control" name="reason" id="stu_id" value="" size="25" maxlength="30" >
                    											           </div>
                    										          </div>
                    									         </div>
                                      </div>
                                      <div class='form-group'>
                                              <div class="row">
                    										         <div class="col-md-6">
                                                     <div class="col-xs-2 col-md-2">
                    												            <span>中文姓名:</span>
                    											           </div>
                    											           <div class="col-xs-8 col-md-4">
                                                       <input type="text" class="form-control" name="reason" id="stu_name" value="" size="25" maxlength="30" >
                    											           </div>
                    										          </div>
                    									         </div>
                                      </div>
                                      <div class='form-group'>
                                              <div class="row">
                    										         <div class="col-md-6">
                                                     <div class="col-xs-2 col-md-2">
                    												            <span>英文姓名:</span>
                    											           </div>
                    											           <div class="col-xs-8 col-md-4">
                                                       <input type="text" class="form-control" name="reason" id="stu_ename" value="" size="25" maxlength="30" >
                    											           </div>
                    										          </div>
                    									         </div>
                                      </div>
                                      <div class='form-group'>
                                              <div class="row">
                    										         <div class="col-md-6">
                                                     <div class="col-xs-2 col-md-2">
                    												            <span>系所:</span>
                    											           </div>
                    											           <div class="col-xs-8 col-md-4">
                                                       <select class="form-control" name="qry_dpt" id="cls_id_qry" style='display: inline-block; width: auto;'></select>
                    											           </div>
                    										          </div>
                    									         </div>
                                      </div>
                                      <div class='form-group'>
                                              <div class="row">
                    										         <div class="col-md-6">
                                                     <div class="col-xs-2 col-md-2">
                    												            <span>E-mail:</span>
                    											           </div>
                    											           <div class="col-xs-8 col-md-4">
                                                       <input type="text" class="form-control" name="reason" id="stu_email" value="" size="25" maxlength="30" >
                    											           </div>
                    										          </div>
                    									         </div>
                                      </div>

                                      <div class='form-group'>
                                              <div class="row">
                    										         <div class="col-md-6">

                    											           <div class="col-xs-8 col-md-4">
                                                       <button type="button" class="btn btn-default" id="check_btn">確認查詢</button>
                    											           </div>
                    										          </div>
                    									         </div>
                                      </div>



                                    </div>
                                </div>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        資料查詢結果
                                    </div>
                                    <div class="panel-body ">

                                            <!--<fieldset>-->
                                            <div id="hl_canceled">
                                                <table cellspacing="0" class="dt-Table table table-striped table-bordered" id="Btable" width="100%">
                                                    <thead>
                                                        <tr style="font-weight:bold">
                                                            <th>學號</th>
                                                            <th>中文姓名</th>
                                                            <th>英文姓名</th>
                                                            <th>系所</th>
                                                            <th>E-mail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--</fieldset>-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
            <? include("inc/footer.php"); ?>
