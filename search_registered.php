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
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<? include("inc/footer.php"); ?>
