<? include("inc/header.php"); ?>

<? include("inc/navi.php"); ?>

<? include("inc/sidebar.php"); ?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <? include ("inc/page-header.php"); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div id="message">
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            查詢條件
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <!-- 是否領取的條件篩選 -->
                                <div class="form-group">
                                    <select name="take-or-not" id="take-or-not" class="form-control">
                                      <option value="no">未領取</option>
                                      <option value="yes">已領取</option>
                                      <option value="all">全部</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">掛號信件查詢</div>
                        <div class="panel-body">
                            <div id="hl_canceled">
                                <table cellspacing="0" class="dt-Table table table-striped table-bordered" id="Btable" width="100%">
                                    <thead>
                                        <tr style="font-weight:bold">
                                            <th>姓名</th>
                                            <th>信件號碼</th>
                                            <th>收件日期</th>
                                            <th>收件校區</th>
                                            <th>系所</th>
                                            <th>功能區</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (Modal) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- Modal -->
                    <div class="modal fade" id="myModal">
              	        <div class="modal-dialog">
              	            <div class="modal-content">
              	                <div class="modal-header">
              	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              	                    <h4 class="modal-title">資料修改</h4>
              	                </div>
              	                <div class="modal-body">
              	                    <!-- <div align="center" id="loadingIMG">
              	                        <img src="images/loading.gif">
              	                    </div> -->
              	                    <div id="data">
              	                        <div class="panel panel-primary">
              	                            <div class="panel-heading"></div>
              	                                <div class="panel-body ">
              	                                    <form  class="form-horizontal"  name="letter_edit" id="letter_edit" action="" method="post">
              	                                    	<table class="table table-condensed table-hover table-bordered" id="table1">
              	                                    			<tr>
              	                                    				<!-- <div class="form-group"> -->
              	                                    					<div class="row">
              	                                    						<td class="col-xs-2 col-md-1 td1" align="center">姓名</td>
              	                                    						<td class="col-xs-2 col-md-2">
              	                                    						  <input type="text" class="form-control" name="edit_stu_name" id="edit_stu_name" oninput = "search()" onporpertychange = "search()" style='width:auto; display: inline-block;'>
              	                                    						</td>
              	                                    						<td class="col-xs-1 col-md-1 td1" align="center">系所</td>
              	                                    						<td class="col-xs-2 col-md-2">
                                                                  <select class='form-control' id="edit_dept_code" name='edit_dept_code'>
                                                                  </select>
              	                                    						</td>
              	                                    					</div>
              	                                    					<!-- </div> -->
              	                                    				</tr>
                                                 						<tr>
                                                 							<div class="row">
                                                								<td class="col-xs-2 col-md-1 td1" align="center">信件號碼</td>
                                                 								<td class="col-xs-2 col-md-2">
                                                 									<input type="text" class="form-control" name="edit_letter_no" id="edit_letter_no" style='width:auto; display: inline-block;'>
                                                 								</td>
                                                 								<td class="col-xs-1 col-md-1 td1" align="center">收件校區</td>
                                                 								<td class="col-xs-2 col-md-2">
                                                									<select class='form-control' style='width:auto; display: inline-block;' id="edit_room_code" name='edit_room_code'>
                                                									  <option value='1'>進德</option>
                                                                    <option value='2'>寶山</option>
                                                									</select>
                                                 								</td>
                                                 							</div>
                                                 						</tr>
                                                  					<tr>
                                                  						<div class="row">
                                                  							<td class="col-md-1 td1" align="center">收件日期</td>
                                                  							<td class="col-md-1">
                                                  								<div class='form-group'>
                                                  									<div class="row">
                                                  										<div class="col-md-4">
                                                  											<input type='text' class="form-control" id='edit_receive_date' name="edit_receive_date" readonly="true" style='width:auto; display: inline-block;'>
                                                  										</div>
                                                  									</div>
                                                  								</div>
                                                  							</td>
                                                  						</div>
                                                  					</tr>
              	                                    				<tr>
              	                                    					<td colspan="4" align="center">
              	                                    						<button type="submit" class="btn btn-primary" name="save" >儲存</button>
              	                                    						<!-- onclick='timesum();' -->
              	                                    					</td>
              	                                    				</tr>
              	                                    	</table>
              	                                    </form>
              	                                </div>
              	                        </div>
              	                    </div>
              	                </div>
              	                <div class="modal-footer">
              	                    <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
              	                </div>
              	            </div><!-- /.modal-content -->
              	        </div><!-- /.modal-dialog -->
              	    </div><!-- /.modal -->
                </div>
            </div>
            <!-- /.row (Modal)-->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<? include("inc/footer.php"); ?>
