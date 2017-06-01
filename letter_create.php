<? include("inc/header.php"); ?>
    <? include("inc/navi.php"); ?>
        <? include("inc/sidebar.php"); ?>
<style>
	h3{
		font-family: "微軟正黑體";
	}
	li{
		font-family: "微軟正黑體";
	}
	table{
		font-family: "微軟正黑體";
	}

</style>
<!-- Page Content -->
<div id="page-wrapper">
	<div class="container-fluid" >
		<? include ("inc/page-header.php"); ?>

		<div class="panel panel-primary">
			<div class="panel-heading" style="text-align:left">
			    掛號信件建檔
			</div>
			<div class="panel-body panel-height">
				<form  class="form-horizontal"  name="letter_new" id="letter_new" action="<?=$_SERVER['PHP_SELF'] ?>" method="post"   >
				<table class="table table-bordered" id="table1">
						<tr>
							<!-- <div class="form-group"> -->
								<div class="row">
									<td class="col-xs-2 col-md-1 td1" align="center">姓名</td>
									<td class="col-xs-2 col-md-2">
										<input type="text" class="form-control" name="stu_name" id="stu_name" oninput = "search(1)" onporpertychange = "search(1)" style='width:auto; display: inline-block;'>
									</td>
									<td class="col-xs-1 col-md-1 td1" align="center">系所</td>
									<td class="col-xs-2 col-md-2">
										<input type="text" class="form-control" name="dept_code" id="dept_code" style='width:auto; display: inline-block;'>
										<input type="text" class="form-control" name="dept_name" id="dept_name" style='width:auto; display: inline-block;'>
									</td>
								</div>
							<!-- </div> -->
						</tr>

						<tr>
							<div class="row">
								<td class="col-xs-2 col-md-1 td1" align="center">信件號碼</td>
								<td class="col-xs-2 col-md-2">
									<input type="text" class="form-control" name="letter_no" id="letter_no" style='width:auto; display: inline-block;'>
								</td>
								<td class="col-xs-1 col-md-1 td1" align="center">收件校區</td>
								<td class="col-xs-2 col-md-2">
									<select class='form-control' style='width:auto; display: inline-block;' id="room_code" name='room_code'></select>
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
											<input type='text' class="form-control" id='receive_date' name="receive_date" readonly="true" style='width:auto; display: inline-block;'>
										</div>
									</div>
								</div>
							</td>
							<td class="col-md-1 td1" align="center">備註</td>
							<td class="col-md-1">
								<div class="form-group">
									<div class="row">
											<div class="col-xs-8 col-md-2">
												<input type='text' class="form-control" id='comment' name="comment" style='width:auto; display: inline-block;'>
											</div>
									</div>
								</div>
							</td>
						</div>
					</tr>


					<tr>
						<td colspan="4" align="center">
							<button type="submit" class="btn btn-primary" name="store" >送出計算</button>
							<!-- onclick='timesum();' -->
						</td>
					</tr>

					<!-- </thead> -->

				</table>

				<div class="row">
				    <div class="col-lg-12">
				        <div class="panel panel-primary">
				            <div class="panel-heading"></div>
				                <div class="panel-body ">
				                    <!--<fieldset>-->
				                        <div id="_content">
				                        	<div class='table-responsive'>
				                        		<table class="table table-striped table-condensed table-hover table-bordered nowrap" id="Btable" cellspacing="0">
				                        			<thead>
				                        				<tr style="font-weight:bold">
				                        					<th style='text-align:center;'>姓名</th>
				                        					<th style='text-align:center;'>信件號碼</th>
				                        					<th style='text-align:center;'>收件日期</th>
				                        					<th style='text-align:center;'>取件日期</th>
				                        					<th style='text-align:center;'>系所</th>
				                        					<th style='text-align:center;'>收件校區</th>
				                        					<th style='text-align:center;'>代領人</th>
				                        					<th style='text-align:center;'>備註</th>
				                        					<th style='text-align:center;'>修改</th>
				                        					<th style='text-align:center;'>刪除</th>
				                        				</tr>
				                        			</thead>
				                        			<tbody>
				                        			</tbody>
				                        		</table>
				                        	</div>
				                        </div>
				                    <!--</fieldset>-->
				                </div>
				        </div>
				    </div>
				</div>

			</div>
		</form>
		</div>

	</div>
		</div>
	    <!-- /.row -->
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
	                                    <form  class="form-horizontal"  name="letter_edit" id="letter_edit" action="" method="post"   >
	                                    	<table class="table table-bordered" id="table1">
	                                    			<tr>
	                                    				<!-- <div class="form-group"> -->
	                                    					<div class="row">
	                                    						<td class="col-xs-2 col-md-1 td1" align="center">姓名</td>
	                                    						<td class="col-xs-2 col-md-2">
	                                    						<input type="text" class="form-control" name="edit_stu_name" id="edit_stu_name" oninput = "search(1)" onporpertychange = "search(1)" style='width:auto; display: inline-block;'>
	                                    						</td>
	                                    						<td class="col-xs-1 col-md-1 td1" align="center">系所</td>
	                                    						<td class="col-xs-2 col-md-2">
	                                    							<input type="text" class="form-control" name="edit_dept_code" id="edit_dept_code" style='width:auto; display: inline-block;'>
	                                    							<input type="text" class="form-control" name="edit_dept_name" id="edit_dept_name" style='width:auto; display: inline-block;'>
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
                                  									<select class='form-control' style='width:auto; display: inline-block;' id="edit_room_code" name='edit_room_code'></select>
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
                                    							<td class="col-md-1 td1" align="center">備註</td>
                                    							<td class="col-md-1">
                                    								<div class="form-group">
                                    									<div class="row">
                                    											<div class="col-xs-8 col-md-2">
                                    												<input type='text' class="form-control" id='edit_comment' name="edit_comment" style='width:auto; display: inline-block;'>
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
	<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<? include("inc/footer.php"); ?>
