<? include("inc/header.php"); ?>

<? include("inc/navi.php"); ?>

<? include("inc/sidebar.php"); ?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <? include ("inc/page-header.php"); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">未領郵件清冊列印(PDF)</div>
                        <div class="panel-body">
                            <form id="form1">
                            </form>
                            <!-- <button class="btn btn-default btn-print"><i class="fa fa-print" aria-hidden="true"></i>清冊列印</button>
                            <table cellspacing="0" class="dt-Table table table-striped table-bordered" id="Btable" width="100%">
                                <thead>
                                    <tr style="font-weight:bold">
                                        <th>系所</th>
                                        <th>姓名</th>
                                        <th>信件號碼</th>
                                        <th>收件日期</th>
                                        <th>收件校區</th>
                                        <th>簽名</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> -->
                        </div>
                        <div class="panel-footer text-center">
                            <button class="btn btn-default btn-print"><i class="fa fa-print" aria-hidden="true"></i>清冊列印</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<? include("inc/footer.php"); ?>
